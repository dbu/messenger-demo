<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\WintermuteType;
use App\Message\WintermuteMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class WintermuteController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $messenger,
    ) {
    }

    #[Route('/wintermute', name: 'app_wintermute')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(WintermuteType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()
            && $form->isValid()
        ) {
            $this->messenger->dispatch(new WintermuteMessage($form->getData()->getText()));
            $this->addFlash('success', 'Input received');

            return $this->redirectToRoute('app_wintermute');
        }

        return $this->render('form_wintermute.html.twig', [
            'title' => 'Message for Wintermute',
            'form' => $form,
        ]);
    }
}
