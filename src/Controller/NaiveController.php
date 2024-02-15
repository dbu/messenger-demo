<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\WintermuteType;
use App\Repository\WintermuteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NaiveController extends AbstractController
{
    public function __construct(
        private WintermuteRepository $wintermuteRepository,
    ) {
    }

    #[Route('/naive', name: 'app_naive')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(WintermuteType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()
            && $form->isValid()
        ) {
            $this->wintermuteRepository->save($form->getData());
            $this->addFlash('success', 'Input received');

            return $this->redirectToRoute('app_naive');
        }

        return $this->render('form.html.twig', [
            'title' => 'Message for Wintermute',
            'form' => $form,
        ]);
    }
}
