<?php
/*
*
* Kulllanıcılara tek girdiyi gösteren sayfa.
*
* Bu sayfaya ham veri $post şeklinde ilişkili dizi halinde gelecek
* biz de dosya içerisinde istediğimiz şekilde verileri göstereceğiz.
* Dosya bize ham veriyi, taglenmiş html şeklinde göstermeye yarıyor.
*
* @author Midori Kocak 2014
*
*/
?>
<article>
    <h2><?php echo $post['title']; ?></h2>

    <p><?= $post['content'] ?></p>
    <small><?= $post['created'] ?></small>
</article>


