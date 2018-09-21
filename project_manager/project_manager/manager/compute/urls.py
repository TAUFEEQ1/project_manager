from django.urls import path,include
from . import views
from rest_framework import routers

router = routers.DefaultRouter()

router.register(r'tasks',views.TasksView,'tasks')

urlpatterns = [
	path('',include(router.urls))
]
