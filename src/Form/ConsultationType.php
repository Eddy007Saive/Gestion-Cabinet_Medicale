<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Medecin;
use App\Entity\Medicament;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DATE_CONS',DateType::class,[
                "attr" => [
                    'class' => "form-control",
                    'value'  =>  $options["DATE_CONS"],
                    'readOnly'=> true
                ],
                'widget' => 'single_text',
            ])
            ->add('SYMPTOME',TextType::class,[
                "attr" => [
                    'class' => "form-control",

                ],
                'constraints'=> [
                    new Length([
                        'min'=> 5,
                        'minMessage'=>"Trop courts" 
                    ])
                ]
            ])
            ->add('DIAGNOSTIC',TextType::class,[ 
                "attr" => [
                'class' => "form-control",

            ],])
            ->add('ID_PATIENT', EntityType::class, [
                "attr" => [
                    'class' => "form-control",

                ],
                'class' => Patient::class,
                'choice_label' => 'NOM',
            ])
            ->add('MEDICAMENTS', EntityType::class, [
                "attr" => [
                    'class' => "form-control",

                ],
                'class' => Medicament::class,
                'choice_label' => 'NOM',
                'multiple' => true,
            ])
            ->add('ID_MEDECIN', EntityType::class, [
                "attr" => [
                    'class' => "form-control",

                ],
                'class' => Medecin::class,
                'choice_label' => 'NOM',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
            'DATE_CONS' => null
        ]);
    }
}
