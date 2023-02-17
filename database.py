import sqlite3
from sqlite3 import Error


def create_connection(db_file):
    """ create a database connection to the SQLite database
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
    """ create a table from the create_table_sql statement
    :param conn: Connection object
    :param create_table_sql: a CREATE TABLE statement
    :return:
    """
    try:
        c = conn.cursor()
        c.execute(create_table_sql)
    except Error as e:
        print(e)


def main():
    sql_create_reservation_table = """ CREATE TABLE IF NOT EXISTS reservations (
                                        reservation_id integer PRIMARY KEY,
                                        check_in_date text,
                                        check_out_date text,
                                        FOREIGN KEY (user_id) REFERENCES users (user_id)
                                        FOREIGN KEY (room_id) REFERENCES rooms (room_ids)
                                    ); """

    sql_create_user_table = """CREATE TABLE IF NOT EXISTS users (
                                    id user_id PRIMARY KEY,
                                    name text NOT NULL,
                                    email text,
                                    phone_number text,
                                );"""

    sql_create_user_table = """CREATE TABLE IF NOT EXISTS rooms (
                                    id room_id PRIMARY KEY,
                                    room_type NOT NULL,
                                    floor INT
                                );"""
    # create a database connection
    conn = create_connection(database)

    # create tables
    if conn is not None:
        # create projects table
        create_table(conn, sql_create_projects_table)

        # create tasks table
        create_table(conn, sql_create_tasks_table)
    else:
        print("Error! cannot create the database connection.")


if __name__ == '__main__':
    main()