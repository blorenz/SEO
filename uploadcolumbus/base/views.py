""" Views for the base application """

from django.shortcuts import render_to_response
from django.template import RequestContext
from uploadcolumbus.base.models import *
from django.forms.formsets import formset_factory
from session_csrf import anonymous_csrf


@anonymous_csrf
def home(request):
    """ Default view for the root """

    """ TODO:
            Handle POST for uploads
                Add Song Files to a mailbox
                Add band information to a mailbox
    """

    song_forms = formset_factory(SongForm, extra=4)
    band_form = BandForm()
    song_form = SongForm()

    initialData = {'band_form': band_form,
                'song_form': song_form,
                'song_forms': song_forms, }

    c = RequestContext(request, initialData)

    if request.method == 'POST':
            band_form = BandForm(request.POST)
            song_form = SongForm(request.POST, request.FILES)
            song_forms = SongForm(request.POST, request.FILES)
            if band_form.is_valid() and song_form.is_valid() and song_forms.is_valid():
                #handle_uploaded_file(request.FILES['file'])
                return HttpResponseRedirect('/thanks-columbus/')
            else:
                band_form = BandForm()
                song_form = SongForm()
                song_forms = formset_factory(SongForm, extra=4)

#    return render_to_response('base/home.html', context_instance=RequestContext(request))
    return render_to_response('base/home.html', c)
