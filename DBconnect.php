

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
    
    //get results
   
    
    $i = 0;
	
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
			
               
				
     }
    } 

    else 
        echo "no results";
 
    //close the connection
    $conn->close();

  ?>

