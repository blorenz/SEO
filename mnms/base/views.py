""" Views for the base application """

from django.shortcuts import render_to_response, HttpResponse, get_object_or_404
from django.template import RequestContext
from mnms.base.models import Page, Project

def home(request):
    """ Default view for the root """
    return render_to_response('base/home.html',
        context_instance=RequestContext(request))

def page(request,slug):
    p = get_object_or_404(Page,slug=slug)
    return HttpResponse(p.content)
