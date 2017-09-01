# Creating a custom list filter

A list filter is an implementation that defines how an a filter input has to be rendered. This works together with the
`AdminRepository` that receives the submitted form that was built using list filter types.

1. Create a new class implementing `LIN3S\AdminBundle\Configuration\Type\ListFilterType`
1. Add the class to Dependency Container with `lin3s_admin.list_filter_type` tag name and the desired alias.
1. Reference the created service with the alias in the property `type` of list > filters > field_name of your `admin.yml`

## Render function

>TODO
