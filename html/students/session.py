class Session:
    def __init__(self, machineId:int, status:str, sessionType:str, showResults:bool, showPlateSpeed:bool, showReleaseSpeed:bool):
        self.machineId = machineId
        self.status = status
        self.type = sessionType
        self.showResults = showResults
        self.showPlateSpeed = showPlateSpeed
        self.showReleaseSpeed = showReleaseSpeed
