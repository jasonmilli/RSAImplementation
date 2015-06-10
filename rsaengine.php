<?php
// Run this to test the implementation of the method.
require 'primary.php';
require 'secondary.php';
require 'rsa.php';
use Math\Secondary;
use Crypt\RSA;
$sender = new RSA(2,2);
$receiver = new RSA(2,2); // Be aware, any higher than 2,2 will result in severe performance penalties, ideally this should be 100,100
echo "Generating Keys...\n";
$receiver->generateKeys();
echo "Public Key:\n";
print_r($key = $receiver->getPublicKey());
echo "Message: ".($message = 'j')."\n";
echo "Cipher: ".($cipher = $sender->encrypt($key, ord($message).''))."\n";
echo "Decoded message: ".chr($receiver->decrypt($cipher))."\n";
