<?php

namespace App\Service;

use App\Service\Storage\User;
use App\Service\Storage\UserJsonRepository;

class UserService
{

    /**
     * @var UserJsonRepository
     */
    private $repository;

    public function __construct(UserJsonRepository $repository){
        $this->repository = $repository;
    }
    /**
     * @param $request
     * @return bool
     */
    public function create($request): bool
    {
        try {
            if ($this->checkThatUserExists($request)) {
                return false;
            } else {
                $user = new User();
                $user->setEmail($request->get('email'));
                $user->setPassword($request->get('password'));
                return $this->repository->save($user);
            }
        } catch (\Exception $ex) {
            return false;
        }

    }


    public function checkThatUserExists($request): bool
    {
        return (bool)$this->repository->findOne($request->get('email'));
    }
}