from django.urls import path
from . import views

app_name = 'setupper'
urlpatterns = [
    path('', views.index, name='index'),
    path('docs/rules', views.rules, name='rules'),
    path('docs/factions', views.factions, name='factions'),
    path('docs/roles', views.roles, name='roles'),
]
