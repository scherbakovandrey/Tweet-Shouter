<?php

namespace App\Letgo\Application\Controller;

use App\Letgo\Domain\ShoutServiceInterface;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class ShoutController extends AbstractController
{
    public function index(ShoutServiceInterface $shoutService, TweetRepositoryInMemory $repo, Request $request, $twitterName)
    {
        $limit = $request->query->get('limit');

        $apiResponse = $shoutService->shout($repo, $twitterName, $limit);

        if ($apiResponse['status'] != Response::HTTP_OK) {
            return new JsonResponse($apiResponse, $apiResponse['status']);
        }

        return JsonResponse::create($apiResponse['tweets']);
    }
}