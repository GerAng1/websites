from django.shortcuts import get_object_or_404, render
from django.http import HttpResponse

from .models import Faction


# Create your views here.
def index(request):
    return render(request, 'setupper/index.html')


def setup(request):
    return HttpResponse("You're about to create a new game! At the SETUP.")


def docs(request):
    return render(request, 'setupper/maindocs.html')


def details(request):
    return HttpResponse("Here will bee the deetz.")


def factions(request):
    table = (Faction.objects.all())
    return render(request, 'setupper/docs.html', {'table': table})
