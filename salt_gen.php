<?php
     $salt = openssl_random_pseudo_bytes(40, $cstrong);
     if (!$cstrong) {
          die("Not cryto strong.");
     }
     
     function hexToStr($hex)
     {
         $string='';
         for ($i=0; $i < strlen($hex)-1; $i+=2)
         {
             $string .= chr(hexdec($hex[$i].$hex[$i+1]));
         }
         return $string;
     }
     
     $salt = bin2hex($salt);
     //echo "Salt: ".$salt, PHP_EOL;
?>