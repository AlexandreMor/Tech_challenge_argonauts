<?php

namespace App\Controller;

use App\Entity\Argonaute;
use App\Form\ArgonauteType;
use App\Repository\ArgonauteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArgonauteController extends AbstractController
{
    /**
     * @Route("/", name="argonaute")
     */
    public function index(Request $request,ArgonauteRepository $argonauteRepo, EntityManagerInterface $entityManager): Response
    {
        $argonaute= new Argonaute;
        $form = $this->createForm(ArgonauteType::class, $argonaute);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
 
            $entityManager->persist($argonaute);

            $entityManager->flush();
    
            return $this->redirectToRoute('argonaute');
    
        }
        return $this->render('argonaute/index.html.twig', [
            "form" => $form->createView(),
            "argonautes" => $argonauteRepo->findAll(),
        ]);
    }
}
