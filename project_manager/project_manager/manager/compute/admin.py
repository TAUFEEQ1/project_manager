from django.contrib import admin
from .models import Assignments,Projects,Tasks,Resources,Reports,Workerids

# Register your models here.

admin.site.register([Assignments,Projects,Tasks,Resources,Reports,Workerids])