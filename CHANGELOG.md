#CHANGELOG

This changelog references the relevant changes done between versions.

To get the diff for a specific change, go to https://github.com/LIN3S/AdminBundle/commit/XXX where XXX is the change hash 
To get the diff between two versions, go to https://github.com/LIN3S/AdminBundle/compare/v0.2.0...v0.3.0

* 0.3.0
    * Relocated `app.min.js` and `app.min.css` to inside `javascripts.html.twig` and `stylesheets.html.twig` Twig includes.
        * Be careful overriding this twig components if you are not using ES2015.
    * Added `fonts` Twig block and remove fonts from `stylesheets` block.
    * Actions configuration tree supports nested arrays. There are encoding in json objects.
    * Added `print_name` configuration option.
    * Added `lin3s_admin_title` Twig block and remove the title itself from `lin3s_admin_actions`.
    * Replaced custom modal with Magnific Popup and created image-popup and confirm-dialog JS components.  
