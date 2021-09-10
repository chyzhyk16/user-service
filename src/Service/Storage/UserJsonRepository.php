<?php

namespace App\Service\Storage;

use Symfony\Component\Config\Definition\Exception\Exception;

class UserJsonRepository implements UserRepositoryInterface
{

    private $filename = 'users.json';

    /**
     * @param User $user
     * @return bool
     */
    public function save(User $user): bool
    {
        try {
            $result = $this->fetchData();
            $result[$user->getEmail()] = $user->getPassword();
            $json_data = json_encode($result);
            file_put_contents($this->filename, $json_data);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }


    /**
     * @param string $email
     * @return User|false
     */
    public function findOne(string $email)
    {
        $users = $this->fetchData();
        if (key_exists($email, $users)) {
            $user = new User();
            $user->setEmail($email);
            $user->setPassword($users[$email]);
            return $user;
        } else {
            return false;
        }
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        $result = [];
        $data = $this->fetchData();
        foreach ($data as $key => $value) {
            $user = new User();
            $user->setEmail($key);
            $user->setPassword($value);
            $result[] = $user;
        }
        return $result;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        try {
            $result = $this->fetchData();
            unset($result[$user->getEmail()]);
            $json_data = json_encode($result);
            file_put_contents($this->filename, $json_data);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    private function fetchData()
    {
        return json_decode(file_get_contents($this->filename), true);
    }
}