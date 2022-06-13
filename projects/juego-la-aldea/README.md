# First Django Project
**Mafia-inspired game setupper.**

### aldeasite/

- Django project

within are apps & manage.py.  

Until now, nothing has been added to manage.py

#### apps  
Each created app has Models, Views and Templates.  

##### aldeasite/  
Main app.  
- has settings.py where:
    - INSTALLED_APPS are defined
        - any new app created must be added here
    - Database config is made
- has urls.py where:
    - you need to add the URL of any app you create.
        - you need to `from django.urls import include` then `path('{{path_name (usually appname)}}/', include('{{app_name}}.urls')),`  

##### setupper/  
Handles receiving the quantity of players, characters that'll play, assignment of characters to the players, documentation & some tips for being the Overseer.

- **Models**
    - Character
        - Description (CharField max_length = 1000?)
        - Abilities (List)
        - Limitations
        - Extra notes

    - Player
        - Name
        - Character (foreignKey)

    - Abilities ***?***
        - Character (foreignKey)

    - Resources/Objects
        - Brief Description

- **Views/Templates**
    - index.html
        - Add players & characters
    - recap.html
        - View inserted info.
        - Download as PDF
    - edit.html
        - make changes
    - docs.html
        - List of all docs

##### login/  (??) (FUTURE RELEASE)
In order to display the specific setup they created.
