<?php

namespace App\Controller;

use App\Repository\ProjectsRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_home')]
    public function index(ProjectsRepository $projectsRepository, StatusRepository $statusRepository): Response
    {
        $team = $this->security->getUser()->getTeam();

        $status = $statusRepository->findAll();
        $countTeam = [];
        $countAll = [];

        foreach ($status as $st) {
            $teamProjects = $projectsRepository->findBy(['teamProject' => $team, 'status' => $st->getId()]);
            $projects = $projectsRepository->findBy(['status' => $st->getId()]);

            $countTeam[] = [$st->getName(), count($teamProjects)];
            $countAll[] = [$st->getName(), count($projects)];
        }

        return $this->render('home/index.html.twig', [
            'teamProjects' => $projectsRepository->findBy(['teamProject' => $team, 'status' => 197]),
            'projects' => $projectsRepository->findBy(['status' => 197]),
            'countTeamProjects' => $countTeam,
            'countProjects' => $countAll,
        ]);
    }
}
