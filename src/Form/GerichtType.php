<?php

namespace App\Form;

use App\Entity\Gericht;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GerichtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('picture', FileType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Bild',
            ])
            ->add('removepicture', CheckboxType::class, [
                'required' => false,
                'mapped' => false,
                // 'row_attr' => ['class' => 'd-none',],
            ])
            ->add('beschreibung')
            ->add('preis')
            ->add('speichern', SubmitType::class)
        ;

        $builder->get('picture')
            ->addModelTransformer(new CallbackTransformer(
                function ($picture) {
                    return null;
                },
                function ($picture) {
                    return $picture;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gericht::class,
        ]);
    }
}
