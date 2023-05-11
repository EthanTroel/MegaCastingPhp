<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\SearchType;
use \Symfony\Bundle\SecurityBundle\Security;

class FilterType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        $userNiveauPro = $user ? $user->getNiveauPro() : null;
        
        $builder
            ->add('search', TextType::class, [
                'label' => 'Recherche',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Recherche',
                    'data' => null,
                ],
            ]);
        
        if ($userNiveauPro) {
            $builder->add('niveauPro', ChoiceType::class, [
                'choices' => [
                    'Rechercher en fonction du niveau pro' => $userNiveauPro,
                ],
                'expanded' => true,
                'multiple' => true,
            ]);
        }
        
        $builder
            ->add('domainesMetiers', EntityType::class, [
                'class' => 'App\Entity\DomaineMetier',
                'choice_label' => 'Libelle',
                'choice_value' => 'Libelle',
                'data' => null,
            ])
            ->add('metier', EntityType::class, [
                'class' => 'App\Entity\Metier',
                'choice_label' => 'Libelle',
                'choice_value' => 'Libelle',
                'data' => null,
            ])
            ->add('TypeContrats', EntityType::class, [
                'class' => 'App\Entity\TypeContrat',
                'choice_label' => 'Libelle',
                'choice_value' => 'Libelle',
                'data' => null,
            ])
            ->add('Rechercher', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }
}
