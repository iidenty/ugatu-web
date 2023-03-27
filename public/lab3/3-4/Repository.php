<?php

namespace lab3s34;

class Repository
{
    public function getByLogin(string $login): User
    {
        if (($handle = fopen('database.csv', "r")) !== FALSE) {
            while (($data = fgetcsv($handle, null, ";")) !== FALSE) {
                $loginRow = $data[0];

                if ($loginRow === $login)
                    return new User(
                        $login,
                        $data[2],
                        $data[1],
                        $data[3]
                    );
            }
            fclose($handle);
        }

        throw new UserNotFoundException('User not found.');
    }
}