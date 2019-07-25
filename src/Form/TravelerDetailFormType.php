<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;

class TravelerDetailFormType extends AbstractType implements FormTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, [
                'label' => 'Votre nom:',
                'required'   => true,
            ])
            ->add("adulte1", NumberType::class, [
                'label' => '18-34 ans',
                'required'   => true,
            ])
            ->add("adulte2", NumberType::class, [
                'label' => '35-54 ans',
                'required'   => true,
            ])
            ->add("adulte3", NumberType::class, [
                'label' => '55-69 ans',
                'required'   => true,
            ])
            ->add("adulte4", NumberType::class, [
                'label' => '70+ ans',
                'required'   => true,
            ])    // Configure your form options here
            ->add("enfants1", NumberType::class, [
                'label' => '0-2 ans',
                'required'   => true,
            ])
            ->add("enfants2", NumberType::class, [
                'label' => '3-7 ans',
                'required'   => true,
            ])
            ->add("enfants3", NumberType::class, [
                'label' => '8-12 ans',
                'required'   => true,
            ])
            ->add("enfants4", NumberType::class, [
                'label' => '13-17 ans',
                'required'   => true,
            ])
            ->add("travelDate1", CheckboxType::class, [
                'label' => 'J\'ai des dates exactes. Choisissez une date de début et une date de fin  ',
                'required'   => false,
                'attr' => ['class' => 'hidden'],
            ])
            ->add("beginDate", DateType::class, [
                'label' => 'Date de départ',
                'required'   => false,
            ])
            ->add("endDate", DateType::class, [
                'label' => 'Date de fin',
                'required'   => false,
            ])
            ->add("travelDate2", CheckboxType::class, [
                'label' => 'J\'ai une idée approximative  ',
                'required'   => false,
                'attr' => ['class' => 'hidden'],
            ])
            ->add("mois", TextType::class, [
                'label' => 'Mois:',
                'required'   => false,
            ])
            ->add("annees", TextType::class, [
                'label' => 'Années:',
                'required'   => false,
            ])
            ->add("travelDate3", CheckboxType::class, [
                'label' => 'Je n\'ai pas décidé  ',
                'required'   => false,
                'attr' => ['class' => 'hidden'],
            ])
            ->add("disponibilityDays", ChoiceType::class, [
                'choices' => [
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                ],
                'multiple' => true,
                'required'   => true,
                'expanded' => true,
                'attr' => ['class' => 'checkbox'],
                'label' => 'Jours de disponibilité:'
            ])
            ->add("disponibilityHour", ChoiceType::class, [
                'choices' => [
                    'Entre 10h et 12h' => "Entre 10h et 12h",
                    'Entre 13h et 14h' => "Entre 13h et 14h",
                    'Entre 14h et 16h' => "Entre 14h et 16h",
                    'Entre 16h et 17h30' => "Entre 16h et 17h30",
                ],
                'multiple' => true,
                'required'   => true,
                'expanded' => true,
                'attr' => ['class' => 'checkbox'],
                'label' => 'Heure de disponibilité:'
                ])
            ->add("phoneNumber", NumberType::class, [
                'label' => 'Merci de nous indiquer votre numéro de téléphone ',
                'required'   => true,
            ])
            ->add("comment", TextareaType::class, [
                'label' => ' ',
                'required'   => true,
            ])
            ->add("cgu", CheckboxType::class, [
                'label' => ' ',
                'required'   => true,
                'attr' => ['class' => 'hidden'],
            ])
        ;
    }
}
