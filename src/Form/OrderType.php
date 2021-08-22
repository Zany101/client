<?php

namespace App\Form;

use App\Entity\Datacenters;
use App\Entity\OrderItems;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;


use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;

class OrderType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
      $builder
      ->add('plan', ChoiceType::class, [
          'choices'  => [
              'Month' => 0,
              'Quaterly (10% Discount)' => 1,
              'Semi-Anualy (10% Discount)' => 2,
              'Annually (10% Discount)' => 3,
          ],
      ])
      ->add('datacenter', EntityType::class,[
        'class' => Datacenters::class,
        'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('u')
                ->orderBy('u.id', 'ASC');
        },
        'choice_label' => 'displayName',
        'choice_value' => 'Id',
        'placeholder' => 'Select Datacenter',
      ])
      ->add('slots', NumberType::class, [
          'attr' => [
              'value' => 0,
              'min' => 5,
              'max' => 50
          ]
      ])
      ->add('hostname', TextType::class, [
        'attr' => [
          'placeholder' => 'The name of your game server',
        ]
      ])
      ->add('rconPassword', PasswordType::class, [
        'attr' => [
          'placeholder' => 'Administraitors password',
        ]
      ])

          // ->add('type', NumberType::class,[
          //   'constraints' => [
          //       new NotBlank(),
          //       new Length(['min' => 3]),
          //   ],
          // ])
      ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
      $resolver->setDefaults([
          'data_class' => OrderItems::class,
          'required' => false,
      ]);
  }
}
