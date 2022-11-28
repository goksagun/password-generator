<?php

namespace App\Controller\Api;

use App\Service\PasswordGeneratorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{
    public function __construct(private readonly PasswordGeneratorService $generator)
    {
    }

    #[Route('/api/password/generate', name: 'api_password', methods: ['POST'])]
    public function generate(Request $request): JsonResponse
    {
        return $this->json($this->generator->generate($request->get('phrase')));
    }
}
