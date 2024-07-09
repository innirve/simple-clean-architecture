<?php

declare(strict_types=1);

namespace App\Controller;

use App\Api\Model\ModelValidator;
use App\Api\Model\User\UserCreateModel;
use App\UseCase\User\UserCreate;
use App\UseCase\User\UserList;
use App\UseCase\User\UserRead;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends AbstractController
{
    #[OA\Post(
        description: 'Creates a User resource.',
        summary: 'Creates a User resource.',
        requestBody: new OA\RequestBody(
            description: 'The new User resource',
            content: new OA\JsonContent(ref: new Model(type: UserCreateModel::class))
        ),
        tags: ['User'],
        responses: [
            new OA\Response(response: Response::HTTP_CREATED, description: 'User resource created'),
            new OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Invalid input'),
            new OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: 'Unprocessable entity'),
        ]
    )]
    public function create(Request $request, UserCreate $userCreate, ModelValidator $validator): JsonResponse
    {
        return $this->json(
            $userCreate->execute($validator->validate((new UserCreateModel())((string) $request->getContent()))),
            Response::HTTP_CREATED
        );
    }

    #[OA\Get(
        description: 'Retrieves a User resource.',
        summary: 'Retrieves a User resource.',
        tags: ['User'],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'User resource'),
            new OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Resource not found'),
        ]
    )]
    public function read(UserRead $userRead, int $id): JsonResponse
    {
        return $this->json($userRead->execute($id));
    }

    #[OA\Get(
        description: 'Retrieves the collection of User resources.',
        summary: 'Retrieves the collection of User resources.',
        tags: ['User'],
        parameters: [
            new OA\Parameter(
                name: 'page',
                description: 'The page number',
                in: 'query',
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'limit',
                description: 'Maximum number of results to return',
                in: 'query',
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(response: Response::HTTP_OK, description: 'User collection'),
        ]
    )]
    public function list(Request $request, UserList $userList): JsonResponse
    {
        return $this->json($userList->execute(
            (int) $request->get('page', 1),
            (int) $request->get('limit', 10)
        ));
    }
}
