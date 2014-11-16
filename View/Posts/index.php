<?php
/**
 * Posts are shown in public context. This file serves to present raw data as html tags.
 *
 * @author Midori Kocak 2014
 *
 */
if (isset($posts) && ! empty($posts)) :
    foreach ($posts as $post) :
        ?>
<article>
	<h2><?php echo htmlspecialchars($post['title']); ?></h2>

	<p><?= substr(strip_tags($post['content']), 0, 40) ?>... <a
			href="<?= LINK_PREFIX ?>/Posts/View/<?= $post['id'] ?>">Devamını Oku</a>
	</p>
	<small><?= $post['created'] ?></small>
</article>
<?php
    endforeach
    ;

endif;
?>

