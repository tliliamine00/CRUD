<?php

namespace App\Controller;

use App\Entity\Transporteur;
use App\Form\TransporteurType;
use App\Repository\TransporteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;


class TransporteurController extends AbstractController
{
    /**
     * @Route("/transporteursss", name="transporteurss")
     */
    public function index(): Response
    {
        return $this->render('back/transporteur.html.twig', [
            'controller_name' => 'TransporteurController',
        ]);
    }
    /**
     * @Route("/SupprimerTransporteur/{id}",name="deletetransporteur")
     */
    function Delete($id,TransporteurRepository $repository)
    {
        $transporteur=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($transporteur);
        $em->flush();//mise a jour
        return $this->redirectToRoute('ajoutertransporteur');
    }



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/transporteurs",name="ajoutertransporteur")
     */
    function Add(Request $request,\Swift_Mailer $mailer)
    {
        $transporteur=new Transporteur();
        $form=$this->createForm(TransporteurType::class, $transporteur);
        $en=$this->getDoctrine()->getManager()->getRepository(Transporteur::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($transporteur);
            $message = (new \Swift_Message('Bienvenue'))
                ->setFrom('hytacocampi21@gmail.com')
                ->setTo($transporteur->getMail())
                ->setBody(
                    'Bienvenue, vous êtes officiellement le chauffeur de Hytaco, veuillez attendre votre affectation!'
                )
            ;
            $mailer->send($message);
            $em->flush();
            return $this->redirectToRoute('ajoutertransporteur');

        }
        if($request->isMethod("POST"))
        {
            $nom = $request->get('nom');
            $transporteur=$this->getDoctrine()->getManager()->getRepository(Transporteur::class)->findBy(array('nom'=>$nom));
            return $this->render('back/transporteur.html.twig',
                [
                    'form'=>$form->createView(), 'trans'=>$transporteur
                ]
            );
        }

        return $this->render('back/transporteur.html.twig',
            [
                'form'=>$form->createView(), 'trans'=>$en
            ]
        );

    }


    /**
     * @param Request $request
     * @Route("/ModifierTransporteur/{id}",name="modifiertransporteur")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier(TransporteurRepository $repository,$id,Request $request)
    {
        $transporteur=$repository->find($id);
        $form=$this->createForm(TransporteurType::class,$transporteur);
        $en=$this->getDoctrine()->getManager()->getRepository(Transporteur::class)->findAll();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('ajoutertransporteur');
        }
        return $this->render('back/transporteur.html.twig',
            [
                'form'=>$form->createView(), 'trans'=>$en
            ]
        );
    }


}
