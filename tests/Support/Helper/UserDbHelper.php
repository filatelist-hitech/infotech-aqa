<?php

declare(strict_types=1);

namespace Tests\Support\Helper;

use Codeception\Module;
use InvalidArgumentException;
final class UserDbHelper extends Module
{
    /**
     * @return array{email: string, password_hash: string, first_name: string, last_name: string}
     */
    public function createTestUser(string $passwordHash): array
    {
        if ($passwordHash === '') {
            throw new InvalidArgumentException('Password hash must not be empty.');
        }

        $user = [
            'email' => sprintf('aqa.fixture.%s@example.test', bin2hex(random_bytes(6))),
            'password_hash' => $passwordHash,
            'first_name' => 'AQA',
            'last_name' => 'Fixture',
        ];

        $this->getModule('Db')->haveInDatabase('users', $user);

        return $user;
    }
}
