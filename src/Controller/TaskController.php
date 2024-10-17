<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\PriorityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/task', name: 'task.')]
class TaskController extends AbstractController
{

    // #[Route('/{id}', name: 'show')]
    // public function show($id): Response
    // {
    // }

    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        PriorityRepository $priorityRepository
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], 400);
        }

        $task = new Task();
        $task->setTitle($data['title'] ?? '');
        $task->setDescription($data['description'] ?? '');
        $task->setDone(false);

        $priority = $priorityRepository->find($data['priority']);
        if (!$priority) {
            return new JsonResponse(['error' => 'Invalid priority'], 400);
        }
        $task->setPriority($priority);

        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse(['success' => 'Task created'], 201);
    }



    // #[Route('/edit/{id}', name: 'edit')]
    // public function edit($id): Response
    // {
    // }

    // #[Route('/delete/{id}', name: 'delete')]
    // public function delete($id): Response
    // {
    // }
}
