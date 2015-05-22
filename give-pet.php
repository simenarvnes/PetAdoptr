<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <title>Give A Pet | Pet Adoptr</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/give-pet.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script src="js/post.js"></script>
    </head>
    <body>
        <?php
        include 'header.php';
        include "utils/database.php";
        generate_filter_data();
        ?>
        <div class="container-fluid">
            <div class="row" id="heading">
                <div class="col-md-11 col-md-offset-1">
                    <h3>Please fill out the information of your pet</h3>
                    <p class="required">* Required fields</p>
                </div>
            </div>
        </div>
        <!-- Pet Post Forum Page Main-->
        <div class="container" id="main">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <form class="form-horizontal" action="utils/post.php" method="POST" enctype="multipart/form-data" id="target">
                        <!--Basic Fields-->
                        <fieldset>
                            <legend><i class="fa fa-info-circle"></i>Basic Fields</legend>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Pet Name<span class="required">*</span></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="name" placeholder="Name" name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="species" class="col-sm-2 control-label">Species<span class="required">*</span></label>
                                <div class="col-sm-2">
                                    <input type="hidden" id="species" name="species">
                                    <div class="btn-group" dropdown>
                                        <button class="btn btn-default dropdown-toggle"
                                        type="button" id="species_menu" data-toggle="dropdown" aria-expanded="false">
                                        Select Species <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" id="species_menu_ul">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="breeds" class="col-sm-2 control-label">Breeds<span class="required">*</span></label>
                                <div class="col-sm-2">
                                    <input type="hidden" id="breeds" name="breeds">
                                    <div class="btn-group" dropdown>
                                        <button class="btn btn-default dropdown-toggle"
                                        type="button" id="breeds_menu" data-toggle="dropdown" aria-expanded="false">
                                        Select Breeds <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" id="breeds_menu_ul">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sex" class="col-sm-2 control-label">Sex<span class="required">*</span></label>
                                <div class="col-sm-2">
                                    <label class="radio-inline">
                                        <input type="radio" id="sex" name="sex" value="Male" checked /> <label>Male </label><br>
                                        <input type="radio" id="sex" name="sex" value="Female" /><label>Female </label>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="age" class="col-sm-2 control-label">Age<span class="required">*</span></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="age" placeholder="Age" name="age">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="color" class="col-sm-2 control-label">Color</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="color" placeholder="Color" name="color">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="size" class="col-sm-2 control-label">Size</label>
                                <div class="col-sm-2">
                                    <input type="hidden" id="size" name="size">
                                    <div class="btn-group" dropdown>
                                        <button class="btn btn-default dropdown-toggle"
                                        type="button" id="size_menu" data-toggle="dropdown" aria-expanded="false">
                                        Select Size <span class="caret"></span></button>
                                        <ul class="dropdown-menu" role="menu" id="size_menu_ul">
                                            <li role="presentation"><a role="menuitem" tabindex="1">Small</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="1">Medium</a></li>
                                            <li role="presentation"><a role="menuitem" tabindex="1">Large</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <!--Address-->
                        <fieldset>
                            <legend><i class="fa fa-map-marker"></i>Address</legend>
                            <div class="form-group">
                                <label for="city" class="col-sm-2 control-label">City<span class="required">*</span></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="city" placeholder="City" name="city">
                                </div>
                                <div class="col-sm-2">
                                    <input type="hidden" id="state" name="state">
                                    <div class="btn-group" dropdown>
                                        <button class="btn btn-default dropdown-toggle"
                                        type="button" id="state_menu" data-toggle="dropdown" aria-expanded="false">
                                        State <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" id="state_menu_ul">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="zipCode" class="col-sm-2 control-label">Zip Code<span class="required">*</span></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="zipCode" placeholder="Zip Code" name="zipCode">
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <!--Description-->
                        <fieldset>
                            <legend><i class="fa fa-comment"></i>Description</legend>
                            <textarea class="form-control" rows="3" id="description" name="description"></textarea>
                        </fieldset>
                        <br>
                        <!--Upload Photos-->
                        <fieldset>
                            <legend><i class="fa fa-camera"></i>Upload Photos</legend>
                            <ul>
                                <!--<li>up to 3 images</li>-->
                                <!--<li>3MB MAX file size</li>-->
                            </ul>
                            <div>
                                <input type="file" id="image" name="image[]" multiple>
                            </div>
                        </fieldset>
                        <br>
                        <!--YouTube Link-->
                        <fieldset>
                            <legend><i class="fa fa-youtube-play"></i>YouTube Link</legend>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <input type="url" class="form-control" id="videoLink" placeholder="URL" name="videoLink">
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <!--Post-->
                        <fieldset>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="" id="agree" /><label>I agree to the <a data-toggle="modal" data-target="#privacy">terms and conditions</label></a>
                                    </label>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit" id="submit">Submit pet for adoption</button>
                            </div>
                        </fieldset>
                        <br>
                    </form>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>