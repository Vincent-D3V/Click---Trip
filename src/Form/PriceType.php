<?php

namespace App\Form;

use App\Entity\Price;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateBegin')
            ->add('dateEnd')
            ->add('price')
            ->add('persons', ChoiceType::class, [
                'choices'  => [
                    '2 pers.' => 2,
                    '4 pers' => 4,
                    '6 pers' => 6,
                    '8 pers' => 8,
                    '10 pers' => 10
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Price::class,
        ]);
    }
}
