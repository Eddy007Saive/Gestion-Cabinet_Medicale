<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MedecinFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NOM', TextType::class, [
                "attr" => [
                    'class' => "form-control",

                ],
            ])
            ->add('PRENOM', TextType::class, [
                "attr" => [
                    'class' => "form-control",

                ],
            ])
            ->add('PHOTOS', FileType::class, [
                "attr" => [
                    'class' => "form-control",
                    'id'=> "id_image",

                ],
                 'mapped' => false,
                 'required' => false,

                 'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un document PDF ou une image valide',
                    ]),
                ],
            ])
            ->add('ADRESSE', TextType::class, [
                "attr" => [
                    'class' => "form-control",

                ],
            ])
            ->add('SPECIALITE', EntityType::class, [
                'class' => Specialite::class,
                'choice_label' => 'specialite',
                "attr" => [
                    'class' => "form-control",

                ],
            ])
            ->add('Telephone', TextType::class, [
                'mapped' => false, // Indique que ce champ n'est pas lié à une propriété de l'entité
                "attr" => [
                    'class' => "form-control",
        

                ],
                "data"=>$options["Telephone"]
            ])
            ->add('Enregistrer',SubmitType::class, [
                "attr" => [
                    'class' => "btn btn-primary mt-4",

                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
            'Telephone' => null,
        ]);
    }
}
