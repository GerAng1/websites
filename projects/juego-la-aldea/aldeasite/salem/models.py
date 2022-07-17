from django.db import models


# Create your models here.
class Theme(models.Model):
    name = models.CharField('Name', max_length=100)
    prologue = models.TextField('Prologue', default="Prologue")
    descr = models.TextField('Description', default="Description")

    def __str__(self):
        return self.name


class Faction(models.Model):
    name = models.CharField('Name', max_length=100)
    descr = models.TextField('Description', default="Description")
    obj = models.TextField('Objective', default="Objective")
    theme = models.ForeignKey(Theme, on_delete=models.CASCADE)

    def __str__(self):
        return self.name


class Role(models.Model):
    name = models.CharField('Name', max_length=100)
    descr = models.TextField('Description', default="Description")
    faction = models.ForeignKey(Faction, on_delete=models.CASCADE)
    notes = models.TextField('Notes', default="None")
    tips = models.TextField('Tips', default="None")
    tier = models.IntegerField('Tier', default=1)

    def __str__(self):
        return self.name


class Player(models.Model):
    name = models.CharField('Name', max_length=100)

    def __str__(self):
        return self.name


class Village(models.Model):
    name = models.CharField('Name', max_length=100)
    occupants = models.ManyToManyField(Player, through='Membership')
    status = models.TextField("Status", default="Hasn't started.")
    date_created = models.DateField()
    theme = models.ForeignKey(Theme, on_delete=models.CASCADE)

    def __str__(self):
        return self.name


class Membership(models.Model):
    player = models.ForeignKey(Player, on_delete=models.CASCADE)
    village = models.ForeignKey(Village, on_delete=models.CASCADE)
    faction = models.ForeignKey(Faction, on_delete=models.CASCADE)
    assigned_roles = models.ManyToManyField(Role)
    alive = models.BooleanField('Alive', default=True)
    overseer = models.BooleanField('Overseer', default=False)
