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
            <p>System Registration</p>
            <form>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="username" class="right inline">Username</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" id="username" name="username" placeholder="i.e mtkocak">
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="password" class="right inline">Passowrd</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="password" id="password" placeholder="password">
                    </div>
                </div>
                <div class="row">
                    <div class="small-3 columns">
                        <label for="password" class="right inline">Passowrd Confirmation</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="password" id="password" placeholder="password">
                    </div>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <button class="right" type="submit">Next</button>
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
