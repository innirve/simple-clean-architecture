<?php

declare(strict_types=1);

namespace App\Event\EventListener;

use App\Exception\ApiException;
use App\Exception\ErrorCollectionRepresentation;
use App\Exception\ErrorRepresentation;
use App\Exception\ErrorValidationRepresentation;
use App\Exception\NotValidFormException;
use App\Serializer\FormErrorsSerializer;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Render\RenderOpenApi;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Translation\Translator;

final readonly class ExceptionListener
{
    public function __construct(
        private SerializerInterface $serializer,
        private FormErrorsSerializer $formErrorsSerializer,
        private Translator $translator
    ) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof NotValidFormException) {
            $this->handleNotValidFormException($event, $exception);
        } elseif ($exception instanceof ApiException) {
            $this->handleApiException($event, $exception);
        } else {
            $this->handleException($event);
        }
    }

    private function handleNotValidFormException(ExceptionEvent $event, NotValidFormException $exception): void
    {
        $formErrors = $this->formErrorsSerializer->serializeFormErrors($exception->getForm());
        $errorValidationRepresentations = [];

        foreach ($formErrors['global'] as $errorMessage) {
            $errorValidationRepresentations[] = new ErrorValidationRepresentation(
                $this->translator->trans($errorMessage)
            );
        }

        foreach ($formErrors['fields'] as $field => $errorMessage) {
            if (is_array($errorMessage)) {
                foreach ($errorMessage as $message) {
                    $errorValidationRepresentations[] = new ErrorValidationRepresentation(
                        $this->translator->trans($message),
                        $field
                    );
                }
            } else {
                $errorValidationRepresentations[] = new ErrorValidationRepresentation(
                    $this->translator->trans($errorMessage),
                    $field
                );
            }
        }

        $errorCollectionRepresentation = new ErrorCollectionRepresentation(
            $this->translator->trans(NotValidFormException::VALIDATION_FAILED),
            $errorValidationRepresentations
        );

        $event->setResponse(
            new JsonResponse(
                $this->serializer->serialize($errorCollectionRepresentation, RenderOpenApi::JSON),
                Response::HTTP_UNPROCESSABLE_ENTITY,
                [],
                true
            )
        );
    }

    private function handleApiException(ExceptionEvent $event, ApiException $exception): void
    {
        $event->setResponse(
            new JsonResponse(
                $this->serializer->serialize(
                    ['errors' => new ErrorRepresentation(
                        $this->translator->trans($exception->getMessage()),
                    )],
                    RenderOpenApi::JSON
                ),
                $exception->getCode(),
                [],
                true
            )
        );
    }

    private function handleException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $event->setResponse(
            new JsonResponse(
                $this->serializer->serialize(
                    [
                        'errors' => new ErrorRepresentation(
                            $this->translator->trans($exception->getMessage()),
                        ),
                    ],
                    RenderOpenApi::JSON
                ),
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [],
                true
            )
        );
    }
}
