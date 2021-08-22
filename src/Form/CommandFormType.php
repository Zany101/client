<?php

namespace App\Form;

use App\Entity\ServiceCustomCmdlines;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntType;
use Symfony\Component\Form\FormBuilderInterface;

class CommandFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class,[
              'label' => false,
              'required' => false,
              'attr' => [
                'placeholder' => 'Description'
              ]
            ])
            ->add('cmdline', TextType::class,[
              'label' => false,
              'required' => false,
              'help' => 'Seperate parameters with a comma (sdkfileid=123,sdkfileid=123)',
              'attr' => [
                'placeholder' => 'Command Line',
              ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServiceCustomCmdlines::class,
        ]);
    }
}
