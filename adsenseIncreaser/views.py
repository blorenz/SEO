# Create your views here for adsenseIncreaseer
from django.template import Context, loader
from django.template import RequestContext
from django.template.loader import render_to_string
from django.shortcuts import get_object_or_404, render_to_response, redirect
from django.core.urlresolvers import reverse
from django.contrib.auth import authenticate, login as django_login, logout as django_logout
from django.http import HttpResponseRedirect, HttpResponse
import tasks
import adsenseCost.analyze as aca
import json
import simplejson


def home(request):
	return HttpResponse("Hello, world. You're at the home.")
	
def check(request):
	if request.method == "GET":
		taskNumber = request.GET.get("task", False)
		if taskNumber:
			ads = aca.getTaskResults(taskNumber)
			response = {}
			if ads:
				# Convert the list to HTML for display
				response[ 'list' ] = render_to_string( 'adsenseIncreaser/includes/list_display.html',
																   { 'results_list': ads, 
																	}, context_instance = RequestContext( request ) )
				response[ 'done' ] = 1    # If you know there are more results coming later, could make this 0
			else:
				response[ 'done' ] = 0

			return( HttpResponse( simplejson.dumps( response ), mimetype='text/html' ))
		else:
			return HttpResponse("Nothing")
	return HttpResponse("Nothing")
			
def index(request):
	if request.method == "GET":
		domain = request.GET.get("domain", False)
		if domain:
			domainResults = None
			taskNumber = tasks.getDomainInfo.delay(domain)
			return render_to_response('adsenseIncreaser/index.html', {'domain': domain, 'taskNumber': taskNumber.task_id}, context_instance=RequestContext(request))
	
	return render_to_response('adsenseIncreaser/index.html', {}, context_instance=RequestContext(request))
	