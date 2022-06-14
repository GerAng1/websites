from django.db import models

# Create your models here.
class Character(models.Model):
    name = models.CharField('Name', max_length=100)
    descr = models.TextField('Description')
    faction = models.ForeignKey('Faction', Faction, on_delete=models.CASCADE)
    abils = models.ManyToManyField('Abilities', Ability)
    limits = models.TextField('Limitations')
    xtras = model.TextField('Extras')
    rank = model.IntegerField('Rank', default=1)

    def __str__(self):
        return self.name


class Player(models.Model):
    name = models.CharField('Name', max_length=100)
    character = models.ForeignKey('Character', Character, on_delete=models.CASCADE)
    alive = models.BooleanField('Alive', default=True)

    def __str__(self):
        return self.name


class Ability(models.Model):
    name = models.CharField('Name', max_length=100)
    descr = models.TextField('Description')
    xtras = model.TextField('Extras')

    def __str__(self):
        return self.name


class Faction(models.Model):
    name = models.CharField('Name', max_length=100)
    descr = models.TextField('Description')
    obj = model.TextField('Objective')

    def __str__(self):
        return self.name
