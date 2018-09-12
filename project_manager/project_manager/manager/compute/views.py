from django.shortcuts import render
from rest_framework import viewsets
from .models import Tasks
from .serializers import TasksSerializer
from rest_framework.response import Response
from criticalpath import Node
import json

class TasksView(viewsets.ModelViewSet):

	queryset = Tasks.objects.all()
	serializer_class = TasksSerializer
		
	def list(self, request, *args, **kwargs):
		queryset,project_duration,criticaltasks=self.get_queryset()
		serializer = self.get_serializer(queryset,many=True)
		data1 = { 'task_data':serializer.data, 'duration':project_duration,'criticaltasks':criticaltasks}
		return Response(data1)
	def get_queryset(self):
		projid = self.request.query_params.get("projid")
		tasks = Tasks.objects.filter(projectid=projid)
		activity = list()
		p = Node(projid)
		for i in range(len(tasks)):
			activity.append(p.add(Node(tasks[i].taskid, duration=tasks[i].duration,lag=0)))
		
		for i in range(len(tasks)):
			preceedingtasks = json.loads(tasks[i].preceedingtasks)
			for j in preceedingtasks:
				for k in range(len(tasks)):
					if j == tasks[k].taskid:
						break;
				p.link(activity[k],activity[i])

		p.update_all()
		criticalway = p.get_critical_path()
		criticaltasks = list()
		for i in range(len(criticalway)):
			criticaltasks.append(criticalway[i].name)
		for i in range(len(tasks)):
			tasks[i].earlystart = activity[i].es
			tasks[i].latestart = activity[i].ls
			tasks[i].earlyfinish = activity[i].ef
			tasks[i].latefinish = activity[i].lf
		return tasks,p.duration,criticaltasks
		

	