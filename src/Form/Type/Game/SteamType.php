<?php

namespace App\Form\Type\Game;

use App\Entity\GameSteamConfig;


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


class SteamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('serviceId', TextType::class)
            ->add('enableHldsupdate', TextType::class)
            ->add('hldsGameType', TextType::class)
            ->add('validate', TextType::class)
            ->add('executeOnCreate', TextType::class)
            ->add('extraOptions', TextType::class)
            ->add('steamAccount', TextType::class)
            ->add('steamPassword', TextType::class)
            ->add('runAsserviceUser', TextType::class)
            ->add('promptSteamAccount', TextType::class)
            ->add('storeGameId', TextType::class)
            ->add('workShopEnabled', TextType::class)
            ->add('workshopStop', TextType::class)
            ->add('workshopSkipDownload', TextType::class)
            ->add('workshopFileIdFormat', TextType::class)
            ->add('workshopFileIdSeparator', TextType::class)
            ->add('storeBackgrounds', TextType::class)
            ->add('workshopAccount', TextType::class)
            ->add('workshopPassword', TextType::class)
            ->add('workshopInstalledIcon', TextType::class)
            ->add('workshopCollectionsEnabled', TextType::class)
            ->add('workshopRetry', TextType::class)
            ->add('searchUnlisted', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GameSteamConfig::class,
            // 'label' => false,
            'required' => false,
        ]);
    }
}
