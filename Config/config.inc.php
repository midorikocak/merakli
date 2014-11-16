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
    'db' =>
        array(
            'host' => '127.0.0.1',
            'dbname' => 'merakli',
            'username' => 'root',
            'password' => 'midori',
        ),
);