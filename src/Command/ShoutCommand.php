<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Letgo\Infrastructure\ShoutService;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;

class ShoutCommand extends Command
{
    protected static $defaultName = 'app:shout';

    /**
     * @var ShoutServiceInterface
     */
    private $shoutService;

    /**
     * @var TweetRepositoryInMemory
     */
    private $repo;

    public function __construct(ShoutService $shoutService, TweetRepositoryInMemory $repo)
    {
        parent::__construct();

        $this->shoutService = $shoutService;
        $this->repo = $repo;
    }

    protected function configure()
    {
        $this
            ->addArgument('twitterName', InputArgument::REQUIRED, 'The username of the Twitter user.')
            ->addArgument('limit', InputArgument::REQUIRED, 'The limit of the tweets.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $twitterName = $input->getArgument('twitterName');
        $limit = $input->getArgument('limit');

        $apiResponse = $this->shoutService->shout($this->repo, $twitterName, $limit);

        if ($apiResponse['status'] != Response::HTTP_OK) {
            $output->writeln('Error: ' . $apiResponse['error']);
            return false;
        }

        $output->writeln('Tweets:');
        $output->writeln($apiResponse['tweets']);
    }
}