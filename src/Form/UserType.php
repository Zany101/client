<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Role;
use App\Entity\Countries;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userName', TextType::class,[
              'attr' => [
                'placeholder' => 'Username'
              ]
            ])
            ->add('password', PasswordType::class,[
              'attr' => [
                'placeholder' => 'Password'
              ]
            ])
            ->add('confirm', PasswordType::class,[
              'help' => 'You gea',
              'attr' => [
                'placeholder' => 'Confirm Password'
              ],
            ])
            // ->add('role', EntityType::class,[
            //   'class' => Role::class,
            //   'query_builder' => function (EntityRepository $er) {
            //       return $er->createQueryBuilder('u')
            //           ->where('u.roleId > 0 AND u.roleId < 3 ')
            //           ->orderBy('u.displayName', 'ASC');
            //   },
            //   'choice_label' => 'displayName',
            //   'placeholder' => 'Role',
            //
            // ])
            ->add('firstName', TextType::class,[
              'attr' => [
                'placeholder' => 'Firstname'
              ]
            ])
            ->add('lastName', TextType::class,[
              'attr' => [
                'placeholder' => 'Lastname'
              ]
            ])
            ->add('email', TextType::class,[
              'attr' => [
                'placeholder' => 'Email address'
              ]
            ])
            ->add('homePhone', TextType::class,[
              'attr' => [
                'placeholder' => 'Phone number'
              ]
            ])
            ->add('country', EntityType::class,[
              'class' => Countries::class,
              'query_builder' => function (EntityRepository $er) {
                  return $er->createQueryBuilder('u')
                      ->orderBy('u.displayName', 'ASC');
              },
              'choice_label' => 'displayName',
              'choice_value' => 'displayName',
              'placeholder' => 'Country',

            ])
            ->add('state', TextType::class,[
              'attr' => [
                'placeholder' => 'State'
              ]
            ])
            ->add('city', TextType::class,[
              'attr' => [
                'placeholder' => 'City'
              ]
            ])
            ->add('address', TextType::class,[
              'attr' => [
                'placeholder' => 'Address'
              ]
            ])
            ->add('zip', TextType::class,[
              'attr' => [
                'placeholder' => 'Zip code'
              ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'required' => false,
            'label' => false,
        ]);
    }
}
