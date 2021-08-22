<?php

namespace App\Form\Type\Game;

use App\Entity\GamePaths;


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


class PathsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('relativeExecutable', TextType::class)
            ->add('relativeWorkingDir', TextType::class)
            ->add('relativeSubadminFiles', TextType::class)
            ->add('relativeResellerFiles', TextType::class)
            ->add('relativeUserFiles', TextType::class)
            ->add('filesFolderName', TextType::class)
            ->add('enableExtDownload', TextType::class)
            ->add('extDownloadUrl', TextType::class)
            ->add('extSaveName', TextType::class)
            ->add('extExtractOpt', TextType::class)
            ->add('extScriptEngineId', TextType::class)
            ->add('extScript', TextType::class)
            ->add('extLicense', TextType::class)
            ->add('extLicenseAccepted', TextType::class)
            ->add('skipExeError', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GamePaths::class,
            // 'label' => false,
            'required' => false,
        ]);
    }
}
