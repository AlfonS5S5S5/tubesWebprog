<?php
require_once '../../../BackEnd/connection.php';
    
    $query = "SELECT * from users where user_role = 'MEMBER'";
    $result = mysqli_query($conn, $query);
    
    while(mysqli_fetch_array($result)) {
            $xml = new SimpleXMLElement('<members/>');
            $data = "<members>";
            while ($row = mysqli_fetch_assoc($result)) {
                $data .= "<member>";
                $data .= "<user_id>" . $row['user_id'] . "</user_id>";
                $data .= "<user_name>" . $row['user_name'] . "</user_name>";
                $data .= "<user_password>" . $row['user_password'] . "</user_password>";
                $data .= "<user_wallet>" . $row['user_wallet'] . "</user_wallet>";
                $data .= "<user_block_status>" . $row['user_block_status'] . "</user_block_status>";
                $data .= "<user_profile_picture>" . $row['user_profile_picture'] . "</user_profile_picture>";
                $data .= "<user_role>" . $row['user_role'] . "</user_role>";
                $data .= "</member>";
            }
            $data .= "</members>";
          $x = new SimpleXMLElement($data);
            $x->asXML('members.xml');
    }
?>