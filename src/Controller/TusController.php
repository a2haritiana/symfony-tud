<?php

namespace App\Controller;

use App\Service\TusService;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TusController extends AbstractController
{
    public function __construct(private readonly TusService $service, private readonly LoggerInterface $logger)
    {
    }

    #[Route(
        '/tus/{token?}',
        name: 'tus',
        requirements: ['token' => '[\w\-=]+'],
        methods: ['POST', 'PATCH', 'HEAD', 'OPTIONS'],
        schemes: ['https']
    )]
    public function tusServer(): BinaryFileResponse|Response
    {
        try {
            $tusResponse = $this->service->getServer()->serve();

            return $tusResponse->send();

        } catch (ReflectionException $e) {
            $this->logger->error('--- TUS ERROR --- ' . $e->getMessage());

            return $this->json([
                'error'   => 'Erreur TUS',
                'message' => $e->getMessage(),
            ]);
        }

    }
}
