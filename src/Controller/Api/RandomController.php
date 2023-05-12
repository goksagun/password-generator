<?php

namespace App\Controller\Api;

use App\Generator\RandomGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ZxcvbnPhp\Zxcvbn;

class RandomController extends AbstractController
{
    #[Route('/api/random/generate', name: 'api_random_generate', methods: ['POST'])]
    public function generate(Request $request): JsonResponse
    {
        $strategy = match ($request->get('strategy')) {
            'alpha' => RandomGenerator::STRATEGY_ALPHA,
            'numeric' => RandomGenerator::STRATEGY_NUMERIC,
            'complex' => RandomGenerator::STRATEGY_COMPLEX,
            'alpha-lower' => RandomGenerator::STRATEGY_ALPHA_LOWER,
            'alpha-upper' => RandomGenerator::STRATEGY_ALPHA_UPPER,
            'alphanumeric-lower' => RandomGenerator::STRATEGY_ALPHANUMERIC_LOWER,
            default => RandomGenerator::STRATEGY_ALPHA_NUMERIC,
        };
        $length = $request->get('length', RandomGenerator::DEFAULT_LENGTH);

        return $this->json([
            'data' => [
                'length' => $length,
                'random' => $random = (new RandomGenerator($length, $strategy))->generate(),
                'strength' => (new Zxcvbn())->passwordStrength($random),
            ],
        ], Response::HTTP_CREATED);
    }
}
