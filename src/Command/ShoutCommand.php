<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;

class ShoutCommand extends Command
{
    protected static $defaultName = 'app:shout';

    /**
     * @var TweetRepositoryInMemory
     */
    private $repo;

    public function __construct(TweetRepositoryInMemory $repo)
    {
        parent::__construct();

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
        $output->writeln('Tweets:');

        $twitterName = $input->getArgument('twitterName');
        $limit = $input->getArgument('limit');

        if (!is_numeric($limit) || $limit < 1 || $limit > 10) {
            $output->writeln('Error: Limit parameter MUST be equal or less than 10');
        }

        //check valid username ?

        //service???
        $tweets = $this->repo->searchByUserName($twitterName, $limit);

        //service???
        $formattedTweets = [];
        foreach ($tweets as $tweet) {
            $formattedTweets[] = $tweet->getText();
        }

        $output->writeln($formattedTweets);
    }
}