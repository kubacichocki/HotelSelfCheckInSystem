<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
     </head>
     <body>
        <!-- Importing bootstrap libraries -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <?php
            // getting all values from the HTML form
            $name = $_POST['nameInput'];
            $confirmationNumber = $_POST['confirmationNumberInput'];
            $language = $_POST['language'];
            echo "You chose the language: $language";
            echo "Name: $name Confirmation number: $confirmationNumber<br>";

            // database details
            $host = "localhost";
            $username = "root";
            $password = "";
            $dbname = "hotel_self_check_in";

            // creating a connection
            $conn = mysqli_connect($host, $username, $password, $dbname);

            // to ensure that the connection is made
            if (!$conn)
            {
                die("Connection failed!" . mysqli_connect_error());
            }
        
            // Prepare query
            $stmt = $conn->prepare('SELECT users.name, reservations.check_in_date, reservations.check_out_date FROM users 
            INNER JOIN reservations ON users.user_id = reservations.user_id 
            WHERE users.name = ? AND reservations.reservation_id = ?'); 

            // Bind parameters separately in order to prevent SQL injections 
            $stmt->bind_param("ss", $name, $confirmationNumber);

            // Excecute query
            $stmt->execute();
            $result = $stmt->get_result();
            // echo "RESULTS: ", $result;
            //  Display results if exist
            if(mysqli_num_rows($result) > 0){
            $reservation_found = TRUE;
            $message = "You have been checkd in successfully ";
              while($row = $result->fetch_assoc()) {
                echo "Name: " . $row["name"] . " Check In Date: " . $row["check_in_date"] . " Check Out Date: " . $row["check_out_date"];
                }
            }else{
              echo "DIDNT FIND RESERVATION";
              $reservation_found = FALSE;
            }

            // echo "Searching for available rooms";

            // //  Query available rooms for that date
            // $date1 = '2023-05-05';
            // $date2 = '2023-05-07';
            // $sql2 = "SELECT r.room_id, r.room_type, r.floor
            // FROM rooms r WHERE NOT EXISTS (SELECT * FROM reservations rs WHERE rs.room_id = r.room_id
            // AND (rs.check_in_date <= '$date1' AND rs.check_out_date >= '$date2')); ";
          
            //   // Excecute query
            //   $result2 = $conn->query($sql2);
            //   if(isset($result2)){
            //     while($row = $result->fetch_assoc()) {
            //       echo "Room ID: " . $row["room_id"] . " Room type " . $row["room_type"] . " Floor: " . $row["floor"];
            //       }
            //   }else{
            //     echo "Didnt find anything";
            //   }

            // close connection
            mysqli_close($conn);
        ?>

        <div id="content">
        <!-- Hotel logo -->
        <img src="logo.png" width="350" height = "350" alt="Hotel Logo">

        
        <?php
        if ($reservation_found == TRUE) {
        ?>
        <h1>Check-in succesfull <span class="badge bg-secondary">New</span></h1>
        <?php
        }else{ ?>
        <h1>We could not find your reservation <span class="badge bg-secondary">New</span></h1>
        <?php 
        };
        ?>
        </div>


</body>
</html>