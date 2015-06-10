<?php
// Test script for secondary.php
require 'primary.php';
require 'secondary.php';
use Math\Secondary;
echo "Large number length 100: ".Secondary::largeNumberGenerator(100)."\n";
echo "Large number length 100: ".Secondary::largeNumberGenerator(100)."\n";
echo "Inverse of 4 (mod 19): ".Secondary::inverse('4', '19')." (5)\n";
echo "Inverse of 7 (mod 64): ".Secondary::inverse('7', '64')." (55)\n";
echo "Modulus of 319 (mod 7): ".Secondary::modulus('319', '7')." (4)\n";
echo "Modulus of 7 (mod 319): ".Secondary::modulus('7', '319')." (7)\n";
echo "Modulus of 210 (mod 7): ".Secondary::modulus('210', '7')." (0)\n";
$st = Secondary::getST('193');
echo "s,t of 193: {$st['s']},{$st['t']} (6,3)\n";
$st = Secondary::getST('2049');
echo "s,t of 2049: {$st['s']},{$st['t']} (11,1)\n";
$st = Secondary::getST('194');
echo "s,t of 194: {$st['s']},{$st['t']} (0,193)\n";
//print_r(Secondary::getBases(100,100));
echo "Base 2, exponent 10, modulus 51: ".Secondary::expMod('2','10','51')." (4)\n";
echo "Base 7, exponent 8, modulus 17: ".Secondary::expMod('7','8','17')." (4)\n";
echo "Miller Test 17, 2 bases: ".(Secondary::millerTest('17', '2') ? 'prime' : 'composite')." (prime)\n";
echo "Miller Test 128, 1 bases: ".(Secondary::millerTest('128', '1') ? 'prime' : 'composite')." (composite)\n";
