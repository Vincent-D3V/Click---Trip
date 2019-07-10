<?php

namespace App\Form;

use App\Entity\Size;
use App\Entity\Stage;
use App\Form\PriceType;
use App\Entity\Style;
use App\Entity\Theme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('destination')
            ->add('reference')
            ->add('nameStage')
            ->add('duration')
            ->add('themes', EntityType::class, [
                'expanded'=>true,
                'multiple'=>true,
                'class'=>Theme::class,
                'choice_label'=> 'theme',
                'by_reference' => false])
            ->add('styles', EntityType::class, [
                'expanded'=>true,
                'multiple'=>true,
                'class'=>Style::class,
                'choice_label'=> 'style',
                'by_reference' => false])
            ->add('sizes', EntityType::class, [
                'expanded'=>true,
                'multiple'=>true,
                'class'=>Size::class,
                'choice_label'=> 'people',
                'by_reference' => false])
            ->add('prices', CollectionType::class, array(
                'entry_type'   => PriceType::class,
                'allow_add'    => true,
                'allow_delete' => true
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
