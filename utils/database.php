<?php
/**
 * @filesource
 */

/**
 * Connecting the database
 * @return mysqli mysqli connection object
 * @throws Exception
 */
function connect_db()
{
    // Create connection
    $conn = new mysqli(DB_SERVER_NAME, DB_USER_NAME, DB_PASSWORD);

    mysqli_select_db($conn, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception('Connection to DB failed: ' . $conn->connect_error);
    }
    return $conn;
}

/** Generate the filter data
 * Grab all species and breeds data from the database
 * and then echo contents
 */
function generate_filter_data()
{
    try {
        $conn = connect_db();
        //get species and breeds
        $results = $conn->query("SELECT * FROM species");
        echo "<script>var pet_types = {";

        while ($row = $results->fetch_array()) {
            $ret = $conn->query("SELECT name FROM breeds WHERE specie_id = " . $row["id"]);
            echo '"' . $row["name"] . '"' . ":[";
            while ($row_breeds = $ret->fetch_array()) {
                echo '"' . $row_breeds["name"] . '"' . ",";
            }
            echo "],";
            $ret->free();
        }

        echo "};</script>";
        $results->free();


        $conn->close();
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}

/** Display search(filter) results
 * Search from database and echo results
 * Used by search.php
 */
function display_search_results()
{
    $conn = connect_db();
    $sql = "SELECT pet.*, address.state FROM pet INNER JOIN address on pet.address_id = address.id";
    $sql2 = "";
    $first = TRUE;
    $num_pages = 0;

    //check if variables are set
    $sp = isset($_GET['sp']) ? htmlspecialchars($_GET['sp']) : 'none';
    $br = isset($_GET['br']) ? htmlspecialchars($_GET['br']) : 'none';
    $state = isset($_GET['state']) ? htmlspecialchars($_GET['state']) : 'none';
    $sex = isset($_GET['sex']) ? htmlspecialchars($_GET['sex']) : 'none';
    $age = isset($_GET['age']) ? htmlspecialchars($_GET['age']) : 'none';

    //select species
    if ($sp != "none") {
        if($first){
            $sql .= " WHERE";
            $first = FALSE;
        }else{
            $sql .= " ADD";
        }
        $sql .= " species_id = (SELECT id FROM `species` WHERE name='$sp')";
        
        //select breed
        if ($br != "none") {
            $sql .= " ADD breed_id = (SELECT id FROM `breeds` WHERE name='$br')";
        }
    }
    //select sex
    if ($sex != "none") {
        if ($sex == "Male") {
            if($first){
                $sql .= " WHERE";
                $first = FALSE;
            }else{
                $sql .= " ADD";
            }
            $sql .= " sex = 1";
        } else {
            if($first){
                $sql .= " WHERE";
                $first = FALSE;
            }else{
                $sql .= " ADD";
            }
            $sql .= " sex = 2";
        }
    }
    //select age
    if ($age != "none") {
        if ($age === "Baby (~1yr old)") {
            if($first){
                $sql .= " WHERE";
                $first = FALSE;
            }else{
                $sql .= " ADD";
            }
            $sql .= " age <= 1";
        } else if ($age === "Young (1-5 yrs old)") {
            if($first){
                $sql .= " WHERE";
                $first = FALSE;
            }else{
                $sql .= " ADD";
            }
            $sql .= " age > 1 AND age <= 5";
        } else {
            if($first){
                $sql .= " WHERE";
                $first = FALSE;
            }else{
                $sql .= " ADD";
            }
            $sql .= " age < 5";
        }
    }
    //select state
    if($state != "none"){
        if($first){
            $sql .= " WHERE";
            $first = FALSE;
        }else{
            $sql .= " ADD";
        }
        $sql .= " state = '$state'";
    }

    //**sorting code to be implemented here**//

    //limit results to display 12 at most per page
    //select a portion for the page
    $sql2 .= $sql . " LIMIT 12";
    $offset = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($offset - 1) * 12;
    $sql2 .= " OFFSET $offset";

    //check total number of results and pages
    if ($result = $conn->query($sql)) {
        $num_results = $result->num_rows;
        $num_pages = (int)($num_results / 12);
        if($num_results%12 != 0){
            $num_pages++;
        }

        $result->free();
    }

    //check if we have search results
    if ($num_results == 0) {
        echo "<div class='container'>";
        echo "<h4>No Search Results</h4></div>";
    } else {
        display_results($sql2, $num_results);
    }

    display_pagination($num_pages);

    $conn->close();
}

/** Display favorite results
 * Search from database and echo results
 * Used by favorite.php
 */
function display_favorite_results()
{
    $conn = connect_db();
    $user_id = get_user_id();
    $sql = "SELECT * FROM (SELECT pet.*, address.state FROM pet INNER JOIN address on pet.address_id = address.id) as A";
    $sql .= " JOIN (SELECT pet_id FROM favorites WHERE user_id = '$user_id') as B on A.id = B.pet_id";
    $sql2 = "";
    $first = TRUE;
    $num_pages = 0;
    $num_results = 0;

    //limit results to display 12 at most per page
    //select a portion for the page
    $sql2 .= $sql . " LIMIT 12";
    $offset = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($offset - 1) * 12;
    $sql2 .= " OFFSET $offset";

    //check total number of results and pages
    if ($result = $conn->query($sql)) {
        $num_results = $result->num_rows;
        $num_pages = (int)($num_results / 12);
        if($num_results%12 != 0){
            $num_pages++;
        }

        $result->free();
    }

    //check if we have search results
    if ($num_results == 0) {
        echo "<div class='container'>";
        echo "<h4>No favorites yet!</h4></div>";
    } else {
        display_results($sql2, $num_results);
    }

    display_pagination($num_pages);

    $conn->close();
}
/** Display pet listing
 * Search from database and echo results
 * Used by listings.php
 */
function display_listing_results()
{
    $conn = connect_db();
    $user_id = get_user_id();
    $sql = "SELECT * FROM (SELECT pet.*, address.state FROM pet INNER JOIN address on pet.address_id = address.id) as A";
    $sql .= " JOIN (SELECT pet_id FROM listing WHERE user_id = '$user_id') as B on A.id = B.pet_id";
    $sql2 = "";
    $first = TRUE;
    $num_pages = 0;
    $num_results = 0;

    //limit results to display 12 at most per page
    //select a portion for the page
    $sql2 .= $sql . " LIMIT 12";
    $offset = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($offset - 1) * 12;
    $sql2 .= " OFFSET $offset";

    //check total number of results and pages
    if ($result = $conn->query($sql)) {
        $num_results = $result->num_rows;
        $num_pages = (int)($num_results / 12);
        if($num_results%12 != 0){
            $num_pages++;
        }

        $result->free();
    }

    //check if we have search results
    if ($num_results == 0) {
        echo "<div class='container'>";
        echo "<h4>No pets posted for adoption yet!</h4></div>";
    } else {
        display_results($sql2, $num_results);
    }

    display_pagination($num_pages);

    $conn->close();
}

/**
* A general function that displays the pet list on the page when given a sql query
* It will display 12 pets on the screen with pet name, age, sex and location
* @param $sql the sql select query
* @param $num_results the total number of results
*/
function display_results($sql, $num_results){
    $conn = connect_db();
    if ($result = $conn->query($sql)) {
        echo "<div class='container' style='padding-top:20px'>";
        echo "<h4>Total " .$num_results . " Results</h4>";
        
        //display results in 3 rows and 4 collums
        for ($row = 0; $row < 3; $row++) {
            echo "<div class='row'>";
            for ($col = 0; $col < 4; $col++) {
                if (null !== ($pet = $result->fetch_assoc())) {
                    //url to indivisual pet page
                    echo "<a href=";
                    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
                    $path = parse_url($url, PHP_URL_PATH);
                    $segments = explode('/', $path);
                    echo 'http://' . $_SERVER['HTTP_HOST'];
                    for ($i = 0; $i < count($segments) - 1; $i++) {
                        echo $segments[$i] . '/';
                    }
                    echo 'pet-details.php?id=' . $pet["id"];
                    //display thumbnail
                    echo "><div class='col-sm-6 col-md-3'><div class='thumbnail'>";
                    get_pet_thumbnail($pet["id"]);
                    echo "<div class='caption'>";
                    //display pet name
                    echo "<h5>Name: " . $pet["name"] . "</h5>";
                    //display pet age
                    echo "<h5>Age: ";
                    if($pet["age"] == 0){
                        echo "less than a year old";
                    }else{
                        echo $pet["age"];
                    }
                    echo "</h5>";
                    //display pet sex
                    echo "<h5>Sex: ";
                    if ($pet["sex"] == 1) {
                        echo "Male";
                    } else {
                        echo "Female";
                    }
                    echo "</h5>";
                    //display pet location
                    echo "<h5>Location: " . get_address($pet["address_id"]) . "</h5>";
                    echo "</div></div></div></a>";
                }
            }
            echo "</div>";   
        }

        echo "</div>";
        $result->free();
    }
    $conn->close();
}

/**
 * @param $num_pages int number of maximum pages
 */
function display_pagination($num_pages)
{
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
    $query = parse_url($url, PHP_URL_QUERY);
    if ($query) {
        if (!isset($_GET['page'])) {
            $url .= '&page=';
        } else {
            $url = preg_replace('#page=\d+#', 'page=', $url);
        }
    } else {
        $url .= 'page=';
    }

    echo "<div class='container'><nav><ul class='pagination'>";
    //left arrow
    if ($current_page == 1) {
        echo "<li class='disabled'><span><span aria-hidden='true'>&laquo;</span></span></li>";
    } else {
        echo "<li><a href=$url";
        echo $current_page - 1;
        echo " aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";

    }
    //display up to 5 pages
    for ($x = $current_page - 2; $x <= $current_page + 2 && $x <= $num_pages; $x++) {
        if ($x <= 0) {
            $x = 1;
        }
        if ($x == $current_page) {
            echo "<li class='active'><span> ";
            echo $x;
            echo " <span class='sr-only'>(current)</span></span></li>";
        } else {
            echo "<li><a href=$url$x>";
            echo $x;
            echo " <span class='sr-only'>(current)</span></a></li>";
        }
    }
    //right arrow
    if ($current_page == $num_pages) {
        echo "<li class='disabled'><span><span aria-hidden='true'>&raquo;</span></span></li>";
    } else {
        echo "<li><a href=$url";
        echo $current_page + 1;
        echo " aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
    }

    echo "</ul></nav></div>";
}

/** Get pet thumbnail image from the database
 * @param $pet_id ID of pet
 */
function get_pet_thumbnail($pet_id)
{
    $conn = connect_db();
    $result = $conn->query("SELECT image FROM thumbnails WHERE pet_id = $pet_id");
    if ($row = $result->fetch_array()) {
        echo '<img src="data:image/jpeg;base64,' .
            base64_encode($row['image']) . '"/>';
    }
}

/**
 * @param $addr_id int ID of address
 * @return string
 */
function get_address($addr_id)
{
    try {
        $conn = connect_db();
        $sql = "SELECT * FROM `address` WHERE id = $addr_id";
        $ret = $conn->query($sql)->fetch_object();

        $address = "$ret->city , $ret->state, $ret->zip";

        $conn->close();

        return $address;
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
        return '';
    }
}

/**
* Returns user id of current user that is logged in
*/
function get_user_id(){
    $email = $_SESSION['login_user_email'];
    try {
        $conn = connect_db();
        $sql = "SELECT id FROM users WHERE email = '$email'";

        $ret = $conn->query($sql)->fetch_object();
        $id = $ret->id;

        $conn->close();

        return $id;
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
        return '';
    }
}

/**
 * @param $email string email address
 * @return string
 */
function get_name_by_email($email)
{
    try {
        $conn = connect_db();
        $sql = "SELECT name FROM `users` WHERE email = '$email'";

        $ret = $conn->query($sql)->fetch_object();
        $name = $ret->name;

        $conn->close();

        return $name;
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
        return '';
    }
}

function get_owner_information($pet_id)
{
    try {
        $conn = connect_db();
        $sql = "SELECT * FROM `users` WHERE id = (SELECT owner_id FROM `pet` WHERE id = $pet_id)";
        $ret = $conn->query($sql)->fetch_object();
        $name = $ret->name;
        $email = $ret->email;

        $conn->close();

        return array($name, $email);
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
        return array('', '');
    }
}

function verify_login($email, $password)
{
    try {
        $conn = connect_db();
        $sql = "SELECT * FROM `users` WHERE email = '$email' and password = PASSWORD('$password')";
        $ret = $conn->query($sql)->num_rows == 1 ? true : false;
        $conn->close();
        return $ret;
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
        return false;
    }
}

/**
 * Check if an email is a existed account
 * @param $email string email address
 * @return bool exists or not
 */
function account_exists($email)
{
    try {
        $conn = connect_db();
        $sql = "SELECT * FROM `users` WHERE email = '$email'";
        $ret = $conn->query($sql)->num_rows == 1 ? true : false;
        $conn->close();
        return $ret;
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
        return true;
    }
}

/**
 * @param $email string of email address
 * @param $password string email address
 * @param $name string user's full name
 * @return bool success or not
 */
function create_account($email, $password, $name)
{
    try {
        $conn = connect_db();

        // To protect MySQL injection for Security purpose
        $email = stripslashes($email);
        $password = stripslashes($password);

        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);

        $sql = "INSERT INTO `users` (`name`,`password`,`email`)"
            . "VALUES ('$name',  PASSWORD('$password'),  '$email');";
        $conn->query($sql);
        return true;
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
        return false;
    }
}

/**
* Add the pet to your favorites
* @param $user_id id of the user favoriting the pet
* @param $pet_id id of the pet being favorited
*/
function add_to_favorites($user_id,$pet_id){
    try {
        $conn = connect_db();
        $sql = "INSERT INTO favorites (user_id, pet_id) VALUES ('$user_id', '$pet_id')";
        $conn->query($sql);
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }

}

?>