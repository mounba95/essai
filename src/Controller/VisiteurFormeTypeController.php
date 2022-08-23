<?php

namespace App\Controller;


use App\Entity\Visiteur;
use App\Form\VisiteurFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VisiteurRepository;

class VisiteurFormeTypeController extends AbstractController
{
  /**
    * @Route("/visiteur", name="liste_visiteur")
    */
    public function index(VisiteurRepository $visiteurRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $visiteur = new Visiteur();
        $form = $this->createForm(VisiteurFormType::class, $visiteur);
        $form->handleRequest($request);
        //  return new JsonResponse($Visiteur);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($visiteurRepository->findOneByTelVisiteur(trim($form->get('telVisiteur')->getData()))){
                $this->addFlash('doublon',"Ce Visiteur existe déja");
                return $this->render('visiteur/liste.html.twig', [
                    'visiteurs' => $visiteurRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($visiteur);
                $entityManager->flush();
                $visiteur = new Visiteur();
                $form = $this->createForm(VisiteurFormType::class, $visiteur);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('visiteur/liste.html.twig', [
            'visiteurs' => $visiteurRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("visiteur_delete/{id}", name="delete_visiteur")
     */
    public function delete(Request $request, Visiteur $visiteur): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($visiteur) {
            $visite = $visiteur->getVisites()->getValues();
            //return new JsonResponse($faits);
            if(!empty($visite)){
                $this->addFlash('suppression_imp', "Impossible de supprimer ce Visiteur car il est lié à une visites");
            }else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($visiteur);
                $entityManager->flush();
                $this->addFlash('suppression', "Suppression éffectuée avec succés");
            }
        }

        return $this->redirectToRoute('liste_visiteur');
    }


    
    /**
     * @Route("/visiteur_edit{id}", name="edit_visiteur")
     */
    public function edit(Visiteur $visiteur, VisiteurRepository $visiteurRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $Visiteur = new Visiteur();
        $form = $this->createForm(VisiteurFormType::class, $visiteur);
        $form->handleRequest($request);
        //  return new JsonResponse($Visiteur);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $visiteurRepository->findOneByTelVisiteur(trim($form->get('telVisiteur')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $visiteur->getId()){
                $this->addFlash('doublon',"Ce Visiteur existe déja");
            }else{
                $entityManager->persist($visiteur);
                $entityManager->flush();
                $visiteur = new Visiteur();
                $form = $this->createForm(VisiteurFormType::class, $visiteur);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_visiteur');
            
            }

        }

        return $this->render('visiteur/edit.html.twig', [
            'visiteurs' => $visiteurRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

    public function getUserByEncour()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $visiteur = $this->getDoctrine()->getRepository(Visiteur::class)->findAll();
        $nombreVisite = count($visiteur);
        if (empty($nombreVisite)){
            return new Response(0);
        }
        return new Response($nombreVisite);
    }
}
