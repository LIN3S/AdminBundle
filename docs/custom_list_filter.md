# Creating a custom list filter

A list filter is an implementation that defines how an a filter input has to be rendered. This works together with the
`AdminRepository` that receives the submitted form that was built using list filter types.

Using filters, you can implement customized search based on any field of your entities, although those already 
provided `text` and `date` may be enough for most project, perhaps you will need to customize or create more complex 
filters for your project specific business logic. 

1. Create a new class implementing `LIN3S\AdminBundle\Configuration\Type\ListFilterType`
1. Add the class to Dependency Container with `lin3s_admin.list_filter_type` tag name and the desired alias.
1. Reference the created service with the alias in the property `type` of list > filters > field_name of your `admin.yml`

## Render function

You can handle the header representation of the row within this function, these are the parameters available:
* filter: A `ListFilter` entity of the filter.
* currentValue: The value to be filtered.
* options: An array of options.

Text filter example:

```php
    $attributes = $currentValue !== null ? ' value="' . $currentValue . '"' : '';
    
    foreach ($options['attrs'] as $attrName => $attr) {
        $attributes .= ' ' . $attrName . '="' . $attr . '"';
    }
    
    return sprintf('<input %s type="text" data-filter-field="%s">', $attributes, $filter->field());
```


