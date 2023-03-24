<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class OffreType extends AbstractType
{
    #[Route('/offre/edit', name: '')]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Libelle')
            ->add('DateDeb')
            ->add('DateFin')
            ->add('Reference')
            ->add('Localisation')
            ->add('Agemin')
            ->add('AgeMax')
            ->add('Date')
            ->add('Description')
            ->add('sexes')
            ->add('partenaireDiffusions')
            ->add('Clients')
            ->add('metier')
            ->add('TypeContrats')
            ->add('Envoyer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);

    }
}
