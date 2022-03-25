<?php

namespace App\Controller;

use App\Entity\Bearings;
use App\Form\BearingsType;
use App\Form\BearingsSearchType;
use App\Repository\BearingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bearings')]
class BearingsController extends AbstractController
{
    #[Route('/list/{page}/{filter}', name: 'app_bearings_index', methods: ['GET', 'POST'])]
    public function index(BearingsRepository$bearingsRepository, Request $request, int $page, ?string $filter = null): Response
    {
        $offset = ($page - 1) * 10;
        $bearings = $bearingsRepository->findBy([], [], 10, $offset);
        $all = $bearingsRepository->findAll();

        $form = $this->createForm(BearingsSearchType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData()['filter'];

            if (is_null($filter)) {
                $offset = 0 + (($page - 1) * 10);
                $bearings = $bearingsRepository->findBy([], [], 10, $offset);
                $all = $bearingsRepository->findAll();
            } else {
                $bearings = $bearingsRepository->filterByName($filter);
                $all = $bearings;
            }

            return $this->render('bearings/index.html.twig', [
                'bearings' => $bearings,
                'total' => count($all),
                'numberPages' => intval(round(count($all) / 10)),
                'page' => $page,
                'filter' => $filter,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('bearings/index.html.twig', [
            'bearings' => $bearings,
            'total' => count($all),
            'numberPages' => intval(round(count($all) / 10)),
            'page' => $page,
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'app_bearings_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BearingsRepository $bearingsRepository): Response
    {
        $bearing = new Bearings();
        $form = $this->createForm(BearingsType::class, $bearing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $last = $bearingsRepository->findOneBy([], ['id' => 'DESC']);
            $lastId = $last->getId();

            $bearing->setValue($lastId + 1);

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
