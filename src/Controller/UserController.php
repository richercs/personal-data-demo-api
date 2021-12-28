<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    use FormErrorSerializerTrait;

    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/user/{id}", name="get_user_data", methods={"GET"}, requirements={"id"="\d+"})
     * @param string $id
     * @return JsonResponse
     */
    public function getUserData(string $id): JsonResponse
    {
        return new JsonResponse(
            $this->findUserById($id),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/user", name="get_all_user_data", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllUserData(): JsonResponse
    {
        return new JsonResponse(
            $this->userRepository->findAll(),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/user", name="post_user", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function post(Request $request): JsonResponse
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $form = $this->createForm(UserType::class, new User());

        $form->submit($data);

        if (false === $form->isValid()) {

            return new JsonResponse(
                [
                    'status' => 'error',
                    'errors' => $this->getErrorsFromForm($form)
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->entityManager->persist($form->getData());
        $this->entityManager->flush();

        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            Response::HTTP_CREATED
        );
    }

    private function findUserById($id): User
    {
        $user = $this->userRepository->find($id);

        if (null === $user) {
            throw new NotFoundHttpException('User entity not found!');
        }

        return $user;
    }
}
