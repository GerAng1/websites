# Generated by Django 4.0.5 on 2022-06-14 15:03

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='Faction',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=100, verbose_name='Name')),
                ('descr', models.TextField(verbose_name='Description')),
                ('obj', models.TextField(verbose_name='Objective')),
            ],
        ),
        migrations.CreateModel(
            name='Role',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=100, verbose_name='Name')),
                ('descr', models.TextField(verbose_name='Description')),
                ('limits', models.TextField(verbose_name='Limitations')),
                ('xtras', models.TextField(verbose_name='Extras')),
                ('rank', models.IntegerField(default=1, verbose_name='Rank')),
                ('faction', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='setupper.faction')),
            ],
        ),
        migrations.CreateModel(
            name='Player',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=100, verbose_name='Name')),
                ('alive', models.BooleanField(default=True, verbose_name='Alive')),
                ('assigned_role', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='setupper.role')),
            ],
        ),
        migrations.CreateModel(
            name='Ability',
            fields=[
                ('id', models.BigAutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=100, verbose_name='Name')),
                ('descr', models.TextField(verbose_name='Description')),
                ('xtras', models.TextField(verbose_name='Extras')),
                ('belongs_to', models.ForeignKey(default=0, on_delete=django.db.models.deletion.CASCADE, to='setupper.role')),
            ],
        ),
    ]
