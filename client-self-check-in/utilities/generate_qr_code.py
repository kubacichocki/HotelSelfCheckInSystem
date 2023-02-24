# Importing library
import qrcode
 

def generate_qr_code(name, surname, reservation):
    # Data to be encoded
    data = {
        "firstname" : name,
        "surname": surname,
        "reservation": reservation
    }

    # Encoding data using make() function
    img = qrcode.make(data)
 
    # Saving as an image file
    img.save('MyQRCode1.png')


generate_qr_code("John", "Walker", "21421323")