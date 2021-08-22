<?php

namespace App\Form;

use App\Entity\Services;
use App\Entity\Games;
use App\Entity\User;
use App\Entity\Servers;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;


class ConfigServicesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('serverId', TextType::class,[
            //   'attr' => [
            //     'placeholder' => 'Server'
            //   ]
            // ])
            ->add('server', EntityType::class,[
              'class' => Servers::class,
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('s')
                      ->orderBy('s.displayName', 'ASC');
              },
              'choice_label' => 'displayName',
              'choice_value' => 'Id',
              'placeholder' => 'Server',
            ])
            ->add('user', EntityType::class,[
              'class' => User::class,
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('u')
                      ->orderBy('u.userName', 'ASC');
              },
              'choice_label' => 'userName',
              'choice_value' => 'Id',
              'placeholder' => 'User',
            ])
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
            'data_class' => Services::class,
            'label' => false,
            'required' => false,
        ]);
    }
}
