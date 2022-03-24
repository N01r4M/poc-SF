<?php

namespace App\Controller;

use App\Entity\Phases;
use App\Form\PhasesType;
use App\Repository\PhasesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/phases')]
class PhasesController extends AbstractController
{
    #[Route('/', name: 'app_phases_index', methods: ['GET'])]
    public function index(PhasesRepository $phasesRepository): Response
    {
        return $this->render('phases/index.html.twig', [
            'phases' => $phasesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_phases_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PhasesRepository $phasesRepository): Response
    {
        $phase = new Phases();
        $form = $this->createForm(PhasesType::class, $phase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $last = $phasesRepository->findOneBy([], ['id' => 'DESC']);
            $lastId = $last->getId();

            $phase->setValue($lastId + 1);

            $phasesRepository->add($phase);
            return $this->redirectToRoute('app_phases_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('phases/new.html.twig', [
            'phase' => $phase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_phases_show', methods: ['GET'])]
    public function show(Phases $phase): Response
    {
        return $this->render('phases/show.html.twig', [
            'phase' => $phase,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_phases_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Phases $phase, PhasesRepository $phasesRepository): Response
    {
        $form = $this->createForm(PhasesType::class, $phase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phasesRepository->add($phase);
            return $this->redirectToRoute('app_phases_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('phases/edit.html.twig', [
            'phase' => $phase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_phases_delete', methods: ['POST'])]
    public function delete(Request $request, Phases $phase, PhasesRepository $phasesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phase->getId(), $request->request->get('_token'))) {
            $phasesRepository->remove($phase);
        }

        return $this->redirectToRoute('app_phases_index', [], Response::HTTP_SEE_OTHER);
    }
}
