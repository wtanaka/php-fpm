--TEST--
Test md5_file() function with ASCII output and raw binary output
--SKIPIF--
<?php

$path = dirname(__FILE__);
$data_file = "$path/EmptyFile.txt";
$data_file1 = "$path/DataFile.txt";
if !(($fp = fopen($data_file, 'w')) || ($fp1 = fopen($data_file1, 'w'))  {
  echo "File could not be created ,hence exiting from testcase due to pre-requisite failure\n";
}
fclose( $fp );
fclose( $fp1 );

--FILE--
<?php

/* Prototype: string md5_file( string filename[, bool raw_output] )
 * Description: Calculate the MD5 hash of a given file
 */

/* Creating an empty file */
if (($handle = fopen( "EmptyFile.txt", "w+")) == FALSE)
return false;

/* Creating a data file */
if (($handle2 = fopen( "DataFile.txt", "w+")) == FALSE)
return false;

/* Writing into file */ 
$filename = "DataFile.txt";
$content = "Add this to the file\n";
if (is_writable($filename)) {
  if (fwrite($handle2, $content) === FALSE) {
    echo "Cannot write to file ($filename)";
    exit;
  }
}

// close the files 
fclose($handle);
fclose($handle2);

/* Testing error conditions */
echo "\n*** Testing foe error conditions ***\n";

/* No filename */
var_dump( md5_file("") );

/* invalid filename */
var_dump( md5_file("a") );

/* Scalar value as filename  */
var_dump( md5_file(12) );

/* NULL as filename */
var_dump( md5_file(NULL) );

/* Zero arguments */
 var_dump ( md5_file() );

/* More than valid number of arguments ( valid is 2)  */
var_dump ( md5_file("EmptyFile.txt", true, NULL) );

/* Hexadecimal Output for Empty file as input */
echo "\n*** Hexadecimal Output for Empty file as Argument ***\n";
var_dump( md5_file("EmptyFile.txt") );

/* Raw Binary Output for Empty file as input */
echo "\n*** Raw Binary Output for Empty file as Argument ***\n";
var_dump( md5_file("EmptyFile.txt", true) );

/* Normal operation with hexadecimal output */
echo "\n*** Hexadecimal Output for a valid file with some contents ***\n";
var_dump( md5_file("DataFile.txt") );

/* Normal operation with raw binary output */
echo "\n*** Raw Binary Output for a valid file with some contents ***\n";
var_dump ( md5_file("DataFile.txt", true) );

// remove temp files
unlink("DataFile.txt");
unlink("EmptyFile.txt");

echo "\nDone";
?>
--EXPECTF--
*** Testing foe error conditions ***

Warning: md5_file(): Filename cannot be empty in %s on line %d
bool(false)

Warning: md5_file(a): failed to open stream: No such file or directory in %s on line %d
bool(false)

Warning: md5_file(12): failed to open stream: No such file or directory in %s on line %d
bool(false)

Warning: md5_file(): Filename cannot be empty in %s on line %d
bool(false)

Warning: md5_file() expects at least 1 parameter, 0 given in %s on line %d
NULL

Warning: md5_file() expects at most 2 parameters, 3 given in %s on line %d
NULL

*** Hexadecimal Output for Empty file as Argument ***
string(32) "d41d8cd98f00b204e9800998ecf8427e"

*** Raw Binary Output for Empty file as Argument ***
string(16) "��ُ ��	���B~"

*** Hexadecimal Output for a valid file with some contents ***
string(32) "7f28ec647825e2a70bf67778472cd4a2"

*** Raw Binary Output for a valid file with some contents ***
string(16) "(�dx%��wxG,Ԣ"

Done

