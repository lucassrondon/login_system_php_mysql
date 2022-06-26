<?php
    function clean_data($data){
        $clean_data = trim($data);
        $clean_data = stripslashes($clean_data);
        $clean_data = htmlspecialchars($clean_data);

        return $clean_data;
    }

    function email_exists($server_connection, $email){
        $sql_get_data = "SELECT email FROM login_info";
        $result = $server_connection->query($sql_get_data);

        while ($row = $result->fetch_assoc()){
            if ($row["email"] == $email){
                return True;
            }
        }return False;
    }

    function username_exists($server_connection, $username){
        $sql_get_data = "SELECT username FROM login_info";
        $result = $server_connection->query($sql_get_data);

        while ($row = $result->fetch_assoc()){
            if ($row["username"] == $username){
                return True;
            }
        }return False;
    }

    function log_in($server_connection, $email, $password){
        $sql_get_data = "SELECT email, password FROM login_info";
        $result = $server_connection->query($sql_get_data);

        while ($row = $result->fetch_assoc()){
            if ($row["email"] == $email){
                if ($row["password"] != $password){
                    return False;
                }
                else{
                    return True;
                }
            }
        }return False;
    }

?>
