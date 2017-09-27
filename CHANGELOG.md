# CHANGELOG

This changelog references the relevant changes done between versions.

To get the diff for a specific change, go to https://github.com/LIN3S/AdminBundle/commit/XXX where XXX is the change hash 
To get the diff between two versions, go to https://github.com/LIN3S/AdminBundle/compare/v0.4.0...v0.5.0

* 0.6.0
    * Made AdminBundle compatible with multiple persistence strategies; for now is compatible with DoctrineORM and PDO.
    * Added sticky behaviour to the form right sidebar.
    * Made JavaScript and CSS code compatible with IE11.
    * Imported `parsleyjs` module in the js entry file.
    * Updated lin3s-front-foundation dependency from v0.6.0 to v0.6.1.
    * Updated lin3s-front-foundation dependency from v0.5.0 to v0.6.0.
    * Made translatable the value of the string list field content.
    * Moved the `javascripts` Twig block from top to bottom in the body.
    * Extracted panel independent Twig component.
    * Improved button component adding type parameter.
    * Full refactor of AdminBundle's JavaScript.
        * Removed jQuery dependency
        * Migrated code to ES2015 standards using `class` approach
    * [BC break] Refactored Twig components.
        * Button, filter flash_message and form_collection components are moved from partial to components directory so,
        please, check out before upgrade if your project extends this components.
* 0.5.1
    * Updated Webpack to v3 to solve bug related with the production build
    * Improved general js code to avoid minor bugs
* 0.5.0
    * Made compatible with Twig v2.
    * Changed collection buttons for "a" to avoid unexpected submit events.
    * Removed hardcoded lang from DOM.
    * Fixed bug related with nested collection's prototype.
    * Added parsley for error validations.
    * Added default order by implementation for the list view.
    * Minor improvements inside form collection and remove coupled froala styles.
    * Added portuguese translations.
    * Made date list field nullable.
    * Made translatables filters and list fields.
    * Decoupled with Twig include the `lin3s_admin_global_action` block in list view.
    * Added `id` getter method in the Entity configuration class.
    * Added novalidate by default in the admin form theme.
    * Added HandleCommandActionType.
    * [BC break] Refactored the whole js and scss files.
    * [BC break] Changed LIN3SAdminBundle to Lin3sAdminBundle so, be caution with `lin3_s` configuration, now it is `lin3s_admin`.
    * Added fr translation messages.
    * Refactored and unified registries.
    * [BC break] Made configuration, dependency injection, extension, registry final.
    * [BC break] `lin3s_admin.action`, `lin3s_admin.list_field` and `lin3s_admin.list_filter` tags now require an `alias`.
    * [BC break] In config, `class` was replaced by `type` and now config type `alias` must be used instead service name.
     for action, list field and list filters. Check [reference_configuration](docs/reference_configuration.md) for further info.
    * [BC break] Moved configuration type implementations to `Extension` folder.
    * [BC break] Removed Redirect, EntityId and OptionResolver traits.
    * [BC break] Moved NewActionType, EditActionType and DeleteActionType to LIN3SAdminCRUDExtensionBundle.
    * [BC break] Moved HandleCommandActionType to LIN3SAdminDDDExtensionBundle.
    * Added `lin3s_admin_global_action` block in list view.
    * [BC break] Removed code used by external dependencies from list views.
    * [BC break] Renamed `lin3s_admin_actions` to `lin3s_admin_global_actions` in list view.
    * [BC break] Removed new.html.twig and edit.html.twig and unified in form.html.twig page.
    * Changed routing strategy now it's /{entity}/{id}/{action}.
    * [BC break] Full change of configuration namespaces:
    
| Previous                                            | New                                                   |
| --------                                            | ---                                                   |
| LIN3S\AdminBundle\Action\Action                     | LIN3S\AdminBundle\Configuration\Model\Action          |
| LIN3S\AdminBundle\Action\ActionType                 | LIN3S\AdminBundle\Configuration\Type\ActionType       |
| LIN3S\AdminBundle\Action\ActionType                 | LIN3S\AdminBundle\Configuration\Type\ActionType       |
| LIN3S\AdminBundle\Configuration\EntityConfiguration | LIN3S\AdminBundle\Configuration\Model\Entity          |
| LIN3S\AdminBundle\ListField\ListFieldType           | LIN3S\AdminBundle\Configuration\Type\ListFieldType    |
| LIN3S\AdminBundle\ListFilter\ListFilter             | LIN3S\AdminBundle\Configuration\Model\ListFilter      |
| LIN3S\AdminBundle\ListFilter\ListFilterType         | LIN3S\AdminBundle\Configuration\Type\ListFilterType   |    
* 0.4.1
    * Removed Sylius registry dependency.
* 0.4.0
    * Improvements in gulpfile.
    * [BC break] Made `getEntityId()` private in `EntityId` trait.
    * [BC break] `LocaleController` removed.
    * `OptionResolver` trait added to check options exist in actions.
    * `Redirect` action type added.
    * [BC break] In configuration `printName` was renamed to `printNames` and now is an array containing `singular` and
    `plural` indexes to name the target entity.
    * [BC break] Added entity configuration parameter to `ListFieldType::render()`.
    * [BC break] Added `header()` to `ListFieldType` interface.
    * Added new `ActionsListFieldType` allowing to list actions that can be performed for an entity in each table row.
    * Minor fix in `DefaultQueryBuilder`.
    * Improvements in frontend scripts.
    * Added `TwigActionTranslation`.
    * Deprecated `TwigJsonDecodeFilter`.
    
* 0.3.2
    * Styles and Twig bug fixes.
* 0.3.1
    * Styles and Twig bug fixes.
* 0.3.0
    * Relocated `app.min.js` and `app.min.css` to inside `javascripts.html.twig` and `stylesheets.html.twig` Twig includes.
        * Be careful overriding this twig components if you are not using ES2015.
    * Added `fonts` Twig block and remove fonts from `stylesheets` block.
    * Actions configuration tree supports nested arrays. There are encoding in json objects.
    * Added `print_name` configuration option.
    * Added `lin3s_admin_title` Twig block and remove the title itself from `lin3s_admin_actions`.
    * Replaced custom modal with Magnific Popup and created image-popup and confirm-dialog JS components.  
