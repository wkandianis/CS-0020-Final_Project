

  <?php 
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
   
  
    //select the database
    $conn->select_db($db);
    $sql = "SELECT * FROM `users`";

    $result = $conn->query($sql);
    

   // add new user
    $sql = "INSERT INTO users (fname, lname, username, pwd, email, loc)
    VALUES ('$fname', '$lname','$username','$pwd','$email','$loc')";
    

    $result = $conn->query($sql);
    if ($result === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
 




    // get data from table 
   $sql = "SELECT pwd, loc FROM users WHERE username = $username";
   
   $result = $conn->query($sql);
    if ($result === FALSE) {
      echo "Error: " . $sql . "<br>" . $conn->error;
   }
   
   if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo $row["pwd"];
      echo $row["loc"];

    }

   }
    $conn->close();



  
  ?>

