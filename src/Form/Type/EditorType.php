<?php

namespace App\Form\Type;


use App\Entity\Datacenter;
use App\Entity\Countries;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType ;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;


class EditorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextareaType::class,[
              'attr' => [
                'editor' => 'true'
              ]
            ])
            ->add('save', SubmitType::class,[
              'attr' => [
                'editor' => 'true'
              ]
            ])
            ->add('exit', SubmitType::class,[
              'attr' => [
                'editor' => 'true'
              ]
            ])
            ->add('search', SubmitType::class,[
              'attr' => [
                'editor' => 'true'
              ]
            ])
            ->add('encoder', SubmitType::class,[
              'attr' => [
                'editor' => 'true'
              ]
            ])
            ->add('save', SubmitType::class,[
              'attr' => [
                'editor' => 'true'
              ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'label' => false,
            'required' => false,
            'mapped' => false,
        ]);
    }
}
