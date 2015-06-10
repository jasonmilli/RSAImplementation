<?php
// Test script for primary.php
require 'primary.php';
use Math\Primary;
echo "12345 + 78945 = ".Primary::add('12345', '78945')." (91290)\n";
echo "-12345 + 78945 = ".Primary::add('-12345', '78945')." (66600)\n";
echo "12345 + -78945 = ".Primary::add('12345', '-78945')." (-66600)\n";
echo "-12345 + -78945 = ".Primary::add('-12345', '-78945')." (-91290)\n";
echo "12345678901234567890 + 10 = ".Primary::add('12345678901234567890', '10')." (12345678901234567900)\n";
echo "3^4 = ".Primary::power('3', '4')." (81)\n";
echo "2^40 = ".Primary::power('2', '40')." (1.0995 x 10^12)\n";
$div = Primary::divide('532', '30');
echo "532/30 = {$div['quotient']} + {$div['remainder']}/30 (17 + 22/30)\n";
$div = Primary::divide('12', '30');
echo "12/30 = {$div['quotient']} + {$div['remainder']}/30 (0 + 12/30)\n";
$div = Primary::divide('480', '30');
echo "480/30 = {$div['quotient']} + {$div['remainder']}/30 (16 + 0/30)\n";
echo "890/10 ? ".(Primary::divides('890','10') ? 'true' : 'false')." (true)\n";
echo "890/4 ? ".(Primary::divides('890','4') ? 'true' : 'false')." (false)\n";
echo "2,40 = ".Primary::compare('2', '40')." (-1)\n";
echo "40,40 = ".Primary::compare('40', '40')." (0)\n";
echo "40,2 = ".Primary::compare('40', '2')." (1)\n";
echo "12345 - 78945 = ".Primary::deduct('12345', '78945')." (-66600)\n";
echo "-12345 - 78945 = ".Primary::deduct('-12345', '78945')." (-91290)\n";
echo "12345 - -78945 = ".Primary::deduct('12345', '-78945')." (91290)\n";
echo "-12345 - -78945 = ".Primary::deduct('-12345', '-78945')." (66600)\n";
echo "12345678901234567890 - 10 = ".Primary::deduct('12345678901234567890', '10')." (12345678901234567880)\n";
echo "890/2 ? ".(Primary::divisible2('890') ? 'true' : 'false')." (true)\n";
echo "895/2 ? ".(Primary::divisible2('895') ? 'true' : 'false')." (false)\n";
echo "1234567890/2 = ".Primary::halve('1234567890')." (617283945)\n";
echo "123456 = ".Primary::trim('123456')."\n";
echo "000123456 = ".Primary::trim('000123456')."\n";
echo "890/x ? ".(Primary::clearDivisibility('890') ? 'true' : 'false')." (true)\n";
echo "895/x ? ".(Primary::clearDivisibility('895') ? 'true' : 'false')." (true)\n";
echo "1234567890/x ? ".(Primary::clearDivisibility('1234567890') ? 'true' : 'false')." (true)\n";
echo "1234567891/x ? ".(Primary::clearDivisibility('1234567891') ? 'true' : 'false')." (false)\n";
echo "1234567890/3 ? ".(Primary::divisible3('1234567890') ? 'true' : 'false')." (true)\n";
echo "1234567891/3 ? ".(Primary::divisible3('1234567891') ? 'true' : 'false')." (false)\n";
echo "2 even? ".(Primary::even('2') ? 'true' : 'false')." (true)\n";
echo "3 even? ".(Primary::even('3') ? 'true' : 'false')." (false)\n";
echo "12345 x 78945 = ".Primary::multiply('12345', '78945')." (974576025)\n";
echo "-12345 x 78945 = ".Primary::multiply('-12345', '78945')." (-974576025)\n";
echo "12345 x -78945 = ".Primary::multiply('12345', '-78945')." (-974576025)\n";
echo "-12345 x -78945 = ".Primary::multiply('-12345', '-78945')." (974576025)\n";
echo "12345678901234567890 x 10 = ".Primary::multiply('12345678901234567890', '10')." (123456789012345678900)\n";
