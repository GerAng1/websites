# Generated by Django 4.0.5 on 2022-07-15 11:08

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('setupper', '0003_remove_faction_id_remove_player_id_remove_role_id_and_more'),
    ]

    operations = [
        migrations.AlterField(
            model_name='player',
            name='assigned_roles',
            field=models.ManyToManyField(blank=True, null=True, to='setupper.role'),
        ),
        migrations.AlterField(
            model_name='role',
            name='faction',
            field=models.ForeignKey(blank=True, null=True, on_delete=django.db.models.deletion.CASCADE, to='setupper.faction'),
        ),
    ]