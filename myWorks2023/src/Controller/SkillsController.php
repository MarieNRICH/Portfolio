<?php

namespace App\Controller;

use App\Entity\Skills;
use App\Form\SkillsType;
use App\Repository\SkillsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/skills')]
class SkillsController extends AbstractController
{
    #[Route('/', name: 'app_skills_index', methods: ['GET'])]
    public function index(SkillsRepository $skillsRepository): Response
    {
        return $this->render('skills/index.html.twig', [
            'skills' => $skillsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_skills_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $skill = new Skills();
        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('icons')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $skill->setIcons($newFilename);
            }

            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('app_skills_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('skills/new.html.twig', [
            'skill' => $skill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_skills_show', methods: ['GET'])]
    public function show(Skills $skill): Response
    {
        return $this->render('skills/show.html.twig', [
            'skill' => $skill,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_skills_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Skills $skill, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(SkillsType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('icons')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $skill->setIcons($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_skills_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('skills/edit.html.twig', [
            'skill' => $skill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_skills_delete', methods: ['POST'])]
    public function delete(Request $request, Skills $skill, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token'))) {
            $entityManager->remove($skill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_skills_index', [], Response::HTTP_SEE_OTHER);
    }
}
