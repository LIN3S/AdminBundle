# Creating a custom action

An action is any change that can be performed over a single entity. A creation, an edition, a state change... all of 
them are considered actions. Due to project requirements a variety of actions may be applied therefore, sometimes is not
enough to use common CRUD actions. Even though, we provide built in new, edit and delete actions available under 
`LIN3S\AdminBundle\Action\Type` namespace and work well with Symfony Forms.

To create an action: 
1. Extend `LIN3S\AdminBundle\Action\ActionType` interface. This `ActionType` will receive  a set of parameters and is 
expected to return a `Symfony\Component\HttpFoundation\Response` Common responses are a rendered twig template or a 
`RedirectResponse`.
1. Add the class to Dependency Container with `lin3s_admin.action` tag name and the desired alias.
1. Define the action in `admin.yml` in the entity where is going to be used. Example:
```yaml
my_entity:
    class: AdminBundle\Entity\MyEntity
    name:
        singular: admin.my_entity.name.singular
        plural: admin.my_entity.name.plural
    actions:
        my_action:
            type: my_custom_action_alias
            options:
                name: MyAction
                catchable_exceptions: AdminBundle\Entity\MyEntity\Exception\MyCustomException: admin.exception.my_entity.error_message
    ...
```

## The parameters
* entity: The entity affected by this action. 
* config: The entity configuration.
* request: The HTTP request
* options: An array with the declared options.

## Action scope
Once defined an action for an entity can be attached to global scope of the list or locally to each row of content.

### Global
Adding an action in global scope creates a top button in list view with the name defined and iterates over all the 
entity rows calling axecute method per each.

Example: 
```yaml
taxon_header:
    class: AdminBundle\Entity\MyEntity
    name:
        ...
    actions:
        my_action:
            type: my_action
            options:
                name: MyAction
    list:
        fields:
            ...
        filters:
            ...
        global_actions: ["new", "my_action"]
```

### Row
Adding an action as row level creates a button in the action list column per row to launch itself affecting only to the
row entity where the link button has been triggered.

Example: 
```yaml
taxon_header:
    class: AdminBundle\Entity\TaxonHeader\TaxonHeader
    name:
        ...
    actions:
        my_action:
            type: aitor_action
            options:
                name: MiAccion
    list:
        fields:
            my_fancy_entity_field:
                name: admin.my_entity.list.fields.my_fancy_entity_field
                type: string
                options:
                    field: my_fancy_entity_field
            actions:
                name: lin3s_admin.list.table.actions
                type: actions
                options:
                    actions: ['edit', 'my_action']
        filters:
            ...
        global_actions: ...
```

