<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}

