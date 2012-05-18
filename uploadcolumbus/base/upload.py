# Python imports
import os.path
import md5
import time

# Django imports
from django.core.files import File
from django.core.files.storage import default_storage
from django.core.files.base import ContentFile

# Local imports
from uploadcolumbus import settings


def save_file(fv):
        pass
        #content_type = fv.content_type
        #filename = gen_md5() + ".mp3"
        #SimpleUploadedFile(filename, fv.read(), content_type)


def write_forms(box, dict_forms):
    boxi = os.path.join(settings.MEDIA_ROOT, box)
    os.mkdir(boxi)
    the_file = open(os.path.join(boxi, 'form.txt'), 'w')
    for s in dict_forms.items():
        the_file.write(s[0] + '\t' + s[1] + '\n')
    the_file.close()


def handle_uploaded_files(dict_files,dict_forms):
    ''' The intention of this function is to save all files that are in the dict_files.
        Each form submission will need a path that will have a md5 generated 'dropbox' for the files.

        media root/
            |______dfsk32fdsk3203dsdfsa32dsfds/
            |                   |_______ band_image
            |                   |_______ song_file
            |                   |_______ song_file_n
            |______iounl23083204kjljlk2340822/
                                |_______ band_image
                                |_______ song_file
                                |_______ song_file_n
    '''
    # Create the dropbox
    m = md5.new()
    m.update(str(time.time()))

    # Start populating the dropbox
    write_forms(m.hexdigest(), dict_forms)
    for s in dict_files.keys():
        img_file = dict_files.get(s)
        img_name = os.path.join(m.hexdigest(), s + '_' + img_file.name)
        img_content = img_file.read()
        content_file = ContentFile(img_content)
        default_storage.save(img_name, content_file)
