import requests
import serial
import json
from blinkt import set_all, set_brightness, show, clear
import time

address = '10.3.141.1' #RaspAP default IP

# /dev/ttyACM0 on linux
# /COMXX on windows
ser = serial.Serial(
    port='/dev/ttyACM0',\
    baudrate=115200,\
    parity=serial.PARITY_NONE,\
    stopbits=serial.STOPBITS_ONE,\
    bytesize=serial.EIGHTBITS,\
        timeout=1)

print("Verbunden mit: " + ser.name)

while True:
	values = ser.readline().split(";")
	if len(values)==2 and values[0] != '' and values[1] != '': 
		print('http://'+address+'/api/v1.php?players/'+values[0]+'/buy/'+values[1])
		r = requests.get('http://'+address+'/api/v1.php?players/'+values[0]+'/buy/'+values[1])
		if r.status_code == 200:
			success = r.json()
			if success["success"] == True:
				print("Erfolgreich gekauft!")
				set_all(0, 255, 0)
				show()
				time.sleep(1)
				clear()
				show()
				ser.write("OK")
			else:
				print("Fehler beim Einkauf!")
				set_all(255, 0, 0)
				show()
				time.sleep(1)
				clear()
				ser.write("NOTOK")

