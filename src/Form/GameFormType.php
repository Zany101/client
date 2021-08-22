<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\GameServices;
use App\Entity\Games;
use App\Entity\User;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;


class GameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slots', IntegerType::class)
            ->add('game', EntityType::class,[
              'class' => Games::class,
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('u')
                      ->orderBy('u.id', 'ASC');
              },
              'choice_label' => 'displayName',
              'choice_value' => 'Id',
              'placeholder' => 'Game',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => false,
            'required' => false,
        ]);
    }
}
