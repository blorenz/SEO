"""urlconf for the base application"""

from django.conf.urls.defaults import url, patterns


urlpatterns = patterns('uploadcolumbus.base.views',
    url(r'^$', 'home', name='home'),
    url(r'^thanks-columbus', 'thanks', name='thanks'),
    url(r'^legal$', 'legal', name='legal'),
)
