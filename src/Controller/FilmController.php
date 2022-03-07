<?php

namespace App\Controller;


use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    #[Route('/', name: 'films')]
    public function index(FilmRepository $repository): Response
    {
        $films=$repository->findAll();

        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }

##################################################################"

    #[Route('film/show/{id}', name: 'show')]
    public function show(Film $film): Response
    {

        return $this->render('film/show.html.twig', [
            'film' => $film,
        ]);
    }
########################################################################"
    #[Route('film/delete/{id}', name: 'delete')]
    public function delete(Film $film = null, EntityManagerInterface $manager){

        if($film){
        $manager->remove($film);
        $manager->flush();
        }
        return $this->redirecteToRoute(route:'films');
    }
###################################################################################""
    #[Route('/film/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface  $manager): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($film);
            $manager->flush();
            return $this->redirectToRoute('show');
        }
        return $this->renderForm( 'film/new.html.twig',
            ['form'=> $form]
        );
    }


    #[Route('/film/change/{id}', name: 'change')]
    public function change(Film $film,Request $request,EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($film);
            $manager->flush();

            return $this->redirectToRoute('show', [
                'id'=> $film->getId(),
            ]);

        }

        return $this->renderForm('film/edition.html.twig',[

            'form' => $form,
        ]);

    }




}
