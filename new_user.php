

<?php
    if(isset($_POST['submit']))
    {
        $username = $_POST['uname'];
        $password = $_POST['pwd'];
        $location = $_POST['loc'];

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

        $sql = "INSERT INTO users (username, pwd, loc)
        VALUES ('$username','$password', '$location')";
        
    
        $result = $conn->query($sql);
        if (! $result) {
         
          echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
?>
