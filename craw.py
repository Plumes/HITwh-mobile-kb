# -*- coding: utf-8 -*-
import urllib2
import re

year = ["09","10","11","12"]
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
dup =99

space = "&nbsp"
for yno in year:
	outsql = open("/home/plumes/Code/data/"+yno+"test.sql",'w')
	for mno in major:
		cno = yno+mno+"01"
		output = open("/home/plumes/Code/data/"+cno+".txt",'w')
		xnxq = "2012-2013-2"
		url = "http://222.194.15.1:8080/kccx/bjkb_info.jsp?xnxq=2012-2013-2&bj="+cno
		html = urllib2.urlopen(url).read()
		uhtml = html.decode('GBK').encode('utf-8')
		output.write(uhtml)
		output.close()
		output = open("/home/plumes/Code/data/"+cno+".txt",'r')
		
		line = output.readline()
		corder = 0
		while line != "":

			str = line.rstrip()
			# print corder,"\t"+str
			# corder=corder+1
			# print str
			
			if str == "        <TR bgcolor=\"#F2EDF8\" align=\"left\">":
				corder = corder + 1
				tmp = output.readline()
				tmp = output.readline()
				#print "di %d jie" %corder
				for weekday in range(1,8):
					
					str = (output.readline()).rstrip()
					#print str
					#print "hi"
					if str != "                <td>&nbsp;</td>":
						for i in range(1,11):
							tmp = output.readline()
						str = output.readline().rstrip().lstrip()
						#print str
						rlist = str.split("||")
						cnt = len( rlist )
						#print rlist[0]
						for j in range(0,cnt):
							flag = 0
							rstr = rlist [j]
							teacher = rstr.split(("讲授的"))[0]
							rstr = rstr.split(("讲授的"))[1]
							if rstr.find("于") < 0:
								sweek = dup+j
								eweek = eweek
								if rstr.find("在") >=0:
									rstr = rstr.split("在")[1]
									room =rstr.split("上课")[0]
								else :
									room = "未定"
							else: 
								cname = rstr.split(("["))[0]
								rstr = rstr.split(("于"))[1]
								if  rstr.find(",") >= 0:
									lrstr =rstr.split(",")[0]
									rstr = rstr.split(",")[1]
									flag = 1
									if lrstr.find('-')>=0:
										sweek = lrstr.split('-')[0]
										eweek = lrstr.split('-')[1]
									else:
										sweek = lrstr
										eweek = sweek
									
									if rstr.find('-')>=0:
										sweek1 = rstr.split('-')[0]
										rstr = rstr.split('-')[1]
										if rstr.find("周在") >= 0:
											eweek1 = rstr.split((" 周在"))[0]
											rstr = rstr.split((" 周在"))[1]
											room = rstr.split(("上课"))[0]
										else :
											eweek1 = rstr.split((" 周上课"))[0]
											room = "未定"
									else:

										if rstr.find("周在") >= 0:
											eweek1 = rstr.split((" 周在"))[0]
											rstr = rstr.split((" 周在"))[1]
											room = rstr.split(("上课"))[0]
											sweek1=eweek1
										else :
											eweek1 = rstr.split((" 周上课"))[0]
											room = "未定"
											sweek1 = eweek1
								else:
									if rstr.find("-")>=0:
										sweek =  rstr.split(("-"))[0]
										rstr = rstr.split(("-"))[1]
										if rstr.find("周在") >= 0:
											eweek = rstr.split((" 周在"))[0]
											rstr = rstr.split((" 周在"))[1]
											room = rstr.split(("上课"))[0]
										else :
											eweek = rstr.split((" 周上课"))[0]
											room = "未定"
									else:
										sweek =  rstr.split((" 周"))[0]
										eweek = sweek
										rstr = rstr.split((" 周"))[1]
										if rstr.find("在") >=0:
											rstr = rstr.split("在")[1]
											room =rstr.split("上课")[0]
										else:
											room ="未定"
							#print teacher
							sql = r"INSERT INTO `kb`(`cno`, `weekday`, `corder`, `cname`, `sweek`, `room`, `teacher`, `eweek`) VALUES "
							sql = sql + "("
							sql = sql +"\"%s\",%d,%d,\"%s\",%s,\"%s\",\"%s\",%s" %(cno,weekday,corder,cname,sweek,room,teacher,eweek)
							sql =sql +")"
							outsql.write(sql+";\n")
							if flag == 1:
								sql2 = r"INSERT INTO `kb`(`cno`, `weekday`, `corder`, `cname`, `sweek`, `room`, `teacher`, `eweek`) VALUES "
								sql2 = sql2 + "("
								sql2 = sql2 +"\"%s\",%d,%d,\"%s\",%s,\"%s\",\"%s\",%s" %(cno,weekday,corder,cname,sweek1,room,teacher,eweek1)
								sql2 =sql2 +")"
								outsql.write(sql2+";\n")
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


