import mysql.connector as mariadb
from mysql.connector.cursor import MySQLCursorPrepared
from logger import Logger
from session import Session
import os

logger = Logger('./Database.log')

def get_db_connection():
    try:
        connection = mariadb.connect(user='smartmitt', password='smartmitt', database='smartmitt', host='localhost', use_pure=True)
    except:
        errString = 'Failed to connect to smartmitt database'
        logger.log(errString, 'get_db_connection')
        raise Exception(errString)
    return connection


def read_session(id:int)->Session:
    query = """SELECT 
                    MachineId,
                    Status,
                    SessionType,
                    ShowSuccessOrMiss, 
                    TimetoshowPlaySpeed, 
                    TimetoshowReleaseSpeed 
                FROM sessions 
                WHERE SeqSessionNumber = %s"""
    try:
        results = __read(query, (id,))[0]
    except:
        errString = 'Session read failed'
        logger.log(errString, 'get_session_settings')
        raise Exception(errString)

    return Session(results[0], results[1], results[2], results[3] == 'yes', results[4] > 0, results[5] > 0)

def read_machine_id()->int:
    query = 'SELECT UnitSerialNumber FROM smconfig WHERE ID = 1'
    try:
        results = __read(query, tuple())
    except:
        errString = 'Machine id read failed'
        logger.log(errString, 'get_session_settings')
        raise Exception(errString)
    
    return results[0][0]

def __read(query:str, args:tuple):
    try:
        connection = get_db_connection()
        cursor = connection.cursor(cursor_class=MySQLCursorPrepared)
        cursor.execute(query, args)
        results = cursor.fetchall()
    except:
        errString = 'Read failed'
        logger.log(errString, '__read')
        raise Exception(errString)
    finally:
        connection.close()
    
    return results