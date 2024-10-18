<?php

namespace App\Controller;

use App\Repository\PriorityRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'home.')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TaskRepository $taskRepository, PriorityRepository $priorityRepository): Response
    {
        $tasks = $taskRepository->findAll() ?: "No tasks found";
        $priorities = $priorityRepository->findAll();

        return $this->render('home/index.html.twig', [
            'tasks' => $tasks,
            'priorities' => $priorities,
        ]);
    }
}
