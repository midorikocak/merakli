<?php
/**
 * One file is shown using this layout
 * Raw data will be injected here as $file variable and handled by this layout.
 *
 * @author Midori Kocak 2014
 *
 */
?>

<article>
	<h2><?php echo $file['id']; ?></h2>

	<p><?= htmlspecialchars($file['filename']) ?></p>
</article>


