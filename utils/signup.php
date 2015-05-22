<?php

/**
 * @filesource
 */

session_start();

include '../../dbauth_prototype.php';
include '../utils/database.php';

if (empty($_POST['user_name']) || empty($_POST['user_email'])
    || empty($_POST['user_password'])
) {
    echo "Error: Empty email or password or name!";
} else {
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];
    $name = $_POST['user_name'];

    $valid = true;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $valid = false;
        echo "Error: Invalid email address!<br>";
    }

    if (account_exists($email)) {
        $valid = false;
        echo "Error: Email has already existed!<br>";
    }

    if (strlen($password) < 5) {
        $valid = false;
        echo "Error: Password is too short!<br>";
    }

    if ($valid) {
        if (create_account($email, $password, $name)) {
            $_SESSION['login_user'] = $email;
            echo "created";
        } else {
            echo "Error: Can't create the account, internal error!";
        }
    }
}