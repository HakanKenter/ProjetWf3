<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class IdentificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('pseudo')
            ->add('ville')
            ->add('civilite', ChoiceType::class, [
                'choices' => [
                    'Genre' => [
                        'Femme' => 'femme',
                        'Homme' => 'homme',
                    ]
                ]
            ])
            ->add('adresse')
            ->add('password')
            ->add('confirm_password')
            ->add('birth')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
