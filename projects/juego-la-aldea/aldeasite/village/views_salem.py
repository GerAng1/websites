from django.http import Http404
from django.shortcuts import get_object_or_404, render

from .models import Faction, Role, Theme

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


def new_game(request):
    return render(
        request, 'salem/new_game.html')


def docs(request, main_script):
    if main_script == 'rules':
        return render(
            request, 'salem/docs/rules.html',
            {
                'main_script': main_script,
                'factions': factions,
                'dict_roles': {1: villagers, 2: witches, 3: lone_wolves}})
    else:
        return render(
            request, 'salem/docs/docs.html',
            {
                'main_script': main_script,
                'factions': factions,
                'dict_roles': {1: villagers, 2: witches, 3: lone_wolves}})


def detail(request, object_model, object_pk):
    if object_model == 'factions':
        object = get_object_or_404(Faction, pk=object_pk)

        return render(
            request, 'salem/docs/faction.html',
            {
                'main_script': object_model,
                'object': object,
                'factions': factions,
                'dict_roles': {1: villagers, 2: witches, 3: lone_wolves}})

    elif object_model == 'roles':
        object = get_object_or_404(Role, pk=object_pk)

        return render(
            request, 'salem/docs/role.html',
            {
                'main_script': object_model,
                'object': object,
                'factions': factions,
                'dict_roles': {1: villagers, 2: witches, 3: lone_wolves}})

    else:
        raise Http404("U did somethin wrong.")
