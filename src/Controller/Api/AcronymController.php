<?php

namespace App\Controller\Api;

use App\Service\AcronymGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AcronymController extends AbstractController
{
    public function __construct(
        private readonly AcronymGeneratorInterface $generator,
        private readonly ValidatorInterface $validator
    ) {
    }

    #[Route('/api/acronym/generate', name: 'api_acronym_generate', methods: ['POST'])]
    public function generate(Request $request): JsonResponse
    {
        $constraint = new Assert\Collection([
            'phrase' => [
                new Assert\NotBlank(),
            ],
        ]);

        $violations = $this->validator->validate($request->request->all(), $constraint);

        if ($violations->count()) {
            $data = [
                'error' => [
                    'code' => 4220,
                    'message' => 'Unprocessable entity',
                    'errors' => [],
                ],
            ];

            /** @var ConstraintViolation[] $violations */
            foreach ($violations as $violation) {
                $data['error']['errors'][] = [
                    'path' => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }

            return $this->json($data, 422);
        }

        return $this->json($this->generator->generateWithStrength($request->get('phrase')));
    }
}
