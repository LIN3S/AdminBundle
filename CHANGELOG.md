#CHANGELOG

This changelog references the relevant changes done between versions.

To get the diff for a specific change, go to https://github.com/LIN3S/AdminBundle/commit/XXX where XXX is the change hash 
To get the diff between two versions, go to https://github.com/LIN3S/AdminBundle/compare/v0.2.0...v0.3.0

* 0.4.0
    * Improvements in gulpfile
    * [BC break] Made `getEntityId()` private in `EntityId` trait.
    * [BC break] `LocaleController` removed.
    * `OptionResolver` trait added to check options exist in actions.
    * `Redirect` action type added.
    * [BC break] In configuration `printName` was renamed to `printNames` and now is an array containing `singular` and
    `plural` indexes to name the target entity.
    * [BC break] Added entity configuration parameter to `ListFieldType::render()`.
    * [BC break] Added `header()` to `ListFieldType` interface.
    * Added new `ActionsListFieldType` allowing to list actions that can be performed for an entity in each table row.
    * Minor fix in `DefaultQueryBuilder`
    * Improvements in frontend scripts
    * Added `TwigActionTranslation` and `TwigJsonDecodeFilter`
* 0.3.2
    * Styles and Twig bug fixes
* 0.3.1
    * Styles and Twig bug fixes
* 0.3.0
    * Relocated `app.min.js` and `app.min.css` to inside `javascripts.html.twig` and `stylesheets.html.twig` Twig includes.
        * Be careful overriding this twig components if you are not using ES2015.
    * Added `fonts` Twig block and remove fonts from `stylesheets` block.
    * Actions configuration tree supports nested arrays. There are encoding in json objects.
    * Added `print_name` configuration option.
    * Added `lin3s_admin_title` Twig block and remove the title itself from `lin3s_admin_actions`.
    * Replaced custom modal with Magnific Popup and created image-popup and confirm-dialog JS components.  
