from random import shuffle
from django.shortcuts import get_object_or_404, render
from django.contrib.auth.decorators import login_required
from django.http import HttpResponseRedirect
from django.urls import reverse

from .ratio2 import faction_sort, tag_player

from .models import Faction, Role, Theme, Player, Village

factions = Faction.objects.all()
roles_villagers = Role.objects.filter(faction=1)
roles_witches = Role.objects.filter(faction=2)
roles_lone_wolves = Role.objects.filter(faction=3)
dict_roles = {1: roles_villagers, 2: roles_witches, 3: roles_lone_wolves}


# Create your views here.
def index(request):
    return render(
        request, 'salem/index.html',
        {
            'main_script': 'index',
            'theme': Theme.objects.filter(pk=1)})


# Village creation: Step 1/3
@login_required
def new_game(request):
    if request.method == 'POST':
        new_player = request.POST.get('newPlayer')
        Player(name=new_player).save()
        return HttpResponseRedirect(reverse('salem:new-game'))

    return render(
        request, 'salem/1_new_game.html',
        {
            'main_script': 'index',
            'players': Player.objects.filter(village__isnull=True)})


# Village creation: Step 2/3
@login_required
def sort(request):
    players = Player.objects.filter(village__isnull=True)
    id_list = []

    if request.method == 'POST':
        # Storing objects in list & randomizing order:
        for player in players:
            id_list.append(int(player.id))
            player.assigned_roles.clear()

        shuffle(id_list)

        # Uses method created in ration.py to define qty of enry faction
        vllgrs_w_role, vllgrs_no_role, vllgrs_drole, mafia_w_role, mafia_no_role, num_lone_wolves = faction_sort(len(id_list))

        # Adds faction to players
        if vllgrs_drole:
            tag_player(vllgrs_w_role+vllgrs_drole, id_list, 1, True)
        else:
            tag_player(vllgrs_w_role, id_list, 1, False)
        if vllgrs_no_role:
            tag_player(vllgrs_no_role, id_list, 1, False)
        tag_player(mafia_w_role, id_list, 2, False)
        if mafia_no_role:
            tag_player(mafia_no_role, id_list, 2, False)
        tag_player(num_lone_wolves, id_list, 3, False)

        return HttpResponseRedirect(reverse('salem:sort'))

    villagers = Player.objects.filter(
        faction__id=1).filter(village__isnull=True)

    mafia = Player.objects.filter(
        faction__id=2).filter(village__isnull=True)

    lone_wolves = Player.objects.filter(
        faction__id=3).filter(village__isnull=True)

    sorted_players = {
        'villagers': villagers,
        'mafia': mafia,
        'lone_wolves': lone_wolves}

    return render(
        request, 'salem/2_sort.html',
        {
            'main_script': "rules",
            'sorted_players': sorted_players})


# Village creation: Step 3/3
@login_required
def create_village(request):
    return render(
        request, 'salem/3_create_village.html',
        {
            'main_script': "rules"})


@login_required
def overview(request):
    players = Player.objects.filter(village__isnull=True)

    if request.method == 'POST':
        new_village = request.POST.get('newVillage')
        v = Village(
            name=new_village,
            theme=Theme.objects.get(pk=1),
            overseer=request.user)

        v.save()

        for p in players:
            p.village = v
            p.save()

        return HttpResponseRedirect(reverse('salem:overview'))

    # A list of dictionaries in which each dictionary is a village w info
    villages_data = []
    villages = Village.objects.filter(overseer=request.user)

    for v in villages:
        data = {}
        data["village"] = v
        villagers = Player.objects.filter(
            faction__id=1).filter(village=v)
        mafia = Player.objects.filter(
            faction__id=2).filter(village=v)
        lone_wolves = Player.objects.filter(
            faction__id=3).filter(village=v)
        data["villagers"] = villagers
        data["mafia"] = mafia
        data["lone_wolves"] = lone_wolves

        villages_data.append(data)

    return render(
        request, 'salem/overview.html',
        {
            'main_script': 'my-villages',
            'data': villages_data})


# Documentation
def rules(request):
    return render(
        request, 'salem/docs/rules.html',
        {
            'main_script': "rules",
            'factions': factions,
            'dict_roles': dict_roles})


def all_factions(request):
    return render(
        request, 'salem/docs/factions.html',
        {
            'main_script': "factions",
            'factions': factions,
            'dict_roles': dict_roles})


def detail(request, faction_pk):
    current_faction = get_object_or_404(Faction, pk=faction_pk)

    return render(
        request, 'salem/docs/detail.html',
        {
            'main_script': "factions",
            'current_faction': current_faction,
            'factions': factions,
            'dict_roles': dict_roles})
