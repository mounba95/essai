<?php

namespace App\Controller;


use App\Entity\Rdv;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TypeRdvFormType;
use App\Form\RdvFormType;
use App\Form\RdvPersonnelType;
use App\Form\RdvProfessionnelType;
use App\Repository\RdvRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class RdvController extends AbstractController
{



    /**
     * @Route("/rdv", name="liste_rdv")
     */
    public function liste(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $rdvs = $repo->rdvcrere();
        return $this->render('rdv/liste.html.twig', [
            'rdvs' => $rdvs
        ]);

    }

    /**
     * @Route("/types", name="choisi_rdv")
     */
    public function choixType(Request $request): Response
    {
        $form = $this->createForm(TypeRdvFormType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $type =  $form->get('typeRdv')->getData();
            if($type == 1){
                return $this->redirectToRoute('rdvprofessionnel');
            }else{
                return $this->redirectToRoute('rdvpersonnel');
            }
        }
            return $this->render('rdv/choix.html.twig', ['form' => $form->createView(),
        
        ]);

    }

    /**
     * @Route("/crerrdvper", name="rdvpersonnel")
     */
    public function rdvpersonnel(Request $request): Response
    {
       $repo=$this->getDoctrine()->getRepository(Rdv::class);
       $user=$this->getUser();
       $nom=$user->getnomUser();
       $prenom=$user->getprenomUser();
       $id=$user->getId();
       $crerPar= $prenom. ' ' .$nom;
       $idCrerPar=$id;


       //creation du rendez vous
       $rdv= new Rdv();
       $form=$this->createForm(RdvPersonnelType::class,$rdv);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){

        $entityManager=$this->getDoctrine()->getManager();
        $date= new \DateTime();
        $rdv
        ->setdateCreation($date)
        ->setcrerPar($crerPar)
        ->setidCrerPar($idCrerPar)
        ->setStatut(1)
        ->settypeRdv(2);

         //Verification si un rendez vous est programmer la meme date
         $numuser=$form->get('users')->getData()->getTelUser();
         $daterdv=$form->get('daterdv')->getData();
         $numvisiteur=$form->get('visiteurs')->getData()->getTelVisiteur();
         //return new JsonResponse($numUser);
         if ($repo->verifictionVistesEncoucrour($daterdv,$numuser))
         {
             $this->addFlash(
                 'rdvexiste',
                 "Désolé cette personne a deja un rendez vous programmer la meme date et la meme heur!!!"
             );
         }elseif($repo->verifierVisiteur($numvisiteur,$daterdv))
         {
            $this->addFlash(
                'error',
                "Désolé vous avez deja un rendez-vou programmer la meme date et la meme heur"
            );
         }
         else{
        $entityManager->persist($rdv);
        $entityManager->flush();
        if($entityManager){
            $this->addFlash(
                'ajouter',
                "Enregistrement effectuer avec succer"
            );
           // return $this->redirectToRoute('detailrdv',['id'=>$rdv->getId()]);
           return $this->redirectToRoute('liste_rdv');
        }
    }
        
    }
       return $this->render('rdv/ajoutpersonnel.html.twig',['form'=>$form->createView()
    ]);

    }

    
  /**
     * @Route("/crerrdvpro", name="rdvprofessionnel")
     */
    public function rdvprofessionnel(Request $request): Response
    {
       $repo=$this->getDoctrine()->getRepository(Rdv::class);
       $user=$this->getUser();
       $nom=$user->getnomUser();
       $prenom=$user->getprenomUser();
       $id=$user->getId();
       $crerPar= $prenom. ' ' .$nom;
       $idCrerPar=$id;


       //creation du rendez vous
       $rdv= new Rdv();
       $form=$this->createForm(rdvprofessionnelType::class,$rdv);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){

        $entityManager=$this->getDoctrine()->getManager();
        $date= new \DateTime();
        $rdv
        ->setdateCreation($date)
        ->setcrerPar($crerPar)
        ->setidCrerPar($idCrerPar)
        ->setStatut(1)
        ->settypeRdv(1);

         //Verification si un rendez vous est programmer la meme date
         $daterdv=$form->get('daterdv')->getData();
         $service=$form->get('services')->getData()->getNomService();
         $numvisiteur=$form->get('visiteurs')->getData()->getTelVisiteur();
         //return new JsonResponse($numUser);
         if ($repo->verifictionVistesEncoucrours($daterdv,$service))
         {
             $this->addFlash(
                 'rdvexistes',
                 "Désolé cet service est programmer pour un rendez-vous a cette meme date et meme heurs !!!"
             );
         }elseif($repo->verifierVisiteur($numvisiteur,$daterdv))
         {
            $this->addFlash(
                'error',
                "Désolé vous avez deja un rendez-vous programmer la meme date et la meme heur"
            );
         }
         else{
        $entityManager->persist($rdv);
        $entityManager->flush();
        if($entityManager){
            $this->addFlash(
                'ajouter',
                "Enregistrement effectuer avec succer"
            );
           // return $this->redirectToRoute('detailrdv',['id'=>$rdv->getId()]);
           return $this->redirectToRoute('liste_rdv');
        }
       }
       
    }
       return $this->render('rdv/ajoutprofessionnel.html.twig',['form'=>$form->createView()
    ]);

    }

    /**
     * @Route("/deleteRdv/{id}", name="delete_rdv")
     */
    public function delete($id,Rdv $rdv){
        $em=$this->getDoctrine()->getManager();
        $rdv=$em->getRepository(Rdv::class)->find($id);
        $em->remove($rdv);
        $em->flush();
            $this->addFlash(
                'suppression',
                "Supression effectuer avec succer");

        return $this->redirectToRoute('liste_rdv');
    }

    /**
 * @Route("/details/{id}", name="detailrdv")
 */
public function detailvisitel($id): Response
{
    $em = $this->getDoctrine()->getManager();
    $rdv = $em->getRepository(Rdv::class)->find($id);
    return $this->render('rdv/detail.html.twig',[
        'rdv' => $rdv
    ]);
}

    /**
     * @Route("/editeRdv{id}", name="edite_rdv")
     */
    public function edite(Rdv $rdv,$id, Request $request):Response{

        $repo=$this->getDoctrine()->getRepository(Rdv::class);
        $rdvs=$repo->findAll();

        $rdv= $repo->findOneById($id);
        $form=$this->createForm(RdvFormType::class,$rdv);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($rdv);
            $entityManager->flush();

            if($entityManager){
                $this->addFlash(
                    'modifier',
                    "Modification effecuer avec succer"
                );
                return $this->redirectToRoute('liste_rdv');
            }
        }
        return $this->render('rdv/edit.html.twig',['form'=>$form->createView(),
            'rdvs'=>$rdvs
    ]);
    }

    // les rendez-vous annuler
    /**
     * @Route("/annuler", name="liste_annuler")
     */
    public function fermer(Request $request): Response
    {      
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');      
        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $rdvs = $repo->rdvFermer();
        return $this->render('rdv/annuler.html.twig', [
            'rdvs' => $rdvs
        ]);
    }

 //Annuler un rendez-vous

    /**
     *@Route("/fins", name="annule_rdv")
     */
    public function ActionFin(Request $request, EntityManagerInterface $entityManager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $rdvs = $repo->rdvcrere();
        $user = $this->getUser();
        $nom = $user->getNomUser();
        $prenom = $user->getPrenomUser();
        $id = $user->getId();
        $fermerpar = $nom.' '.$prenom;
        $idfermerpar=$id;
        $id = $request->query->get('id');
        $rdv = $entityManager->getRepository(Rdv::class)->find($id);
        $date = new \DateTime();
        $rdv
        ->setDateAnnuler($date)
        ->setStatut(0)
        ->setIdFermerPar($idfermerpar)
        ->setFermerPar($fermerpar);
        $entityManager->persist($rdv);
        $entityManager->flush();
        $this->addFlash(
            'fin',
            " La le rendez-vou à été annuler avec succer!!!"
        );
        return $this->redirectToRoute('liste_rdv');
    }



    
     /**
     * @Route("/mesrdv", name="liste_mesrdv")
     */
    public function MesRdv(RdvRepository $rdvRepository): Response
    {  

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $userId = $user->getId();      
        $rdvs = $rdvRepository->getMesRdv($userId);
        return $this->render('rdv/mesrdv.html.twig', ['rdvs' => $rdvs
        ]);
        return $this->redirectToRoute('liste_mesrdv');
    }

    
    /**
     * @Route("/allrdv", name="allrdv")
     */
    public function Rdv(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repo = $this->getDoctrine()->getRepository(Rdv::class);
        $rdvs = $repo->findAll();
        return $this->render('rdv/all.html.twig', [
            'rdvs' => $rdvs
        ]);
    }
}
