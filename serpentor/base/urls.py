"""urlconf for the base application"""

from django.conf.urls.defaults import url, patterns


urlpatterns = patterns('serpentor.base.views',
    url(r'^$', 'home', name='home'),
)
