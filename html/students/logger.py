import time
import os

class Logger:
    def __init__(self, path:str):
        self.loggingFile = open(path, 'w')

    def __del__(self):
        self.loggingFile.close()

    def log(self, message: str, callingFunctionName: str):

        if (callingFunctionName == None):
            callingFunctionName = ''

        StringToWrite = 'Local: ' + time.strftime('%m/%d/%y %H:%M:%S', time.localtime()) + ' | ' +  callingFunctionName + ' | '  + \
                        message + ' | TZ:'   + str(time.timezone) + ' |  GMT- ' + time.strftime('%m/%d/%y %H:%M:%S', time.gmtime()) + '\n'

        self.loggingFile.writelines(StringToWrite)
        self.loggingFile.flush()
        os.fsync(self.loggingFile)