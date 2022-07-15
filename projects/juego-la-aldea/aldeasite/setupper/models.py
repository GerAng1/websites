from django.db import models


# Create your models here.
class Faction(models.Model):
    name = models.CharField('Name', max_length=100, primary_key=True)
    descr = models.TextField('Description')
    obj = models.TextField('Objective')

    def __str__(self):
        return self.name


class Role(models.Model):
    name = models.CharField('Name', max_length=100, primary_key=True)
    descr = models.TextField('Description')
    faction = models.ForeignKey(Faction, on_delete=models.CASCADE, blank=True, null=True)
    notes = models.TextField('Notes', default="None")
    tips = models.TextField('Tips', default="None")
    tier = models.IntegerField('Tier', default=1)

    def __str__(self):
        return self.name


class User(models.Model):
    name = models.CharField('Name', max_length=100)
    assigned_roles = models.ManyToManyField(Role, blank=True)
    alive = models.BooleanField('Alive', default=True)

    def __str__(self):
        return self.name
