
import subprocess
import sys
from subprocess import Popen, PIPE, STDOUT
from collections import Counter
import time
import math
import random
import pymongo

from pymongo import MongoClient
client = MongoClient('localhost', 27017) #make a connection with mongoClient
db = client.cinturon
ritmo = db.ritmo
metricas = db.metricas

def notification(address, reg_not):
	print "**************************************"
	print "Notification Register",reg_not 
	print "**************************************"
	cmd="gatttool -b "+address+" --char-write-req --handle="+reg_not+" --value=0100 --listen"  
	process = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE, stderr=subprocess.STDOUT)
	nextline = process.stdout.readline()
	
	band=True
	inicio=int(round(time.time() * 1000))
	cont=0
	lista_rr=list()
	
	while band:
		nextline = process.stdout.readline()
		
		print "=========================================="
		if "value:" in nextline:
			hr=nextline[39:41]
			hrint= int(hr, 16) #hex string to int
			
			rr=nextline[42:47]
			rr=rr.replace(" ", "")
			rr=rr[2:4]+rr[0:2]
			rrint=int(rr,16)
			
			print "hr int:", hrint
			print "RR",rrint
			
			
			rr1=0
			if(len( nextline[39:len(nextline)] )==16):
				rr1=nextline[48:53]
				rr1=rr1.replace(" ","")
				rr1=rr1[2:4]+rr1[0:2]
				rrint1=int(rr1,16)
				print "RR1",rrint1
			
			rrprom=0
			if(rr1!=0):
				rrprom = (rrint + rrint1)/2.0
			else:
				rrprom = rrint
			
			print "RRPROM",rrprom
			h=time.strftime("%H:%M:%S")
			f=time.strftime("%y-%m-%d")
			db.ritmo.save({"hr":hrint,"rr":rrprom,"fecha":f,"hora":h}) #save data
			
			if(rrprom<2000):
				lista_rr.append(rrprom) #method append() appends a passed object into the existing list
			
			actual=int(round(time.time() * 1000))
			if(actual-inicio)>60000:
				band=False
			
		if nextline == '' and process.poll() != None:
			break
		
		print "=========================================="
	
	print "lista es",lista_rr
	return lista_rr

def get_pNN50(lista_rr):
	n = len(lista_rr)
	suma=0
	cont50=0
	for i in range(n-1):
		dif=lista_rr[i+1] - lista_rr[i]
		if(dif>50):
			cont50+=1
	
	pNN50=cont50*100.0/(n-1)
	return pNN50

def get_rmssd(lista_rr):
	n = len(lista_rr)
	suma=0
	cont50=0
	for i in range(n-1):
		dif=lista_rr[i+1] - lista_rr[i]
		suma=suma+(dif**2)
	
	rmssd=math.sqrt(suma*1.0/(n-1))
	return rmssd

def get_logrmssd(lista_rr):
	n = len(lista_rr)
	suma=0
	cont50=0
	for i in range(n-1):
		dif=lista_rr[i+1] - lista_rr[i]
		suma=suma+(dif**2)
	
	temp_rmssd=math.sqrt(suma*1.0/(n-1))
	rmssd_log=20*math.log(temp_rmssd)
	return rmssd_log


	

address="78:A5:04:81:B3:66"
reg_not="0x0013"

lista_rr=notification(address,reg_not)

#lista_rr=[900,900,900,900,900,800]

pNN50 = get_pNN50(lista_rr)
print "pNN50 es",pNN50

rmssd = get_rmssd(lista_rr)
print "RMSSD es",rmssd

db.metricas.save({"pnn50":pNN50,"rmssd":rmssd})

rmssd_log = get_logrmssd(lista_rr)


#for x in ritmo.find(): print(x)