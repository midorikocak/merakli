<?php
/**
 * One category is shown using this layout
 * Raw data will be injected here as $post variable and handled by this layout.
 *
 * @author Midori Kocak 2014
 *
 */
if (sizeof($posts > 0)) :
    foreach ($posts as $post) :
        ?>
<article>
	<h2><?php echo $post['title']; ?></h2>

	<p><?= substr(strip_tags($post['content']), 0, 40) ?>... <a
			href="<?= LINK_PREFIX ?>/Posts/View/<?= $post['id'] ?>">Read more...</a>
	</p>
	<small><?= $post['created'] ?></small>
</article>
<?php
    endforeach
    ;


endif;
?>