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

    protected $doctrine;

    protected $movieRepository;

    protected $peopleRepository;

    protected function configure()
    {
        $this->setDescription('Import movies playing now in french theaters')
            ->setHelp('Allows to import now playing in france movies from TMDB');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->doctrine = $this->getApplication()
            ->getKernel()
            ->getContainer()
            ->get('doctrine');

        $this->movieRepository = $this->getApplication()
            ->getKernel()
            ->getContainer()
            ->get('tmdb.movie_repository');

        $this->peopleRepository = $this->getApplication()
            ->getKernel()
            ->getContainer()
            ->get('tmdb.people_repository');


        $movies = $this->movieRepository->getNowPlaying([
            'region' => 'FR',
            'language' => 'fr-FR',
        ]);

        foreach ($movies->getIterator() as $key => $data) {
            $persistedMovie = $this->doctrine
                ->getRepository(Movie::class)
                ->findByTMDBId($data->getId());

            if (!$persistedMovie) {
                $movie = $this->doctrine->getRepository(Movie::class)
                    ->create([
                        'tmdb_id' => $data->getId(),
                        'title' => $data->getTitle(),
                        'release_date' => $data->getReleaseDate(),
                        'description' => $data->getOverview(),
                    ]);

                $credits = $this->movieRepository->getCredits($data->getId(), [
                    'language' => 'fr-FR',
                ]);

                /* Process crew and cas members separately, because the API provides
                two different collections */
                foreach ($credits->getCrew()->getIterator() as $peopleData) {
                    $this->createRelatedPeople($movie, $peopleData, 'crew');
                }

                foreach ($credits->getCast()->getIterator() as $peopleData) {
                    $this->createRelatedPeople($movie, $peopleData, 'cast');
                }
            }
        }

        $io->success('Movies imported.');
    }

    /**
     * Creates a related people
     *
     * @param App\Entity\Movie the movie to assiciate with the newly created
     *        people
     * @param array $data the data
     * @param string peopleType the type of people (crew/cast)
     */
    protected function createRelatedPeople($movie, $data, $peopleType) {
        $persistedPeople = $this->doctrine
            ->getRepository(People::class)
            ->findByTMDBId($data->getId());

        if (!$persistedPeople) {
            $details = $this->peopleRepository->load($data->getId());

            $people = $this->doctrine->getRepository(People::class)
                ->create([
                    'tmdb_id' => $data->getId(),
                    'first_name' => $data->getName(),
                    'last_name' => $data->getName(),
                    'description' => $details->getBiography() ?: '',
                ]);

            $this->doctrine->getRepository(MovieCrew::class)
                ->create([
                    'people' => $people,
                    'movie' => $movie,
                    'job' => $peopleType === 'crew' ? $data->getJob() : 'Acteur/rice',
                ]);
        }
    }
}
