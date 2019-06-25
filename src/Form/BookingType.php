<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDay', DateType::class, [
                'widget'=>'single_text',
                'format'=>'dd-MM-yyyy',
                'attr'=>['class'=>'js-datepicker'],
                'html5'=>false,
                'model_timezone'=>'Europe/Paris'
            ])
            ->add('email', EmailType::class)
            ->add('orderType', ChoiceType::class, [
                'choices'=> [
                    'Journée'=>true,
                    'Demi-journée'=>false
                ],
                'multiple'=>false
            ])
            ->add('ticketNumber', IntegerType::class, [
                'attr'=> [
                    'min'=>1,
                    'max'=>50
                ]
            ])
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
