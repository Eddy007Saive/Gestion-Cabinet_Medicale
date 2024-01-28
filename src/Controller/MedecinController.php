<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Entity\Telephone;
use App\Form\MedecinFormType;
use Doctrine\ORM\EntityManager;
use App\Repository\MedecinRepository;
use App\Repository\TelephoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/medecin')]
class MedecinController extends AbstractController
{
    #[Route('/', name: 'app_medecin', methods: ['GET', 'POST'])]

    public function index(EntityManagerInterface $entityManager): Response
    {
        //Onrecuperer la liste des médecin
        $medecin=$entityManager->getRepository(Medecin::class)->findAll();
        
        return $this->render('medecin/index.html.twig',[
            "medecins"=>$medecin
        ]);
    }



    #[Route('/nouveau', name: 'app_medecin.new', methods: ['GET', 'POST'])]

    public function store(Request $req, EntityManagerInterface $entityManager , SluggerInterface $slugger)
    {

        
        $medecin = new Medecin();

        $telephones = new Telephone();

        $form = $this->createForm(MedecinFormType::class, $medecin);

        $form->handleRequest($req);

        $newFile=null;

        if ($form->isSubmitted() && $form->isValid()) {
            //Traitement de l'image
            $image= $form->get('PHOTOS')->getData();

            if($image){
                //Récuperer le nom du fichier 
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                
                //Créer un nouveau nom
                $newFile=$originalFilename."-".uniqid().".".$image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('media_directory'),
                        $newFile
                    );
                } catch (FileException $e) {
                    
                }
            }
            //En prend toute les données
            $medecin->setPHOTOS($newFile);

            //Récuperer les data
            $data=$form->getData();

            //Entrer les données 
            $entityManager->persist($data);

            $entityManager->flush();
            //Je recupere le derniere ID

            //On récupere e numéro de telephone qui es dan le formulaire
            $telephoneNumber =  $form->get('Telephone')->getData();

            //On vérifie si il esixste déja dans la table telephone
             $telephone = $entityManager->getRepository(Telephone::class)->findOneBy(['TELEPHONE' => $telephoneNumber]);
            
            //Si il n'exite pas on insert 
            if(!$telephone) {
                $telephones->setTELEPHONE($telephoneNumber);
                $telephones->setIDMEDECIN($medecin);
                $entityManager->persist($telephones);
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_medecin', [], Response::HTTP_SEE_OTHER);



        }

        return $this->render('medecin/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/{id}/modifier', name: 'app_specialite.modify', methods: ['GET', 'POST'])]

    public function Modify(Medecin $medecin, $id ,EntityManagerInterface $entityManager ,Request $req ) : Response {
        $tele=new Telephone();
        
        $telephone = $entityManager->getRepository(Telephone::class)->findOneBy(['ID_MEDECIN' => $id]);

        $form = $this->createForm(MedecinFormType::class, $medecin,[
            "Telephone"=>$telephone->getTELEPHONE()
        ]);
        
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            //En prend toute les données
            $data=$form->getData();

            //Entrer les données 
            $entityManager->persist($data);

            $entityManager->flush();

            //On récupere e numéro de telephone qui es dan le formulaire
            $telephoneNumber =  $form->get('Telephone')->getData();

            //On vérifie si il esixste déja dans la table telephone
             $telephones = $entityManager->getRepository(Telephone::class)->findOneBy(['TELEPHONE' => $telephoneNumber]);
            
            //Si il n'exite pas on insert 
            if(!$telephones) {
                $tele->setTELEPHONE($telephoneNumber);
                $tele->setIDMEDECIN($medecin);
                $entityManager->persist($telephone);
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_medecin', [], Response::HTTP_SEE_OTHER);



        }
        return $this->render('medecin/new.html.twig', [
            'form' => $form->createView(),
            "medecin"=>$medecin
        ]); 
    }



    #[Route('/{id}', name: 'app_medecin.show', methods: ['GET'])]

    public function show(Medecin $medecin ,$id,EntityManagerInterface $entityManager): Response
    {
        $telephones = $entityManager->getRepository(Telephone::class)->findOneBy(['ID_MEDECIN' => $id]);
        return $this->render('medecin/show.html.twig', [
            'medecin' => $medecin,
            "telephone"=>$telephones->getTELEPHONE()
        ]);
    }

}
