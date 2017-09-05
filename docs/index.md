#Overview

LIN3S Admin Bundle provides a basic set of tools to build your own admin panel. Some concepts have been introduced
to add extension points to allow developers create custom logic for each of the usual features of an admin panel. Some
basic implementations of those extension points are also provided in this bundle with some common features implemented.

##The concepts

###ActionTypes

An action is any change that can be performed over a single entity. A creation, an edition, a state change... all of 
them are considered actions. Due to project requirements a variety of actions may be applied therefore, sometimes is not
enough to use common CRUD actions. Even though, we provide built in new, edit and delete actions available under 
`LIN3S\AdminBundle\Action\Type` namespace and work well with Symfony Forms.

In case you want to implement a custom action for your entity, you need to extend `LIN3S\AdminBundle\Action\ActionType`
interface. This `ActionType` will receive a set of parameters and is expected to return a `Symfony\Component\HttpFoundation\Response`
Common responses are a rendered twig template or a `RedirectResponse`.

ActionTypes are usually generic and need to be associated with an entity in the configuration.

[More details](custom_action.md)

###ListFieldType

A list field type is an implementation that defines how a list table column will be rendered. This bundle implements
`StringListFieldType` as an example. This field type tries to render a column for the given field passed in the options
array as field parameter.

In case you want to write your own list field column rendered you need to implement
`LIN3S\AdminBundle\ListFields\ListFieldType`. The `render()` method is expected to return an already escaped
string, can be HTML but be careful as it will be printed in the list without been escaped.

ListFieldTypes are usually generic and need to be associated with an entity in the configuration.

[More details](custom_list_field.md)

###ListFilters

A list filter is an implementation that defines how an a filter input has to be rendered. This works together with the
`AdminRepository` that receives the submitted form that was built using list filter types.

[More details](custom_list_filter.md)

### Configuration reference

[Configuration reference docs](configuration_reference.md)
