<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\PriorityRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/task', name: 'task.')]
class TaskController extends AbstractController
{

    #[Route('/new', name: 'new', methods: ['POST'])]
    #[OA\Response(
        response: 201,
        description: 'Creation of new task'
    )]
    #[OA\Response(
        response: 400,
        description: 'Return if json is invalid'
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['title', 'description', 'priority'],
            properties: [
                new OA\Property(property: 'title', type: 'string', example: 'New Task'),
                new OA\Property(property: 'description', type: 'string', example: 'Description of the task'),
                new OA\Property(property: 'priority', type: 'integer', example: 1)
            ]
        )
    )]
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

    #[Route('/edit/{id}', name: 'edit', methods: ['PUT'])]
    #[OA\Put(
        path: '/task/edit/{id}',
        summary: 'Modifier une tâche existante',
        tags: ['Task'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'description', 'priority'],
                properties: [
                    new OA\Property(property: 'title', type: 'string', example: 'New Task'),
                    new OA\Property(property: 'description', type: 'string', example: 'Description of the task'),
                    new OA\Property(property: 'priority', type: 'integer', example: 1)
                ]
            )
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Tâche mise à jour avec succès',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'success', type: 'string', example: 'Task updated')
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Erreur de validation des données',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'error', type: 'string', example: 'Invalid JSON')
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Tâche non trouvée',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'error', type: 'string', example: 'Task not found')
            ]
        )
    )]
    public function edit(
        Request $request,
        $id,
        EntityManagerInterface $entityManager,
        TaskRepository $taskRepository,
        PriorityRepository $priorityRepository
    ): JsonResponse {
        $task = $taskRepository->find($id);
        if (!$task) {
            return new JsonResponse(['error' => 'Task not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], 400);
        }

        $task->setTitle($data['title'] ?? $task->getTitle());
        $task->setDescription($data['description'] ?? $task->getDescription());

        $priority = $priorityRepository->find($data['priority']);
        if (!$priority) {
            return new JsonResponse(['error' => 'Invalid priority'], 400);
        }
        $task->setPriority($priority);

        $entityManager->flush();

        return new JsonResponse(['success' => 'Task updated'], 200);
    }

    // #[Route('/delete/{id}', name: 'delete')]
    // public function delete($id): Response
    // {
    // }
}
