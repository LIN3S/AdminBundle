#Configuration reference

```yaml
lin3_s_admin:
    entities:
        pages:
            name:
                # .... Strings are translated passing them through trans filter .... #
                singular: admin.page.name.singular
                plural: admin.page.name.plural
            class: App\Domain\Model\Page\Page
            actions:
                new:
                    class: lin3s_admin.action.type.new
                    options:
                        name: lin3s_admin.action.edit
                        form: App\Infrastructure\Web\Symfony\Form\Type\Page\PageType
                edit:
                    class: lin3s_admin.action.type.edit
                    options:
                        name: lin3s_admin.action.edit
                        form: App\Infrastructure\Web\Symfony\Form\Type\Page\PageType
                # .... Add as many actions as you need .... #
                # .... Check options of each action type, can be different .... #
            list:
                fields:
                    id:
                        class: lin3s_admin.list_field_type.string
                        options:
                            name: 'Id'
                            field: id
                    actions:
                        class: lin3s_admin.list_field_type.actions
                        options:
                            actions: ['edit']
                            name: lin3s_admin.list.table.actions
                    # .... Add as many fields as you need .... #
                    # .... Check options of each list field type, can be different .... #
                filters:
                    Id:
                        class: lin3s_admin.list_filter_type.text
                        field: id
                    # .... Add as many filters as you need .... #
                globalActions: ['new']

```
