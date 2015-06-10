<?php namespace Math;
/**
 * Class for more complicated Math functions.
 * Uses the basic functions from primary.
 * For systems with an alternate storage, ie not strings of digits, this can be used with probably not too many changes.
 */
class Secondary extends Primary {
    /**
     * Extended Euclidean Algorithm.
     * Returns the multiplicative inverse of a number $a (mod $mod).
     */
    public static function inverse($a, $mod) {
        $i = 2;
        $q = array('0');
        $r = array($mod, $a);
        $s = array('1','0');
        $t = array('0','1');
        while (true) {
            $divide = self::divide($r[$i-2], $r[$i-1]);
            if ($divide['remainder'] == 0) {
                return false;
            }
            $q[] = $divide['quotient'];
            $r[] = $divide['remainder'];
            $s[] = self::deduct($s[$i-2], self::multiply($q[$i-1],$s[$i-1]));
            $t[] = self::deduct($t[$i-2], self::multiply($q[$i-1],$t[$i-1]));
            if ($divide['remainder'] == '1') {
                break;
            }
            $i++;
        }
        if (self::compare($t[$i], '0') == 1) {
            return $t[$i];
        } else {
            return self::add($mod, $t[$i]);
        }
    }
    /**
     * Tests for the primality of a number $a.
     * By Rabin's Probabilistic formula, the chance of composite $a passing is:
     *     0.25 ^ $number_of_bases
     */
    public static function millerTest($a, $number_of_bases) {
        $st = self::getST($a);
        $bases = self::getBases($number_of_bases, strlen($a));
        foreach ($bases as $base) {
            $prime = false;
            if (self::expMod($base, $st['t'], $a) == 1) {
                $prime = true;
            } else {
                for ($j = 0; $j < $st['s']; $j++) {
                    if (self::expMod($base, self::multiply($st['t'], self::power('2', $j.'')), $a) == self::deduct($a, '1')) {
                        $prime = true;
                        break;
                    }
                }
            }
            if (!$prime) {
                return false;
            }
        }
        return true;
    }
    /**
     * Returns $base ^ $exp (mod $mod)
     */
    public static function expMod($base, $exp, $mod) {
        $running = "1";
        for ($i=0; $i<$exp; $i++) {
            $running = self::multiply($running, $base);
            $running = self::modulus($running, $mod);
        }
        return $running;
    }
    public static function modulus($a, $mod) {
        while (self::compare($a, $mod) >= 0) {
            $a = self::deduct($a, $mod);
        }
        return $a;
    }
    /**
     * Returns an array of distinct bases for the Miller Test.
     * Could be made more efficient and random by using a slightly different largeNumberGenerator function to include evens etc.
     */
    public static function getBases($count, $length) {
        $bases = array();
        for ($i = 0; $i < $count; $i++) {
            $degree = rand(1,$length - 1);
            while(in_array($base = self::largeNumberGenerator($degree), $bases));
            $bases[] = $base;
        }
        return $bases;
    }
    /**
     * For $number calculates (2 ^ s) * t.
     * t is an odd integer.
     */
    public static function getST($number) {
        $s = 0;
        $number = self::deduct($number, '1');
        while (self::divisible2($number)) {
            $s++;
            $number = self::halve($number);
        }
        return array('s' => $s, 't' => $number);
    }
    /**
     * Uses microtime to create a random number.
     * Also checks that the string is not divisible by 2, 3 or 5 allthough this should be optional.
     * Depending on processor speeds this may not be completely random, works fine on the pi.
     */
    public static function largeNumberGenerator($length) {
        $check = false;
        while (!$check) {
            $large_number = '';
            for ($i = 0; $i < $length; $i++) {
                while (($digit = substr(microtime(),7,1)) == '0' && $i == 0);
                $large_number .= $digit;
            }
            if (!self::clearDivisibility($large_number)) {
                $check = true;
            }
        }
        return $large_number;
    }
}
