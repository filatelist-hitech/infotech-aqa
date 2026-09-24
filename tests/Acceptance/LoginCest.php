<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;
use Tests\Support\Page\LoginPage;

final class LoginCest
{
    private LoginPage $loginPage;

    public function _before(AcceptanceTester $I): void
    {
        $this->loginPage = new LoginPage($I);
        $this->loginPage->open();
    }

    public function loginWithInvalidCredentials(AcceptanceTester $I): void
    {
        $this->loginPage->login('aqa_invalid_user@example.test', 'InvalidPassword123!');

        $I->seeElement(LoginPage::FORM);
        $I->waitForText('Incorrect email / password', 10, LoginPage::PASSWORD_ERROR);
//        $I->makeScreenshot('loginWithInvalidCredentials');
	}

    public function submitEmptyForm(AcceptanceTester $I): void
    {
        $this->loginPage->login('','');

        $I->waitForText('Email cannot be blank.', 10,  LoginPage::EMAIL_ERROR);
        $I->waitForText('Password cannot be blank.', 10,  LoginPage::PASSWORD_ERROR);
//	$I->makeScreenshot('submitEmptyForm');
    }

    public function passwordIsMasked(AcceptanceTester $I): void
    {
        $this->loginPage->fillPassword('VisibleOnlyInTheTest123!');

        $I->assertSame('password', $I->grabAttributeFrom(LoginPage::PASSWORD, 'type'));
//      $I->makeScreenshot('passwordIsMasked'); 
   }

    public function openPasswordRecovery(AcceptanceTester $I): void
    {
        $this->loginPage->openPasswordRecovery();

        $I->seeInCurrentUrl('/site/restore-password');
        $I->waitForElementVisible('#reset-form',10);
//	$I->makeScreenshot('openPasswordRecovery');

    }
}
