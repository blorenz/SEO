""" Basic models, such as user profile """
from django.db import models

from markdown import markdown


class Project(models.Model):
    name = models.CharField(max_length=255, unique=True)

    def __unicode__(self):
        return self.name


class Page(models.Model):
    title = models.CharField(max_length=255)
    slug = models.SlugField(unique=True)
    content = models.TextField()

    content_html = models.TextField(blank=True, null=True, editable=False)

    project = models.ForeignKey(Project)

    @models.permalink
    def get_absolute_url(self):
        return ('page_view', (), {'slug': self.slug, })

    def __unicode__(self):
        return self.title

    def save(self, force_insert=False, force_update=False):
        self.content_html = markdown(self.content)
        super(Page, self).save(force_insert, force_update)
