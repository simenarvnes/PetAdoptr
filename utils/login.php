<?php

/**
 * @filesource
 */

session_start();

include '../../dbauth_prototype.php';
include '../utils/database.php';

if (empty($_POST['email']) || empty($_POST['password'])) {
    echo "Error: Empty email or password!";
} else {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (verify_login($email, $password)) {
        $_SESSION['login_user'] = get_name_by_email($email);
        $_SESSION['login_user_email'] = $email;
        echo "verified";
    } else {
        echo "Error: Email or password is invalid";
    }
}