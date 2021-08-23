<?php

echo color('blue', "[+]")." ===========================================\n";
echo color('blue', "[+]")." AES-256-GCM Encrypt Decrypt - By: GidhanB.A\n";
echo color('blue', "[+]")." ===========================================\n";
echo color('blue', "[+]")." 1. Encrypt\n";
echo color('blue', "[+]")." 2. Decrypt\n";
echo color('blue', "[+]")." ===========================================\n";
echo color('blue', "[+]")." Select your tools: ";
$tools = trim(fgets(STDIN));

echo "\n";
if ($tools == 1) {
    echo color('yellow', "[+]")." Encrypt Mode\n";
    echo color('yellow', "[+]")." Input Text: ";
    $text = trim(fgets(STDIN));
    echo color('yellow', "[+]")." Input Password: ";
    $pswd = trim(fgets(STDIN));
    $res = AESencrypt($text,$pswd);
    echo color('green', "[+]")." Encrypted: $res\n";
} elseif ($tools == 2) {
    echo color('yellow', "[+]")." Decrypt Mode\n";
    echo color('yellow', "[+]")." Input Encrypted Text: ";
    $enc = trim(fgets(STDIN));
    echo color('yellow', "[+]")." Input Password: ";
    $pswd = trim(fgets(STDIN));
    $res = AESdecrypt($enc,$pswd);
    echo color('green', "[+]")." Decrypted: $res\n";
} else {
    die(color('red', "[+]")." Error!\n");
}

function AESencrypt($text,$key)
    {
        $tag = "";
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-gcm'));
        $ciphertext = openssl_encrypt($text, 'aes-256-gcm', substr(hash('sha256', $key, true), 0, 32), OPENSSL_RAW_DATA, $iv, $tag, "", 16);
        $encrypted = base64_encode($iv.$ciphertext.$tag);
        return $encrypted;
    }

function AESdecrypt($text,$key)
    {
        $decrypted = openssl_decrypt(substr(base64_decode($text), openssl_cipher_iv_length('aes-256-gcm'), - 16), 'aes-256-gcm', substr(hash('sha256', $key, true), 0, 32), OPENSSL_RAW_DATA, substr(base64_decode($text), 0, openssl_cipher_iv_length('aes-256-gcm')), substr(base64_decode($text), - 16));
        return $decrypted;
    }

function color($color, $text)
    {
        $arrayColor = array(
            'red'       => '1;31',
            'green'     => '1;32',
            'yellow'    => '1;33',
            'blue'      => '1;34',
        );  
        return "\033[".$arrayColor[$color]."m".$text."\033[0m";
    }