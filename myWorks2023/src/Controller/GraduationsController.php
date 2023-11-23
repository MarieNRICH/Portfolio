<?php

namespace App\Controller;

use App\Entity\Graduations;
use App\Form\GraduationsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GraduationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/graduations')]
class GraduationsController extends AbstractController
{
    #[Route('/', name: 'app_graduations_index', methods: ['GET'])]
    public function index(GraduationsRepository $graduationsRepository): Response
    {
        return $this->render('graduations/index.html.twig', [
            'graduations' => $graduationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_graduations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $graduation = new Graduations();
        $form = $this->createForm(GraduationsType::class, $graduation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('img')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $graduation->setImg($newFilename);
            }

            $entityManager->persist($graduation);
            $entityManager->flush();

            return $this->redirectToRoute('app_graduations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('graduations/new.html.twig', [
            'graduation' => $graduation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_graduations_show', methods: ['GET'])]
    public function show(Graduations $graduation): Response
    {
        return $this->render('graduations/show.html.twig', [
            'graduation' => $graduation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_graduations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Graduations $graduation, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(GraduationsType::class, $graduation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('img')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $graduation->setImg($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_graduations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('graduations/edit.html.twig', [
            'graduation' => $graduation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_graduations_delete', methods: ['POST'])]
    public function delete(Request $request, Graduations $graduation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $graduation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($graduation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_graduations_index', [], Response::HTTP_SEE_OTHER);
    }
}
