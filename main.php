<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "hrms_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "select `users`.`id`, `users`.`name` as `user_name`, `users`.`rs` as `user_rs`, 
`user_details`.`nick_name`, `user_details`.`national_id`, `user_details`.`gender`, `user_details`.`blood_group`, 
`user_details`.`current_address`, `bn_current_address`, `users`.`email`, `users`.`is_exist`, `user_details`.`avatar` as `avatar`
 from `users` left join `roles` on `users`.`role_id` = `roles`.`id` 
 left join `user_details` on `user_details`.`user_id` = `users`.`id` 
 left join `post_ids` on `post_ids`.`id` = `user_details`.`post_id` 

 left join `locations` on `post_ids`.`location_id` = `locations`.`id` 
 where `post_ids`.`location_id` = 7 and `users`.`is_exist` = '1'";

$result = mysqli_query($conn, $sql);

// if (mysqli_num_rows($result) > 0) {
//     while($row = $result->fetch_assoc()) {
//         echo $row['user_rs']."<br>";
//     }
// }

foreach((object)$result as $user) {
    $path = "D:\Download\avatar2";

    $dir = new \DirectoryIterator( realpath($path));

    foreach ($dir as $fileInfo) {
        if($fileInfo->getFilename() == '.' || $fileInfo->getFilename() == '..'){
            continue;
        }

        if($fileInfo->getFilename() == $user['avatar']){
            if( $fileName = str_replace( $user['avatar'], $user['user_rs'].".", $fileInfo->getFilename() ) ) {
                rename(
                    $fileInfo->getFilename(), 
                    './idb/'.$fileName.$fileInfo->getExtension()
                );
                continue;
                continue;
            }
            else{
                array_push($errorRS, $user['user_rs']);
            }
        }else{
            echo $user['user_rs'] . "<br>";
            continue;
                continue;
        }
    }
    

}

// return print_r($errorRS);
