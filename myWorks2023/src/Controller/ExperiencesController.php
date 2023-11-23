<?php

namespace App\Controller;

use App\Entity\Experiences;
use App\Form\ExperiencesType;
use App\Repository\ExperiencesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/experiences')]
class ExperiencesController extends AbstractController
{
    #[Route('/', name: 'app_experiences_index', methods: ['GET'])]
    public function index(ExperiencesRepository $experiencesRepository): Response
    {
        return $this->render('experiences/index.html.twig', [
            'experiences' => $experiencesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_experiences_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $experience = new Experiences();
        $form = $this->createForm(ExperiencesType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($experience);
            $entityManager->flush();

            return $this->redirectToRoute('app_experiences_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('experiences/new.html.twig', [
            'experience' => $experience,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_experiences_show', methods: ['GET'])]
    public function show(Experiences $experience): Response
    {
        return $this->render('experiences/show.html.twig', [
            'experience' => $experience,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_experiences_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Experiences $experience, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExperiencesType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_experiences_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('experiences/edit.html.twig', [
            'experience' => $experience,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_experiences_delete', methods: ['POST'])]
    public function delete(Request $request, Experiences $experience, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$experience->getId(), $request->request->get('_token'))) {
            $entityManager->remove($experience);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_experiences_index', [], Response::HTTP_SEE_OTHER);
    }
}
