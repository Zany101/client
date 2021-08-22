<?php

namespace App\Form\Type\Game;

use App\Entity\GameLinks;


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


class LinksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('linkId', TextType::class)
            ->add('modId', TextType::class)
            ->add('url', TextType::class)
            ->add('displayName', TextType::class)
            ->add('description', TextType::class)
            ->add('icon', TextType::class)
            ->add('newPage', TextType::class)
            ->add('insidePanel', TextType::class)
            ->add('categoryId', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GameLinks::class,
            // 'label' => false,
            'required' => false,
        ]);
    }
}
