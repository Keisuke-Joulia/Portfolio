<?php

namespace App\Form;

use App\Entity\Contact;
use Beelab\Recaptcha2Bundle\Form\Type\RecaptchaSubmitType;
use Beelab\Recaptcha2Bundle\Validator\Constraints\Recaptcha2;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'nom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('subject', TextType::class, [
                'label' => 'sujet'
            ])
            ->add('message', TextareaType::class, [
                'label' => 'message'
            ])
            ->add('captcha', RecaptchaSubmitType::class, [
                'constraints' => new Recaptcha2(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
