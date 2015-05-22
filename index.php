<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <title>Pet Adoptr</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
        <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/style.css">
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <script src="js/index.js"></script>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div id="main-circles">
            <div class="container-fluid">
                <div class="intro-heading">Find a Pet to Adopt.</div>
                <hr>
                <div class="intro-subheading">Select a species to search for below, or click the button to post a pet</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" id="top-row">
                            <div id="f1_container">
                                <div id="f1_card">
                                    <div class="front face">
                                        <img src="images/dog-silhouette.svg" class="img-circle" value="Dogs">
                                    </div>
                                    <div class="back face">
                                        <img src="images/dog-silhouette-hover.png" class="img-circle" value="Dogs">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" id="top-row">
                            <div id="f1_container">
                                <div id="f1_card">
                                    <div class="front face">
                                        <img src="images/cat-silhouette.svg" class="img-circle" value="Cats">
                                    </div>
                                    <div class="back face">
                                        <img src="images/cat-silhouette-hover.png" class="img-circle" value="Cats">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" id="top-row">
                            <div id="f1_container">
                                <div id="f1_card">
                                    <div class="front face">
                                        <img src="images/bird-silhouette.svg" class="img-circle" value="Birds">
                                    </div>
                                    <div class="back face">
                                        <img src="images/bird-silhouette-hover.png" class="img-circle" value="Birds">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" id="bottom-row">
                            <div id="f1_container">
                                <div id="f1_card">
                                    <div class="front face">
                                        <img src="images/reptile-silhouette.svg" class="img-circle" value="Reptiles">
                                    </div>
                                    <div class="back face">
                                        <img src="images/reptile-silhouette-hover.png" class="img-circle" value="Reptiles">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" id="bottom-row">
                            <div id="f1_container">
                                <div id="f1_card">
                                    <div class="front face">
                                        <img src="images/fish-silhouette.svg" class="img-circle" value="Fishes">
                                    </div>
                                    <div class="back face">
                                        <img src="images/fish-silhouette-hover.png" class="img-circle" value="Fishes">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6" id="bottom-row">
                            <div id="f1_container">
                                <div id="f1_card">
                                    <div class="front face">
                                        <img src="images/other-silhouette.svg" class="img-circle" value="Other">
                                    </div>
                                    <div class="back face">
                                        <img src="images/other-silhouette-hover.png" class="img-circle" value="Other">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="find-button">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <a href="give-pet.php" class="btn btn-block">Find a Home for your Pet today!</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="pet-ad">
            <div class="container-fluid" id="pet-ad-background">
                <div class="row">
                    <div class="col-md-6 col-md-offset-6">
                        <h1> We make finding your next pet easy.</h1>
                        <h3>1. Browse our pet listings</h3>
                        <h3>2. Contact the pet's owner</h3>
                        <h3>3. Arrange to bring home your new pet!</h3>
                        <a href="search.php" class="btn btn-block">Browse pets now</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="pet-tips">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <h1> Pet Care Tips? We've got them. </h1>
                <h3>Whether you're a first-time pet owner, or you're adopting your 6th, we've got pet tips that cover all ranges. </h3>
                <a href="pet-tips.php" class="btn btn-block">Check out our pet care tips</a>
                </div>
            </div>
            </div>
        </div>
        <div id="success-quotes">
            <h1> Success Stories </h1>
            <div class="container-fluid">
                <div class='row'>
                    <div class='col-md-12'>
                        <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                            <!-- Bottom Carousel Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#quote-carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#quote-carousel" data-slide-to="1"></li>
                                <li data-target="#quote-carousel" data-slide-to="2"></li>
                            </ol>
                            <!-- Carousel Slides / Quotes -->
                            <div class="carousel-inner">
                                <!-- Quote 1 -->
                                <div class="item active">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2 text-center">
                                                <p>Pet Adoptr allowed me to find my most recent dog, Alfred. The process was quick, easy, 
                                                and Alfred was a great fit with my other pets!</p>
                                                <small>Malcolm Tram
                                                <br>
                                                Sacramento, CA
                                                </small>

                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <!-- Quote 2 -->
                                <div class="item">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2  text-center">
                                                <p>I recently had to give up my cat Taters after moving to an apartment that didn't allow pets. 
                                                Pet Adoptr made this difficult decision easier by allowing me to find Taters a great new owner.</p>
                                                <small>Clarice Fontaine
                                                <br>
                                                San Francisco, CA
                                                </small>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                                <!-- Quote 3 -->
                                <div class="item">
                                    <blockquote>
                                        <div class="row">
                                            <div class="col-md-8 col-md-offset-2  text-center">
                                                <p>I wanted to adopt a pet recently, but as a teenager, had to convince my parents first. 
                                                Using Pet Adoptr's Pet Care Tips, I was able to persuade them to let me adopt a bunny.</p>
                                                <small>Lisa Sanders
                                                <br>
                                                Oakland, CA
                                                </small>
                                            </div>
                                        </div>
                                    </blockquote>
                                </div>
                            </div>
                            <!-- Carousel Buttons Next/Prev -->
                            <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i
                            class="fa fa-chevron-left"></i></a>
                            <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i
                            class="fa fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sign-up">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <h1>Ready to try pet adoptr?</h1>
                        <p> Just click the sign up button below </p>
                        <a data-toggle="modal" class="btn btn-block" data-target="#signup-modal">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>