<?php

namespace App\Form\Type\Game;


use App\Entity\Game;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckType;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;


class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('operatingSystem', IntegerType::class,[
              'attr' => [
                'placeholder' => 'Operating System'
              ]
            ])
            ->add('displayName', TextType::class,[
              'attr' => [
                'placeholder' => 'Display Name'
              ]
            ])
            ->add('shortName', TextType::class,[
              'attr' => [
                'placeholder' => 'Short Name'
              ]
            ])
            ->add('privateRuleValue', TextType::class,[
              'attr' => [
                'placeholder' => 'Private Rule Value'
              ]
            ])
            ->add('privateRuleName', TextType::class,[
              'attr' => [
                'placeholder' => 'Private Rule Name'
              ]
            ])
            ->add('hostnameRule', TextType::class,[
              'attr' => [
                'placeholder' => 'Hostname Rule'
              ]
            ])
            // ->add('mapRule', TextType::class)
            // ->add('slotsRule', TextType::class)
            // ->add('excludeRules', TextType::class)
            ->add('queryProtocol', TextType::class,[
              'attr' => [
                'placeholder' => 'Query Protocol'
              ]
            ])
            ->add('rconProtocol', TextType::class,[
              'attr' => [
                'placeholder' => 'Rcon Protocol'
              ]
            ])
            ->add('showInCreateList', TextType::class,[
              'attr' => [
                'placeholder' => 'Create List'
              ]
            ])
            ->add('isVoiceServer', TextType::class,[
              'attr' => [
                'placeholder' => 'Voice Server'
              ]
            ])
            ->add('isTemplate', TextType::class,[
              'attr' => [
                'placeholder' => 'Template'
              ]
            ])
            ->add('minSlots', TextType::class,[
              'attr' => [
                'placeholder' => 'Min Slots'
              ]
            ])
            ->add('maxSlots', TextType::class,[
              'attr' => [
                'placeholder' => 'Max Slots'
              ]
            ])
            ->add('defaultSlots', TextType::class,[
              'attr' => [
                'placeholder' => 'Default Slots'
              ]
            ])
            ->add('nameFromQuery', TextType::class,[
              'attr' => [
                'placeholder' => 'Query Name'
              ]
            ])
            ->add('joinUrl', TextType::class,[
              'attr' => [
                'placeholder' => 'Join Url'
              ]
            ])


            ->add('gamePorts', PortType::class)
            ->add('gameCmdlines', CommandType::class)
            // ->add('gameConfigFiles', ConfigFileType::class)
            ->add('gameConfigFiles', CollectionType::class, [
              'entry_type' => ConfigFileType::class,
              'entry_options' => ['label' => false],
            ])
            // ->add('gameKeys', KeysType::class)
            // ->add('gameLinks', LinksType::class)
            ->add('gamePaths', PathsType::class)
            ->add('gamePermissions', PermissionsType::class)
            ->add('gamePunkbusterConfig', PunkbusterType::class)
            ->add('gameSteamConfig', SteamType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
            // 'label' => false,
            'required' => false,
        ]);
    }
}
