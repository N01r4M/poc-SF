<?php

namespace App\Controller;

use App\Entity\Portfolios;
use App\Form\PortfoliosType;
use App\Form\SearchType;
use App\Repository\PortfoliosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/portfolios')]
class PortfoliosController extends AbstractController
{
    #[Route('/list/{page}/{filter}', name: 'app_portfolios_index', methods: ['GET', 'POST'])]
    public function index(PortfoliosRepository$portfoliosRepository, Request $request, int $page, ?string $filter = null): Response
    {
        $offset = ($page - 1) * 10;
        $portfolios = $portfoliosRepository->findBy([], [], 10, $offset);
        $all = $portfoliosRepository->findAll();

        $form = $this->createForm(SearchType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData()['filter'];

            if (is_null($filter)) {
                $offset = 0 + (($page - 1) * 10);
                $portfolios = $portfoliosRepository->findBy([], [], 10, $offset);
                $all = $portfoliosRepository->findAll();
            } else {
                $portfolios = $portfoliosRepository->filterByName($filter);
                $all = $portfolios;
            }

            return $this->render('portfolios/index.html.twig', [
                'portfolios' => $portfolios,
                'total' => count($all),
                'numberPages' => intval(round(count($all) / 10)),
                'page' => $page,
                'filter' => $filter,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('portfolios/index.html.twig', [
            'portfolios' => $portfolios,
            'total' => count($all),
            'numberPages' => intval(round(count($all) / 10)),
            'page' => $page,
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'app_portfolios_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PortfoliosRepository $portfoliosRepository): Response
    {
        $portfolio = new Portfolios();
        $form = $this->createForm(PortfoliosType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $portfoliosRepository->add($portfolio);
            return $this->redirectToRoute('app_portfolios_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('portfolios/new.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portfolios_show', methods: ['GET'])]
    public function show(Portfolios $portfolio): Response
    {
        $projects = $portfolio->getProjects();
        $manager = $portfolio->getManager();

        return $this->render('portfolios/show.html.twig', [
            'portfolio' => $portfolio,
            'projects' => $projects,
            'manager' => $manager
        ]);
    }

    #[Route('/{id}/edit', name: 'app_portfolios_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Portfolios $portfolio, PortfoliosRepository $portfoliosRepository): Response
    {
        $form = $this->createForm(PortfoliosType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $portfoliosRepository->add($portfolio);
            return $this->redirectToRoute('app_portfolios_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('portfolios/edit.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portfolios_delete', methods: ['POST'])]
    public function delete(Request $request, Portfolios $portfolio, PortfoliosRepository $portfoliosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portfolio->getId(), $request->request->get('_token'))) {
            $portfoliosRepository->remove($portfolio);
        }

        return $this->redirectToRoute('app_portfolios_index', [], Response::HTTP_SEE_OTHER);
    }
}
