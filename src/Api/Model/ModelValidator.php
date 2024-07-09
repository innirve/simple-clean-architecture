<?php

declare(strict_types=1);

namespace App\Api\Model;

use App\Exception\NotValidFormException;
use Symfony\Component\Form\FormFactory;

final readonly class ModelValidator
{
    private FormFactory $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function validate(ModelInterface $model): ModelInterface
    {
        $form = $this->formFactory->create(ModelType::class, $model, ['data_class' => get_class($model)]);
        $form->submit($model->submittedData());

        if (!$form->isValid()) {
            throw new NotValidFormException($form);
        }

        return $model;
    }
}
