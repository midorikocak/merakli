<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Foundation | Welcome</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <link rel="stylesheet" href="css/app.css" />
    <link href='http://fonts.googleapis.com/css?family=PT+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <script src="js/vendor/modernizr.js"></script>
</head>
<body>
  
    <div class="row">
        <div class="large-4 large-centered columns" id="box">
            <h1>Meraklı</h1>
            <p>System Settings</p>
            <form>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="title" class="right inline">Title</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="title" name="title" placeholder="Merakli Bilisimci">
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="description" class="right inline">Description</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="description" placeholder="Description">
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="copyright" class="right inline">Footer Copyright</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="copyright" name="copyright" placeholder="Copyright / Footer">
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


    
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
    $(document).foundation();
    </script>
</body>
</html>
