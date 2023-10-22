<?php

namespace App\Controller;
use App\Entity\Book;
use App\Form\BookType;
use App\Form\AuthorType;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/book/add2',name : 'add2_book')]
public function add2 (ManagerRegistry $doctrine , Request $request)
{
    $em = $doctrine->getManager();
    $book = new Book();
  $form = $this->createForm(BookType::class,$book);
  $form->handleRequest($request);
 
  if ($form->isSubmitted())
  { 
    $book->setPublished(true);
$em->persist($book);
$em->flush();
return $this->redirectToRoute('read_book');
}
else
{
   return $this->renderForm('book/addbook.html.twig',['f'=>$form]);
}
}
#[Route('/book/read',name:'read_book')]
public function read (BookRepository $bookrepo) {
 $book = $bookrepo->findAll();
 return $this->render('book/read.hmtl.twig',['books'=> $book]);
}
#[Route('/book/edit/{id}', name: 'edit_book')]
public function edit(ManagerRegistry $doctrine, BookRepository $bookrepo, Request $request, $id)
{
    $book = $bookrepo->find($id);
    $em = $doctrine->getManager();
    $form = $this->createForm(BookType::class, $book);

    $form->handleRequest($request);
    if ($form->isSubmitted()) {
        $em->persist($book);
        $em->flush();
        return $this->redirectToRoute("read_book");
    }

    return $this->renderForm("book/edit.html.twig", ["form" => $form]);
}
#[Route('/book/delete/{id}', name: 'delete_book')]
public function delete(ManagerRegistry $doctrine, BookRepository $bookrep, $id)
{
    $em = $doctrine->getManager();
    $book = $bookrep->find($id);

    $em->remove($book);
    $em->flush();

    return $this->redirectToRoute("read_book");
}
#[Route('/book/show/{id}', name: 'show_book')]
public function showBook(int $id, BookRepository $bookRepository): Response
{
    $book = $bookRepository->find($id);

    if (!$book) {
        throw $this->createNotFoundException('Le livre demandé n\'existe pas.');
    }

    return $this->render('book/show.html.twig', ['book' => $book]);
}

}