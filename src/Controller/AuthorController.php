<?php

namespace App\Controller;

use App\Form\AuthorType;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    #[Route('/showAuthor/{name}', name: 'app_showAuthor')]

    public function showAuthor ($name)
    {
        return $this->render('author/show.html.twig',['n'=>$name]);

    }
    #[Route('/showlist', name: 'app_showlist')]

    public function list()
    {$authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
    );
        return $this->render("author/list.html.twig",['authors'=>$authors]);
    }
    #[Route('/auhtorDetails/{id}', name: 'app_authorDetails')]

    public function auhtorDetails»($id)
    {
        $author = [
            'id' => $id,
            'picture' => '~images',
            'username' => 'Author',
            'email' => 'author.email',
            'nb_books' => 10,
        ];

        return $this->render("author/showAuthor.html.twig",['author'=>$author]);
        }
    #[Route('/Affiche', name: 'app_Affiche')]


    public function Affiche (AuthorRepository $repository)
        {
            $author=$repository->findAll() ; //select *
            return $this->render('author/Affiche.html.twig',['author'=>$author]);
        }

    #[Route('/Add', name: 'app_Add')]

public function  Add (Request  $request)
{
    $author=new Author();
    $form =$this->CreateForm(AuthorType::class,$author);
  $form->add('Ajouter',SubmitType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid())
    {
        $em=$this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute('app_Affiche');
    }
    return $this->render('author/Add.html.twig',['f'=>$form->createView()]);

}
    #[Route('/edit/{id}', name: 'app_edit')]
    public function edit(AuthorRepository $repository, $id, Request $request)
    {
        $author = $repository->find($id);
        $form = $this->createForm(AuthorType::class, $author);
        $form->add('Edit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush(); // Correction : Utilisez la méthode flush() sur l'EntityManager pour enregistrer les modifications en base de données.
            return $this->redirectToRoute("app_Affiche");
        }

        return $this->render('author/edit.html.twig', [
            'f' => $form->createView(),
        ]);
    }
    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete($id, AuthorRepository $repository)
    {
        $author = $repository->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();

        
        return $this->redirectToRoute('app_Affiche');
    }
    #[Route('/AddStatistique', name: 'app_AddStatistique')]

    public function addStatistique(EntityManagerInterface $entityManager): Response
    {
        // Créez une instance de l'entité Author
        $author1 = new Author();
        $author1->setUsername("test"); // Utilisez "setUsername" pour définir le nom d'utilisateur
        $author1->setEmail("test@gmail.com"); // Utilisez "setEmail" pour définir l'email

        // Enregistrez l'entité dans la base de données
        $entityManager->persist($author1);
        $entityManager->flush();

        return $this->redirectToRoute('app_Affiche'); // Redirigez vers la route 'app_Affiche'
    }
}

