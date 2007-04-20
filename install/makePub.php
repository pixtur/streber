<?php
# makes all files in a directory readable. 
# Read more at http://www.streber-pm.org/3643


function listdirs($dir) 
{
    $dirs= glob($dir . "/*");
    if(count(dirs)) {
        foreach($dirs as $file) {
            echo $file."<br>";
            if(is_dir($file)) {
                chmod($file, 0777);
                listdirs($file);
            }
            else {
                chmod($file, 0644);
            }
        }
    }
}

listdirs(".");

?>
