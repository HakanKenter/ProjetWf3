<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;




class Annonce2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('Prix')
            ->add('Image')
            // ->add('user')
            // ->add('user', EntityType::class, ['class' => User::class, 'choice_label' => 'prenom'])   
            // ->add('CreatedAt')

            // ->add('user', TextType::class, [
            //     // 'value'   => $this->getUser(),

            // ->add('user', ChoiceType::class, [
            //     'choice_value' => ChoiceList::value($this, 'uuid'),

            // ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
