<?php


namespace App\Security;


class Crypt
{
    private $output = false;
    private $encrypt_method = 'AES-256-CBC';
    private $secret_key = 'fe67d68ee1e09b47acd8810b880d537034c10c15344433a992b9c79002666844';
    private $secret_iv = 'fdd3345455fffgffffhkkyoife67d68ee1e09b47acd8810b880d537034c10c15344433a992b9c79002666844';

    function encrypt($string) {
        $key = hash("sha256", $this->secret_key);
        $iv = substr(hash("sha256", $this->secret_iv), 0, 16);
        $output = openssl_encrypt($string, $this->encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    function decrypt($string) {
        $key = hash("sha256", $this->secret_key);
        $iv = substr(hash("sha256", $this->secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $this->encrypt_method, $key, 0, $iv);
        return $output;
    }

}