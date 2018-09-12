from rest_framework import serializers
from .models import Tasks

class TasksSerializer(serializers.ModelSerializer):
	class Meta:
		model = Tasks
		fields = ('projectid','taskid','duration','preceedingtasks','earlystart','latestart','earlyfinish','latefinish')

