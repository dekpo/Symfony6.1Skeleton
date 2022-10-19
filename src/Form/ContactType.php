<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName',null,[
                'attr' => [
                    'class'     => 'form-control',
                    'minlenght' => '5',
                    'maxlenght' => '100'
                ],
                'label' => 'Prénom Nom',
                'label_attr' => [
                    'class' => 'form-label mb-2'
                ]
            ])
            ->add('email',EmailType::class,[
                'attr' => [
                    'class'     => 'form-control',
                    'minlenght' => '5',
                    'maxlenght' => '150'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label mb-2'
                ]
            ])
            ->add('subject', null,[
                'attr' => [
                    'class'     => 'form-control',
                    'minlenght' => '5',
                    'maxlenght' => '150'
                ],
                'label' => 'Sujet',
                'label_attr' => [
                    'class' => 'form-label mb-2'
                ]
            ])
            ->add('message', null,[
                'attr' => [
                    'class'     => 'form-control',
                ],
                'label' => 'Votre message',
                'label_attr' => [
                    'class' => 'form-label mb-2'
                ]
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'contact',
                'locale' => 'fr',
            ])
            ->add('submit',SubmitType::class, [
                'attr' => [
                    'class'     => 'btn btn-primary mt-2',
                ],
                'label' => 'Envoyer'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
