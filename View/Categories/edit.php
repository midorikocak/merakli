<?php
/**
 * View template for editing categories in admin context.
 *
 * Same form with add layout is used here. However old data is injected here
 * using $category variable.
 *
 * @author Midori Kocak 2014
 *
 */
?>

<form action="<?= LINK_PREFIX ?>/Categories/Edit/<?= $category['id'] ?>"
	method="post">
	<input type="hidden" name="id" id="id" value="<?= $category['id'] ?>" />

	<div class="row">
		<div class="large-12 columns">
			<label>Title <input id="title" name="title" type="text"
				placeholder="large-12.columns" value="<?= htmlspecialchars($category['title']) ?>" />
			</label>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<button type="submit">Submit</button>
		</div>
	</div>
</form>
