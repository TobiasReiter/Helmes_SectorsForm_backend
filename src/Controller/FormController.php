<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\ValidationException;
use App\Service\UserService;
use App\Validator\FormValidator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    private UserService $userService;
    private FormValidator $formValidator;
    private EntityManagerInterface $entityManager;

    public function __construct(UserService $userService, FormValidator $formValidator, EntityManagerInterface $entityManager)
    {
        $this->userService = $userService;
        $this->formValidator = $formValidator;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws Exception
     */
    #[Route('/api/save-form', name: 'app_form', methods: ['POST'])]
    public function saveForm(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->formValidator->validateData($data);
        } catch (ValidationException $e) {
            return new JsonResponse(['message' => 'Validation failed', 'errors' => $e->getErrors()], 400);
        }

        try {
            $userName = $request->headers->get('X-User-Name') ?? $data['name'];
            $user = $this->userService->createOrUpdateUser($userName, $data, $this->entityManager);

            return new JsonResponse(['message' => 'Form data saved successfully'], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }


    #[Route('/api/user/{username}', name: 'get_user_data', methods: ['GET'])]
    public function getUserData(string $username, Request $request): JsonResponse
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['name' => $username]);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        $token = $request->headers->get('X-Auth-Token');
        if ($token !== $user->getName()) {
            return new JsonResponse(['message' => 'Unauthorized access'], 403);
        }

        $userData = [
            'name' => $user->getName(),
            'sectors' => $user->getUserSectors()->map(fn($userSector) => $userSector->getSector()->getId())->toArray(),
            'agreeToTerms' => $user->getAgreeToTerms(),
        ];

        return new JsonResponse($userData, 200);
    }
}
