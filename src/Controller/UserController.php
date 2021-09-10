<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     */
    public function create(UserService $userService, Request $request): Response
    {
        $request = $this->transformJsonBody($request);
        if (!$request->get('email') || !$request->request->get('password')) {
            return $this->return_json('Bad request params');
        }
        if ($userService->create($request)) {
            return $this->return_json('User has been created successfully');
        } else {
            return $this->return_json('User hasn`t been created');
        }
    }

    /**
     * @Route("/find", name="find")
     */
    public function find(UserService $userService, Request $request): Response
    {
        $request = $this->transformJsonBody($request);
        return $this->json(['status' => $userService->checkThatUserExists($request)]);
    }

    private function return_json($message): JsonResponse
    {
        return $this->json([
            'message' => $message
        ]);
    }

    private function transformJsonBody(Request $request): Request
    {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
