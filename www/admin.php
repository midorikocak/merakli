<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Merakli CMS</title>
    <link rel="stylesheet" href="<?=FILE_PREFIX?>css/foundation.css" />
    <link rel="stylesheet" href="<?=FILE_PREFIX?>css/app.css" />
    <link rel="stylesheet" href="<?=FILE_PREFIX?>css/app.css" />
    <link rel="stylesheet" src="<?=FILE_PREFIX?>css/wysiwyg-color.css" />
</head>
<body>
    
    <nav class="top-bar" data-topbar>
        <ul class="title-area">
 
            <li class="name">
                <h1>
                    <a href="#">
                        Merakli CMS
                    </a>
                </h1>
            </li>
            <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
        </ul>
        <section class="top-bar-section">
 
            <ul class="center">
                <li class="divider"></li>
                <li class="has-dropdown">
                    <a href="#">Posts</a>
                    <ul class="dropdown">
                        <li><a href="<?= LINK_PREFIX ?>/Posts/show">All posts &rarr;</a></li>
                        <li><a href="<?= LINK_PREFIX ?>/Posts/add">New post</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li class="has-dropdown">
                    <a href="#">Categories</a>
                    <ul class="dropdown">
                        <li><a href="<?= LINK_PREFIX ?>/Categories/show">All categories &rarr;</a></li>
                        <li><a href="<?= LINK_PREFIX ?>/Categories/add">New category</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li class="has-dropdown">
                    <a href="#">Files</a>
                    <ul class="dropdown">
                        <li><a href="<?= LINK_PREFIX ?>/Files/show">All files &rarr;</a></li>
                        <li><a href="<?= LINK_PREFIX ?>/Files/add">New file</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="right">
                <li class="has-dropdown">
                    <a href="#">Admin</a>
                    <ul class="dropdown">
                        <li><a href="<?= LINK_PREFIX ?>/Users/show">All users &rarr;</a></li>
                        <li><a href="<?= LINK_PREFIX ?>/Users/add">New user</a></li>
                        <li><a href="<?= LINK_PREFIX ?>/Users/edit/<?=$_SESSION['id']?>">My profile</a></li>
                        <li><a href="<?= LINK_PREFIX ?>/Users/logout">Logout</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="<?= LINK_PREFIX ?>/Settings/add">Settings</a></li>
            </ul>
        </section>
    </nav>
    <div class="row">
        <?php
        if(isset($message)):
        ?>
        <div data-alert class="alert-box">
            <?=$message?>
            <a href="#" class="close">&times;</a>
        </div>
        <?php
        endif;
        ?>
        <div class="large-12 columns">
            <?php echo $content; ?>
        </div>
    </div>
 
    <footer class="row">
        <div class="large-12 columns">
            <hr/>
            <div class="row">
                <div class="large-6 columns">
                    <p>&copy; Copyright 2014 Meraklibilisimci.com</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="<?=FILE_PREFIX?>js/vendor/jquery.js"></script>
    <script src="<?=FILE_PREFIX?>js/foundation.min.js"></script>
    <script type="text/javascript" src="<?=FILE_PREFIX?>/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "#content",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste moxiemanager"
            ],
            file_browser_callback: function(field_name, url, type, win) {
                if(type=='image') $('#my_form input').click();
            },
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>
    <script>
    $(document).foundation();
    $('.image_list_element').click(function(){
            var imageToAdd = "<img src='"+$(this).attr('src')+"' />";
            tinyMCE.execCommand('mceInsertContent', false, imageToAdd);
        });
    </script>
</body>
</html>
