<?php

namespace App\Controller;

use App\Entity\AnotherForm;
use App\Entity\Example;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/example/create', name: "app_example_create")]
    public function create(Request $request): Response
    {
        $example = new Example();

        $form = $this->createFormBuilder($example)
            ->add('name', TextType::class, ['label' => 'ExampleName'])
            ->add('save', SubmitType::class, ['label' => 'Create Example'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $example = $form->getData();

            $this->em->persist($example);
            $this->em->flush();

            return $this->redirectToRoute('app_example_create');
        }

        return $this->render('example/create.html.twig', compact('form'));
    }
}
