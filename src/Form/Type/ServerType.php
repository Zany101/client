<?php

namespace App\Form\Type;


use App\Entity\Servers;

use Doctrine\ORM\EntityRepository;

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

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;


class ServerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datacenterId', TextType::class,[
              'attr' => [
                'placeholder' => 'Datacenter'
              ]
            ])
            ->add('operatingSystem', TextType::class,[
              'attr' => [
                'placeholder' => 'Operating System'
              ]
            ])
            ->add('primaryIp', TextType::class,[
              'attr' => [
                'placeholder' => 'Ip Address'
              ]
            ])
            ->add('displayName', TextType::class,[
              'attr' => [
                'placeholder' => 'Display Name'
              ]
            ])
            ->add('enabled', TextType::class,[
              'attr' => [
                'placeholder' => 'Enabled'
              ]
            ])
            ->add('vsMemoryMb', TextType::class,[
              'attr' => [
                'placeholder' => 'Memory'
              ]
            ])
            ->add('vsDiskMb', TextType::class,[
              'attr' => [
                'placeholder' => 'Disk'
              ]
            ])
            ->add('vsDrive', TextType::class,[
              'attr' => [
                'placeholder' => 'Drive'
              ]
            ])
            ->add('maxCpu', TextType::class,[
              'attr' => [
                'placeholder' => 'Cpu'
              ]
            ])
            ->add('maxMemory', TextType::class,[
              'attr' => [
                'placeholder' => 'Max Memory'
              ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Servers::class,
            'label' => false,
            'required' => false,
        ]);
    }
}
