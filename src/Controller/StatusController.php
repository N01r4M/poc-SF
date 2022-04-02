<?php

namespace App\Controller;

use App\Entity\Status;
use App\Form\StatusType;
use App\Form\SearchType;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/status')]
class StatusController extends AbstractController
{
    #[Route('/list/{page}/{filter}', name: 'app_status_index', methods: ['GET', 'POST'])]
    public function index(StatusRepository$statusRepository, Request $request, int $page, ?string $filter = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $offset = ($page - 1) * 10;
        $status = $statusRepository->findBy([], [], 10, $offset);
        $all = $statusRepository->findAll();

        $form = $this->createForm(SearchType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData()['filter'];

            if (is_null($filter)) {
                $offset = 0 + (($page - 1) * 10);
                $status = $statusRepository->findBy([], [], 10, $offset);
                $all = $statusRepository->findAll();
            } else {
                $status = $statusRepository->filterByName($filter);
                $all = $status;
            }

            return $this->render('status/index.html.twig', [
                'status' => $status,
                'total' => count($all),
                'numberPages' => intval(round(count($all) / 10)),
                'page' => $page,
                'filter' => $filter,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('status/index.html.twig', [
            'status' => $status,
            'total' => count($all),
            'numberPages' => intval(round(count($all) / 10)),
            'page' => $page,
            'form' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'app_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StatusRepository $statusRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $last = $statusRepository->findOneBy([], ['id' => 'DESC']);
            $lastId = $last->getId();

            $status->setValue($lastId + 1);

            $statusRepository->add($status);
            return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('status/new.html.twig', [
            'status' => $status,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_status_show', methods: ['GET'])]
    public function show(Status $status): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('status/show.html.twig', [
            'status' => $status,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Status $status, StatusRepository $statusRepository): Response
    {
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $statusRepository->add($status);
            return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('status/edit.html.twig', [
            'status' => $status,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_status_delete', methods: ['POST'])]
    public function delete(Request $request, Status $status, StatusRepository $statusRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$status->getId(), $request->request->get('_token'))) {
            $statusRepository->remove($status);
        }

        return $this->redirectToRoute('app_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
