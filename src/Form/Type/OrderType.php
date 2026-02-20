<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Repository\ServiceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderType extends AbstractType
{

    public function __construct(private ServiceRepository $serviceRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service_id', ChoiceType::class, [
                'choices' => array_flip($this->serviceRepository->getNameActiveServices()),
                'label' => 'Услуга',
                'placeholder' => 'Выберите услугу',
            ])
            ->add('email', EmailType::class, ['label' => 'Электронная почта'])
            ->add('price', IntegerType::class, ['label' => 'Стоимость', 'disabled' => true])
            ->add('save', SubmitType::class, ['label' => 'Подтвердить']);
    }
}