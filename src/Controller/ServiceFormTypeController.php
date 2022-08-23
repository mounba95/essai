<?php

namespace App\Controller;


use App\Entity\Service;
use App\Form\ServiceFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ServiceRepository;

class ServiceFormTypeController extends AbstractController
{
  /**
    * @Route("/service", name="liste_service")
    */
    public function index(ServiceRepository $serviceRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $service = new Service();
        $form = $this->createForm(ServiceFormType::class, $service);
        $form->handleRequest($request);
        //  return new JsonResponse($Service);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // return new JsonResponse($form->get('region')->getData()->getId());
            if ($serviceRepository->findOneByNomService(trim($form->get('nomService')->getData()))){
                $this->addFlash('doublon',"Ce Service existe déja");
                return $this->render('service/liste.html.twig', [
                    'services' => $serviceRepository->findAll(), 'form' => $form->createView(),
                ]);
            }else{
                $entityManager->persist($service);
                $entityManager->flush();
                $service = new Service();
                $form = $this->createForm(ServiceFormType::class, $service);
                $this->addFlash('register',"Enregistrement effectué avec succés");
            }
        }

        return $this->render('service/liste.html.twig', [
            'services' => $serviceRepository->findAll(), 'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("service_delete/{id}", name="delete_service")
     */
    public function delete(Request $request, Service $service): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($service) {
            $user = $service->getVisites()->getValues();
            //return new JsonResponse($faits);
            if(!empty($user)){
                $this->addFlash('suppression_imp', "Impossible de supprimer ce service car il contient des personnel");
            }else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($service);
                $entityManager->flush();
                $this->addFlash('suppression', "Suppression éffectuée avec succés");
            }
        }

        return $this->redirectToRoute('liste_service');
    }


    
    /**
     * @Route("/service_edit{id}", name="edit_service")
     */
    public function edit(Service $service, ServiceRepository $serviceRepository, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $Service = new Service();
        $form = $this->createForm(ServiceFormType::class, $service);
        $form->handleRequest($request);
        //  return new JsonResponse($Service);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ind = $serviceRepository->findOneByNomService(trim($form->get('nomService')->getData()));
            // return new JsonResponse($ind['id'][0]);
            if ($ind and $ind->getId() != $service->getId()){
                $this->addFlash('doublon',"Ce Service existe déja");
            }else{
                $entityManager->persist($service);
                $entityManager->flush();
                $service = new Service();
                $form = $this->createForm(ServiceFormType::class, $service);
                $this->addFlash('register',"Modification effectué avec succés");
                return $this->redirectToRoute('liste_service');
            
            }

        }

        return $this->render('service/edit.html.twig', [
            'services' => $serviceRepository->findAll(), 'form' => $form->createView(),
        ]);
    }


}
