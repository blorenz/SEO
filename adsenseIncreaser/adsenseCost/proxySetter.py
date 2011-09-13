#!/usr/bin/env python

import os
import sys
from PyQt4.QtCore import QUrl, SIGNAL,QObject,QVariant,Qt,QTimer
from PyQt4.QtGui import QApplication, QImage, QPainter
from PyQt4.QtWebKit import QWebPage, QWebView
from PyQt4.QtTest import QTest
from PyQt4.QtNetwork import QNetworkProxy, QNetworkAccessManager, QNetworkRequest
from urllib2 import urlopen
import urllib2
import _mysql
import json
import binascii
import random
import socket
import threading
import time

JQUERY_URL = 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js' 
JQUERY_JSON_URL = 'http://jquery-json.googlecode.com/files/jquery.json-2.2.min.js'
JQUERY_FILE = JQUERY_URL.split('/')[-1]
JQUERY_FILE_JSON_URL = JQUERY_JSON_URL.split('/')[-1] 
JQUERY_PATH = os.path.join(os.path.dirname(__file__), JQUERY_FILE)
JQUERY_JSON_PATH = os.path.join(os.path.dirname(__file__), JQUERY_FILE_JSON_URL)




# Proxies?!?
# proxy = QtNetwork.QNetworkProxy()
# proxy.setType(QtNetwork.QNetworkProxy.Socks5Proxy)
# proxy.setHostName('localhost');
# proxy.setPort(1337)
# QtNetwork.QNetworkProxy.setApplicationProxy(proxy);

# OR

#include <QNetworkProxy>
# QNetworkProxy proxy(QNetworkProxy::HttpProxy, "proxy.host", proxy.port);
# QNetworkProxy::setApplicationProxy(proxy);

class ProxyCheck():
	def __init__(self,region=None):
		self.proxies = []
		
		if region == 'us':
			file = open('/proxies/proxy.us.good.db','r')
		else:
			file = open('/proxies/proxy.good.db','r')
			
		for line in file:
			proxyAndTime = line.strip().split(',')
			if float(proxyAndTime[1]) < 3.0:		#Select less than 3 seconds
				self.proxies.append(proxyAndTime[0])
		file.close()

		random.seed()
		proxyString = self.proxies[random.randint(0,len(self.proxies)-1)]
		proxyDivide = proxyString.strip().split(':')
		self.proxy = QNetworkProxy()
		self.proxy.setType(QNetworkProxy.HttpProxy)
		self.proxy.setHostName(proxyDivide[0])
		self.proxy.setPort(int(proxyDivide[1]))
		
	def getProxy(self):
		file = open('/proxies/proxy.good.db','r')
		for line in file:
			proxyAndTime = line.strip().split(',')
			if float(proxyAndTime[1]) < 3.0:		#Select less than 3 seconds
				self.proxies.append(proxyAndTime[0])
		file.close()

		random.seed()
		proxyString = self.proxies[random.randint(0,len(self.proxies)-1)]
		proxyDivide = proxyString.strip().split(':')
		self.proxy = QNetworkProxy()
		self.proxy.setType(QNetworkProxy.HttpProxy)
		self.proxy.setHostName(proxyDivide[0])
		self.proxy.setPort(int(proxyDivide[1]))
		return self.proxy
		
	def getProxyurllib2(self, region=None):
		if region == 'us':
			file = open('/proxies/proxy.us.good.db','r')
		else:
			file = open('/proxies/proxy.good.db','r')
		for line in file:
			proxyAndTime = line.strip().split(',')
			if float(proxyAndTime[1]) < 3.0:		#Select less than 3 seconds
				self.proxies.append(proxyAndTime[0])
		file.close()

		random.seed()
		proxyString = self.proxies[random.randint(0,len(self.proxies)-1)]
		proxyDivide = proxyString.strip().split(':')
		return urllib2.ProxyHandler({'http': proxyString})
		
		# HOW TO SET:
		#self.manager = QNetworkAccessManager()
		#self.manager.setProxy(self.proxy) 
		
		#self.web_page.setNetworkAccessManager(self.manager)
		


# HOW TO USE:
# self.web_page.currentFrame().load(QNetworkRequest(QUrl('http://www.google.com/ncr')))


		
		
# Proxy Checking 
aliveThreads = 0
goodList = []
class CheckProxy ( threading.Thread ):
	def __init__ ( self, proxy ):
	  self.currentProxy = proxy
	  threading.Thread.__init__ ( self )
	  
	def run ( self ):
		global aliveThreads
		global goodList
		aliveThreads += 1
		start = time.time()
		if self.is_bad_proxy(self.currentProxy):
			print "Bad Proxy %s" % (self.currentProxy)
		else:
			print "%s is working in %.2f seconds" % (self.currentProxy,time.time()-start)
			goodList.append((self.currentProxy,time.time()-start))
		aliveThreads -= 1

	def is_bad_proxy(self,pip):    
		try:
			proxy_handler = urllib2.ProxyHandler({'http': pip})
			opener = urllib2.build_opener(proxy_handler)
			opener.addheaders = [('User-agent', 'Mozilla/5.0')]
			urllib2.install_opener(opener)
			req=urllib2.Request('http://www.google.com/ncr')  # change the URL to test here
			sock=urllib2.urlopen(req)
		except urllib2.HTTPError, e:
			print 'Error code: ', e.code
			return e.code
		except Exception, detail:
			print "ERROR:", detail
			return True
		return False

		
def mainProxyCheck():
	global aliveThreads, goodList
	socket.setdefaulttimeout(5)

	# two sample proxy IPs
	proxyList = []
		
	file = open('/proxies/proxy.db','r')
	for line in file:
		proxyList.append(line.strip())
	file.close()

	for currentProxy in proxyList:
		CheckProxy(currentProxy).start()
		
	while True:
		time.sleep(10)
		if aliveThreads <= 0:
			break
	
	newList = open('/proxies/proxy.good.db','w')
	goodList.sort()
	for line in goodList:
		newList.write(line[0] +','+str(line[1])+'\r\n')
	newList.close()
	
def mainProxyUSCheck():
	global aliveThreads, goodList
	socket.setdefaulttimeout(5)

	# two sample proxy IPs
	proxyList = []
		
	file = open('/proxies/proxy.us.db','r')
	for line in file:
		proxyList.append(line.strip())
	file.close()

	for currentProxy in proxyList:
		CheckProxy(currentProxy).start()
		
	while True:
		time.sleep(10)
		if aliveThreads <= 0:
			break
	
	newList = open('/proxies/proxy.us.good.db','w')
	goodList.sort()
	for line in goodList:
		newList.write(line[0] +','+str(line[1])+'\r\n')
	newList.close()
	
		

if __name__ == '__main__':
	if sys.argv[1] == 'us':
		mainProxyUSCheck()
	else:
		mainProxyCheck()	
    