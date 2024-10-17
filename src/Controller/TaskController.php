<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/task', name: 'task.')]
class TaskController extends AbstractController
{

    #[Route('/{id}', name: 'show')]
    public function show($id): Response
    {
    }

    #[Route('/create', name: 'create')]
    public function index(): Response
    {
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit($id): Response
    {
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id): Response
    {
    }
}
