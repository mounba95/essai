<?php /** @noinspection ALL */

namespace App\Controller;

use App\Entity\Visite;
use App\Form\TypeVisiteFormType;
use App\Form\VisiteFiltrageForm;
use App\Form\visiteserviceForm;
use App\Form\VisiteFormType;
use App\Form\VisitePersonnelType;
use App\Form\VisiteProfessionnelType;
use App\Repository\VisiteRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class VisiteController extends AbstractController
{


  /**
    * @Route("/accueil", name="accueil")
    */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Visite::class);
        $nbrVsite = $repo->getParService();
        $nbrVsiteparStatue = $repo->visiteParType();
        
        //$donnee = $repo->getVisitebyJour($dateEntree);
        //return new JsonResponse($nbrVsiteparStatue);
        return $this->render('accueil.html.twig', [
            'nbrVisite' => $nbrVsite,
            'nbrVsiteparStatue' => $nbrVsiteparStatue
        ]);
    }



    /**
     * @Route("/creer", name="liste_crer")
     */
    public function liste(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repo = $this->getDoctrine()->getRepository(Visite::class);
        $visites = $repo->vistesCreer();
        return $this->render('visitecrer/liste.html.twig', [
            'visites' => $visites
        ]);

    }

    /**
     * @Route("/type", name="choisi_type")
     */
    public function choixType(Request $request): Response
    {
        $form = $this->createForm(TypeVisiteFormType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $type =  $form->get('typeVisite')->getData();
            if($type == 1){
                return $this->redirectToRoute('addcourierprofessionnel');
            }else{
                return $this->redirectToRoute('addcourierpersonnel');
            }
        }
            return $this->render('visitecrer/choix.html.twig', ['form' => $form->createView(),
        
        ]);

    }

/**
 * @Route("/creercourrierpf", name="addcourierprofessionnel")
 */
public function courrierProffesionnel(Request $request): Response
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repo = $this->getDoctrine()->getRepository(Visite::class);
        $user = $this->getUser();
        $nom = $user->getNomUser();
        $prenom = $user->getPrenomUser();
        $id = $user->getId();
        $crerpar = $nom.' '.$prenom;
        $idcrerpar= $id;
       //return new JsonResponse($crerpar);

        //add Visite
        $visite = new Visite();
        $form = $this->createForm(VisiteProfessionnelType::class, $visite);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager = $this->getDoctrine()->getManager();
            $date = new \DateTime();
            $visite
            ->setEntrer($date)
            ->setDateOperation(new \Datetime(date('d-m-Y')))
            ->setStatue(1)
            ->setTypeVisite(1)
            ->setcrerPar($crerpar)
            ->setIdCrerPar($idcrerpar);
            //Verification des visites encours du meme Visite
            $numVisite = $form->get('visiteurs')->getData()->getTelVisiteur();
            //return new JsonResponse($numVisite);
            if ($repo->verifictionVistesEncoucrour($numVisite))
            {
                $this->addFlash(
                    'visiteExiste',
                    "Désolé vous avez une visite encour !!!"
                );
            }else{
            $entityManager->persist($visite);
            $entityManager->flush();
            if ($entityManager) {
                $this->addFlash(
                    'register',
                    "Debut de la visite!!!"
                );
                return $this->redirectToRoute('detailvisite',['id'=>$visite->getId()]);
            } else {
                $this->addFlash(
                    'nonregister',
                    "Erreur !!!"
                );
            }
        }

        }
        return $this->render('visitecrer/ajoutcourrierprofessionnel.html.twig', ['form' => $form->createView(),
        ]);
}


/**
 * @Route("/creercourrier", name="addcourierpersonnel")
 */
public function courrierPersonnel(Request $request): Response
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    $repo = $this->getDoctrine()->getRepository(Visite::class);
    $user = $this->getUser();
    $nom = $user->getNomUser();
    $prenom = $user->getPrenomUser();
    $id = $user->getId();
    $crerpar = $nom.' '.$prenom;
    $idcrerpar= $id;
   //return new JsonResponse($crerpar);

    //add Visite
    $visite = new Visite();
    $form = $this->createForm(VisitePersonnelType::class, $visite);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
    
        $entityManager = $this->getDoctrine()->getManager();
        $date = new \DateTime();
        $visite
        ->setEntrer($date)
        ->setDateOperation(new \Datetime(date('d-m-Y')))
        ->setStatue(1)
        ->setTypeVisite(2)
        ->setcrerPar($crerpar)
        ->setIdCrerPar($idcrerpar);
        //Verification des visites encours du meme Visite
        $numVisite = $form->get('visiteurs')->getData()->getTelVisiteur();
        //return new JsonResponse($numVisite);
        if ($repo->verifictionVistesEncoucrour($numVisite))
        {
            $this->addFlash(
                'visiteExiste',
                "Désolé vous avez une visite encour !!!"
            );
        }else{
        $entityManager->persist($visite);
        $entityManager->flush();
        if ($entityManager) {
            $this->addFlash(
                'register',
                "Debut de la visite!!!"
            );
            return $this->redirectToRoute('detailvisite',['id'=>$visite->getId()]);
        } else {
            $this->addFlash(
                'nonregister',
                "Erreur !!!"
            );
        }
    }

    }
    return $this->render('visitecrer/ajoutcourrierpersonnel.html.twig', ['form' => $form->createView(),
    ]);
}

/**
 * @Route("/detail/{id}", name="detailvisite")
 */
public function detailvisitel($id): Response
{
    $em = $this->getDoctrine()->getManager();
    $visite = $em->getRepository(Visite::class)->find($id);
    return $this->render('visitecrer/detail.html.twig',['visite' => $visite]);
}



    /**
     * @Route("/delete/{id}", name="delete_visite")
     */

    public function deleteVisite(Visite $visite, $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $visite = $em->getRepository(Visite::class)->find($id);
        $em->remove($visite);
        $em->flush();
        $this->addFlash(
            'suppression',
            "Suppression effectuée avec succés !!!"
        );
        return $this->redirectToRoute('liste_crer');
    }

    /**
     * @Route("/modifierVisite{id}", name="edit_visite")
     */
    public function editVisite(Visite $visite, $id, Request $request): Response
    {
       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repo = $this->getDoctrine()->getRepository(Visite::class);
        $visites = $repo->findAll();

        //add Visite
        $visite = $repo->findOneById($id);
        $form = $this->createForm(VisiteFormType::class, $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

            $visite->setStatue(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($visite);
            $entityManager->flush();
            $this->addFlash(
                'register',
                "Modification effectuer avec succer !!!"
            );
            return $this->redirectToRoute('liste_crer');
        }

        return $this->render('visitecrer/edit.html.twig', ['form' => $form->createView(),
            'visites' => $visites
        ]);


        
    }
    //Fin de la visite

    /**
     *@Route("/fin", name="fin_visite")
     */
    public function ActionFin(Request $request, EntityManagerInterface $entityManager){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Visite::class);
        $visites = $repo->vistesFermer();
        $user = $this->getUser();
        $nom = $user->getNomUser();
        $prenom = $user->getPrenomUser();
        $id = $user->getId();
        $fermerpar = $nom.' '.$prenom;
        $idfermerpar=$id;
        $id = $request->query->get('id');
        $visite = $entityManager->getRepository(Visite::class)->find($id);
        $date = new \DateTime();
        $visite
        ->setSortie($date)
        ->setStatue(0)
        ->setIdFermerPar($idfermerpar)
        ->setFermerPar($fermerpar);
        $entityManager->persist($visite);
        $entityManager->flush();
        $this->addFlash(
            'fin',
            " La visite a été fermer avec succer!!!"
        );
        return $this->redirectToRoute('liste_fermer');
    }





    /**
     * @Route("/all", name="allVisite")
     */
    public function Visite(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $repo = $this->getDoctrine()->getRepository(Visite::class);
        $visites = $repo->findAll();
        return $this->render('allvisite/liste.html.twig', [
            'visites' => $visites
        ]);
    }



    /**
     * @Route("/fermer", name="liste_fermer")
     */
    public function fermer(Request $request): Response
    {      
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');      
        $repo = $this->getDoctrine()->getRepository(Visite::class);
        $visites = $repo->vistesFermer();
        return $this->render('visitefermer/liste.html.twig', [
            'visites' => $visites
        ]);
    }



    public function getvisite(VisiteRepository $visiteRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $visites = $this->getDoctrine()->getRepository(Visite::class)->findAll();
        $nombreVisite = count($visites);
        if (empty($nombreVisite)){
            return new Response(0);
        }
        return new Response($nombreVisite);
    }


    public function getVisiteEncour(VisiteRepository $visiteRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    

        $donnee = $visiteRepository->getVisiteEncour();
        if ($donnee and $donnee[0]['nombre'] != null) {
            $response = new Response($donnee[0]['nombre']);
            return $response;
        }else{
            return new Response(0);
        }
    }


    public function getVisiteJour(VisiteRepository $visiteRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    
        $dateEntree = new \Datetime(date('d-m-Y'));
        $donnee = $visiteRepository->getVisitebyJour($dateEntree);
        //return new JsonResponse($donnee);
        if ($donnee and $donnee[0]['nombre'] != null) {
            $response = new Response($donnee[0]['nombre']);
            return $response;
        }else{
            return new Response(0);
        }
    } 

     /**
     * @Route("/mesvisite", name="liste_mesvisite")
     */
    public function MesVisite(VisiteRepository $visiteRepository): Response
    {  

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $userId = $user->getId();      
        $visites = $visiteRepository->getMesVisite($userId);
        return $this->render('mesvisite/mesvisite.html.twig', ['visites' => $visites
        ]);
    }



     /**
     * @Route("/visiteparfiltrage", name="visiteparfiltrage")
     */
    public function visiteparfiltrage(Request $request): Response
    {

        $repo = $this->getDoctrine()->getRepository(Visite::class);
        $visites = $repo->findAll();



        $visite = new Visite();
        $form = $this->createForm(VisiteFiltrageForm::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($visite);
            $entityManager->flush();
            if ($entityManager) {
                $this->addFlash(
                    'register',
                    "Enregistrement effectué avec succès !!!"
                );
                $visites = $repo->findAll();
                $visite = new Visite();
               // $form = $this->createForm(VisiteFiltrageForm::class, $visite);
                return $this->render('visiteparfiltrage/visiteparfiltrage.html.twig', ['form' => $form->createView(),
                    'visites' => $visites
                ]);
            } else {
                $this->addFlash(
                    'nonregister',
                    "Erreur !!!"
                );
            }

        }
        return $this->render('visiteparfiltrage/visiteparfiltrage.html.twig', ['form' => $form->createView(),
            'visites' => $visites
        ]);

    }



     /**
     * @Route("/visiteservice", name="visiteservice")
     */
    public function visiteService(Request $request): Response
    {

        $repo = $this->getDoctrine()->getRepository(Visite::class);
        $visites = $repo->findAll();



        $visite = new Visite();
        $form = $this->createForm(visiteserviceForm::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateDebut = $form->get('entrer')->getData();
            $dateFin = $form->get('sortie')->getData();
            $visiteur = $form->get('visiteurs')->getData();
            $service = $form->get('services')->getData();
            //$dt = new \DateTime($dateDebut);
            //return new JsonResponse ($dt);
           if (!empty($dateDebut) && empty($dateFin) && !empty($visiteur) && empty($service)){
                $visites = $repo->visitesParDebutParVisiteur($dateDebut, $visiteur);
            }elseif(!empty($dateDebut) && !empty($dateFin) && empty($visiteur) && !empty($service)){
                $visites = $repo->visitesParPeriodeParService($dateDebut, $dateFin, $service);
            }elseif(empty($dateDebut) && empty($dateFin) && !empty($visiteur) && !empty($service)){
                $visites = $repo->visitesParServiceParVisiteur($service, $visiteur);
            }elseif(empty($dateDebut) && empty($dateFin) && !empty($visiteur) && empty($service)){
                $visites = $repo->visitesParVisiteur($visiteur);
            }elseif(empty($dateDebut) && empty($dateFin) && empty($visiteur) && !empty($service)){
                $visites = $repo->visitesParService($service);
            }elseif(!empty($dateDebut) && !empty($dateFin) && empty($visiteur) && empty($service)){
            $visites = $repo->visitesParPeriode($dateDebut, $dateFin);
            }elseif(!empty($dateDebut) && empty($dateFin) && empty($visiteur) && empty($service)){
                $visites = $repo->visitesParDebut($dateDebut);
            }elseif(!empty($dateDebut) && empty($dateFin) && empty($visiteur) && !empty($service)){
                $visites = $repo->visitesParDebutParService($dateDebut,$service);
            }elseif(!empty($dateDebut) && !empty($dateFin) && !empty($visiteur) && empty($service)){
                $visites = $repo->visitesParPeriodeParVisiteur($dateDebut, $dateFin, $visiteur);
            }elseif(!empty($dateDebut) && empty($dateFin) && !empty($visiteur) && !empty($service)){
                $visites = $repo->visitesParDebutParServiceParVisiteur($dateDebut, $service, $visiteur);
            }


                
                
                
                return $this->render('visiteservice/visiteservice.html.twig', ['form' => $form->createView(),
                    'visites' => $visites
                ]);

        }
        return $this->render('visiteservice/visiteservice.html.twig', ['form' => $form->createView(),
            'visites' => $visites
        ]);

    }
}