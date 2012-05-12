""" Basic models, such as user profile """
from django.db import models
from django import forms


class SongForm(forms.Form):
    song_name = forms.CharField(max_length=100)
    song_file = forms.FileField()
    song_lyrics = forms.CharField(widget=forms.Textarea)


class BandForm(forms.Form):
    band_name = forms.CharField(max_length=100)
    band_bio = forms.CharField(widget=forms.Textarea)
    band_gigs = forms.CharField(widget=forms.Textarea)
