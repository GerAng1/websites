from django.urls import path
from . import views_salem

app_name = 'salem'
urlpatterns = [
    path('', views_salem.index, name='index'),
    path('new-game/', views_salem.new_game, name='new-game'),
    # path('edit/', views.edit, name='edit'),
    # path('recap/', views.recap, name='recap'),
    path('docs/<str:main_script>', views_salem.docs, name='docs'),
    path('docs/<str:object_model>/<int:object_pk>', views_salem.detail, name='detail'),
]
