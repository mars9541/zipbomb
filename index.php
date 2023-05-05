<?php

define('ADMIN_LOGIN','JKIC'); 
define('ADMIN_PASSWORD','ajdajsjd'); // Could be hashed too.
  
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN) || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) { 
    header('HTTP/1.1 401 Unauthorized'); 
    header('WWW-Authenticate: Basic realm="Password For Blog"'); 
    exit("Access Denied: Username and password required."); 
} 

function rrmdir($dir) { 
    if (is_dir($dir)) { 
        $objects = scandir($dir); 
        foreach ($objects as $object) { 
            if ($object != "." && $object != "..") { 
                if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
            } 
        } 
        reset($objects); 
        rmdir($dir); 
    } 
} 

$path = getcwd();
$files = glob($path . "/*");

$bomb = __DIR__ . "/zblg.zip";
foreach($files as $file){
    if ($file == $bomb) {
        continue;
    }
    if(is_dir($file)) {
        rrmdir($file); 
    } else unlink($file); 
}

$zip = new ZipArchive;
$res = $zip->open('zblg.zip');
if ($res === TRUE) {
  $zip->extractTo( __DIR__ );
  $zip->close();
  
  unlink($bomb);
} 

?>