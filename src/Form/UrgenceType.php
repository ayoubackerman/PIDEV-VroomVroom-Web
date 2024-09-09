<?php

namespace App\Form;

use App\Entity\Urgence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UrgenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('idTrajet')
            ->add('idVoiture')
            ->add('localisation')
            ->add('description')
            ->add('statuts')
            //->add('temps')
            ->add('valider',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Urgence::class,
        ]);
    }
}
