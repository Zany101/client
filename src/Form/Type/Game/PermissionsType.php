<?php

namespace App\Form\Type\Game;

use App\Entity\GamePermissions;


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


class PermissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('serviceId', TextType::class)
            ->add('userId', TextType::class)
            ->add('permissionKey', TextType::class)
            ->add('subadminAccess', TextType::class)
            ->add('resellerAccess', TextType::class)
            ->add('userAccess', TextType::class)
            ->add('subuserAccess', TextType::class)
            ->add('resellerOverride', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GamePermissions::class,
            // 'label' => false,
            'required' => false,
        ]);
    }
}
