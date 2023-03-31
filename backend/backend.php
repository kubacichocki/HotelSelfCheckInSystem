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

                //Check in query
                $check_in = $conn->prepare('UPDATE reservations SET is_checked_in = ? WHERE reservation_id = ?');

                // Bind paremeters
                $is_checked_in = '1';
                $check_in->bind_param("ss",$is_checked_in,$confirmationNumber);
                // Excecute query
                $check_in->execute();

                // We leave this part for the future iterations if company would like to have it done usign QR CODES
                //Import QR code library
                // include 'phpqrcode/qrlib.php';
                // $text = $name . " Check-in Date: " . $check_in_date . " Check-out Date: " . $check_out_date . " Room: " . $current_room;
                // QRcode::png($text, 'image.png', QR_ECLEVEL_M, 4);
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

        <!-- Conditional rendering depending on the check-in result -->
        <?php
        if ($reservation_found == TRUE) {
        ?>
          <h1 id="success">You have been checked in successfully.<span class="badge bg-secondary"></span></h1>
          <h2 id="success2">Please present your confirmation number at the reception desk to receive a room key.</h2>
          <img src="image.png" alt="QR Code">
          <button type="button" class="btn btn-info" onClick="goBack()">Go Back</button>
        <?php
        }else{ ?>
          <h1 id="failure">Unfortunately, we could not find your reservation<span class="badge bg-secondary"></span></h1>
          <h2 id="failure2">Make sure you enter the correct details or go to the reception desk for help</h2>
          <button type="button" class="btn btn-info" onClick="goBack()">Go Back</button>
          <?php 
        };
        ?>
        </div>

    <script>
      function goBack() {
        window.history.back();
      }

      var language = <?php echo json_encode($language); ?>;

      var languages = {
      eng: {
          success: "You have been checked in successfully.",
          success2: "Please present your confirmation number at the reception desk to receive a room key.",
          failure: "Unfortunately, we could not find your reservation",
          failure2: "Make sure you enter the correct details or go to the reception desk for help",
      },
      es: {
        success: "El registro fue exitoso.",
        success2: "Ha sido registrado con éxito.",
        failure: "No pudimos encontrar su reserva.",
        failure2: "Desafortunadamente, no pudimos encontrar su reserva. Asegúrese de ingresar los detalles correctos o diríjase a la recepción para obtener ayuda."
      },
      pl: {
        success: "Sukces! Znaleźliśmy Twoją rezerwację",
        success2: "Proszę udaj się do biurka recepcji z kodem swojej rezerwacji aby otrzymać klucz do pokoju",
        failure: "Niestety nie mogliśmy znaleźć Twojej rezerwacji",
        failure2: "Upewnij się, że poprawne dane zostały podane, albo udaj się do biurka recepcji po pomoc",
      },
      bg: {
           success: "Чекирахте се успешно.",
           success2: "Моля, представете вашия номер за потвърждение на рецепцията, за да получите ключ от стаята.",
           failure: "За съжаление не можахме да намерим вашата резервация",
           failure2: "Уверете се, че сте въвели правилните данни или отидете на рецепцията за помощ",
      },
      ro: {
          succes: "Ati rezervat cu success .",
          succes2:"Va rugam introduceti numarul confirmarii la receptie sa primiti cheia camerei",
          failure: "Din nefericire, nu putem sa va gasim rezervarea" ,
          failure2: " Asigurati-va ca v-ati introdus corect detaliile sau mergeti la birou pentru ajutor",
        },
      hi: {
        success: "आपने सफलतापूर्वक चेक इन किया है।",
        success2: "कृपया अपना पुष्टि संख्या रिसेप्शन डेस्क पर प्रदान करें ताकि आप कमरे का कुंजी प्राप्त करें।", 
        failure: "दुर्भाग्य से, हम आपका आरक्षण नहीं ढूंढ पाए।",
        failure2: "सुनिश्चित करें कि आप सही विवरण दर्ज करते हैं या रिसेप्शन डेस्क के लिए मदद के लिए जाएं।",
      },
          
    }

  // Define language through window hash
  if(language) {
      // Variable to check if check-in was successful or not
      let element_failure = document.getElementById('failure');

      if(language === "#es"){
        if(element_failure){
          document.getElementById("failure").innerHTML = languages.es.failure
          document.getElementById("failure2").innerHTML = languages.es.failure2
        }else{
          document.getElementById("success").innerHTML = languages.es.success
          document.getElementById("success2").innerHTML = languages.es.success2
        }
      }
      if(language === "#pl"){
        if(element_failure){
          document.getElementById("failure").innerHTML = languages.pl.failure
          document.getElementById("failure2").innerHTML = languages.pl.failure2
        }else{
          document.getElementById("success").innerHTML = languages.pl.success
          document.getElementById("success2").innerHTML = languages.pl.success2
        }
      }
      if(language === "#bg"){
        if(element_failure){
          document.getElementById("failure").innerHTML = languages.bg.failure
          document.getElementById("failure2").innerHTML = languages.bg.failure2
        }else{
          document.getElementById("success").innerHTML = languages.bg.success
          document.getElementById("success2").innerHTML = languages.bg.success2
        }
      }
      if(language === "#ro"){
        if(element_failure){
          document.getElementById("failure").innerHTML = languages.ro.failure
          document.getElementById("failure2").innerHTML = languages.ro.failure2
        }else{
          document.getElementById("success").innerHTML = languages.ro.success
          document.getElementById("success2").innerHTML = languages.ro.success2
        }
      }
      if(language === "#hi"){
        if(element_failure){
          document.getElementById("failure").innerHTML = languages.hi.failure
          document.getElementById("failure2").innerHTML = languages.hi.failure2
        }else{
          document.getElementById("success").innerHTML = languages.hi.success
          document.getElementById("success2").innerHTML = languages.hi.success2
        }
      }
  }
    </script>

</body>
</html>