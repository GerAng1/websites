from django.contrib import admin

# Register your models here.
from .models import Role, User, Faction

admin.site.register(Faction)
admin.site.register(Role)
admin.site.register(User)
