<?php

namespace App\Controller;

use App\Entity\Medicament;
use App\Form\MedicamentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/medicament')]
class MedicamentController extends AbstractController
{
    /**
     * Affiche le fenetre et la liste de toute les medicaments
     *
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/', name: 'app_medicament')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        //
        $medicaments = $entityManager->getRepository(Medicament::class)->findAll();

        return $this->render('medicament/index.html.twig', [
            'medicaments' => $medicaments,
        ]);
    }

    /**
     * Affiche la fenetre nouveau pour l'ajouter d'un medicaments
     *
     * @param Request $req
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    #[Route('/nouveau', name: 'app_medicament.new', methods: ['GET', 'POST'])]

    public function store(Request $req, EntityManagerInterface $entityManager)
    {

        //Initialisation de medicament 
        $medicament = new Medicament();

        //Création du forme 
        $form = $this->createForm(MedicamentFormType::class, $medicament);

        //Evénement qui prend toutes les données contenue dans les champs
        $form->handleRequest($req);

        //Initialisation du variable qui va contenir l'image 
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
                    //Copie de l'image dans la destination
                    $image->move(
                        $this->getParameter('media_directory'),
                        $newFile
                    );
                } catch (FileException $e) {
                    
                }
            }
            //En prend toute les données
            $medicament->setPHOTOS($newFile);

            //Récuperer les données dans les champs 
            $data=$form->getData();

            //Entrer les données 
            $entityManager->persist($data);

            $entityManager->flush();
            
            //Redicrection vers une routes 
            return $this->redirectToRoute('app_medicament',[], Response::HTTP_SEE_OTHER);

        }

        return $this->render('medicament/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * 
     */
    #[Route('/{id}', name: 'app_medicament.show', methods: ['GET'])]
    public function show(Medicament $medicament): Response
    {
        return $this->render('medicament/show.html.twig', [
            'medicament' => $medicament,
        ]);
    }
}
