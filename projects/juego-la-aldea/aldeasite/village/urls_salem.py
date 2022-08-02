from django.urls import path
from . import views_salem

app_name = 'salem'
urlpatterns = [
    path('', views_salem.index, name='index'),
    path('new-game', views_salem.new_game, name='new-game'),
    path('new-game/sort', views_salem.sort, name='sort'),
    path('new-game/create', views_salem.create_village, name='create-village'),
    # path('edit/', views.edit, name='edit'),
    # path('recap/', views.recap, name='recap'),
    path('docs/', views_salem.rules, name='rules'),
    path('docs/factions', views_salem.all_factions, name='factions'),
    path('docs/details/<int:faction_pk>/', views_salem.detail, name='detail'),
]
