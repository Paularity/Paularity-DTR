<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('plainPassword', PasswordType::class, [
                'label'         => 'Password',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped'        => false,
                'constraints'   => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min'           => 6,
                        'minMessage'    => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max'           => 4096,
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class,[
                'multiple'  =>  true,
                'expanded'  =>  true,
                'choices'   => [
                    'Super Administrator'   => "ROLE_SUPER_ADMIN",
                    'Administrator'         => 'ROLE_ADMIN',
                    'User'                  => 'ROLE_USER'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
