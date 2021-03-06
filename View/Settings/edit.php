<?php
/**
 * View template for editing settings for first time in admin context.
 *
 * @author Midori Kocak 2014
 *
 */
?>
<form action="<?= LINK_PREFIX ?>/Settings/Edit" method="post">
	<div class="row">
		<div class="large-12 columns">
			<label>Site Başlığı <input id="title" name="title" type="text"
				placeholder="Site Başlığı" value="<?= $setting['title'] ?>" />
			</label>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Site Açıklaması <input id="description" name="description"
				type="text" placeholder="Site Açıklaması"
				value="<?= $setting['description'] ?>" />
			</label>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label>Site Altbilgi <input id="copyright" name="copyright"
				type="text" placeholder="Site Altbilgisi"
				value="<?= $setting['copyright'] ?>" />
			</label>
		</div>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<button type="submit">Submit</button>
		</div>
	</div>
</form>