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
            $room_type = $_POST['room_type'];

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
        
            // Prepare query to get the reservation from database
            $get_reservation_query = $conn->prepare('SELECT users.name, reservations.check_in_date, reservations.check_out_date, reservations.room_id FROM users 
            INNER JOIN reservations ON users.user_id = reservations.user_id 
            WHERE users.name = ? AND reservations.reservation_id = ? AND reservations.check_in_date = ?'); 

            // get todays date
            $today = date("Y/m/d");

            // Bind parameters separately in order to prevent SQL injections 
            $get_reservation_query->bind_param("sss", $name, $confirmationNumber, $today);

            // Excecute query
            $get_reservation_query->execute();
            $result = $get_reservation_query->get_result();

            if(mysqli_num_rows($result) > 0){
            $reservation_found = TRUE;
            $message = "You have been checked in successfully ";
              while($row = $result->fetch_assoc()) {
                $check_in_date = $row["check_in_date"];
                $check_out_date = $row["check_out_date"];
                $name = $row["name"];
                $current_room = $row["room_id"];
                }
                // Check if the room is already assigned
                if($current_room == NULL){      
                  // Query to select available rooms
                  $get_available_room = $conn->prepare('SELECT r.room_id, r.room_type, r.floor FROM rooms r LEFT JOIN reservations res ON r.room_id = res.room_id WHERE res.check_in_date > ? OR res.check_out_date < ? OR res.check_in_date IS NULL AND r.room_type = ? LIMIT 1;;');
                  
                  // Bind parameters
                  $get_available_room->bind_param("sss",$check_in_date,$check_out_date,$room_type);
                  
                  // Excecute query
                  $get_available_room->execute();
                  $result_available_room = $get_available_room->get_result();
    
                  $row_available_room = $result_available_room->fetch_assoc();
                  $room = $row_available_room["room_id"];
    
                  // Assign room to the reservation
                  $assign_room = $conn->prepare('UPDATE reservations SET room_id = ? WHERE reservation_id = ?');
                  // Bind paremeters
                  $assign_room->bind_param("ss",$room,$confirmationNumber);
                  // Excecute query
                  $assign_room->execute();
                }
            }else{
              $message = "Unfortunately, we could not find your reservation. Make sure you entered correct details or go to the reception desk for help";
              $reservation_found = FALSE;
            }



            // close connection
            mysqli_close($conn);
        ?>

        <div id="content">
        <!-- Hotel logo -->
        <img src="logo.png" width="350" height = "350" alt="Hotel Logo">

        <!-- Conditional rendering depending on check-in result -->
        <?php
        if ($reservation_found == TRUE) {
        ?>
        <h1 id="success">Check-in succesfull <span class="badge bg-secondary"></span></h1>
        <h2 id="success2"><?php echo $message ?></h2>
        <button type="button" class="btn btn-info" onClick="goBack()">Go Back</button>
        <?php
        }else{ ?>
        <h1 id="failure">We could not find your reservation <span class="badge bg-secondary"></span></h1>
        <h2 id="failure2"><?php echo $message ?></h2>
        <button type="button" class="btn btn-info" onClick="goBack()">Go Back</button>
        <?php 
        };
        ?>
        </div>

    <script>
      function goBack() {
        window.history.back();
      }

  //      var language = <?php echo json_encode($language); ?>;

  //     var languages = {
  //     eng: {
  //         success: "Check-in was successful.",
  //         success2: "You have been checked in successfully.",
  //         failure: "We could not find your reservation.",
  //         failure2: "Unfortunately, we could not find your reservation. Make sure you entered correct details or go to the reception desk for help",
  //     },
  //     es: {
  //       success: "El registro fue exitoso.",
  //       success2: "Ha sido registrado con éxito.",
  //       failure: "No pudimos encontrar su reserva.",
  //       failure2: "Desafortunadamente, no pudimos encontrar su reserva. Asegúrese de ingresar los detalles correctos o diríjase a la recepción para obtener ayuda."
  //     }
  //   }

  //   // Define language through window hash
  // if(language) {
  //     if(language === "#es"){
  //       document.getElementById("failure").innerHTML = languages.es.failure
  //       document.getElementById("failure2").innerHTML = languages.es.failure2
  //       document.getElementById("success").innerHTML = languages.es.success
  //       document.getElementById("success2").innerHTML = languages.es.success2
  //     }
  // }
    </script>

</body>
</html>