<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class BookController extends AbstractController
{
    #[Route('', name:'app_book_index',methods: ['GET'])]
    public function index(BookRepository $repository,Request $request): Response
    {


        $books = $repository->findAll();

        // Utiliser ArrayAdapter pour adapter les données à Pagerfanta
        $adapter = new ArrayAdapter($books);
        $pagerfanta = new Pagerfanta($adapter);

        // Récupérer le numéro de la page actuelle depuis la requête
        $currentPage = $request->query->getInt('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $pagerfanta->setMaxPerPage(10); // Nombre d'éléments par page

        return $this->render('book/index.html.twig', [
            'books' => $pagerfanta,]);
    }
    #[Route('/book/{id}', name: 'app_book_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
}
