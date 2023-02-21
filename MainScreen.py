import tkinter as tk 

class MainScreen:
    def __init__(self):
        self.win = tk.Tk()
        self.win.title("Self Check-in")
        self.win.geometry("1270x720")
        self.win.configure(background="white")



        self.lblHeader = tk.Label(self.win, text="Configuration screen", background="white")
                # This places the header
        self.lblHeader.place(x=100, y=50, anchor="center")

        self.entry1 = tk.Entry(self.win)
        self.entry1.place(x=100, y=100, anchor="center")
        self.win.mainloop()
mywin = MainScreen()

