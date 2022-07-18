from django.http import Http404
from django.shortcuts import get_object_or_404, render

from .models import Faction, Role


# Create your views here.
def index(request):
    return render(
        request, 'salem/index.html',
        {'main_script': 'index'})


def new_game(request):
    return render(
        request, 'salem/new_game.html')


def docs(request, main_script):
    factions = Faction.objects.all()
    witches = Role.objects.filter(faction=1)
    villagers = Role.objects.filter(faction=2)
    lone_wolves = Role.objects.filter(faction=3)
    return render(
        request, 'salem/docs.html',
        {
            'main_script': main_script,
            'factions': factions,
            'dict_roles': {1: witches, 2: villagers, 3: lone_wolves}})


def detail(request, object_model, object_pk):
    factions = Faction.objects.all()
    witches = Role.objects.filter(faction=1)
    villagers = Role.objects.filter(faction=2)
    lone_wolves = Role.objects.filter(faction=3)

    if object_model == 'Faction':
        object = get_object_or_404(Faction, pk=object_pk)
        main_script = 'factions'
    elif object_model == 'Role':
        object = get_object_or_404(Role, pk=object_pk)
        main_script = 'roles'
    else:
        raise Http404("U did somethin wrong.")

    return render(
        request, 'salem/details.html',
        {
            'main_script': main_script,
            'object_model': object_model,
            'object': object,
            'factions': factions,
            'dict_roles': {1: witches, 2: villagers, 3: lone_wolves}})
