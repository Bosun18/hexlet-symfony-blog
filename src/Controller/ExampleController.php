<?php

namespace App\Controller;

use App\Entity\Example;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExampleController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    #[Route('/example')]
    public function index(): Response
    {
        $data = $this->em->getRepository(Example::class)->findAll();

        return $this->json($data);
    }


    #[Route('/example/create')]
    public function create(): Response
    {
        $example = new Example();
        $example->setName('created_at_' . time());

        $this->em->persist($example);
        $this->em->flush();

        return $this->json($example);
    }
}
