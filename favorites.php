<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <title>Favorites | Pet Adoptr</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        include 'header.php';
        include 'footer.php';
        include "utils/database.php";
        ?>
        <div class="container">
            <h3>Favorite list for 
                <?php
                echo $_SESSION['login_user'];
                ?>

            </h3>
        </div>
        <!-- //sorting tab
        <div class="container">
            <div class="dropdown">
                <h4 style="float: left; margin-right: 10px">Sort by</h4>
                <button class="btn btn-default dropdown-toggle" type="button"
                id="sortby" data-toggle="dropdown" aria-expanded="false">
                Posted Date <span class="caret"></span></button>
                <ul class="dropdown-menu" role="sort" id="sortby_ul">
                </ul>
            </div>
        </div>
        -->
        <?php display_favorite_results(); ?>
    </body>
</html>