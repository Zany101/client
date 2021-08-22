<?php

namespace App\Form;

use App\Entity\SupportTickets;
use App\Entity\Role;
use App\Entity\Countries;
use App\Form\TicketReplyType;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\EqualTo;


class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class,[
              'attr' => [
                'placeholder' => 'Subject'
              ]
            ])
            ->add('replies', CollectionType::class, [
                 'entry_type' => TicketReplyType::class,
                 'entry_options' => ['label' => false],
             ])
             // ->add('replies', TicketReplyType::class)
            // ->add('deparment', ChoiceType::class,[
            //   'attr' => [
            //     'placeholder' => 'Ask your question here.'
            //   ]
            // ])
            // ->add('attachment', FileType::class,[
            //   'attr' => [
            //     'placeholder' => 'Add Attachment.'
            //   ]
            // ])
            // ->add('message', TextareaType::class,[
            //   'attr' => [
            //     'id' => 'editor',
            //     'placeholder' => 'Ask your question here.',
            //     'data-editor' => true
            //   ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SupportTickets::class,
            'required' => false,
            'label' => false,
        ]);
    }
}
