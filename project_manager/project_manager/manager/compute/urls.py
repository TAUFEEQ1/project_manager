from django.urls import path,include
from . import views
from rest_framework import routers

router = routers.DefaultRouter()

router.register('tasks',views.TasksView,'tasks-list')

urlpatterns = [
	path('',include(router.urls))
]
