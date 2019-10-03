<?php

require_once ROOT.'/services/FileService.php';
require_once ROOT.'/config/Registry.php';

class OpensslRSA
{
    /**
     * Encrypting the data by using the public key and store the results in $encrypted
     * @param $data
     * @return string $encrypted
     */
    public static function encryptDataByPublKey(string $data): string
    {
        $filePublKey = Registry::$pathToKey.Registry::$fileNamePublKey;
        $publicKey = self::getKey($filePublKey);

        openssl_public_encrypt($data, $encrypted, $publicKey);

        return $encrypted;
    }

    /**
     * Decrypting the ecryptData by using the private key and store the results in $decrypted
     * @param $encryptdata
     * @return string $decrypted
     */
    public static function decryptDataByPrivKey(string $encryptdata): string
    {
        $filePrivKey = Registry::$pathToKey.Registry::$fileNamePrivKey;
        $privateKey =  self::getKey($filePrivKey);

        openssl_private_decrypt($encryptdata, $decrypted, $privateKey);

        return $decrypted;
    }

    public static function getKey(string $file): string
    {
        return FileService::getContentFromFile($file);
    }

}