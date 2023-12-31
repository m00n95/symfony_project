<?php

namespace App\Form;

use App\Entity\ContractType;
use App\Entity\Sector;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ],
                'multiple' => true, // Allow selecting multiple roles if necessary
                'expanded' => true, // Render the roles as checkboxes or radio buttons
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'required' => false,
                ])
            ->add('lastname')
            ->add('firstname')
            ->add('picture')
            ->add('endDate')
            ->add('sector', EntityType::class, [
                'class' => Sector::class,
                'choice_label' => 'title'])
            ->add('contractType', EntityType::class, [
                'class' => ContractType::class,
                'choice_label' => 'title'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
