# Advanced configuration

To adapt the admin to your needs some extension points have been created. These, allow reusability and 
 ease of use to create scalable and flexible admin panels.
 
Take a look to the following example config:

```yaml
# app/Resources/config.tml
lin3s_admin:
    entities:
        pages:
            name:
                singular: 'Page'
                plural: 'Pages'
            class: App\Domain\Model\Page\Page
            actions:
                new:
                    name: 'New page'
                    type: crud_new
                    options:
                        form: AppBundle\Form\Type\PageType
                edit:
                    name: 'Edit page'
                    type: crud_edit
                    options:
                        form: AppBundle\Form\Type\PageType
                # .... 
            list:   
                fields:
                    id:
                        name: id
                        type: string
                        options:
                            field: id
                    actions:
                        name: lin3s_admin.list.table.actions
                        type: actions
                        options:
                            actions: ['edit']
                    # .... 
                filters:
                    id:
                        name: id
                        type: text
                        field: id
                    # ....
                global_actions: ['new']
        another_entity:
            # ....
            class: AppBundle\Entity\AnotherEntity
            # ....
```

As you have noticed, different concepts such as actions, fields, filters and global actions show up. The configuration
above defines how our admin panel should behave for our `Page` entity. This has been defined under 
`lin3s_admin.entities.pages.class` using our fully qualified class name (FQCN). Multiple entities can be defined using 
`lin3s_admin.entities` as a key value array.

Bellow the FQCN, you can find the **actions**. These define the manipulations that can be performed to our entity, the 
`Page`. Each action will require three values:
  
  * The **name**, a string that will be translated and shown as reference to the action in the admin.
  * The **type**, is a reusable manipulator that will perform actions to our entity. No actions exist by default in 
  AdminBundle package but you can use [existing actions](available_extensions.md) or [create a new one](custom_action.md).
  In the example above we are using [CRUD Extensions Bundle](https://github.com/LIN3S/AdminCRUDExtensionsBundle)
  * The **options** fields is an array that holds different values for each action type. Check the reference of each 
  action for further info
 
Each entity will have a list containing all the data related to the target entity. This list can also be configured in 
 three ways; list fields, list filters and global actions.
 
**List fields**

List fields array (`lin3s_admin.entities.pages.list.field` in the example above) holds all columns that need to be shown 
in the pages entity list. Each column can be rendered in a diferent way using a different **type** and can have a **name**
that will be used as table header of that column. Therefore each list field entry will have the following options:

  * The **name**, a string that will be translated and shown as table header of the current column.
  * The **type**, is a reusable column type that will render the content accordingly. AdminBundle has some 
  [built-in list fields](available_extensions.md) or you can [create a new one](custom_list_field.md).
    In the example above we are using built-in 
    [string](https://github.com/LIN3S/AdminBundle/blob/master/src/LIN3S/AdminBundle/Extension/ListField/StringListFieldType.php)
    and 
    [actions](https://github.com/LIN3S/AdminBundle/blob/master/src/LIN3S/AdminBundle/Extension/ListField/ActionsListFieldType.php)
    field types.
  * The **options** fields is an array that holds different values for each list field type. Check the reference of each 
    list field for further info

**List filters**

List filters array (`lin3s_admin.entities.pages.list.filters` in the example above) holds all filters that can be selected 
in the pages entity list. Each filter will render a custom form input for each use case and will be placed in a dropdown
list over the table. Each list filter entry will have the following obtions

  * The **name**, a string that will be translated and shown in the dropdown filter menu.
  * The **type**, selects a reusable filter type. AdminBundle has some
  [built-in list filters](available_extensions.md) or you can [create a new one](custom_list_filter.md).
    In the example above we are using built-in 
    [text](https://github.com/LIN3S/AdminBundle/blob/master/src/LIN3S/AdminBundle/Extension/ListFilter/TextListFilterType.php)
    filter.
  * The **options** fields is an array that holds different values for each list filter type. Check the reference of each 
    list filter for further info

**Global actions**

Global actions are just a reference to the existing actions of our target entity. This array sets a multiple actions 
that will be added to the top right side of the list page. Useful when you need for example a "New" button that isn`t 
related directly to one entity entry.

To use it just add the name of the action you want to add to the `lin3s_admin.entities.<your-entity>.list.global_actions`
array.
