<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Emprunteur;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmprunteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
        
    {


        $builder
            ->add('nom')
            ->add('prenom')
            ->add('tel')
            ->add('user', UserType::class, [
                    'label' => false,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunteur::class,
        ]);
    }
}
