<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Form\FormInterface;

final class NotValidFormException extends \Exception
{
    public const string VALIDATION_FAILED = 'validation.failed';

    private FormInterface $form;

    public function __construct(FormInterface $form)
    {
        $this->form = $form;

        parent::__construct();
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}
