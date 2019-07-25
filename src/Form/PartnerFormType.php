<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("contactPeople", TextType::class, [
                'label' => 'Qui est la meilleure personne à contacter ?',
                'required' => true,
            ])
            ->add("email", EmailType::class, [
                'label' => 'Quelle est votre adresse email ?',
                'required' => true,
            ])
            ->add("companyName", TextType::class, [
                'label' => 'Quel est le nom de votre compagnie ?',
                'required' => true,
            ])
            ->add("websiteUrl", UrlType::class, [
                'label' => 'Quelle est l\'URL de votre site ?',
                'required' => true,
            ])
            ->add("aboutCompany", TextareaType::class, [
                'label' => 'Parlez-nous un peu de votre entreprise ?',
                'required' => true,
            ])
            ->add("companyAdress", TextType::class, [
                'label' => 'Où se situe votre entreprise ?',
                'required' => true,
            ])
            ->add("companyCountry", TextType::class, [
                'label' => 'Dans quels pays proposez-vous des itinéraires authentiques aux voyageurs ?',
                'required' => true,
            ])
            ->add("allCountry", TextType::class, [
                'label' => 'Couvrez-vous d\'autres destinations ?',
                'required' => true,
            ])
            ->add("companyDate", TextType::class, [
                'label' => 'Quand votre entreprise a-t-elle été créée ?',
                'required' => true,
            ])
            ->add("companyWorker", NumberType::class, [
                'label' => 'Combien de personnes travaillent dans votre entreprise ? 
                (à l\'exclusion des guides / pilotes …)',
                'required' => true,
            ])
            ->add("companyCustomer", NumberType::class, [
                'label' => 'Environ combien de personnes avez-vous fait voyager l\'année dernière ?',
                'required' => true,
            ])
            ->add("companyInfo", TextAreaType::class, [
                'label' => 'Dans quel(s) secteur(s) (thématique, région, prix) êtes-vous spécialisé ?',
                'required' => true,
            ])
            ->add("companyBudget", NumberType::class, [
                'label' => 'Quel est le budget minimum avec lequel vous pouvez travailler, par personne et par jour ?',
                'required' => true,
            ])
            ->add("companyDirectory", TextType::class, [
                'label' => 'Quel est le panier moyen par dossier ?',
                'required' => false,
            ])
            ->add("companyInsurance", TextType::class, [
                'label' => 'Avez-vous une assurance responsabilité civile / Police d’assurance ?',
                'required' => false,
            ])
            ->add("companyMoreInfo", TextAreaType::class, [
                'label' => 'Souhaitez-vous fournir d\'autres informations ?',
                'required' => false,
            ]);
    }
}
