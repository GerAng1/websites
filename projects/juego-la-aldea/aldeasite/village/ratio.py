"""Algorithm that proposes a ratio between factions for the game Mafia."""

from math import ceil
from random import shuffle

from .models import Faction, Role, Player


MAX_ROLES_MAFIA = 5
MAX_ROLES_VILLAGERS = 15
MAX_ROLES_LONEWOLVES = 4


# Assigns faction to player
def tag_player(qty, list, faction_id, double):
    """Assigns roles to players & then faction."""

    # Find all roles of faction
    role_ids = []
    xtra_roles = []
    if double:
        for r in Role.objects.filter(faction=faction_id).exclude(tier__gt=3):
            role_ids.append(r.id)
        for xtra in Role.objects.filter(faction=1).filter(tier__gt=3):
            xtra_roles.append(xtra.id)
        shuffle(xtra_roles)
    else:
        for r in Role.objects.filter(faction=faction_id).exclude(tier__gt=3):
            role_ids.append(r.id)

    shuffle(role_ids)

    while(qty > 0):
        id = list.pop(0)
        p = Player.objects.get(pk=id)

        # Assign role
        assigned_role = role_ids.pop(0)

        p.assigned_roles.add(Role.objects.get(pk=assigned_role))

        # only adds extra role to low_tier roles
        if xtra_roles and p.assigned_roles.all()[0].is_low_tier():
            assigned_role = xtra_roles.pop(0)
            p.assigned_roles.add(Role.objects.get(pk=assigned_role))

        # Assign faction
        p.faction = Faction.objects.get(pk=faction_id)
        p.save()
        qty -= 1

    # return list


def role_checker(people, faction):
    """Checks if number of people in faction
    exceed that of current roles with special abilities.

    Returns:
    - int of people with a Role
    - int with peeople without a Role
    """

    with_role = people
    without_role = 0
    wdouble_role = 0

    if faction == "Villagers" and with_role > MAX_ROLES_VILLAGERS:
        with_role = MAX_ROLES_VILLAGERS
        without_role = people - with_role

    elif faction == "Villagers" and with_role < MAX_ROLES_VILLAGERS:
        # print("\n\n¿Permitir doble rol en Aldeanos? (EXPERIMENTAL)")
        # print("No hay información concreta de que esto sea muy OP...")
        # double_trouble = input("¿Avanzar con doble rol? [S/n]: ")

        # if double_trouble[0].lower() == 's':
        wdouble_role = MAX_ROLES_VILLAGERS - with_role

        MAX_DOUBLE_VILLAGERS = len(Role.objects.filter(faction=1).filter(tier__gt=3))
        if wdouble_role > MAX_DOUBLE_VILLAGERS:
            wdouble_role = MAX_DOUBLE_VILLAGERS

        with_role -= wdouble_role

    elif faction == "Mafia" and people > MAX_ROLES_MAFIA:
        with_role = MAX_ROLES_MAFIA
        without_role = people - with_role

    # This shouldn't happen
    else:
        pass

    return with_role, without_role, wdouble_role


def faction_sort(total):
    """Determines numbers of people on each faction.

    Returns:
    - int of villagers with role
    - int of villagers without role
    - int of villagers with double role
    - int of mafia with role
    - int of mafia without role
    - int of lone wolves
    """
    # Assuming lone_wolves always play:
    lone_wolves = 4 if ceil(total / 5) > 4 else ceil(total / 5)
    # else:
    # lone_wolves = 0

    mafia = round((total - lone_wolves) / 4.01)
    villagers = total - lone_wolves - mafia

    vllgrs_w_role, vllgrs_no_role, vllgrs_drole = role_checker(villagers, "Villagers")
    mafia_w_role, mafia_no_role, mafia_drole = role_checker(mafia, "Mafia")

    return vllgrs_w_role, vllgrs_no_role, vllgrs_drole, mafia_w_role, mafia_no_role, lone_wolves
