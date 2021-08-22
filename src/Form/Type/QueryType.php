<?php

namespace App\Form\Type;


use App\Entity\CompanyInfo;

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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;


class QueryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ip', TextType::class, [
              'constraints' => [
                  new NotBlank(),
                  new Length(['min' => 3]),
              ],
            ])
            ->add('port', NumberType::class,[
              'constraints' => [
                  new NotBlank(),
                  new Length(['min' => 3]),
              ],
            ])
            ->add('protocol', UrlType::class,[
              // 'constraints' => [
              //     new NotBlank(),
              // ],
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
