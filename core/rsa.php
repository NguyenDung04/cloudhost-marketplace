<?php

class RSA
{
    private $privateKey;
    private $publicKey;

    public function setPrivateKey($path)
    {
        if (!file_exists($path)) {
            throw new Exception("Private key file not found: $path");
        }

        $this->privateKey = openssl_pkey_get_private(file_get_contents($path));
        if (!$this->privateKey) {
            throw new Exception("Unable to load private key");
        }
    }

    public function setPublicKey($path)
    {
        if (!file_exists($path)) {
            throw new Exception("Public key file not found: $path");
        }

        $this->publicKey = openssl_pkey_get_public(file_get_contents($path));
        if (!$this->publicKey) {
            throw new Exception("Unable to load public key");
        }
    }

    public function encryptWithPublicKey($data)
    {
        if (!$this->publicKey) {
            throw new Exception("Public key not set");
        }

        openssl_public_encrypt($data, $encrypted, $this->publicKey);
        return base64_encode($encrypted);
    }

    public function decryptWithPrivateKey($data)
    {
        if (!$this->privateKey) {
            throw new Exception("Private key not set");
        }

        openssl_private_decrypt(base64_decode($data), $decrypted, $this->privateKey);
        return $decrypted;
    }

    public function __destruct()
    {
        $this->privateKey = null;
        $this->publicKey = null;
    }
}