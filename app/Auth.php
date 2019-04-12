<?php


namespace App;


class Auth
{
    private $seed;
    private $nonce;

    public function __construct()
    {
        $this->seed = date('c');
        $this->generateNonce();
    }

    public function generateNonce()
    {
        if (function_exists('random_bytes')) {
            $this->nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $this->nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $this->nonce = mt_rand();
        }


    }

    /**
     * @return string
     */
    public function getSeed()
    {
        return $this->seed;
    }

    public function getNonce(): string
    {
        return base64_encode($this->nonce);
    }


    public function setSeed($seed)
    {
        $this->seed = $seed;
    }

    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
    }


    public function getTranKey()
    {
        return base64_encode(sha1($this->nonce . $this->seed . env('P2P_SECRET_KEY'), true));
    }


}