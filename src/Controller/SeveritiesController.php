<?php

namespace App\Controller;

use App\Entity\Severities;
use App\Form\SeveritiesType;
use App\Repository\SeveritiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/severities')]
class SeveritiesController extends AbstractController
{
    #[Route('/', name: 'app_severities_index', methods: ['GET'])]
    public function index(SeveritiesRepository $severitiesRepository): Response
    {
        return $this->render('severities/index.html.twig', [
            'severities' => $severitiesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_severities_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SeveritiesRepository $severitiesRepository): Response
    {
        $severity = new Severities();
        $form = $this->createForm(SeveritiesType::class, $severity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $severitiesRepository->add($severity);
            return $this->redirectToRoute('app_severities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('severities/new.html.twig', [
            'severity' => $severity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_severities_show', methods: ['GET'])]
    public function show(Severities $severity): Response
    {
        return $this->render('severities/show.html.twig', [
            'severity' => $severity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_severities_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Severities $severity, SeveritiesRepository $severitiesRepository): Response
    {
        $form = $this->createForm(SeveritiesType::class, $severity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $severitiesRepository->add($severity);
            return $this->redirectToRoute('app_severities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('severities/edit.html.twig', [
            'severity' => $severity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_severities_delete', methods: ['POST'])]
    public function delete(Request $request, Severities $severity, SeveritiesRepository $severitiesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$severity->getId(), $request->request->get('_token'))) {
            $severitiesRepository->remove($severity);
        }

        return $this->redirectToRoute('app_severities_index', [], Response::HTTP_SEE_OTHER);
    }
}
