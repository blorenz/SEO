""" Basic models, such as user profile """
from django.db import models
from django import forms
from form_utils.widgets import ImageWidget


GENRES = [('Bluegrass','Bluegrass'),
('Blues','Blues'),
('Christian','Christian'),
('Classical','Classical'),
('Comedy','Comedy'),
('Country','Country'),
('Dance/Electronic','Dance/Electronic'),
('Folk','Folk'),
('Funk','Funk'),
('Instrumental','Instrumental'),
('Jazz','Jazz'),
('Latino','Latino'),
('Pop','Pop'),
('R&B/Soul','R&B/Soul'),
('Rap','Rap'),
('Reggae','Reggae'),
('Rock','Rock'),
('Singer/Songwriter','Singer/Songwriter')]


class SongForm(forms.Form):
    song_name = forms.CharField(max_length=100, error_messages={'required': 'What\'s the name of the song?.'}, required=False)
    song_file = forms.FileField(error_messages={'required': 'You need to submit the song file.'}, required=False)
    song_lyrics = forms.CharField(widget=forms.Textarea, required=False)


class BandForm(forms.Form):
    band_name = forms.CharField(max_length=100, error_messages={'required': 'Your band needs a name.'})
    band_email = forms.EmailField()#error_message={'required': 'Give us an email to contact you at.'})
    band_genres = forms.ChoiceField(choices=GENRES)
    band_bio = forms.CharField(widget=forms.Textarea, error_messages={'required': 'Tell us a little about your band.'}, required=False)
    band_gigs = forms.CharField(widget=forms.Textarea, required=False)
    band_image = forms.ImageField(widget=ImageWidget, required=False)
