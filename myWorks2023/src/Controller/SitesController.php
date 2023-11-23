<?php

namespace App\Controller;

use App\Entity\Sites;
use App\Form\SitesType;
use App\Repository\SitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/sites')]
class SitesController extends AbstractController
{
    #[Route('/', name: 'app_sites_index', methods: ['GET'])]
    public function index(SitesRepository $sitesRepository): Response
    {
        return $this->render('sites/index.html.twig', [
            'sites' => $sitesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sites_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $site = new Sites();
        $form = $this->createForm(SitesType::class, $site);
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
                $site->setImg($newFilename);
            }

            $entityManager->persist($site);
            $entityManager->flush();

            return $this->redirectToRoute('app_sites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sites/new.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sites_show', methods: ['GET'])]
    public function show(Sites $site): Response
    {
        return $this->render('sites/show.html.twig', [
            'site' => $site,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sites_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sites $site, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(SitesType::class, $site);
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
                $site->setImg($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_sites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sites/edit.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sites_delete', methods: ['POST'])]
    public function delete(Request $request, Sites $site, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $site->getId(), $request->request->get('_token'))) {
            $entityManager->remove($site);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sites_index', [], Response::HTTP_SEE_OTHER);
    }
}
