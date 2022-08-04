from django.db import models
from django.contrib.auth import get_user_model

User = get_user_model()


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
    symbol = models.CharField('Symbol', max_length=10, null=True, blank=True)

    def __str__(self):
        return self.name


class Role(models.Model):
    name = models.CharField('Name', max_length=100)
    descr = models.TextField('Description', default="Description")
    faction = models.ForeignKey(
        Faction, on_delete=models.CASCADE, null=True, blank=True)
    notes = models.TextField('Notes', null=True, blank=True)
    tips = models.TextField('Tips', null=True, blank=True)
    tier = models.IntegerField('Tier', default=1)

    def __str__(self):
        return self.name

    def is_low_tier(self):
        return self.tier > 2


class Village(models.Model):
    name = models.CharField('Name', max_length=100)
    status = models.TextField("Status", default="About to begin.")
    theme = models.ForeignKey(
        Theme, on_delete=models.CASCADE)
    date_created = models.DateField(auto_now_add=True)
    overseer = models.ForeignKey(
        User, on_delete=models.CASCADE, null=True, blank=True)

    def __str__(self):
        return self.name


class Player(models.Model):
    name = models.CharField('Name', max_length=100)
    village = models.ForeignKey(
        Village, on_delete=models.CASCADE, null=True, blank=True)
    faction = models.ForeignKey(
        Faction, on_delete=models.CASCADE, null=True, blank=True)
    assigned_roles = models.ManyToManyField(Role, blank=True)
    alive = models.BooleanField('Alive', default=True)

    def __str__(self):
        return self.name

    def get_roles(self):
        return self.assigned_roles.all()
