import sqlite3
from sqlite3 import Error



def create_connection(db_file):
    """create a database connection to the SQLite database
     specified by db_file
    :param db_file: database file
    :return: Connection object or None
    """
    conn = None
    try:
        conn = sqlite3.connect(db_file)
        return conn
    except Error as e:
        print(e)

    return conn


def create_table(conn, create_table_sql):
    """create a table from the create_table_sql statement
    :param conn: Connection object
    :param create_table_sql: a CREATE TABLE statement
    :return:
    """
    try:
        c = conn.cursor()
        c.execute(create_table_sql)
    except Error as e:
        print(e)


sql_create_reservation_table = """ CREATE TABLE IF NOT EXISTS reservations (
reservation_id integer PRIMARY KEY,
room_id integer,
check_in_date text,
check_out_date text,
FOREIGNKEY(reservation_id)REFERENCES users (user_id)
FOREIGN KEY (room_id) REFERENCES rooms (room_id)
); """


sql_create_user_table = """CREATE TABLE IF NOT EXISTS users (
user_id PRIMARY KEY,
name text NOT NULL,
email text,
phone_number text,);"""


sql_create_rooms_table = """CREATE TABLE IF NOT EXISTS rooms (
room_id PRIMARY KEY,
room_type NOT NULL,
floor INT
);"""

sql_insert_reservations = """
INSERT INTO 'reservations' (reservation_id, room_id, check_in_date, check_out_date)

VALUES
    ('12234', '', '10/02/2023', '15/02/2023'),
    ('12345', '', '05/03/2023', '10/03/2023'),
    ('12456', '', '23/02/2023', '30/02/2023'),
    ('12567', '', '27/02/2023', '03/03/2023'),
    ('12678', '', '05/03/2023', '15/03/2023'),
    ('12789', '', '08/03/2023', '12/03/2023'),
    ('12910', '', '10/03/2023', '18/03/2023'),
    ('12112', '', '15/03/2023', '20/03/2023'),
    ('12113', '', '05/04/2023', '10/04/2023'),
    ('12114', '', '07/04/2023', '10/04/2023'),
    ('12115', '', '10/04/2023', '15/04/2023'),
    ('12116', '', '12/04/2023', '15/04/2023'),
    ('12117', '', '18/04/2023', '20/04/2023'),
    ('12118', '', '21/04/2023', '25/04/2023'),
    ('12119', '', '01/05/2023', '07/05/2023'),
    ('12120', '', '05/05/2023', '08/05/2023'),
    ('12121', '', '10/05/2023', '15/05/2023'),
    ('12122', '', '15/05/2023', '17/05/2023'),
    ('12123', '', '20/05/2023', '25/05/2023'),
    ('12124', '', '15/05/2023', '20/05/2023');"""

sql_insert_rooms = """ INSERT INTO 'rooms' (room_id, room_type, floor)

VALUES
    ('101', 'single', '1'),
    ('102', 'double', '1'),
    ('103', 'appartment', '1'),
    ('104', 'luxury', '1'),
    ('105', 'single', '1'),
    ('106', 'double', '1'),
    ('201', 'luxury', '2'),
    ('202', 'double', '2'),
    ('203', 'single', '2'),
    ('302', 'appartment', '3'),
    ('303', 'single', '3'),
    ('304', 'appartment', '3'),
    ('305', 'double', '3'),
    ('306', 'single', '3'),
    ('307', 'luxury', '3'),
    ('401', 'appartment', '4'),
    ('402', 'luxury', '4'),
    ('403', 'double', '4'),
    ('404', 'appartment', '4'),
    ('405', 'single', '4');"""


sql_insert_users = """ Insert INTO 'users' (user_id, name, email, phone_number)

VALUES
    ('8951222423', 'Patrick Randall', 'PatrickRandall@gmail.com', '+4477879195412'),
    ('8456852541', 'Keira Parker', 'KeiraParker@jourrapide.com' , '+4477744834269'),
    ('8445852541', 'Amelie Pickering', 'AmeliePickering@armyspy.com', '+4477843801161'),
    ('8445878891', 'Spencer Blackburn', 'SpencerBlackburn@rhyta.com', '+4477949549646')
    ('8445852891', 'Thomas Myers', 'ThomasMyers@dayrep.com', '+4477744735473')
    ('8445852891', 'Nicholas Weston', 'NicholasWeston@yahoo.com', '+4477927460933')
    ('8321852891', 'Lewis Goodwin', 'LewisGoodwin@jourrapide.com', '+4477848629119')
    ('8441892891', 'Zoe Tyler', 'ZoeTyler@rhyta.com', '+4477751500008')
    ('8447252891', 'Madison Matthews', 'MadisonMatthews@gmail.com', '+4477965949879')
    ('8445426891', 'Courtney Giles', 'CourtneyGiles@dayrep.com', '+4477944785065')
    ('8445653891', 'Rebecca Coles', 'RebeccaColes@yahoo.com', '+4477748431596')
"""


def main():
    # create a database connection
    conn = sqlite3.connect("tutorial.db")

    # create tables
    if conn is not None:
        # create user table
        create_table(conn, sql_create_user_table)

        # create reservationn tables
        create_table(conn, sql_create_reservation_table)

        # create room table
        create_table(conn, sql_create_rooms_table)
    else:
        print("Error! cannot create the database connection.")


if __name__ == "__main__":
    main()
