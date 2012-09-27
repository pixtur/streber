<?php

 if(file_exists("../install")) {
   rmdirRecursive("../install");
 }
 if(file_exists("../install")) {
  echo "install-directory writeprotected<br>";
 }
 else {
  echo "install-directory has been removed<br>";
 }
  echo "-> return to <a href='../index.php'>login-page</a>";


function rmdirRecursive($path,$followLinks=false) {

   $dir = opendir($path) ;
   while ( $entry = readdir($dir) ) {

       if ( is_file( "$path/$entry" ) || ((!$followLinks) && is_link("$path/$entry")) ) {
           @unlink( "$path/$entry" );
       } elseif ( is_dir( "$path/$entry" ) && $entry!='.' && $entry!='..' ) {
           rmdirRecursive( "$path/$entry" ) ;
       }
   }
   closedir($dir) ;
   return @rmdir($path);
}


?>