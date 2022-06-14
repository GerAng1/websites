from django.shortcuts import get_object_or_404, render
from django.http import HttpResponse


# Create your views here.
def index(request):
    return HttpResponse("Hello, world. You're at the index.")


def setup(request):
    return HttpResponse("You're about to create a new game! At the SETUP.")


def docs(request, char_name):
    char = get_object_or_404(Character, pk=name)
    # return render(request, 'setupper/docs.html', {'char': char})
    return HttpResponse("You're reading the DOCS.")
