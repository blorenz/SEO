"""urlconf for the base application"""

from django.conf.urls.defaults import url, patterns


urlpatterns = patterns('mnms.base.views',
    url(r'^$', 'home', name='home'),
    url(r'(?P<slug>.*?)/$', 'page', name='page_view')
)
