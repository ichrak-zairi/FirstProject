<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/category/read', name: 'read_category')]
    public function read(CategoryRepository $categoryrep): Response
    {
        $categorys = $categoryrep->findAll();

        return $this->render('category/read.html.twig', [
            'categorys' => $categorys,
        ]);
    }

    #[Route('/category/add', name: 'add_category')]
    public function add(ManagerRegistry $doctrine, Request $request)
    {
        $em= $doctrine->getManager();
        $category = new Category();
        $frm = $this->createForm(CategoryType::class,$category);
        $frm->handleRequest($request);
        if ($frm->isSubmitted())
        {
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('read_category');
        }
        else
            return $this->renderForm('category/add.html.twig', [
                'frm' => $frm,
            ]);
    }
}