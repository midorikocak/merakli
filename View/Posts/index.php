/*
*
* Kulllanıcılara girdileri gösteren sayfa.
*
* Bu sayfaya ham veri $posts şeklinde ilişkili dizi halinde gelecek
* biz de dosya içerisinde istediğimiz şekilde verileri göstereceğiz.
* Dosya bize ham veriyi, taglenmiş html şeklinde göstermeye yarıyor.
*
* @author Midori Kocak 2014
*
*/
<?php
if(sizeof($posts>0)):
    foreach($posts as $post):
        ?>
        <h2><?php echo $post['title']; ?></h2>
        <p><?=substr($post['content'],0,40)?></p>
        <small><?=$post['created']?></small>
        <?php?
    endforeach;
endif;
?>

