<?php
$currDir = dirname(__FILE__);
//  $dir ="D:\\tutorial\\";
  $jrDirLib = $currDir. '/commons' ;
  	
  $handle = @opendir($jrDirLib);
  
  while(($lib = readdir($handle)) !== false) {
    $classpath .= 'file:'.$jrDirLib.'/'.$lib .';';
  }
  
  java_require($classpath);