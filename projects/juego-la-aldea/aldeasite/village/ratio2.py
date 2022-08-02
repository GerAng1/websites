from math import ceil


def faction_sort(total):
    # Assuming lone_wolves always play:
    lone_wolves = 4 if ceil(total / 5) > 4 else ceil(total / 5)
    # else:
    # lone_wolves = 0

    mafia = round((total - lone_wolves) / 4.01)
    villagers = total - lone_wolves - mafia

    return villagers, mafia, lone_wolves
