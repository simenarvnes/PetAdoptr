<?php

/**
 * include the username and password of database
 */
include "../dbauth_prototype.php";

session_start();

if (!isset($_SESSION['login_user'])) {
    include 'modals/login-dialog.php';
    include 'modals/signup-dialog.php';

    echo "<script>var g_signed = false;</script>";
} else {
    echo "<script>var g_signed = true;</script>";
}
?>

<!-- CSS Includes -->
<script src="js/header.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:100,400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/style.css">

<!-- Nav -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false" aria-controls="myNavbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">pet adoptr</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li id="li-1"><a href="search.php">Find a Pet</a></li>
                <li id="li-2"><a href="give-pet.php">Give a Pet</a></li>
                <li id="li-3"><a href="pet-tips.php">Pet Care</a></li>
                <li id="li-4"><a href="faq.php">FAQ</a></li>
            </ul>
            <?php if (!isset($_SESSION['login_user'])): ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a data-toggle="modal" data-target="#login-modal"><span
                                class="glyphicon glyphicon-log-in"> </span> Login</a></li>
                    <li><a data-toggle="modal" data-target="#signup-modal"><span
                                class="glyphicon glyphicon-user"> </span>
                            Sign up</a></li>
                </ul>
            <?php else: ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><div class="navbar-text">Logged in as <?php echo $_SESSION['login_user']; ?> </div></li>
                    <li class="dropdown pull-right">
                        <a id="profile" data-toggle="dropdown" class="dropdown-toggle"><span
                                class="glyphicon glyphicon-user"></span> Profile<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="favorites.php">Favorites</a></li>
                            <li><a href="#">My Account</a></li>
                            <li><a href="listings.php">My Listings</a></li>
                            <li class="divider"></li>
                            <li><a href="utils/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif ?>
        </div>
    </div>
</nav>
<!-- End nav -->
