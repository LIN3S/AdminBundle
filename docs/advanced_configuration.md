#Advanced configuration

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
`lin3s_admin.entities.pages.class` using our fully qualified class name (FQCN).

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

**List filters**

**Global actions**
