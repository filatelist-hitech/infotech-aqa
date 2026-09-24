<?php

declare(strict_types=1);

namespace Tests\Support\Page;

use Tests\Support\AcceptanceTester;

final class LoginPage
{
    public const ROUTE = '/login';
    public const FORM = '#login-form';
    public const EMAIL = '#loginform-email';
    public const PASSWORD = '#loginform-password';
    public const EMAIL_ERROR = '#loginform-email ~ .help-block-error';
    public const PASSWORD_ERROR = '#loginform-password ~ .help-block-error';

    private const SUBMIT = '#login-form button[type="submit"]';
    private const PASSWORD_RECOVERY = '#login-form a[href="/site/restore-password"]';

    public function __construct(private readonly AcceptanceTester $I)
    {
    }

    public function open(): void
    {
        $this->I->amOnPage(self::ROUTE);
	$this->I->waitForElementVisible((self::FORM),10);
    }

    public function login(string $email, string $password): void
    {
        $this->fillEmail($email);
        $this->fillPassword($password);
        $this->submit();
    }

    public function fillEmail(string $email): void
    {
        $this->I->fillField(self::EMAIL, $email);
    }

    public function fillPassword(string $password): void
    {
        $this->I->fillField(self::PASSWORD, $password);
    }

    public function submit(): void
    {
        $this->I->click(self::SUBMIT);
    }

    public function openPasswordRecovery(): void
    {
        $this->I->click(self::PASSWORD_RECOVERY);
    }
}
