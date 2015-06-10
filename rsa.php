<?php namespace Crypt;
use Math\Secondary;
/**
 * Class for implementation of the Rivest-Shamir-Adleman cryptosystem.
 */
class RSA {
    private $length; // Length of Prime numbers used
    private $bases; // Number of bases for probabilistic primality test
    private $p; // First prime
    private $q; // Second prime
    private $n; // Product of p and q
    private $euler_n; // Eulers totient of n
    private $d; // Private key
    private $e; // Public key
    // Sets length and bases
    public function __construct($length = 100, $bases = 100) {
        $this->length = $length;
        $this->bases = $bases;
    }
    // Generates keys and test primality with Miller's test
    public function generateKeys() {
        while (!Secondary::millerTest($this->p = Secondary::largeNumberGenerator($this->length), $this->bases));
        while (!Secondary::millerTest($this->q = Secondary::largeNumberGenerator($this->length), $this->bases));
        $this->n = Secondary::multiply($this->p, $this->q);
        $this->euler_n = Secondary::multiply(Secondary::deduct($this->p, '1'), Secondary::deduct($this->q, '1'));
        $this->getE();
        $this->d = Secondary::inverse($this->e, $this->euler_n);
    }
    // Allows class to distribute it's public key
    public function getPublicKey() {
        return array('n' => $this->n, 'e' => $this->e);
    }
    private function getE() {
        $length = round($this->length / 2);
        while (!Secondary::millerTest($this->e = Secondary::largeNumberGenerator($this->length), $this->bases) || Secondary::divides($this->euler_n, $this->n));
    }
    public function encrypt($key, $message) {
        if (Secondary::compare($key['n'], $message) <= 0) {
            return "Message too long.";
        }
        return Secondary::expMod($message, $key['e'], $key['n']);
    }
    public function decrypt($cipher) {
        return Secondary::expMod($cipher, $this->d, $this->n);
    }
}
