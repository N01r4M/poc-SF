<?php

namespace App\Controller;

use App\Entity\Phases;
use App\Form\PhasesType;
use App\Form\PhasesSearchType;
use App\Repository\PhasesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/phases')]
class PhasesController extends AbstractController
{
    #[Route('/list/{page}/{filter}', name: 'app_phases_index', methods: ['GET', 'POST'])]
    public function index(PhasesRepository $phasesRepository, Request $request, int $page, ?string $filter = null): Response
    {
        $offset = ($page - 1) * 10;
        $phases = $phasesRepository->findBy([], [], 10, $offset);
        $all = $phasesRepository->findAll();

        $form = $this->createForm(PhasesSearchType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData()['filter'];

            if (is_null($filter)) {
                $offset = 0 + (($page - 1) * 10);
                $phases = $phasesRepository->findBy([], [], 10, $offset);
                $all = $phasesRepository->findAll();
            } else {
                $phases = $phasesRepository->filterByName($filter);
                $all = $phases;
            }
            
            return $this->render('phases/index.html.twig', [
                'phases' => $phases,
                'total' => count($all),
                'numberPages' => intval(round(count($all) / 10)),
                'page' => $page,
                'filter' => $filter,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('phases/index.html.twig', [
            'phases' => $phases,
            'total' => count($all),
            'numberPages' => intval(round(count($all) / 10)),
            'page' => $page,
            'form' => $form->createView()
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
