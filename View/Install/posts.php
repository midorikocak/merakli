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
            <p>Add a post</p>
            
            <div class="row">
    <form method="post">
        <div class="row">
            <div class="large-12 columns">
                <label>Title
                    <input id="title" name="title" type="text" placeholder="Title" />
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <label>Content
                    <textarea id="content" name="content" placeholder="Content"></textarea>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <label>Categories
                    <select id="category" name="category">
                        <?php foreach ($categories as $category):?>
                            <option value="<?=$category['id']?>"><?=$category['title']?></option>
                        <?php endforeach;?>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <button type="submit">Submit</button>
            </div>
        </div>
    </form>
    <iframe id="form_target" name="form_target" style="display:none"></iframe>
    <form id="my_form" action="<?= LINK_PREFIX ?>/Files/add" method="post" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden;display:none;">
        <input name="image" type="file" onchange="$('#my_form').submit();this.value='';">
    </form>
</div>
        </div>
    </div>
  

    
    <script src="<?=FILE_PREFIX?>js/vendor/jquery.js"></script>
    <script src="<?=FILE_PREFIX?>js/foundation.min.js"></script>
    <script>
    $(document).foundation();
    </script>
</body>
</html>
