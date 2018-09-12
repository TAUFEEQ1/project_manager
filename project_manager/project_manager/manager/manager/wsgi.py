"""
WSGI config for manager project.

It exposes the WSGI callable as a module-level variable named ``application``.

For more information on this file, see
https://docs.djangoproject.com/en/2.1/howto/deployment/wsgi/
"""

import os
import sys
from django.core.wsgi import get_wsgi_application

sys.path.append('/home/nsamba/projects/global/project_manager/project_manager/manager')
sys.path.append('/home/nsamba/projects/global/project_manager/project_manager/manager/manager')
sys.path.append('/home/nsamba/projects/global/project_manager/project_manager/lib/python3.6/')
sys.path.append('/home/nsamba/projects/global/project_manager/project_manager/lib/python3.6/site-packages/')

os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'manager.settings')

application = get_wsgi_application()
