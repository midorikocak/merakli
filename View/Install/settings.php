<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings Setup</title>
    <link rel="stylesheet" href="<?=FILE_PREFIX?>css/foundation.css" />
    <link rel="stylesheet" href="<?=FILE_PREFIX?>css/install.css" />
    <link href='http://fonts.googleapis.com/css?family=PT+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <script src="<?=FILE_PREFIX?>js/vendor/modernizr.js"></script>
  </head>
<body>
  
      <div class="row">
        <div class="large-4 large-centered columns" id="box">
            <h1>Meraklı</h1>
            <p>Settings Setup</p>
            <form method="post">
                <div class="row">
                    <div class="small-3 columns">
                        <label for="title" class="right inline">Title</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="title" name="setting[title]" placeholder="i.e Merakli Bilişimci">
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="description" class="right inline">Description</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="title" name="setting[description]" placeholder="Description">
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="copyright" class="right inline">Copyright / Footer</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="copyright" name="setting[copyright]" placeholder="root">
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <button class="right" type="submit">Done!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  

    
    <script src="<?=FILE_PREFIX?>js/vendor/jquery.js"></script>
    <script src="<?=FILE_PREFIX?>js/foundation.min.js"></script>
    <script>
    $(document).foundation();
    </script>
</body>
</html>
