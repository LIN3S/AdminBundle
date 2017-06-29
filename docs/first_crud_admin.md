# First CRUD Admin
 
As LIN3S Admin is a lightweight and unopinionated admin, you need a small extension to create your first CRUD admin.

1. Installing the CRUD extension

```bash
$ composer require lin3s/admin-crud-extension-bundle
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
            new LIN3S\AdminCRUDExtensionsBundle\Lin3sAdminCRUDExtensionsBundle,
        );
    }

    // ...
}
```

3. Add routing config:

```yaml
# app/config/routing.yml

lin3s_admin:
    resource: "@Lin3sAdminBundle/Resources/config/routing.yml"
    prefix: "admin/"
```
4. Create your first entity

```php
<?php

// src/AppBundle/Entity/Product.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;

/** @Entity */
class Product
{
    /**
     * @Id
     * @Column(type="string")
     * @GeneratedValue(strategy="UUID")
     */
    private $id;

    /** @Column(length=140) */
    private $title;

    public function id()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
```

5. Create the schema for our Product

```bash
$ doctrine:schema:update --force
```

> Make sure you have correctly [configured the database connection](http://symfony.com/doc/current/doctrine.html#configuring-the-database)

6. Create a form for our entity

```php
<?php

// src/AppBundle/Form/Type/ProductType.php

<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Product;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_merge($view->vars, [
            'groups' => [
                [
                    'name'   => 'Product',
                    'fields' => [
                        'title',
                    ],
                ],
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class
        ]);
    }
}

```

7. Add admin configuration

```yaml
# app/config/config.yml

lin3s_admin:
    entities:
        products:
            name:
                singular: Product
                plural: Products
            class: AppBundle\Entity\Product
            actions:
                new:
                    type: crud_new
                    options:
                        name: 'Create product'
                        form: AppBundle\Form\Type\ProductType
                edit:
                    type: crud_edit
                    options:
                        name: 'Edit product'
                        form: AppBundle\Form\Type\ProductType
                delete:
                    type: crud_delete
                    options:
                        name: 'Delete product'
                        form: AppBundle\Form\Type\ProductType
            list:
                fields:
                    id:
                        type: string
                        options:
                            name: 'Id'
                            field: id
                    title:
                        type: string
                        options:
                            name: 'Title'
                            field: getTitle
                    actions:
                        type: actions
                        options:
                            actions:
                                - 'edit'
                                - 'delete'
                filters:
                    title:
                        type: text
                        name: 'Title'
                        field: title
                global_actions: ['new']
```

8. Access the product list in /admin/products

To take full advantage of this admin you may can check the [advanced configuration docs](docs/advanced_configuration.md)
