<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\NeuromancerType;
use App\Message\NeuromancerMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class NeuromancerController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $messenger,
    ) {
    }

    #[Route('/neuromancer', name: 'app_neuromancer')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(NeuromancerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()
            && $form->isValid()
        ) {
            $this->messenger->dispatch(new NeuromancerMessage($form->getData()->getText()));
            $this->addFlash('success', 'Input received');

            return $this->redirectToRoute('app_neuromancer');
        }

        return $this->render('form_neuromancer.html.twig', [
            'title' => 'Message for Neuromancer',
            'form' => $form,
        ]);
    }
}
