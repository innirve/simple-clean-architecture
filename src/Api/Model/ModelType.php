<?php

declare(strict_types=1);

namespace App\Api\Model;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['name' => 'model_type']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach (get_object_vars($options['data']) as $key => $value) {
            $options = [];

            if (is_string($value)) {
                $type = TextType::class;
            } elseif (is_float($value)) {
                $type = NumberType::class;
            } else {
                $type = null;
            }

            $builder->add($key, $type, $options);
        }
    }
}
