<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Auth;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testGenerateTrankey()
    {
        $auth = new Auth();
        $login = 'usuarioprueba';
        $secret = 'ABCD1234';
        $nonce = "WmEyvut9GgvcMWrV";
        $seed = "2016-08-30T16:21:35+00:00";
        $auth->setLogin($login);
        $auth->setSecret($secret);
        $auth->setNonce($nonce);
        $auth->setSeed($seed);


        $this->assertEquals("i/RFwSHAh8d7YgtO3HME5kCnYy8=", $auth->getTranKey(), 'Las Trankey generada es valida');


    }

    public function testGetNonce()
    {
        $auth = new Auth();
        $nonce = "WmEyvut9GgvcMWrV";
        $seed = "2016-08-30T16:21:35+00:00";
        $auth->setNonce($nonce);
        $auth->setSeed($seed);

        $this->assertEquals("V21FeXZ1dDlHZ3ZjTVdyVg==", $auth->getNonce(), 'El nonce retornado es valido');
    }
}
