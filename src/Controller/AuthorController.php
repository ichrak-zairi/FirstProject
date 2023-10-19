<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use App\Entity\Author;
use App\Form\AuthorType;
use Doctrine\Persistence\ManagerRegistry;
class AuthorController extends AbstractController
{
    #[Route('/showAuthor/{name}', name: 'app_author')]
    public function showAuthor($name): Response
    {
        return $this->render('author/show.html.twig',
        ['name' => $name]);
    }
    #[Route('/list', name: 'app_list2')]
    // variable locale le tableau dans le function list 
public function list () {
    $authors= array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
        );
        return $this->render('author/list.html.twig',['authors'=> $authors]);  
}
#[Route('/author_details/{id}', name:'author_details')]
public function author_details ($id)
{
    $authors= array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    return $this->render('author/showAuthor.html.twig',['authors'=> $authors,'id' => $id]);
}
    #[Route('/author/read',name:'read_author')]
   public function read (AuthorRepository $authorrepo) {
    $authors = $authorrepo->findAll();
    return $this->render('author/read.hmtl.twig',['authors'=> $authors]);

   }
   #[Route('/author/add',name:'add_author')]
   public function add (ManagerRegistry $doctrine) {
    $em= $doctrine->getManager();
    $author = new Author();
    $author->setUsername("ichrakzeiri"); //ajouter statique sans formulaire
    $author->setEmail("ichrak.zeiri@gmail.com") ;
    $em->persist($author);
    $em->flush();
   // return new response('objet ajoute');
   return $this->redirectToRoute('read_author');

   }
   #[Route('/author/add2',name:'add2_author')]
   public function add2 (ManagerRegistry $doctrine,Request $request) {
    $em= $doctrine->getManager();
    $author = new Author();
    $form=$this->createForm(AuthorType :: class,$author);
    $form->handleRequest($request);
    if($form ->isSubmitted()){ 
    $em->persist($author);
    $em->flush();
   return $this->redirectToRoute('read_author');
    } else {
        return $this->renderForm('author/add.html.twig',['f'=>$form]);
    }
   }
   #[Route('/author/delete/{id}',name:'delete_author')]
   public function delete (ManagerRegistry $doctrine,authorRepository $authorrepo,$id){

    $em= $doctrine->getManager();
    $author=$authorrepo->find($id);

    $em->remove($author);
    $em->flush();

    return $this->redirectToRoute("read_author");
   }
   #[Route('/author/update/{id}',name:'update_author')]
   public function update (ManagerRegistry $doctrine,authorRepository $authorrepo,Request $request,$id){
    
    $em= $doctrine->getManager();
    $author=$authorrepo->find($id);
    $form=$this->createForm(AuthorType :: class,$author);
    $form->handleRequest($request);
    if ($form->isSubmitted()){
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute("read_author");
    }
return $this->renderForm("author/update.html.twig",["form"=>$form]);

   }
   }
