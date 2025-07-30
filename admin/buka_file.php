<?php

if(isset($_GET['open'])){
    switch($_GET['open']){
        case '' :
            if(!file_exists("informasi_utama.php")) die ("file tidak ada");
            include "informasi_utama.php"; break;
            default:
            if(!file_exists("informasi_utama.php")) die ("file tidak ada");
            include "informasi_utama.php"; break;
    }
}
else{
    if(!file_exists("informasi_utama.php")) die ("file tidak ada");
    include "informasi_utama.php";
}
?>