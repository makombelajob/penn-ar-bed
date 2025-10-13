<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('organization', TextType::class, [ 'label' => 'Organisation' ])
            ->add('email', EmailType::class, [ 'label' => 'Email de contact' ])
            ->add('partnershipType', ChoiceType::class, [
                'label' => 'Type de partenariat',
                'choices' => [
                    'Financier' => 'Financier',
                    'Matériel' => 'Matériel',
                    'Mentorat / Réseau' => 'Mentorat / Réseau',
                    'Autre' => 'Autre',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}


