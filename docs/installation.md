# Installation

## Installation

1. Install this component is using **[Composer][1]**

```bash
$ composer require lin3s/admin-bundle
```

2. Enable the bundle

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new LIN3S\AdminBundle\Lin3sAdminBundle(),
        );
    }

    // ...
}
```

3. Enable the ruting

```yaml
# app/config/routing.yml
lin3s_admin:
    resource: "@Lin3sAdminBundle/Resources/config/routing.yml"
    prefix: "admin/"
```

4. Install bundle assets

```bash
# Symfony 2
$ php app/console assets:install --symlink

# Symfony 3
$ php bin/console assets:install --symlink
```

That's it!, you can now start [creating your first CRUD Admin](first_crud_admin.md)
