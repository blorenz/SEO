#!/usr/bin/env python

import os
import sys

import json
import binascii
import urllib2
import urllib
import random
import xml.dom.minidom
import lxml.html as lh
from lxml.html import soupparser
from proxySetter import ProxyCheck
import socket
import urlparse
import threading
import time
from coolQ import coolQ
from kombu.connection import BrokerConnection
from kombu.messaging import Exchange, Queue, Consumer, Producer
from celery.messaging import establish_connection

#http://pagead2.googlesyndication.com/pagead/ads?output=xml&oe=UTF-8&adtest=on&adsafe=high&num_ads=40&pvt=pvt&client=ca-google&url=http%3A//www.easydietplanstoloseweight.com/three-day-fruit-detox-diet.html&random=984884333

#http://googleads.g.doubleclick.net/aclk?sa=l&ai=BYK27fr4lTprGIufLsQfF3OWSDKj1oyryop3zD8CNtwGQ1icQCBgIIPtPKBQ4AFCUpNj-A2DJ3tOLxKTgEIgBAaABjo-7_gOyASF3d3cuZWFzeWRpZXRwbGFuc3RvbG9zZXdlaWdodC5jb23IAQHaAUhodHRwOi8vd3d3LmVhc3lkaWV0cGxhbnN0b2xvc2V3ZWlnaHQuY29tL3RocmVlLWRheS1mcnVpdC1kZXRveC1kaWV0Lmh0bWyAAgGoAwHoA8gD6APWCegDjAfoA8kD9QMAAADE&num=8&sig=AOD64_16bwY48gMdtxwVp0JewY3N4MvMmw&client=ca-google&adurl=http://www.cardiorenew.com/index.php" 

def another_custom_cmp(w1, w2):
		return cmp(w1[4], w2[4])

class adsenseCostGetter(threading.Thread):
	def __init__(self, ad, q_name, commandLine=False):
		if commandLine:
			connection = BrokerConnection(hostname="localhost",
                                  userid="guest",
                                  password="guest",
                                  virtual_host="/")
		else:
			connection = establish_connection()
		self.cQ = coolQ(connection,queue_name=q_name)
		self.ad = handleAd(ad)
		self.domain = getAdUrl(ad)
		self.result = None
		threading.Thread.__init__(self)
		
	def get_result(self):
		return self.result
		
	def run(self):
			#print 'Started a thread'
			cost = self.getCost(self.domain)
			#print 'Started second in thread' 
			#clean cost
			cost = cost.replace("$","")
			cost = cost.replace("NA","0.00")
			cost = cost.replace('N/A',"0.00")
			#
			self.ad.append(unicode(cost))
			print self.ad
			self.cQ.ad2q({'title':self.ad[0],
						'url':self.ad[1],
						'visible_url':self.ad[2],
						'line2':self.ad[3],
						'line3':self.ad[4],
						'cpc':self.ad[5]})
			self.cQ.close()
			
			
	def getCost(self, domain):
		while True:
			pc = ProxyCheck()
			opener = urllib2.build_opener(pc.getProxyurllib2())
			opener.addheaders = [('User-agent', 'Mozilla/5.0')]
			urllib2.install_opener(opener)
			
			data = {}
			data['q'] = domain
			data['tab'] = 'domain-overview'
			url_values = urllib.urlencode(data)
			url = 'http://www.keywordspy.com/research/search.aspx'
			full_url = url + '?' + url_values

			try:
				f = urllib2.urlopen(full_url)
				data = f.read()
				dom = soupparser.fromstring(data)
				#print dom.text_content()
				print 'finding'
				element = dom.xpath("//table[@id='sumData']/descendant::tr[4]/td[2]")
				#if len(element):
				#	print element[0].text_content()
				break
				
				
			except urllib2.HTTPError:
				print 'Error!'
			except urllib2.URLError:
				print 'Error!'
			except:
				print 'Error!'
			
			
		if element:
			return element[0].text_content()
		else:
			return '0.00'

            
			

def getText(nodelist):
    rc = []
    for node in nodelist:
        if node.nodeType == node.TEXT_NODE:
            rc.append(node.data)
    return ''.join(rc)

def handleAdPreview(slideshow,commandLine):
	ads = slideshow.getElementsByTagName("AD")
	handleAds(ads,commandLine)
	#return sorted(handleAds(ads), key=lambda ad: ad[5], reverse=True)


def handleAds(ads,commandLine):
	newAds = []
	threads = []
	finalAds = []
	
	print 'Ready to start threads!'
	# Phase 1: Start ALL threads
	for ad in ads:
		ss = adsenseCostGetter(ad,'testAds',commandLine)
		ss.start()
		threads.append([ss,ad])
	
	# Phase 2: Wait for ALL threads to come back with costs
	#for thr in threads:	
	#	thr[0].join()
	#	finalAds.append([thr[1],thr[0].get_result()])
	
	# Phase 3: Send results to process add
	#for ad in finalAds:
	#	newAds.append(handleAd(ad[0],ad[1]))
		
	return newAds

def getUrl(ad):
	return ad.getAttribute("visible_url")

def getAdUrl(ad):
	return urlparse.parse_qs(ad.getAttribute("url"))['adurl'][0]

def handleAd(ad):
	newAd = []
	newAd.append(getUrl(ad))
	newAd.append(getAdUrl(ad))
	newAd.append(getText(ad.getElementsByTagName("LINE1")[0].childNodes))
	newAd.append(getText(ad.getElementsByTagName("LINE2")[0].childNodes))
	newAd.append(getText(ad.getElementsByTagName("LINE3")[0].childNodes))
	return newAd 

def getTaskResultsCallback(thing):
	print thing
	
def getTaskResults(taskId):
	cQ = coolQ(establish_connection(),"testAds")
	ads = []
	for i in xrange(5):
		ads.append(cQ.process())
	return ads

def getXMLFromGoogle(domain,commandLine=False):
	socket.setdefaulttimeout(2)
	random.seed()
	while True:
		pc = ProxyCheck(region='us')
		opener = urllib2.build_opener(pc.getProxyurllib2(region='us'))
		opener.addheaders = [('User-agent', 'Mozilla/5.0')]
		urllib2.install_opener(opener)
		data = {}
		data['output'] = 'xml'
		data['oe'] = 'UTF-8'
		data['adtest'] = 'on'
		data['adsafe'] = 'high'
		data['num_ads'] = '20'
		data['pvt'] = 'pvt'
		data['client'] = 'ca-google'
		data['output'] = 'xml'
		data['url'] =  domain
		data['random'] = str(random.randint(1000,99999999))
		url_values = urllib.urlencode(data)
		url = 'http://pagead2.googlesyndication.com/pagead/ads'
		full_url = url + '?' + url_values
		
		try:
			f = urllib2.urlopen(full_url)
			data = f.read()
			break
		except:
			print 'Error with proxy trying to get ads!!'
			


	print 'Got the data, time to parse'
	dom = xml.dom.minidom.parseString(data)
	return handleAdPreview(dom,commandLine=commandLine)

	
def consume():

		connection = BrokerConnection(hostname="localhost",
                                  userid="guest",
                                  password="guest",
                                  virtual_host="/")
		cQ = coolQ(connection,"testAds")
		cQ.process(callback,32233)
		
		

if __name__ == '__main__':
	if sys.argv[1] == 'testc':
		consume()
	elif sys.argv[1] == "testp":
		produce()
	else:
		getXMLFromGoogle('http://www.easydietplanstoloseweight.com',commandLine=True)
	#for l in theList:
	#	print l