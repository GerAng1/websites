from django.contrib import admin

# Register your models here.
from .models import Character, Player, Ability, Faction

admin.site.register(Character)
admin.site.register(Player)
admin.site.register(Ability)
admin.site.register(Faction)
