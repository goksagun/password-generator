<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class RequestTransformerListener
{
    #[AsEventListener(event: KernelEvents::REQUEST)]
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->getContentTypeFormat() === 'json' && $request->getContent()) {
            try {
                $data = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

                if (\is_array($data)) {
                    $request->request->replace($data);
                }
            } catch (\JsonException $e) {
                $event->setResponse(new JsonResponse(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST));
            }
        }
    }
}
