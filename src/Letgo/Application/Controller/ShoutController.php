<?php

namespace App\Letgo\Application\Controller;

use App\Letgo\Application\ShoutApp;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class ShoutController extends AbstractController
{
    public function index(TweetRepositoryInMemory $repo, Request $request, $twitterName)
    {
        $limit = $request->query->get('limit');

        $apiResponse = (new ShoutApp())->shout($repo, $twitterName, $limit);

        if ($apiResponse['status'] != Response::HTTP_OK) {
            return new JsonResponse($apiResponse, $apiResponse['status']);
        }

        return JsonResponse::create($apiResponse['tweets']);
    }
}