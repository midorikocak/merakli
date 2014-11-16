<?php
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
if (isset($posts) && !empty($posts)):
    foreach ($posts as $post):
        ?>
        <article>
            <h2><?php echo $post['title']; ?></h2>

            <p><?= substr(strip_tags($post['content']), 0, 40) ?>... <a
                    href="<?= LINK_PREFIX ?>/Posts/View/<?= $post['id'] ?>">Devamını Oku</a></p>
            <small><?= $post['created'] ?></small>
        </article>
    <?php
    endforeach;
endif;
?>

