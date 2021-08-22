<?php

namespace App\Form\Type\Game;

use App\Entity\GameConfigFiles;


use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;


class ConfigFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fileId', TextType::class,[
              'attr' => [
                'placeholder' => 'File'
              ]
            ])
            ->add('relativePath', TextType::class,[
              'attr' => [
                'placeholder' => 'Relative Path'
              ]
            ])
            ->add('description', TextType::class,[
              'attr' => [
                'placeholder' => 'Description'
              ]
            ])
            ->add('enableTextEditorReseller', TextType::class,[
              'attr' => [
                'placeholder' => 'Text Editor Reseller'
              ]
            ])
            ->add('enableTextEditorUser', TextType::class,[
              'attr' => [
                'placeholder' => 'Text Editor User'
              ]
            ])
            ->add('viewOrder', TextType::class,[
              'attr' => [
                'placeholder' => 'Order'
              ]
            ])
            ->add('template', TextareaType::class,[
              'attr' => [
                'row' => '10',
                'placeholder' => 'Template'
              ]
            ])
            ->add('enableConfigEditor', TextType::class,[
              'attr' => [
                'placeholder' => 'Config Editor'
              ]
            ])
            ->add('readValues', TextType::class,[
              'attr' => [
                'placeholder' => 'Read Values'
              ]
            ])
            ->add('hidePath', TextType::class,[
              'attr' => [
                'placeholder' => 'Hide Path'
              ]
            ])
            ->add('hideReadFailure', TextType::class,[
              'attr' => [
                'placeholder' => 'Hide Failure'
              ]
            ])
            ->add('updateAutomatically', TextType::class,[
              'attr' => [
                'placeholder' => 'Update Automatically'
              ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GameConfigFiles::class,
            'required' => false,
        ]);
    }
}
