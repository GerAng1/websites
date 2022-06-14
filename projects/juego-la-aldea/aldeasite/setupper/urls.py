from django.urls import path
from . import views

app_name = 'setupper'
urlpatterns = [
    path('', views.index, name='index'),
    path('setup/', views.setup, name='setup'),
    # path('edit/', views.edit, name='edit'),
    # path('recap/', views.recap, name='recap'),
    path('docs/', views.docs, name='docs'),
]
