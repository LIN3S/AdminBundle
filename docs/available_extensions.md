# Available extensions

## Built-in extensions

### List fields

**string**

Calls entities' given property and prints the result as a string
 
Configuration reference:
 
|key|description|
|---|---|
|field|The property to be called. You can also nest calls using a dot as separator `getUser.getName`|

Example:

```yaml
lin3s_admin:
    entities:
        pages:
            list:   
                fields:
                    actions:
                        name: Id
                        type: string
                        options:
                            field: getId
```

**datetime**

Formats an object implementing `\DateTimeInterface` with the given format

Configuration reference:

|key|description|
|---|---|
|field|The property to be called. You can also nest calls using a dot as separator `getPost.getPublishDate`|
|format|The format to be pased to `DateTime->format()`. Default value `d M Y`| 

Example:

```yaml
lin3s_admin:
    entities:
        pages:
            list:   
                fields:
                    actions:
                        name: Id
                        type: datetime
                        options:
                            field: getDate
                            format: Y-m-d
```

**actions**

Adds a list of actions that can be performed to each list row.

Configuration reference:

|key|description|
|---|---|
|actions|An array of actions|

Example:

```yaml
lin3s_admin:
    entities:
        pages:
            actions:
                edit:
                    #...
                # .... 
            list:   
                fields:
                    actions:
                        name: Actions
                        type: actions
                        options:
                            actions:
                                - edit # Key has to be defined under actions array
```

### List filters

**text**

Allows filtering fields by given string

Example:

```yaml
lin3s_admin:
    entities:
        pages:
            actions:
                edit:
                    #...
                # .... 
            list:   
                filters:
                    id:
                        name: title
                        type: text
                        field: title
```

## Third-party

**[AdminCrudExtensions](https://github.com/LIN3S/AdminCRUDExtensionsBundle)**: Adds required actions for a CRUD application
**[AdminDDDExtensions](https://github.com/LIN3S/AdminDDDExtensionsBundle)**: Adds actions that trigger commands using a command bus
