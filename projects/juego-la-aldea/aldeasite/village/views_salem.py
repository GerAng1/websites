from django.shortcuts import get_object_or_404, render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect
from django.urls import reverse

from .models import Faction, Role, Theme, Player

factions = Faction.objects.all()
villagers = Role.objects.filter(faction=1)
witches = Role.objects.filter(faction=2)
lone_wolves = Role.objects.filter(faction=3)


# Create your views here.
def index(request):
    return render(
        request, 'salem/index.html',
        {
            'main_script': 'index',
            'theme': Theme.objects.filter(pk=1)})


@login_required
def new_game(request):
    if request.method == 'POST':
        new_player = request.POST.get('newPlayer')
        Player(name=new_player).save()
        return HttpResponseRedirect(reverse('salem:new-game'))

    return render(
        request, 'salem/new_game.html',
        {
            'main_script': 'index',
            'players': Player.objects.filter(village__isnull=True)})


@login_required
def sort(request):
    # add sort.py HERE
    return render(request, 'salem/sort.html',)


def rules(request):
    return render(
        request, 'salem/docs/rules.html',
        {
            'main_script': "rules",
            'factions': factions,
            'dict_roles': {1: villagers, 2: witches, 3: lone_wolves}})


def all_factions(request):
    return render(
        request, 'salem/docs/factions.html',
        {
            'main_script': "factions",
            'factions': factions,
            'dict_roles': {1: villagers, 2: witches, 3: lone_wolves}})


def detail(request, faction_pk):
    current_faction = get_object_or_404(Faction, pk=faction_pk)

    return render(
        request, 'salem/docs/detail.html',
        {
            'main_script': "factions",
            'current_faction': current_faction,
            'factions': factions,
            'dict_roles': {1: villagers, 2: witches, 3: lone_wolves}})
