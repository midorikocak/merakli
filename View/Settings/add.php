<?php
/**
 * View template for adding settings for first time in admin context.
 *
 * @author Midori Kocak 2014
 *
 */
?>
<form action="<?= LINK_PREFIX ?>/Settings/add" method="post">
	<div class="row">
		<div class="large-12 columns">
			<label>Site Title <input id="title" name="title" type="text"
				placeholder="Site Title" />
			</label>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Site Description <input id="description" name="description"
				type="text" placeholder="Site Description" />
			</label>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Site footer <input id="copyright" name="copyright" type="text"
				placeholder="Site footer" />
			</label>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<button type="submit">Submit</button>
		</div>
	</div>
</form>
