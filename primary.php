<?php namespace Math;
/**
 * Class for basic mathematical functions using strings of integers.
 * To circumvent PHP's 32-bit signed integer limit as keys must be in the region of 100 digits.
 * Could have used an array of integers or full ASCII codes to be more efficient.
 */
class Primary {
    public static function multiply($a, $b) {
        if ($a == '0' || $b == '0') {
            return '0';
        }
        $xor = 0;
        if (substr($a,0,1) == '-') {
            $a = substr($a,1);
            $xor++;
        }
        if (substr($b,0,1) == '-') {
            $b = substr($b,1);
            $xor++;
        }
        $return = "0";
        for ($i = 0; $i < strlen($a); $i++) {
            for ($j = 0; $j < strlen($b); $j++) {
                $zeroes = str_repeat("0", (strlen($a) - $i -1) + (strlen($b) - $j - 1));
                $return = self::add($return, ($a[$i] * $b[$j]).$zeroes);
            }
        }
        if ($xor == 1) {
            $return = '-'.$return;
        }
        return $return;
    }
    public static function power($base, $exp) {
        $return = '1';
        for ($i = 0; $i < $exp; $i++) {
            $return = self::multiply($return, $base);
        }
        return $return;
    }
    // Could have used divides and ignored one of the return
    public static function divide($numerator, $divisor) {
        $count = 0;
        while ($numerator >= $divisor) {
            $numerator = self::deduct($numerator, $divisor);
            $count++;
        }
        return array('quotient' => $count.'', 'remainder' => $numerator);
    }
    public static function divides($numerator, $divisor) {
        while ($numerator >= $divisor) {
            $numerator = self::deduct($numerator, $divisor);
            if ($numerator == 0) {
                return true;
            }
        }
        return false;
    }
    public static function add($a, $b) {
        if (substr($a,0,1) == '-' && substr($b,0,1) == '-') {
            $negative = true;
            $a = substr($a,1);
            $b = substr($b,1);
        } elseif (substr($a,0,1) == '-') {
            $a = substr($a,1);
            return self::deduct($b, $a);
        } elseif (substr($b,0,1) == '-') {
            $b = substr($b,1);
            return self::deduct($a, $b);
        } else {
            $negative = false;
        }
        $max = max(strlen($a),strlen($b));
        $return = '';
        $carry = false;
        $a = str_pad($a, $max, "0", STR_PAD_LEFT);
        $b = str_pad($b, $max, "0", STR_PAD_LEFT);
        for ($i = $max - 1; $i >=0; $i--) {
            $sum = $a[$i] + $b[$i];
            if ($carry) {
                $sum++;
            }
            if ($carry = ($sum >= 10)) {
                $sum -= 10;
            }
            $return = $sum.$return;
        }
        if ($carry) {
            $return = '1'.$return;
        }
        if ($negative) {
            $return = '-'.$return;
        }
        return $return;
    }
    public static function compare($a, $b) {
        if (substr($a,0,1) == '-' && substr($b,0,1) == '-') {
            $b = substr($a,1);
            $a = substr($b,1);
        } elseif (substr($a,0,1) == '-') {
            return -1;
        } elseif (substr($b,0,1) == '-') {
            return 1;
        }
        if ($a == $b) {
            return 0;        
        }
        if (strlen($a) > strlen($b)) {
            return 1;
        }
        if (strlen($a) < strlen($b)) {
            return -1;
        }
        for ($i = 0; $i < strlen($a); $i++) {
            if ($a[$i] > $b[$i]) {
                return 1;
            }
            if ($a[$i] < $b[$i]) {
                return -1;
            }
        }
    }
    public static function deduct($a, $b) {
        if (substr($a,0,1) == '-' && substr($b,0,1) == '-') {
            $negative = true;
            $a = substr($a,1);
            $b = substr($b,1);
        } elseif (substr($a,0,1) == '-') {
            $a = substr($a,1);
            return '-'.self::add($a, $b);
        } elseif (substr($b,0,1) == '-') {
            $b = substr($b,1);
            return self::add($a, $b);
        } else {
            $negative = false;
        }
        $comp = self::compare($a,$b);
        if ($comp == 0) {
            return 0;
        }
        if ($comp == -1) {
            $negative = !$negative;
            $t = $a;
            $a = $b;
            $b = $t;
        }
        $return = '';
        $carry = false;
        $b = str_pad($b, strlen($a), "0", STR_PAD_LEFT);
        for ($i = strlen($a) - 1; $i >= 0; $i--) {
            if ($carry) {
                $aa = $a[$i] - 1;
            } else {
                $aa = $a[$i];
            }
            if ($b[$i] > $aa) {
                $carry = true;
                $return = ($aa + 10 - $b[$i]).$return;
            } else {
                $carry = false;
                $return = ($aa - $b[$i]).$return;
            }
        }
        return ($negative ? '-' : '').(self::trim($return));
    }
    public static function divisible2($number) {
        $last = substr($number,strlen($number) - 1);
        return self::even($last);
    }
    public static function halve($number) {
        $result = '';
        $carry = false;
        for ($i = 0; $i < strlen($number); $i++) {
            if ($carry) {
                $a = $number[$i] + 10;
            } else {
                $a = $number[$i];
            }
            if (self::even($number[$i])) {
                $carry = false;
                $result .= $a / 2;
            } else {
                $carry = true;
                $result .= ($a -1) / 2;
            }
        }
        return self::trim($result);
    }
    public static function trim($a) {
        $return = '';
        $start = true;
        for ($i = 0; $i < strlen($a); $i++) {
            if ($a[$i] != 0 || !$start) {
                $return .= $a[$i];
                $start = false;
            }
        }
        return $return;
    }
    // Easily discount integers divisible by 2, 3 or 5
    public static function clearDivisibility($large_number) {
        $last = substr($large_number, strlen($large_number) - 1);
        if (self::even($last) || $last == '5') {
            return true;
        }
        return self::divisible3($large_number);
    }
    // Can be extended for divisibility by 9
    public static function divisible3($a) {
        $check = 0;
        for ($i = 0; $i < strlen($a); $i++) {
            $check += $a[$i];
        }
        return $check % 3 == 0;
    }
    public static function even($a) {
        return in_array($a, array(0,2,4,6,8));
    }
}
