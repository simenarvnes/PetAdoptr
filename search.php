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
        <title>Search | Pet Adoptr</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/search.css">
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php
        include 'header.php';
        include 'footer.php';
        include "utils/database.php";
        generate_filter_data();
        $sp = isset($_GET['sp']) && ($_GET['sp'] != "none")? htmlspecialchars($_GET['sp']) : 'Species';
        $br = isset($_GET['br']) && ($_GET['br'] != "none")? htmlspecialchars($_GET['br']) : 'Breeds';
        $state = isset($_GET['state']) && ($_GET['state'] != "none")? htmlspecialchars($_GET['state']) : 'States';
        $sex = isset($_GET['sex']) && ($_GET['br'] != "none")? htmlspecialchars($_GET['sex']) : 'Sex';
        $age = isset($_GET['age']) && ($_GET['br'] != "none")? htmlspecialchars($_GET['age']) : 'Age';
        ?>
        <div class="container">
            <h3>Search results for:
            <?php
            if ($sp != "Species") {
                print "$sp ";
                if ($br != "none" && $br != "Breeds") {
                print("$br ");
                }
            }else{
            echo "All Animals ";
            }
            if ($sex != "Sex") {
            print("$sex ");
            }
            if ($age != "Age") {
            print("$age ");
            }
            if ($state != "States") {
            print("in $state ");
            }
            ?>
            </h3>
        </div>
        <div id="search-filters">
            <div class="container">
                <h4>Filter Search:</h4>
                <div class="btn-group" dropdown>
                    <button class="btn btn-default dropdown-toggle" type="button"
                    id="species_filter" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $sp; ?> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="filter" id="species_filter_ul">
                    </ul>
                </div>
                <div class="btn-group" dropdown>
                    <button class="btn btn-default dropdown-toggle" type="button"
                    id="breeds_filter" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $br; ?> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="filter" id="breeds_filter_ul">
                    </ul>
                </div>
                <div class="btn-group" dropdown>
                    <button class="btn btn-default dropdown-toggle" type="button"
                    id="state_filter" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $state; ?> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="filter" id="state_filter_ul">
                    </ul>
                </div>
                <div class="btn-group" dropdown>
                    <button class="btn btn-default dropdown-toggle" type="button"
                    id="sex_filter" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $sex; ?> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="filter" id="sex_filter_ul">
                        <li role="presentation"><a role="filteritem" tabindex="1">Male</a></li>
                        <li role="presentation"><a role="filteritem" tabindex="1">Female</a></li>
                    </ul>
                </div>
                <div class="btn-group" dropdown>
                    <button class="btn btn-default dropdown-toggle" type="button"
                    id="age_filter" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $age; ?> <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="filter" id="age_filter_ul">
                        <li role="presentation"><a role="filteritem" tabindex="1">Baby (~1yr old)</a></li>
                        <li role="presentation"><a role="filteritem" tabindex="1">Young (1-5 yrs old)</a></li>
                        <li role="presentation"><a role="filteritem" tabindex="1">Adult (5~ yrs old)</a></li>
                    </ul>
                </div>
                <button type="submit" id="btn-search" class="btn btn-success">Filter Search</button>
                <button type="reset" id="btn-reset" class="btn btn-info">Reset</button>
            </div>
        </div>
        <hr width="90%">

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
        <?php display_search_results(); ?>
    </body>
    <script src="js/search.js"></script>
</html>