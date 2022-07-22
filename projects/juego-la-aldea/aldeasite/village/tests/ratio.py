"""Algorithm that proposes a ratio between factions for the game Mafia."""

from math import ceil


MAX_ROLES_MAFIA = 5
MAX_ROLES_VILLAGERS = 15
MAX_DOUBLE_VILLAGERS = 4
MAX_ROLES_LONEWOLVES = 4


def role_checker(people, faction):
    """Checks if number of people in faction
    exceed that of current roles with special abilities.

    Returns:
    - int of people with a Role
    - int with peeople without a Role
    """

    with_role = people
    without_role = 0

    if faction == "Villagers" and people > MAX_ROLES_VILLAGERS:
        with_role = MAX_ROLES_VILLAGERS
        without_role = people - with_role

    elif faction == "Mafia" and people > MAX_ROLES_MAFIA:
        with_role = MAX_ROLES_MAFIA
        without_role = people - with_role

    return with_role, without_role


print("\n\nAlgoritmo de proporción (BETA) \n")

print("¿Jugar con solitarios?")
print("Los Solitarios son su propia facción y su único objetivo es ser la última persona viva.")
lone_wolves_play = input("¿Jugar con solitarios? [S/n]: ")

total = int(input("Num. jugadores: "))

if lone_wolves_play[0].lower() == 's':
    lone_wolves = 4 if ceil(total / 5) > 4 else ceil(total / 5)
else:
    lone_wolves = 0

mafia = round((total - lone_wolves) / 4.01)
villagers = total - lone_wolves - mafia

mafia_w_role, mafia_no_role = role_checker(mafia, "Mafia")
villagers_w_role, villagers_no_role = role_checker(villagers, "Villagers")

if villagers_w_role < MAX_ROLES_VILLAGERS:
    print("\n\n¿Permitir doble rol en Aldeanos? (EXPERIMENTAL)")
    print("No hay información concreta de que esto sea muy OP...")
    double_trouble = input("¿Avanzar con doble rol? [S/n]: ")

    if double_trouble[0].lower() == 's':
        villagers_wdouble_role = MAX_ROLES_VILLAGERS - villagers_w_role

        if villagers_wdouble_role > MAX_DOUBLE_VILLAGERS:
            villagers_wdouble_role = MAX_DOUBLE_VILLAGERS

        villagers_w_role -= villagers_wdouble_role

print("\n\nDistribución recomendada:")

if villagers_wdouble_role > 0:
    print(f"Aldeanos con doble Rol: {villagers_wdouble_role}")

print(f"Aldeanos con Rol: {villagers_w_role}")

if villagers_no_role > 0:
    print(f"Aldeanos sin Rol: {villagers_no_role}")

print(f"Brujas con Rol: {mafia_w_role}")
if mafia_no_role > 0:
    print(f"Brujas sin Rol: {mafia_no_role}")

print(f"Solitarios: {lone_wolves}")

print("\nDistribución:")
print(f"Aldeanos: {round((villagers_w_role + villagers_no_role) / total * 100, 2)}%")
print(f"Brujas: {round((mafia_w_role + mafia_no_role) / total * 100, 2)}%")

if lone_wolves > 0:
    print(f"Solitarios: {round(lone_wolves / total * 100, 2)}%")

print(f"\nProporción: {round(villagers / mafia, 2)} Aldeanos por cada Bruja")
