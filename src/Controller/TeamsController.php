<?php

namespace App\Controller;

use App\Entity\Teams;
use App\Form\TeamsType;
use App\Form\SearchType;
use App\Repository\TeamsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/teams')]
class TeamsController extends AbstractController
{
    #[Route('/list/{page}/{filter}', name: 'app_teams_index', methods: ['GET', 'POST'])]
    public function index(TeamsRepository$teamsRepository, Request $request, int $page, ?string $filter = null): Response
    {
        $offset = ($page - 1) * 10;
        $teams = $teamsRepository->findBy([], [], 10, $offset);
        $all = $teamsRepository->findAll();

        $form = $this->createForm(SearchType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData()['filter'];

            if (is_null($filter)) {
                $offset = 0 + (($page - 1) * 10);
                $teams = $teamsRepository->findBy([], [], 10, $offset);
                $all = $teamsRepository->findAll();
            } else {
                $teams = $teamsRepository->filterByName($filter);
                $all = $teams;
            }

            return $this->render('teams/index.html.twig', [
                'teams' => $teams,
                'total' => count($all),
                'numberPages' => intval(round(count($all) / 10)),
                'page' => $page,
                'filter' => $filter,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('teams/index.html.twig', [
            'teams' => $teams,
            'total' => count($all),
            'numberPages' => intval(round(count($all) / 10)),
            'page' => $page,
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'app_teams_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TeamsRepository $teamsRepository): Response
    {
        $team = new Teams();
        $form = $this->createForm(TeamsType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamsRepository->add($team);
            return $this->redirectToRoute('app_teams_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teams/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teams_show', methods: ['GET'])]
    public function show(Teams $team): Response
    {
        $members = $team->getMembers();

        return $this->render('teams/show.html.twig', [
            'team' => $team,
            'members' => $members
        ]);
    }

    #[Route('/{id}/edit', name: 'app_teams_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Teams $team, TeamsRepository $teamsRepository): Response
    {
        $form = $this->createForm(TeamsType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamsRepository->add($team);
            return $this->redirectToRoute('app_teams_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('teams/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teams_delete', methods: ['POST'])]
    public function delete(Request $request, Teams $team, TeamsRepository $teamsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $teamsRepository->remove($team);
        }

        return $this->redirectToRoute('app_teams_index', [], Response::HTTP_SEE_OTHER);
    }
}
