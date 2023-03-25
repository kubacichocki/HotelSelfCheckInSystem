//Global variable to check if user selected a room type
var isRoomTypeSelected = false;

// Refresh page in order to change the language
function refreshPage(selectedOption) {
    window.location.hash = selectedOption;
    window.location.reload();
    document.getElementById('language').value = selectedOption;
  }

// Set the room type value for hidden input
function setRoomType(selectedOption){
    document.getElementById('room_type').value = selectedOption;
    isRoomTypeSelected = true
}

// Add an event listener to the form submit button
document.getElementById("submit").addEventListener("click", function(event) {

    // Check if the value of the dropdown menu is empty
    if (!isRoomTypeSelected) {
      // Stop the form from submitting
      event.preventDefault();
      // Alert the user to select an option
      alert("Please select an option from the dropdown menu.");
    }
  });


  // Event listeners for language dropdown menu
  document.getElementById("spanish").addEventListener("click", function(){ 
      refreshPage('#es');
  });

  document.getElementById("english").addEventListener("click", function(){ 
        refreshPage('#eng');
    });

    document.getElementById("polish").addEventListener("click", function(){ 
        refreshPage('#pl');
    });

    document.getElementById("bulgarian").addEventListener("click", function(){ 
        refreshPage('#bg');
    });      
    document.getElementById("romanian").addEventListener("click", function(){ 
        refreshPage('#ro');
      
    });
// Event listeneres for room type dropdown menu
    document.getElementById("single").addEventListener("click", function(){ 
        setRoomType('single');
      
    });
    document.getElementById("double").addEventListener("click", function(){ 
        setRoomType('double');
      
    });
    document.getElementById("twin").addEventListener("click", function(){ 
        setRoomType('twin');
      
    });


  //Languages 
  var languages = {
      eng: {
          welcome: "Welcome to our hotel!",
          instruction: "In order to check in, fill the form below ",
          name: "Enter your name",
          confirmationNumber: "Enter you booking confirmation number",
          warning: "Make sure you enter correct details",
          submit: "Submit"
      },
      es: {
          welcome: 'Binevenidos todos!',
          instruction: "Para registrarse, complete el siguiente formulario",
          name: "Introduzca su nombre",
          confirmationNumber: "Introduzca su número de confirmación de reserva",
          warning: "Asegúrese de ingresar los detalles correctos",
          submit: "Entregar"
      },
      pl: {
        welcome: "Witaj w naszym hotelu!",
        instruction: "Aby się zameldować wypełnij formularz",
        name: "Podaj swoje imię",
        confirmationNumber: "Podaj numer rezerwacji",
        waring: "Upewnij się, że podane dane są prawidłowe",
        submit: "Wyslij"
      },

      bg: {
          welcome: "Добре дошли във нашия хотел!",
          instruction: "За да се регистрирате,попълнете формата по-долу! ",
          name: "Въведете вашето име",
          confirmationNumber: "Въведете вашия номер на резервация",
          warning: "Уверете се че въвеждате правилно вашите данни",
          submit: "Изпрати"
      },
       ro: {
          welcome: "Bine ati venit la hotelul nostru!",
          instruction: "Pentru a face rezervare, completati formularul de mai jos",
          name: "Introduceti-va numele complet",
          confirmationNumber: "Introduceti-va numarul confirmarii rezervarii",
          warning: "Asigurarti-va ca introduceti datele corecte",
          submit: "Incarcati"
       }
           
  };

  // Define language through window hash
  if(window.location.hash) {
      if(window.location.hash === "#eng"){
          header1.textContent = languages.eng.welcome
          header2.textContent = languages.eng.instruction
          document.getElementById("name").innerHTML = languages.eng.name
          document.getElementById("confirmationNumber").innerHTML = languages.eng.confirmationNumber
          document.getElementById("warning").innerHTML = languages.eng.warning
          document.querySelector('button[type="submit"]').innerHTML = languages.eng.submit
      }
      if(window.location.hash === "#es"){
          header1.textContent = languages.es.welcome
          header2.textContent = languages.es.instruction
          document.getElementById("name").innerHTML = languages.es.name
          document.getElementById("confirmationNumber").innerHTML = languages.es.confirmationNumber
          document.getElementById("warning").innerHTML = languages.es.warning
          document.querySelector('button[type="submit"]').innerHTML = languages.es.submit
      }
      if(window.location.hash === "#pl"){
          header1.textContent = languages.pl.welcome
          header2.textContent = languages.pl.instruction
          document.getElementById("name").innerHTML = languages.pl.name
          document.getElementById("confirmationNumber").innerHTML = languages.pl.confirmationNumber
          document.getElementById("warning").innerHTML = languages.pl.warning
          document.querySelector('button[type="submit"]').innerHTML = languages.pl.submit
      }
      if(window.location.hash === "#bg"){
          header1.textContent = languages.bg.welcome
          header2.textContent = languages.bg.instruction
          document.getElementById("name").innerHTML = languages.bg.name
          document.getElementById("confirmationNumber").innerHTML = languages.bg.confirmationNumber
          document.getElementById("warning").innerHTML = languages.bg.warning
          document.querySelector('button[type="submit"]').innerHTML = languages.bg.submit
      }
       if(window.location.hash === "#ro"){
          header1.textContent = languages.ro.welcome
          header2.textContent = languages.ro.instruction
          document.getElementById("name").innerHTML = languages.ro.name
          document.getElementById("confirmationNumber").innerHTML = languages.ro.confirmationNumber
          document.getElementById("warning").innerHTML = languages.ro.warning
          document.querySelector('button[type="submit"]').innerHTML = languages.ro.submit
       }
      };