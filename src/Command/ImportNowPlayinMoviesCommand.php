<?php

namespace App\Command;

use App\Entity\Movie;
use App\Entity\MovieCrew;
use App\Entity\People;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportNowPlayinMoviesCommand extends Command
{
    protected static $defaultName = 'movies:now-playing';

    protected function configure()
    {
        $this->setDescription('Import movies playing now in french theaters')
            ->setHelp('Allows to import now playing in france movies from TMDB');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $doctrine = $this->getApplication()
            ->getKernel()
            ->getContainer()
            ->get('doctrine');

        $movieRepository = $this->getApplication()
            ->getKernel()
            ->getContainer()
            ->get('tmdb.movie_repository');

        $peopleRepository = $this->getApplication()
            ->getKernel()
            ->getContainer()
            ->get('tmdb.people_repository');


        $movies = $movieRepository->getNowPlaying([
            'region' => 'FR',
            'language' => 'fr-FR',
        ]);

        foreach ($movies->getIterator() as $key => $data) {
            $persistedMovie = $doctrine
                ->getRepository(Movie::class)
                ->findByTMDBId($data->getId());

            if (!$persistedMovie) {
                $movie = $doctrine->getRepository(Movie::class)
                    ->create([
                        'tmdb_id' => $data->getId(),
                        'title' => $data->getTitle(),
                        'release_date' => $data->getReleaseDate(),
                        'description' => $data->getOverview(),
                    ]);

                $credits = $movieRepository->getCredits($data->getId(), [
                    'language' => 'fr-FR',
                ]);

                /* Process crew and cas members separately, because the API provides
                two different collections */
                foreach ($credits->getCrew()->getIterator() as $peopleData) {
                    $persistedPeople = $doctrine
                        ->getRepository(People::class)
                        ->findByTMDBId($peopleData->getId());

                    if (!$persistedPeople) {
                        $people = $doctrine->getRepository(People::class)
                            ->create([
                                'tmdb_id' => $peopleData->getId(),
                                'first_name' => $peopleData->getName(),
                                'last_name' => $peopleData->getName(),
                                'description' => $peopleData->getDepartment(),
                            ]);

                        $doctrine->getRepository(MovieCrew::class)
                            ->create([
                                'people' => $people,
                                'movie' => $movie,
                                'job' => $peopleData->getJob(),
                            ]);
                    }
                }

                foreach ($credits->getCast()->getIterator() as $peopleData) {
                    $persistedPeople = $doctrine
                        ->getRepository(People::class)
                        ->findByTMDBId($peopleData->getId());

                    if (!$persistedPeople) {
                        $people = $doctrine->getRepository(People::class)
                            ->create([
                                'tmdb_id' => $peopleData->getId(),
                                'first_name' => $peopleData->getName(),
                                'last_name' => $peopleData->getName(),
                                'description' => $peopleData->getCastId(),
                            ]);

                        $doctrine->getRepository(MovieCrew::class)
                            ->create([
                                'people' => $people,
                                'movie' => $movie,
                                'job' => 'Acteur/ice',
                            ]);
                    }
                }
            }
        }

        $io->success('Movies imported.');
    }
}
