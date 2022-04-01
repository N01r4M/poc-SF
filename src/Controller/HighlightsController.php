<?php

namespace App\Controller;

use App\Entity\Highlights;
use App\Form\HighlightsType;
use App\Form\SearchType;
use App\Repository\HighlightsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/highlights')]
class HighlightsController extends AbstractController
{
    #[Route('/list/{page}/{filter}', name: 'app_highlights_index', methods: ['GET', 'POST'])]
    public function index(HighlightsRepository$highlightsRepository, Request $request, int $page, ?string $filter = null): Response
    {
        $offset = ($page - 1) * 10;
        $highlights = $highlightsRepository->findBy([], [], 10, $offset);
        $all = $highlightsRepository->findAll();

        $form = $this->createForm(SearchType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData()['filter'];

            if (is_null($filter)) {
                $offset = ($page - 1) * 10;
                $highlights = $highlightsRepository->findBy([], [], 10, $offset);
                $all = $highlightsRepository->findAll();
            } else {
                $highlights = $highlightsRepository->filterByName($filter);
                $all = $highlights;
            }

            return $this->render('highlights/index.html.twig', [
                'highlights' => $highlights,
                'total' => count($all),
                'numberPages' => intval(round(count($all) / 10)),
                'page' => $page,
                'filter' => $filter,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('highlights/index.html.twig', [
            'highlights' => $highlights,
            'total' => count($all),
            'numberPages' => intval(round(count($all) / 10)),
            'page' => $page,
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'app_highlights_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HighlightsRepository $highlightsRepository): Response
    {
        $highlight = new Highlights();
        $form = $this->createForm(HighlightsType::class, $highlight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $highlightsRepository->add($highlight);
            return $this->redirectToRoute('app_highlights_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('highlights/new.html.twig', [
            'highlight' => $highlight,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_highlights_show', methods: ['GET'])]
    public function show(Highlights $highlight): Response
    {
        return $this->render('highlights/show.html.twig', [
            'highlight' => $highlight,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_highlights_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Highlights $highlight, HighlightsRepository $highlightsRepository): Response
    {
        $form = $this->createForm(HighlightsType::class, $highlight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $highlightsRepository->add($highlight);
            return $this->redirectToRoute('app_highlights_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('highlights/edit.html.twig', [
            'highlight' => $highlight,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_highlights_delete', methods: ['POST'])]
    public function delete(Request $request, Highlights $highlight, HighlightsRepository $highlightsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$highlight->getId(), $request->request->get('_token'))) {
            $highlightsRepository->remove($highlight);
        }

        return $this->redirectToRoute('app_highlights_index', [], Response::HTTP_SEE_OTHER);
    }
}
