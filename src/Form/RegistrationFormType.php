<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, [
                'label' => 'Mitarbeitername',]
                )
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Ich stimme den Nutzungsbedingungen zu',
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'first_options' => ['label' => 'Passwort', 'hash_property_path' => 'password'],
                'second_options' => ['label' => 'Passwort wiederholen'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Bitte ein Passwort eingeben',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Das Passwort muss mindestens {{ limit }} Buchstaben lang sein',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
