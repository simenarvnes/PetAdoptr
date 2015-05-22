<!DOCTYPE html>
<?php

session_start();

include "../../dbauth_prototype.php";
include "../utils/database.php";

function upload_image($pet_id) {
    $conn = connect_db();
    
    if (isset($_FILES['image'])) {
        for($i = 0; $i < count($_FILES['image']['tmp_name']); $i++) {
            $file_name = $_FILES['image']['tmp_name'][$i];

            list($original_width, $original_height) = getimagesize($file_name);

            //determine new size
            $thumbnail_width = 250;
            $thumbnail_height = 250;
            $ratio_orig = $original_width / $original_height;

            if ($thumbnail_width / $thumbnail_height > $ratio_orig) {
                $thumbnail_width = $thumbnail_height * $ratio_orig;
            } else {
                $thumbnail_height = $thumbnail_width / $ratio_orig;
            }
           
            $thumbnail_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
            $original_image = imagecreatefromstring(file_get_contents($file_name));
            imagecopyresized($thumbnail_image, $original_image, 0, 0, 0, 0, $thumbnail_width, $thumbnail_height, $original_width, $original_height);
            
            ob_start();
            if ($_FILES['image']['type'][$i] == "image/png") {
                imagepng($thumbnail_image);
            } else if ($_FILES['image']['type'][$i] == "image/jpeg" || $_FILES['image']['type'][$i] == "image/jpg") {
                imagejpeg($thumbnail_image);
            } else if ($_FILES['image']['type'][$i] == "image/gif") {
                imagegif($thumbnail_image);
            }
            
            $thumbnail = ob_get_contents();
            ob_end_clean();
            $thumbnail_blob = addslashes($thumbnail);

            ob_start();
            if ($_FILES['image']['type'][$i] == "image/png") {
                imagepng($original_image);
            } else if ($_FILES['image']['type'][$i] == "image/jpeg" || $_FILES['image']['type'][$i] == "image/jpg") {
                imagejpeg($original_image);
            } else if ($_FILES['image']['type'][$i] == "image/gif") {
                imagegif($original_image);
            }

            $thumbnail = ob_get_contents();
            ob_end_clean();
            $original_blob = addslashes($thumbnail);

            // insert original image in blob
            try {
                $conn->query("INSERT INTO albums (pet_id, image) VALUES ('$pet_id', '$original_blob')");
                $conn->query("INSERT INTO thumbnails (pet_id, image) VALUES ('$pet_id', '$thumbnail_blob')");
            } catch (PDOException $e) {
                'Error : ' . $e->getMessage();
            }
        }     
    }
}

function post_pet() {
    // get submitted data by 'POST' method
    $name = $_POST['name'];
    $species = $_POST['species'];
    $breeds = $_POST['breeds'];
    $sex = ($_POST['sex'] == "Male")? 1 : 0;
    $age = $_POST['age'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipCode = $_POST['zipCode'];
    $description = $_POST['description'];
    $videoLink = $_POST['videoLink'];
    
    try {
        $conn = connect_db();

        $obj = $conn->query("SELECT id FROM species WHERE name = '$species'");
        $assoc = $obj->fetch_assoc();
        $species_id = $assoc["id"];

        $obj = $conn->query("SELECT id FROM breeds WHERE specie_id = '$species_id' AND name = '$breeds'");
        $assoc = $obj->fetch_assoc();
        $breeds_id = $assoc["id"];

        $conn->query("INSERT INTO address (id, zip, state, city)
                        VALUES (NULL, '$zipCode', '$state', '$city')");
        $address_id = $conn->insert_id;

        $owner_id = get_user_id();

        $conn->query("INSERT INTO pet (id, breed_id, name, sex, age, address_id, video_link, color, description, owner_id, size, species_id)"
            . "VALUES (NULL, '$breeds_id', '$name', '$sex', '$age', '$address_id', '$videoLink', '$color', '$description', '$owner_id', '$size', '$species_id')");
        $pet_id = $conn->insert_id;

        upload_image($pet_id);

        $conn->query("INSERT INTO listing(user_id, pet_id) VALUES ('$owner_id','$pet_id')");

        header("Location: ../pet-details.php?id=$pet_id");
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}

post_pet();

?>