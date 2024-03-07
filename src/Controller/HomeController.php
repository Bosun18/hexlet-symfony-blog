<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    #[Route('/', name: 'app_home_index', methods: ['GET'])]
    public function index()
    {
        return $this->render('home/index.html.twig', ['posts' => $this->postRepository->findAll()]);
    }

    #[Route('/{id}', name: 'app_home_show', methods: ['GET'])]
    public function showPost(Post $post)
    {
        return $this->render('home/show.html.twig', ['post' => $post]);
    }
}
