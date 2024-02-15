<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\NeuromancerRepository;
use App\Repository\WintermuteRepository;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatusController extends AbstractController
{
    public function __construct(
        private NeuromancerRepository $neuromancerRepository,
        private WintermuteRepository $wintermuteRepository,
        private ContainerInterface $transportLocator,
    ) {
    }

    #[Route('/status', name: 'app_status')]
    public function index(): Response
    {
        return $this->render('status.html.twig', [
            'neuromancer_count' => $this->transportLocator->get('neuromancer')->getMessageCount(),
            'neuromancer_msg' => $this->neuromancerRepository->findRecent(),
            'wintermute_count' => $this->transportLocator->get('wintermute')->getMessageCount(),
            'wintermute_msg' => $this->wintermuteRepository->findRecent(),
        ]);
    }
}
