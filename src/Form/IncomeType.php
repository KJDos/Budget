<?php

namespace App\Form;

use App\Entity\Income;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class IncomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Title",
                'attr' => [
                    'placeholder' => "Write a title"
                ]
            ])
            ->add('amount', MoneyType::class,[
                'label' => "Amount",
                'attr' => [
                    'placeholder' => "Write an amount"
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Send',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Income::class,
        ]);
    }
}
