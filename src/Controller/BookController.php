<?php

namespace App\Controller;

use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
  
    #[Route('/book/add2',name:'add2_book')]
   public function add2 (ManagerRegistry $doctrine,Request $request) {
    $em= $doctrine->getManager();
    $book = new book();
    $form=$this->createForm(BookType::class,$book);
    $form->handleRequest($request);
    $book->setPublished(true);
    if($form ->isSubmitted()){ 
    $em->persist($book);
    $em->flush();
   return $this->redirectToRoute('read_book');
    } else {
        return $this->renderForm('book/addbook.html.twig',['f'=>$form]);
    }
   }
   #[Route('/book/readb',name:'read_book')]
   public function readb (BookRepository $bookrepo) {
    $books = $bookrepo->findAll();
    return $this->render('book/readb.hmtl.twig',['books'=> $books]);

   }
}
