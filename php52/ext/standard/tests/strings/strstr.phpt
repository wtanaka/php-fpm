--TEST--
Test strstr() function
--FILE--
<?php
/* Prototype: string strstr ( string $haystack, string $needle );
   Description: Find first occurrence of a string 
   and reurns the rest of the string from that string 
*/

echo "*** Testing basic functionality of strstr() ***\n";
var_dump( strstr("test string", "test") );
var_dump( strstr("test string", "string") );
var_dump( strstr("test string", "strin") );
var_dump( strstr("test string", "t s") );
var_dump( strstr("test string", "g") );
var_dump( md5(strstr("te".chr(0)."st", chr(0))) );
var_dump( strstr("tEst", "test") );
var_dump( strstr("teSt", "test") );
var_dump( @strstr("", "") );
var_dump( @strstr("a", "") );
var_dump( @strstr("", "a") );


echo "\n*** Testing strstr() with various needles ***";
$string = 
"Hello world,012033 -3.3445     NULL TRUE FALSE\0 abcd\xxyz \x000 octal\n 
abcd$:Hello world";

/* needles in an array to get the string starts with needle, in $string */
$needles = array(
  "Hello world", 	
  "WORLD", 
  "\0", 
  "\x00", 
  "\x000", 
  "abcd", 
  "xyz", 
  "octal", 
  "-3", 
  -3, 
  "-3.344", 
  -3.344, 
  NULL, 
  "NULL",
  "0",
  0, 
  TRUE, 
  "TRUE",
  "1",
  1,
  FALSE,
  "FALSE",
  " ",
  "     ",
  'b',
  '\n',
  "\n",
  "12",
  "12twelve",
  $string
);

/* loop through to get the string starts with "needle" in $string */
for( $i = 0; $i < count($needles); $i++ ) {
  echo "\n-- Iteration $i --\n";
  var_dump( strstr($string, $needles[$i]) );
}  

	
echo "\n*** Testing Miscelleneous input data ***\n";

echo "-- Passing objects as string and needle --\n";
/* we get "Catchable fatal error: saying Object of class needle could not be 
converted to string" by default when an object is passed instead of string:
The error can be  avoided by chosing the __toString magix method as follows: */

class string 
{
  function __toString() {
    return "Hello, world";
  }
}
$obj_string = new string;

class needle 
{
  function __toString() {
    return "world";
  }
}
$obj_needle = new needle;

var_dump(strstr("$obj_string", "$obj_needle"));	


echo "\n-- passing an array as string and needle --\n";
$needles = array("hello", "?world", "!$%**()%**[][[[&@#~!");
var_dump( strstr($needles, $needles) );  // won't work
var_dump( strstr("hello?world,!$%**()%**[][[[&@#~!", "$needles[1]") );  // works
var_dump( strstr("hello?world,!$%**()%**[][[[&@#~!", "$needles[2]") );  // works


echo "\n-- passing Resources as string and needle --\n"; 
$resource1 = fopen(__FILE__, "r");
$resource2 = opendir(".");
var_dump( strstr($resource1, $resource1) );
var_dump( strstr($resource1, $resource2) );


echo "\n-- Posiibilities with null --\n";
var_dump( strstr("", NULL) );
var_dump( strstr(NULL, NULL) );
var_dump( strstr("a", NULL) );
var_dump( strstr("/x0", "0") );  // Hexadecimal NUL

echo "\n-- A longer and heredoc string --\n";
$string = <<<EOD
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
EOD;
var_dump( strstr($string, "abcd") );
var_dump( strstr($string, "1234") );		

echo "\n-- A heredoc null string --\n";
$str = <<<EOD
EOD;
var_dump( strstr($str, "\0") );
var_dump( strstr($str, NULL) );
var_dump( strstr($str, "0") );


echo "\n-- simple and complex syntax strings --\n";
$needle = 'world';

/* Simple syntax */
var_dump( strstr("Hello, world", "$needle") );  // works 
var_dump( strstr("Hello, world'S", "$needle'S") );  // works
var_dump( strstr("Hello, worldS", "$needleS") );  // won't work 

/* String with curly braces, complex syntax */
var_dump( strstr("Hello, worldS", "${needle}S") );  // works
var_dump( strstr("Hello, worldS", "{$needle}S") );  // works


echo "\n-- complex strings containing other than 7-bit chars --\n";
$str = chr(0).chr(128).chr(129).chr(234).chr(235).chr(254).chr(255);
echo "- Positions of some chars in the string '$str' are as follows -\n";
echo chr(128)." => "; 
var_dump( strstr($str, chr(128)) );		
echo chr(255)." => "; 
var_dump( strstr($str, chr(255)) );
echo chr(256)." => "; 
var_dump( strstr($str, chr(256)) ); 

echo "\n*** Testing error conditions ***";
var_dump( strstr($string, ""));
var_dump( strstr() );  // zero argument
var_dump( strstr("") );  // null argument 
var_dump( strstr($string) );  // without "needle"
var_dump( strstr("a", "b", "c") );  // args > expected
var_dump( strstr(NULL, "") );

echo "\nDone";

--CLEAN--
fclose($resource1);
closedir($resource2);
?>
--EXPECTF--
*** Testing basic functionality of strstr() ***
string(11) "test string"
string(6) "string"
string(6) "string"
string(8) "t string"
string(1) "g"
string(32) "7272696018bdeb2c9a3f8d01fc2a9273"
bool(false)
bool(false)
bool(false)
bool(false)
bool(false)

*** Testing strstr() with various needles ***
-- Iteration 0 --
string(86) "Hello world,012033 -3.3445     NULL TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 1 --
bool(false)

-- Iteration 2 --
string(40) "  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 3 --
string(40) "  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 4 --
string(28) " 0 octal
 
abcd$:Hello world"

-- Iteration 5 --
string(38) "abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 6 --
string(32) "xyz  0 octal
 
abcd$:Hello world"

-- Iteration 7 --
string(25) "octal
 
abcd$:Hello world"

-- Iteration 8 --
string(67) "-3.3445     NULL TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 9 --
bool(false)

-- Iteration 10 --
string(67) "-3.3445     NULL TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 11 --
bool(false)

-- Iteration 12 --
string(40) "  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 13 --
string(55) "NULL TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 14 --
string(74) "012033 -3.3445     NULL TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 15 --
string(40) "  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 16 --
bool(false)

-- Iteration 17 --
string(50) "TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 18 --
string(73) "12033 -3.3445     NULL TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 19 --
bool(false)

-- Iteration 20 --
string(40) "  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 21 --
string(45) "FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 22 --
string(81) " world,012033 -3.3445     NULL TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 23 --
string(60) "     NULL TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 24 --
string(37) "bcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 25 --
bool(false)

-- Iteration 26 --
string(20) "
 
abcd$:Hello world"

-- Iteration 27 --
string(73) "12033 -3.3445     NULL TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

-- Iteration 28 --
bool(false)

-- Iteration 29 --
string(86) "Hello world,012033 -3.3445     NULL TRUE FALSE  abcd\xxyz  0 octal
 
abcd$:Hello world"

*** Testing Miscelleneous input data ***
-- Passing objects as string and needle --
string(5) "world"

-- passing an array as string and needle --

Notice: Array to string conversion in %s on line %d
bool(false)
string(27) "?world,!$%**()%**[][[[&@#~!"
string(20) "!$%**()%**[][[[&@#~!"

-- passing Resources as string and needle --
%s
%s

-- Posiibilities with null --
bool(false)
bool(false)
bool(false)
string(1) "0"

-- A longer and heredoc string --
string(729) "abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789"
string(702) "123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789
abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789"

-- A heredoc null string --
bool(false)
bool(false)
bool(false)

-- simple and complex syntax strings --
string(5) "world"
string(7) "world'S"

Notice: Undefined variable: needleS in %s on line %d

Warning: strstr(): Empty delimiter in %s on line %d
bool(false)
string(6) "worldS"
string(6) "worldS"

-- complex strings containing other than 7-bit chars --
- Positions of some chars in the string ' ������' are as follows -
� => string(6) "������"
� => string(1) "�"
  => string(7) " ������"

*** Testing error conditions ***
Warning: strstr(): Empty delimiter in %s on line %d
bool(false)

Warning: Wrong parameter count for strstr() in %s on line %d
NULL

Warning: Wrong parameter count for strstr() in %s on line %d
NULL

Warning: Wrong parameter count for strstr() in %s on line %d
NULL

Warning: Wrong parameter count for strstr() in %s on line %d
NULL

Warning: strstr(): Empty delimiter in %s on line %d
bool(false)

Done
