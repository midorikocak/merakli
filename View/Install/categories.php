<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Settings Setup</title>
<link rel="stylesheet" href="<?= FILE_PREFIX ?>css/foundation.css" />
<link rel="stylesheet" href="<?= FILE_PREFIX ?>css/install.css" />
<link
	href='http://fonts.googleapis.com/css?family=PT+Sans&subset=latin,latin-ext'
	rel='stylesheet' type='text/css'>
<script src="<?= FILE_PREFIX ?>js/vendor/modernizr.js"></script>
</head>
<body>

	<div class="row">
		<div class="large-4 large-centered columns" id="box">
			<h1>Meraklı</h1>

			<p>Add some categories</p>

			<form action="<?= LINK_PREFIX ?>/Categories/Add" method="post">
				<div class="row">
					<div class="large-12 columns">
						<label>Category <input id="title" name="title[0]" type="text"
							placeholder="Title" />
						</label>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns">
						<label>Category <input id="title" name="title[1]" type="text"
							placeholder="Title" />
						</label>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns">
						<label>Category <input id="title" name="title[2]" type="text"
							placeholder="Title" />
						</label>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns">
						<label>Category <input id="title" name="title[3]" type="text"
							placeholder="Title" />
						</label>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns">
						<button type="submit">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>


	<script src="<?= FILE_PREFIX ?>js/vendor/jquery.js"></script>
	<script src="<?= FILE_PREFIX ?>js/foundation.min.js"></script>
	<script>
    $(document).foundation();
</script>
</body>
</html>
