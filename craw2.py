# -*- coding: utf-8 -*-
import urllib2
import re
import time

year = ["12"]
major= ["012","013","014","015",
	"021","022","023","024","025","026",
	"031","032","036",
	"041","042","111",
	"051","052","142",
	"061","101",
	"071","072","073","075",
	"081","082","083","084",
	"121",
	"131","132"]
# grade = '10'
# major = "042"
def  getteacher(rstr):
	if rstr.find("讲授的")>=0:
		teacher = rstr.split("讲授的")[0]
		rstr = rstr.split("讲授的")[1]
	else:
		teacher = "未定"
	return [teacher,rstr]

def getcname(rstr):
	# if rstr.find("讲授的")>=0:
	# 	end = rstr.find('[')
	# 	cname = rstr[rstr.find("讲授的")+9:end]
	# 	print cname
	# 	rstr = rstr.split(']')[1]
	# else:
	# 	cname = "未定"
	# return [cname,rstr]

	end = rstr.find('[')
	cname = rstr[0:end]
	print cname
	rstr = rstr.split(']')[1]
	return [cname,rstr]

def getweek(rstr,dup):
	if rstr.find("于")>=0:
		rstr = rstr.split("于")[1]
		wstr = rstr.split(" 周")[0]
		rstr = rstr.split(" 周")[1]
		if wstr.find(",")>=0:
			left = wstr.split(",")[0]
			right = wstr.split(",")[1]
			if left.find('-')>=0:
				start = left.split('-')[0]
				end = left.split('-')[1]
				weeklist = [[start,end]]
			else:
				start = left
				weeklist = [[start,start]]
			if right.find('-')>=0:
				start = right.split('-')[0]
				end = right.split('-')[1]
				weeklist.append( [start,end] )
			else:
				start = right
				weeklist.append( [start,start] )
		else:
			if wstr.find('-')>=0:
				start = wstr.split('-')[0]
				end = wstr.split('-')[1]
				weeklist = [[start,end]]
			else:
				start = wstr
				weeklist = [[start,start]]
	else:
		weeklist = [[dup,dup]]
	return [weeklist,rstr]

def getroom(rstr):
	if rstr.find("在")>=0:
		end = rstr.find('上课')
		room = rstr[rstr.find("在")+3:end]
	else:
		room = "未定"
	return room





space = "&nbsp"
if __name__ == '__main__':
	for yno in year:
		outsql = open("/home/plumes/Code/data/"+yno+"test.sql",'w')
		for mno in major:
			cno = yno+mno+"01"
			output = open("/home/plumes/Code/data/"+cno+".txt",'w')
			xnxq = "2012-2013-2"
			#time.sleep(1)
			url = "http://222.194.15.1:8080/kccx/bjkb_info.jsp?xnxq=2012-2013-2&bj="+cno
			html = urllib2.urlopen(url).read()
			uhtml = html.decode('GBK').encode('utf-8')
			output.write(uhtml)
			output.close()
			output = open("/home/plumes/Code/data/"+cno+".txt",'r')
			
			line = output.readline()
			corder = 0
			while line != "":

				str = line.strip()
				# print corder,"\t"+str
				# corder=corder+1
				# print str
				
				if str == "<TR bgcolor=\"#F2EDF8\" align=\"left\">":
					corder = corder + 1
					tmp = output.readline()
					tmp = output.readline()
					#print "di %d jie" %corder
					for weekday in range(1,8):
						
						str = (output.readline()).strip()
						#print str
						#print "hi"
						if str != "<td>&nbsp;</td>":
							for i in range(1,11):
								tmp = output.readline()
							str = output.readline().rstrip().lstrip()
							#print str
							rlist = str.split("||")
							cnt = len( rlist )
							#print rlist[0]
							for j in range(0,cnt):
								flag = 0
								rstr = rlist[j]

								val = getteacher(rstr)
								teacher = val[0]
								rstr = val[1]

								val = getcname(rstr)
								cname = val[0]
								rstr = val[1]

								val = getweek(rstr,99+j)
								weeklist = val[0]
								rstr = val[1]

								room = getroom(rstr)
								
								for pair in weeklist:
									sql = r"INSERT INTO `kb`(`cno`, `weekday`, `corder`, `cname`, `sweek`, `room`, `teacher`, `eweek`) VALUES "
									sql = sql + "("
									sql = sql +"\"%s\",%d,%d,\"%s\",%s,\"%s\",\"%s\",%s" %(cno,weekday,corder,cname,pair[0],room,teacher,pair[1])
									sql =sql +")"
									outsql.write(sql+";\n")
									
							#print "#"
							for i in range(1,8):
								tmp = output.readline()
						else:
							tmp = output.readline()
							#print "NULL"
					
				line = output.readline()
			print "success:"+yno+mno

			output.close()
		outsql.close()


