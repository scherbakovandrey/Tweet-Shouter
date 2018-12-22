<?php

namespace App\Letgo\Application\Controller;

use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ShoutController extends AbstractController
{
    public function index(TweetRepositoryInMemory $repo, Request $request, $twitterName)
    {
        $limit = $request->query->get('limit');

	//check valid limit
	//check valid username ?

	//service???
        $tweets = $repo->searchByUserName($twitterName, $limit);

	//service???
        $formattedTweets = [];
        foreach ($tweets as $tweet) {
            $formattedTweets[] = $tweet->getText();
        }

        return JsonResponse::create($formattedTweets);
    }
}
