<?php

namespace App\Controller;

use App\Entity\Risks;
use App\Form\RisksType;
use App\Repository\RisksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/risks')]
class RisksController extends AbstractController
{
    #[Route('/', name: 'app_risks_index', methods: ['GET'])]
    public function index(RisksRepository $risksRepository): Response
    {
        return $this->render('risks/index.html.twig', [
            'risks' => $risksRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_risks_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RisksRepository $risksRepository): Response
    {
        $risk = new Risks();
        $form = $this->createForm(RisksType::class, $risk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $risksRepository->add($risk);
            return $this->redirectToRoute('app_risks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('risks/new.html.twig', [
            'risk' => $risk,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_risks_show', methods: ['GET'])]
    public function show(Risks $risk): Response
    {
        return $this->render('risks/show.html.twig', [
            'risk' => $risk,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_risks_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Risks $risk, RisksRepository $risksRepository): Response
    {
        $form = $this->createForm(RisksType::class, $risk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $risksRepository->add($risk);
            return $this->redirectToRoute('app_risks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('risks/edit.html.twig', [
            'risk' => $risk,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_risks_delete', methods: ['POST'])]
    public function delete(Request $request, Risks $risk, RisksRepository $risksRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$risk->getId(), $request->request->get('_token'))) {
            $risksRepository->remove($risk);
        }

        return $this->redirectToRoute('app_risks_index', [], Response::HTTP_SEE_OTHER);
    }
}
