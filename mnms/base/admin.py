from mnms.base.models import *
from django.contrib import admin


class PageAdmin(admin.ModelAdmin):
    prepopulated_fields = {'slug': ['title']}

    class Media:
        js = ("js/tinymce/jscripts/tiny_mce/tiny_mce.js", "js/tiny.js", )

admin.site.register(Project)
admin.site.register(Page, PageAdmin)
