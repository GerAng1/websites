from django.shortcuts import get_object_or_404, render
from django.http import HttpResponse


# Create your views here.
def index(request):
    return render(request, 'setupper/index.html')


def setup(request):
    return HttpResponse("You're about to create a new game! At the SETUP.")


def docs(request):
    return render(request, 'setupper/docs.html')


def detail(request, object_id):
    return HttpResponse("You're reading the Detail.")
