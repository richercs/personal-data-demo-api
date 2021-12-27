<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    use FormErrorSerializerTrait;

    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/user", name="post_user", methods={"POST"})
     */
    public function post(
        Request $request
    ): JsonResponse
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
}
