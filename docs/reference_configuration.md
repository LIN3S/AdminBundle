#Configuration reference

```yaml
lin3_s_admin:
    entities:
        pages:
            name:
                singular: 'Page'
                plural: 'Pages'
            class: App\Domain\Model\Page\Page
            actions:
                new:
                    name: 'New page'
                    type: new
                    options:
                        form: AppBundle\Form\Type\PageType
                edit:
                    name: 'Edit page'
                    type: edit
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

```

> String fields will go through trans filter and therefore are translatable
