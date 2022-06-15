from django.contrib import admin

# Register your models here.
from .models import Role, Player, Ability, Faction

admin.site.register(Faction)
admin.site.register(Role)
admin.site.register(Ability)
admin.site.register(Player)
