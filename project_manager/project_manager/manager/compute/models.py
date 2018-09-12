# This is an auto-generated Django model module.
# You'll have to do the following manually to clean this up:
#   * Rearrange models' order
#   * Make sure each model has one field with primary_key=True
#   * Make sure each ForeignKey has `on_delete` set to the desired behavior.
#   * Remove `managed = False` lines if you wish to allow Django to create, modify, and delete the table
# Feel free to rename the models, but don't rename db_table values or field names.
from django.db import models


class Assignments(models.Model):
    assid = models.AutoField(db_column='AssId', primary_key=True)  # Field name made lowercase.
    taskid = models.ForeignKey('Tasks', models.DO_NOTHING, db_column='TaskId')  # Field name made lowercase.
    workerid = models.ForeignKey('Workerids', models.DO_NOTHING, db_column='WorkerId')  # Field name made lowercase.
    archived = models.IntegerField(db_column='Archived')  # Field name made lowercase.

    class Meta:
        managed = False
        db_table = 'Assignments'


class Projects(models.Model):
    tasksnumber = models.IntegerField(db_column='TasksNumber')  # Field name made lowercase.
    startdate = models.DateField(db_column='StartDate')  # Field name made lowercase.
    enddate = models.DateField(db_column='EndDate')  # Field name made lowercase.
    duration = models.SmallIntegerField(db_column='Duration')  # Field name made lowercase.
    name = models.CharField(db_column='Name', max_length=30)  # Field name made lowercase.
    location = models.CharField(db_column='Location', max_length=200)  # Field name made lowercase.
    status = models.FloatField(db_column='Status')  # Field name made lowercase.
    archived = models.IntegerField(db_column='Archived')  # Field name made lowercase.
    projectid = models.AutoField(db_column='id', primary_key=True) #Field name made lowercase
    
    class Meta:
        managed = False
        db_table = 'Projects'


class Reports(models.Model):
    reportid = models.AutoField(db_column='ReportId', primary_key=True)  # Field name made lowercase.
    comments = models.TextField(db_column='Comments')  # Field name made lowercase.
    author = models.CharField(db_column='Author', max_length=80)  # Field name made lowercase.
    time = models.DateTimeField(db_column='Time')  # Field name made lowercase.
    taskid = models.IntegerField(db_column='TaskId')  # Field name made lowercase.
    projectid = models.IntegerField(db_column='ProjectId')  # Field name made lowercase.

    class Meta:
        managed = False
        db_table = 'Reports'


class Resources(models.Model):
    quantity = models.IntegerField(db_column='Quantity')  # Field name made lowercase.
    name = models.CharField(db_column='Name', max_length=100)  # Field name made lowercase.
    grouping = models.CharField(db_column='Grouping', max_length=200)  # Field name made lowercase.
    taskid = models.ForeignKey('Tasks', models.DO_NOTHING, db_column='TaskId')  # Field name made lowercase.
    originalquantity = models.IntegerField(db_column='OriginalQuantity')  # Field name made lowercase.
    resourceid = models.AutoField(db_column='id', primary_key=True)
    
    class Meta:
        managed = False
        db_table = 'Resources'


class Tasks(models.Model):
    taskid = models.AutoField(db_column='TaskId', primary_key=True)  # Field name made lowercase.
    projectid = models.ForeignKey(Projects, models.DO_NOTHING, db_column='ProjectId')  # Field name made lowercase.
    progress = models.FloatField(db_column='Progress', blank=True, null=True)  # Field name made lowercase.
    archived = models.IntegerField(db_column='Archived',default=0)  # Field name made lowercase.
    earlystart = models.FloatField(db_column='earlyStart')  # Field name made lowercase.
    earlyfinish = models.FloatField(db_column='earlyFinish')  # Field name made lowercase.
    latestart = models.FloatField(db_column='lateStart')  # Field name made lowercase.
    latefinish = models.FloatField(db_column='lateFinish')  # Field name made lowercase.
    duration = models.FloatField(db_column='Duration')  # Field name made lowercase.
    preceedingtasks = models.TextField(db_column='PreceedingTasks')  # Field name made lowercase. This field type is a guess.

    class Meta:
        managed = False
        db_table = 'Tasks'


class Workerids(models.Model):
    name = models.CharField(db_column='Name', max_length=40)  # Field name made lowercase.
    workhours = models.FloatField(db_column='Workhours')  # Field name made lowercase.

    class Meta:
        managed = False
        db_table = 'WorkerIds'


class OAuth(models.Model):
    uid = models.IntegerField(primary_key=True)
    names = models.CharField(max_length=40)
    email = models.CharField(max_length=40)
    phone_no = models.CharField(max_length=14)

    class Meta:
        managed = False
        db_table = 'o_auth'


class WebAuth(models.Model):
    uid = models.AutoField(primary_key=True)
    username = models.CharField(max_length=15)
    password = models.CharField(max_length=300)
    type = models.CharField(max_length=5, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'web_auth'
