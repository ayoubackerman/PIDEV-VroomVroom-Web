<?php

namespace App\Form;

use App\Entity\Trajet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        $builder
        ->add('ville_depart', ChoiceType::class, [
            'choices'  => [
                '' => null,
                'Ariana' => 'Ariana',
                'Béja' => 'Béja',
                'Ben Arous' => 'Ben Arous',
                'Bizerte' => 'Bizerte',
                'Gabès' => 'Gabès',
                'Gafsa' => 'Gafsa',
                'Jendouba' => 'Jendouba',
                'Kairouan' => 'Kairouan',
                'Kasserine' => 'Kasserine',
                'Kébili' => 'Kébili',
                'Le Kef' => 'Le Kef',
                'Mahdia' => 'Mahdia',
                'Manouba' => 'Manouba',
                'Médenine' => 'Médenine',
                'Monastir' => 'Monastir',
                'Nabeul' => 'Nabeul',
                'Sfax' => 'Sfax',
                'Sidi Bouzid' => 'Sidi Bouzid',
                'Siliana' => 'Siliana',
                'Sousse' => 'Sousse',
                'Tataouine' => 'Tataouine',
                'Tozer' => 'Tozer',
                'Tunis' => 'Tunis',
                'Zaghouan' => 'Zaghouan',
            ],
        ])
        ->add('ville_darrive', ChoiceType::class, [
            'choices'  => [
                '' => null,
                'Ariana' => 'Ariana',
                'Béja' => 'Béja',
                'Ben Arous' => 'Ben Arous',
                'Bizerte' => 'Bizerte',
                'Gabès' => 'Gabès',
                'Gafsa' => 'Gafsa',
                'Jendouba' => 'Jendouba',
                'Kairouan' => 'Kairouan',
                'Kasserine' => 'Kasserine',
                'Kébili' => 'Kébili',
                'Le Kef' => 'Le Kef',
                'Mahdia' => 'Mahdia',
                'Manouba' => 'Manouba',
                'Médenine' => 'Médenine',
                'Monastir' => 'Monastir',
                'Nabeul' => 'Nabeul',
                'Sfax' => 'Sfax',
                'Sidi Bouzid' => 'Sidi Bouzid',
                'Siliana' => 'Siliana',
                'Sousse' => 'Sousse',
                'Tataouine' => 'Tataouine',
                'Tozer' => 'Tozer',
                'Tunis' => 'Tunis',
                'Zaghouan' => 'Zaghouan',
            ],
        ])
            ->add('prix')
            ->add('nbrPlace', ChoiceType::class, [
                'choices'  => [
                    '' => null,
                '1' => true,
                '2' => true,
                '3' => true,
                '4' => true,
            ],
            ])


            ->add('date')
         
                    ->add('modePaiement', ChoiceType::class, [
                        'choices'  => [
                            '' => null,
                            'En ligne' => 'enligne',
                            'Espèce' => 'espece',
                        ],
            ])
            ->add('idUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
