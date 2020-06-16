<?php

namespace App\Form;

use PDO;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class)
            ->add('birth', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('email')
            ->add('imageFile', FileType::class,['required' => true])
            ->add('telephone');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
