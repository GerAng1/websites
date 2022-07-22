from django.urls import path
from . import views_village

app_name = 'village'
urlpatterns = [
    path('', views_village.index, name='index'),
    path('404', views_village.construction, name='construction'),
    path('docs/rules', views_village.rules, name='rules'),
    path('docs/factions', views_village.factions, name='factions'),
    path('docs/roles', views_village.roles, name='roles'),
]
