<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Telephone;
use App\Form\PatientType;
use App\Repository\TelephoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/patient')]
class PatientController extends AbstractController
{
    #[Route('/', name: 'app_patient')]
    
    public function index(EntityManagerInterface $entityManager): Response
    {
        $patients = $entityManager->getRepository(Patient::class)->findAll();

        return $this->render('patient/index.html.twig', [
            'Patients' => $patients
        ]);
    }

    #[Route('/nouveau', name: 'app_patient.new', methods: ['GET', 'POST'])]

    public function store(Request $req, EntityManagerInterface $entityManager , SluggerInterface $slugger)
    {

        
        $patient = new Patient();

        $telephones = new Telephone();

        $newFile=null;

        $form = $this->createForm(PatientType::class, $patient);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {

            //Traitement de l'image
            $image= $form->get('photos')->getData();

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
            $patient->setPhotos($newFile);

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
                $telephones->setIDPATIENT($patient);
                $entityManager->persist($telephones);
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_patient', [], Response::HTTP_SEE_OTHER);



        }

        return $this->render('patient/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_patient.modify', methods: ['GET', 'POST'])]
    public function Modify(Patient $patient, $id, EntityManagerInterface $entityManager, Request $req): Response
    {
        $tele=new Telephone();
        
        $telephone = $entityManager->getRepository(Telephone::class)->findOneBy(['ID_PATIENT' => $id]);

        $form = $this->createForm(PatientType::class, $patient,[
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
            if($telephones==null) {
                $tele->setTELEPHONE($telephoneNumber);
                $tele->setIDPATIENT($patient);
                $entityManager->persist($telephone);
                $entityManager->flush();
            }
           

            return $this->redirectToRoute('app_patient', [], Response::HTTP_SEE_OTHER);



        }
    
        return $this->render('patient/new.html.twig', [
            'form' => $form->createView(),
            'patient' => $patient,
        ]);
    }
    
    #[Route('/{id}', name: 'app_patient.show', methods: ['GET'])]

    public function show(Patient $patient,$id,EntityManagerInterface $entityManager): Response
    {
        $telephones = $entityManager->getRepository(Telephone::class)->findOneBy(['ID_PATIENT' => $id]);
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
            "telephone"=>$telephones->getTELEPHONE()
        ]);
    }


}
