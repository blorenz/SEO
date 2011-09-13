from celery.decorators import task
import adsenseCost.analyze as an

@task()
def add(x, y):
    return x + y
	
@task()
def getDomainInfo(domain):
	an.getXMLFromGoogle(domain)
	
@task()
def getResults(taskId):
	an.getTaskResults(taskId)