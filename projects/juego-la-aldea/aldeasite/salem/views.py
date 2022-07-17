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
    roles = Role.objects.all()
    return render(
        request, 'salem/docs.html',
        {
            'main_script': main_script,
            'factions': factions,
            'roles': roles})


def detail(request, object_model, object_pk):
    factions = Faction.objects.all()
    roles = Role.objects.all()

    if object_model == 'Faction':
        object = get_object_or_404(Faction, pk=object_pk)
        main_script = 'factions'
    elif object_model == 'Role':
        object = get_object_or_404(Role, pk=object_pk)
        main_script = 'roles'
    else:
        raise Http404("U did somethin wrong.")

    return render(
        request, 'salem/docs.html',
        {
            'main_script': main_script,
            'object': object,
            'factions': factions,
            'roles': roles})
