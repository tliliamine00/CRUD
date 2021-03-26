<?php

namespace App\Controller;

use App\Entity\Transporteur;
use App\Form\TransporteurType;
use App\Repository\TransporteurRepository;
use App\Entity\Reclamations;
use App\Form\ReclamationsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;

class FrontaccController extends AbstractController
{
    /**
     * @Route("/accueil", name="frontacc")
     */
    public function ajouterReclamation(Request $request,\Swift_Mailer $mailer): Response
    { $reclamations=new Reclamations();
        $form=$this->createForm(ReclamationsType::class, $reclamations);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclamations);
            $message = (new \Swift_Message('Madame, Monsieur, '))
                ->setFrom('hytacocampi21@gmail.com')
                ->setTo($reclamations->getEmail())
                ->setBody(
                    'Nous avons bien pris en compte votre réclamation. soyons assuré que cet incident demeure tout a fait exceptionnel et totalement indépendant de notre volonté, nous en sommes convaincue, devrait répondre a vos exigences.'
                )
            ;
            $mailer->send($message);
            $em->flush();
            return $this->redirectToRoute('frontacc');

        }
        return $this->render('front/acceuil.html.twig',
            [
                'form'=>$form->createView()
            ]
        );

    }

    /**
     * @Route("/comptef", name="frontcompte")
     */
    public function compte(): Response
    {
        return $this->render('front/compte.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

    /**
     * @Route("/affichef", name="frontaffichage")
     */
    public function affiche(): Response
    {
        return $this->render('front/consult.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }


    /**
     * @Route("/alertsf", name="alertesfff")
     */
    public function alets(): Response
    {
        return $this->render('front/alertes.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

    /**
     * @Route("/visitorf", name="frontcomptee")
     */
    public function visitor(): Response
    {
        return $this->render('front/visitor.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

    /**
     * @Route("/produitf", name="frontproduits")
     */
    public function produits(): Response
    {
        return $this->render('front/produits.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

    /**
     * @Route("/commandef", name="frontcommande")
     */
    public function commandes(): Response
    {
        return $this->render('front/commandes.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }


    /**
     * @Route("/programmef", name="frontprogrammes")
     */
    public function programmes(): Response
    {
        return $this->render('front/programmes.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }



    /**
     * @Route("/profilef", name="frontprofile")
     */
    public function profile(): Response
    {
        return $this->render('front/profile.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

    /**
     * @Route("/evenementf", name="frontevenements")
     */
    public function evenements(): Response
    {
        return $this->render('front/evenements.html.twig', [
            'controller_name' => 'FrontaccController',
        ]);
    }

}
