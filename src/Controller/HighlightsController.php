<?php

namespace App\Controller;

use App\Entity\Highlights;
use App\Form\HighlightsType;
use App\Repository\HighlightsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/highlights')]
class HighlightsController extends AbstractController
{
    #[Route('/', name: 'app_highlights_index', methods: ['GET'])]
    public function index(HighlightsRepository $highlightsRepository): Response
    {
        return $this->render('highlights/index.html.twig', [
            'highlights' => $highlightsRepository->findAll(),
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
