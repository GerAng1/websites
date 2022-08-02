from django.shortcuts import render
from django.contrib.auth import get_user_model
# from django.http import HttpResponse

from .models import Theme

User = get_user_model()
users = User.objects.all()


# Create your views here.
def index(request):
    return render(
        request, 'village/index.html',
        {
            'main_script': 'index',
            'themes': Theme.objects.all()})


def construction(request):
    return render(request, 'base_templates/errors/404.html')


def rules(request):
    return render(request, 'village/rules.html', {'main_script': 'rules'})


def factions(request):
    return render(request, 'village/factions.html', {'main_script': 'factions'})
