from django.contrib import admin

# Register your models here.
from .models import Theme, Faction, Role, Player, Village

admin.site.register(Theme)
admin.site.register(Faction)
admin.site.register(Role)
admin.site.register(Player)
admin.site.register(Village)
