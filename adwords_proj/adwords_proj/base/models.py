""" Basic models, such as user profile """
from django.db import models


class TrendField(models.model):
    pass


class Keyword(models.model):
    keyword = models.CharField()
    match_type = models.IntegerField()  # Broad, Exact or Phrase
    global_monthly = models.IntegerField()
    local_monthly = models.IntegerField()
    cpc = models.DecimalField()  # Get the approximate CPC
    gsn = models.IntegerField()  # Bonus for Google Search Network searches
    trend = TrendField()  # embedded
