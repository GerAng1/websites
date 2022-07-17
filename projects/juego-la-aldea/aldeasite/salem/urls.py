from django.urls import path
from . import views

app_name = 'salem'
urlpatterns = [
    path('', views.index, name='index'),
    path('new-game/', views.new_game, name='new-game'),
    # path('edit/', views.edit, name='edit'),
    # path('recap/', views.recap, name='recap'),
    path('docs/<str:main_script>', views.docs, name='docs'),
    path('docs/<str:object_model>/<str:object_pk>', views.detail, name='detail'),
]
