<?php
     #include "generateNHash.php";
     include "salt_gen.php";
     $s = "pass123";
     $x1 = hash("sha256", "0pass123salt");
     $x2 = hash("sha256", $x1."pass123salt");
     echo "Lower: ".$x2.'<br>';
     $x2 = hash("sha256",strtoupper($x1)."pass123salt");
     echo "Upper: ".$x2.'<br>';
     $x2 = hash("sha256", hexToStr($x1)."pass123salt");
     echo "Method3: ".$x2, PHP_EOL;
     //echo generate()
?>