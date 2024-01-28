<?php

namespace App\Form;

use App\Entity\Forme;
use App\Entity\Medicament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;

class MedicamentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NOM', TextType::class, [
                "attr" => [
                    'class' => "form-control form-control-sm",

                ],
                "constraints"=> [
                    new Length([
                        'min'=>3,
                        "minMessage"=>"Trop court",
                    ])
                ]
            ])
            
            ->add('DATE_EXP', DateType::class, [
                'widget' => 'single_text',
                "attr" => [
                    'class' => "form-control form-control-sm",

                ]
            ])

            ->add('DATE_FAB', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                "attr" => [
                    'class' => "form-control form-control-sm",

                ]
            ])
            ->add('Dosage', TextType::class, [
                "attr" => [
                    'class' => "form-control form-control-sm",

                ],
            ])
            ->add('PRIX', IntegerType::class, [
                "attr" => [
                    'class' => "form-control form-control-sm",

                ],
            ])
            ->add('QT', IntegerType::class, [
                "attr" => [
                    'class' => "form-control form-control-sm",

                ],
            ])
            ->add('INGREDIENT', TextareaType::class, [
                "attr" => [
                    'class' => "form-control form-control-sm",

                ],
            ])
            ->add('PHOTOS', FileType::class, [
                "attr" => [
                    'class' => "form-control form-control-sm",

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

            ->add('ID_FORME', EntityType::class, [
                'class' => Forme::class,
                'choice_label' => 'FORME',
                "attr" => [
                    'class' => "form-control form-control-sm",

                ],
            ])
            ->add('submit', SubmitType::class, [
                "attr" => [
                    'class' => "btn btn-primary",

                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medicament::class,
        ]);
    }
}
