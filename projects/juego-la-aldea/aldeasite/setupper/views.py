from django.shortcuts import render
# from django.http import HttpResponse


# Create your views here.
def index(request):
    return render(request, 'setupper/index.html', {'main_script': 'index'})


def rules(request):
    return render(request, 'setupper/rules.html', {'main_script': 'rules'})


def factions(request):
    return render(request, 'setupper/factions.html', {'main_script': 'factions'})


def roles(request):
    return render(request, 'setupper/roles.html', {'main_script': 'roles'})
