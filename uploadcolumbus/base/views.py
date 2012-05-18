""" Views for the base application """

from django.shortcuts import render_to_response, HttpResponseRedirect
from django.template import RequestContext
from uploadcolumbus.base.models import *
from django.forms.formsets import formset_factory
from session_csrf import anonymous_csrf
from uploadcolumbus.base.upload import *


@anonymous_csrf
def home(request):
    """ Default view for the root """

    """ TODO:
            Handle POST for uploads
                Add Song Files to a mailbox
                Add band information to a mailbox
    """

    initialData = {}

    if request.method == 'POST':
            band_form = BandForm(request.POST)
            song_form = SongForm(request.POST, request.FILES)
            song_forms = SongForm(request.POST, request.FILES)
            initialData = {'bound': True, }
            if band_form.is_valid() and song_form.is_valid() and song_forms.is_valid():
                handle_uploaded_files(request.FILES, request.POST)
                return HttpResponseRedirect('/thanks-columbus/')
    else:
        band_form = BandForm()
        song_form = SongForm()
        song_forms = formset_factory(SongForm, extra=4)

    bandData = {'band_form': band_form,
                'song_form': song_form,
                'song_forms': song_forms, }

    initialData = dict(initialData.items() + bandData.items())
    c = RequestContext(request, initialData)

#    return render_to_response('base/home.html', context_instance=RequestContext(request))
    return render_to_response('base/home.html', c)


def thanks(request):
    c = RequestContext(request)
    return render_to_response('base/thanks.html',c)


def legal(request):
    c = RequestContext(request)
    return render_to_response('base/legal.html',c)
