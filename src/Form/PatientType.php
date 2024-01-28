<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\Telephone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NOM', TextType::class, [
                "attr" => [
                    'class' => "form-control",

                ]
            ])

            ->add('PRENOM', TextType::class, [
                "attr" => [
                    'class' => "form-control",

                ]
            ])

            ->add('photos', FileType::class, [
                "attr" => [
                    'class' => "form-control",
                    'id' => "id_image",

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

                ]
            ])
            ->add('Telephone', TextType::class, [
                'mapped' => false, // Indique que ce champ n'est pas lié à une propriété de l'entité
                "attr" => [
                    'class' => "form-control",


                ],
                "data" => $options["Telephone"],
                'constraints' =>[
                    new Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.',
                    ]),
                ]
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
            'data_class' => Patient::class,
            'Telephone' => null,
        ]);
    }
}
