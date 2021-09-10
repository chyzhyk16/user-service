<?php

namespace App\Service\Storage;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool;

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool;

    /**
     * @param string $email
     * @return mixed
     */
    public function findOne(string $email);

    /**
     * @return User[]
     */
    public function findAll(): array;
}