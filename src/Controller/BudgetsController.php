<?php

namespace App\Controller;

use App\Entity\Budgets;
use App\Form\BudgetsType;
use App\Repository\BudgetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/budgets')]
class BudgetsController extends AbstractController
{
    #[Route('/', name: 'app_budgets_index', methods: ['GET'])]
    public function index(BudgetsRepository $budgetsRepository): Response
    {
        return $this->render('budgets/index.html.twig', [
            'budgets' => $budgetsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_budgets_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BudgetsRepository $budgetsRepository): Response
    {
        $budget = new Budgets();
        $form = $this->createForm(BudgetsType::class, $budget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $budgetsRepository->add($budget);
            return $this->redirectToRoute('app_budgets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('budgets/new.html.twig', [
            'budget' => $budget,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_budgets_show', methods: ['GET'])]
    public function show(Budgets $budget): Response
    {
        return $this->render('budgets/show.html.twig', [
            'budget' => $budget,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_budgets_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Budgets $budget, BudgetsRepository $budgetsRepository): Response
    {
        $form = $this->createForm(BudgetsType::class, $budget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $budgetsRepository->add($budget);
            return $this->redirectToRoute('app_budgets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('budgets/edit.html.twig', [
            'budget' => $budget,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_budgets_delete', methods: ['POST'])]
    public function delete(Request $request, Budgets $budget, BudgetsRepository $budgetsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$budget->getId(), $request->request->get('_token'))) {
            $budgetsRepository->remove($budget);
        }

        return $this->redirectToRoute('app_budgets_index', [], Response::HTTP_SEE_OTHER);
    }
}
