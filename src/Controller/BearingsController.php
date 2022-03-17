<?php

namespace App\Controller;

use App\Entity\Bearings;
use App\Form\BearingsType;
use App\Repository\BearingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bearings')]
class BearingsController extends AbstractController
{
    #[Route('/', name: 'app_bearings_index', methods: ['GET'])]
    public function index(BearingsRepository $bearingsRepository): Response
    {
        return $this->render('bearings/index.html.twig', [
            'bearings' => $bearingsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bearings_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BearingsRepository $bearingsRepository): Response
    {
        $bearing = new Bearings();
        $form = $this->createForm(BearingsType::class, $bearing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bearingsRepository->add($bearing);
            return $this->redirectToRoute('app_bearings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bearings/new.html.twig', [
            'bearing' => $bearing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bearings_show', methods: ['GET'])]
    public function show(Bearings $bearing): Response
    {
        return $this->render('bearings/show.html.twig', [
            'bearing' => $bearing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bearings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bearings $bearing, BearingsRepository $bearingsRepository): Response
    {
        $form = $this->createForm(BearingsType::class, $bearing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bearingsRepository->add($bearing);
            return $this->redirectToRoute('app_bearings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bearings/edit.html.twig', [
            'bearing' => $bearing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bearings_delete', methods: ['POST'])]
    public function delete(Request $request, Bearings $bearing, BearingsRepository $bearingsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bearing->getId(), $request->request->get('_token'))) {
            $bearingsRepository->remove($bearing);
        }

        return $this->redirectToRoute('app_bearings_index', [], Response::HTTP_SEE_OTHER);
    }
}
