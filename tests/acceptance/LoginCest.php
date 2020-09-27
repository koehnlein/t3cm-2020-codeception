<?php 

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function enterInvalidUserData(AcceptanceTester $I)
    {
        $I->amOnPage('/account/login/');
        $I->wantTo('log in');

        $I->waitForElement('.tx-felogin-pi1');
        $I->scrollTo('.tx-felogin-pi1');

        /*
        $I->fillField('input[name="user"]', 'random@example.com');
        $I->fillField('input[name="pass"]', 'dingsbums');
        $I->click('input[type="submit"]');
        */

        $I->submitForm('.tx-felogin-pi1 form', [
            'user' => 'dings@bums.de',
            'pass' => 'dingsbums',
        ]);

        $I->expectTo('see an error message');
        $I->waitForText('Login failure');
    }
}
