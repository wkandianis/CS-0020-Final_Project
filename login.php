

<?php
    if(isset($_POST['submit']))
    {
        $username = $_POST['uname'];
        $password = $_POST['pwd'];
       

        $server = "localhost";   
        $userid = "ukgxpyvvigex4";
        $pw = "$1njfkiz312";
        $db = "dbbc8pf3dpkksh";
        // Create connection
        $conn = new mysqli($server, $userid, $pw);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->select_db($db);

        $sql = "SELECT $username, $password FROM users";
        
    
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "login successful";
        } else {
            echo "user does not exist";
        }
        
        $conn->close();
    }
?>