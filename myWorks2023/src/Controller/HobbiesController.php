<?php

namespace App\Controller;

use App\Entity\Hobbies;
use App\Form\HobbiesType;
use App\Repository\HobbiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hobbies')]
class HobbiesController extends AbstractController
{
    #[Route('/', name: 'app_hobbies_index', methods: ['GET'])]
    public function index(HobbiesRepository $hobbiesRepository): Response
    {
        return $this->render('hobbies/index.html.twig', [
            'hobbies' => $hobbiesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hobbies_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hobby = new Hobbies();
        $form = $this->createForm(HobbiesType::class, $hobby);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hobby);
            $entityManager->flush();

            return $this->redirectToRoute('app_hobbies_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hobbies/new.html.twig', [
            'hobby' => $hobby,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hobbies_show', methods: ['GET'])]
    public function show(Hobbies $hobby): Response
    {
        return $this->render('hobbies/show.html.twig', [
            'hobby' => $hobby,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hobbies_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hobbies $hobby, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HobbiesType::class, $hobby);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hobbies_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('hobbies/edit.html.twig', [
            'hobby' => $hobby,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hobbies_delete', methods: ['POST'])]
    public function delete(Request $request, Hobbies $hobby, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hobby->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hobby);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hobbies_index', [], Response::HTTP_SEE_OTHER);
    }
}
