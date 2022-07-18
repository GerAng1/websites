"""Script to understand how to access dicts."""

my_dict = {'dict': {'key1': 'object1', 'key2': 'object2', 'key3': 'object3'}}

for key in my_dict:
    for object in my_dict[key]:
        print(my_dict[key][object])
