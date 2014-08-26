<?php
/**
* Tüm sistemdeki ayarları buradan hallediyoruz.
*
* Veritabanına kaydetmediğimiz ve sürekli değişmeyecek
* olan veritabanı sunucusu, cache tipi gibi bilgileri 
* bu dosyada saklayacağız.
*
* @author     Midori Kocak <mtkocak@mtkocak.net>
*/

$config = array(
    "db"=> array(
        "dbname"=>"merakli",
        "host"=>"localhost",
        "username"=>"root",
        "password"=>"midori"
    )
);

?>