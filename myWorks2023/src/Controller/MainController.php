<?php

namespace App\Controller;

use App\Repository\SitesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(SitesRepository $sitesRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'sites' => $sitesRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('main/admin.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
     
    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('main/contact.html.twig', [
            'controller_name' => 'Salut les amis!',
        ]);
    }
}
