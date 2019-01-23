<?php

namespace App\Letgo\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

final class PagesController extends AbstractController
{
    public function index()
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body><a href="/shout/realDonaldTrump?limit=10">API: /shout/realDonaldTrump?limit=10</a></body></html>'
        );
    }
}