from django.db import models


# Create your models here.
class Faction(models.Model):
    name = models.CharField('Name', max_length=100)
    descr = models.TextField('Description')
    obj = models.TextField('Objective')

    def __str__(self):
        return self.name


class Role(models.Model):
    name = models.CharField('Name', max_length=100)
    descr = models.TextField('Description')
    faction = models.ForeignKey(Faction, on_delete=models.CASCADE)
    limits = models.TextField('Limitations')
    xtras = models.TextField('Extras')
    rank = models.IntegerField('Rank', default=1)

    def __str__(self):
        return self.name


class Ability(models.Model):
    name = models.CharField('Name', max_length=100)
    descr = models.TextField('Description')
    belongs_to = models.ForeignKey(Role, on_delete=models.CASCADE, default=0)
    xtras = models.TextField('Extras')

    def __str__(self):
        return self.name


class Player(models.Model):
    name = models.CharField('Name', max_length=100)
    assigned_role = models.ForeignKey(Role, on_delete=models.CASCADE)
    alive = models.BooleanField('Alive', default=True)

    def __str__(self):
        return self.name
