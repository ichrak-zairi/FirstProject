<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    #[Route('/film', name: 'app_film')]
    public function index(): Response
    {
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
        ]);
    }

    #[Route('/film/read', name: 'read_film')]
    public function read(FilmRepository $filmrep): Response
    {
        $films = $filmrep->findAll();

        return $this->render('film/read.html.twig', [
            'films' => $films,
        ]);
    }

    #[Route('/film/add', name: 'add_film')]
    public function add(ManagerRegistry $doctrine, Request $request)
    {
        $em= $doctrine->getManager();
        $film = new Film();
        $frm = $this->createForm(FilmType::class,$film);
        $frm->handleRequest($request);
        $film->setViews(1);
        if ($frm->isSubmitted())
        {
            $em->persist($film);
            $em->flush();
            return $this->redirectToRoute('read_film');
        }
        else
            return $this->renderForm('film/add.html.twig', [
                'frm' => $frm,
            ]);
    }
}