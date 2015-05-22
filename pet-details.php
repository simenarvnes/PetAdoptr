<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <title>Adopt a Pet | Pet Adoptr</title>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/pet-details.css">
        <link rel="stylesheet" href="css/dialog.css">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css"
            media="screen" rel="stylesheet" type="text/css"/>
        </head>
        <body>
            <?php
            include 'header.php';
            include 'utils/database.php';
            $pet_id = 0;
            if (isset($_GET['id'])) {
            $pet_id = $_GET['id'];
            }
            $conn = connect_db();
            $detail = $conn->query("SELECT * FROM `pet` WHERE id = $pet_id")->fetch_object();
            $owner = $conn->query("SELECT name FROM `users` WHERE id = $detail->owner_id"
            )->fetch_object()->name;
            $owner = ucfirst($owner);
            $address = get_address($detail->address_id);
            $sex = $detail->sex == 1 ? 'Male' : 'Female';
            $species = $conn->query("SELECT name FROM `species` WHERE id = (" .
            "SELECT specie_id FROM `breeds` WHERE id = $detail->breed_id )"
            )->fetch_object()->name;
            $breed = $conn->query("SELECT name FROM `breeds` WHERE id = $detail->breed_id"
            )->fetch_object()->name;
            $name = $detail->name;
            $name = ucfirst($name);
            $age = $detail->age;
            $video_link = $detail->video_link;
            $color = $detail->color;
            $desc = $detail->description;
            $size = $detail->size;
            echo "<script>var youtube_link = '$video_link';</script>";
            echo "<script>var user_id = " . get_user_id() . "</script>";
            include 'modals/adopt-me-dialog.php';
            ?>
            <script src="js/pet-details.js"></script>
            <div class="box-button">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a class="results btn" id="back-results" href="javascript:history.go(-1)"><i
                                class="fa fa-angle-double-left"></i>
                            Back to Search Results</a>
                            <a class="adopt btn btn-danger" id="adopt-me">Adopt Me</a>
                            <a class="heart btn btn-danger" id="fav_button1"><i class="fa fa-heart"></i> Add to Favorites</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <main id="main" role="main">
            <div class="js-animal-profile-page">
                <div class="container profile-block">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5">
                            <div class="carousel slide" data-interval="false" data-ride="carousel"
                                id="carousel-example-generic">
                                <?php
                                $sql = "SELECT image FROM albums WHERE pet_id = $pet_id";
                                $results = $conn->query($sql);
                                echo '<div class="carousel-inner">';
                                    $active = true;
                                    while ($row = $results->fetch_array()) {
                                    if ($active)
                                    echo '<div class="item active">';
                                        else
                                        echo '<div class="item">';
                                            echo '<span class="image" data-alt="Photo" data-picture="">';
                                                echo '<span><img src="data:image/jpeg;base64,' .
                                                base64_encode($row['image']) . '"/></span>';
                                            echo '</span>';
                                            echo '<div class="fav-box action-box"><a class="ico-box" href="#" target="_blank" id="fav_button2">';
                                                echo '<i class="fa fa-heart"></i></a><div class="txt"></div></div>';
                                            echo '</div>';
                                            $active = false;
                                            }
                                        echo '</div>';
                                        $results = $conn->query($sql);
                                        $count = 0;
                                        echo '<ol class="carousel-indicators">';
                                            while ($row = $results->fetch_array()) {
                                            echo '<li class="' . ($count == 0 ? 'active' : '') . '" data-slide-to="' . $count .
                                                '" data-target="#carousel-example-generic">';
                                                echo '<img src="data:image/jpeg;base64,' .
                                                base64_encode($row['image']) . '" width="90"/>';
                                            echo '</li>';
                                            $count++;
                                            }
                                        echo '</ol>';
                                        ?>
                                    </div>
                                    <a class="watch" id="watch-video"><i class="fa fa-video-camera"></i> Watch Video</a>
                                </div>
                                <section class="col-lg-7 col-md-7 col-sm-7 profile-info-mobile">
                                    <div class="clearfix">
                                        <h1 class="heading-title">Adopt <?php echo $name; ?></h1>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li>
                                            <a data-toggle="tab" href="#about">Contact</a>
                                        </li>
                                        <li class="active">
                                            <a data-toggle="tab" href="#details">Description</a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#organization">Details</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="about">
                                            <address class="address">
                                                <br>
                                                <div class="box">
                                                    <strong class="title"><i class="fa fa-map-marker"></i>Location</strong>
                                                    <div class="holder">
                                                        <p><?php echo $address; ?></p>
                                                    </div>
                                                </div>
                                                <div class="box email-box">
                                                    <strong class="title"><i class="fa fa-user"></i>Owner</strong>
                                                    <div class="holder">
                                                        <p><?php echo $owner; ?></p>
                                                    </div>
                                                </div>
                                            </address>
                                        </div>
                                        <div class="active tab-pane" id="details">
                                            <div class="text-block">
                                                <div class="block-holder js-read-moreable long-about">
                                                    <h2 class="clearfix">
                                                    <span class="heading-text">
                                                        <?php echo $name; ?>'s Description
                                                    </span>
                                                    </h2>
                                                    <p><?php echo $desc; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="organization">
                                            <table class="table js-animal-tabular-traits">
                                                <tbody>
                                                    <tr>
                                                        <td class="field">
                                                            Name:
                                                        </td>
                                                        <td class="value">
                                                            <?php echo $name; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="field">
                                                            Species:
                                                        </td>
                                                        <td class="value">
                                                            <?php echo $species; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="field">
                                                            Breed:
                                                        </td>
                                                        <td class="value">
                                                            <?php echo $breed; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="field">
                                                            Location:
                                                        </td>
                                                        <td class="value">
                                                            <?php echo $address; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="field">
                                                            Owner type:
                                                        </td>
                                                        <td class="value">
                                                            Shelter/Rescue
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="field">
                                                            Sex:
                                                        </td>
                                                        <td class="value">
                                                            <?php echo $sex; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="field">
                                                            Age:
                                                        </td>
                                                        <td class="value">
                                                            <?php echo $age; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="field">
                                                            Size type:
                                                        </td>
                                                        <td class="value">
                                                            <?php echo $size; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="field">
                                                            Color:
                                                        </td>
                                                        <td class="value">
                                                            <?php echo $color; ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    </main>
                    <div id="video-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <iframe width="400" height="300" frameborder="0" allowfullscreen=""></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $conn->close();
                    include 'footer.php'
                    ?>
                </body>
            </html>