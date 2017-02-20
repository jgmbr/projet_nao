Getting Started With NewsBundle
===============================

NewsBundle allows you to manage your articles on your website !

Prerequisites
-------------

This version of the bundle requires Symfony 3.2+.

Installation
------------

Installation is a quick (I promise!) 5 step process:

1. Download NewsBundle
2. Enable NewsBundle
3. Update your database schema
4. Configure list page
5. Configure admin page

Step 1: Download NewsBundle
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Download NewsBundle with repository:

.. code-block:: bash

    $ git clone [urlRepository] .

Step 2: Enable the bundle
~~~~~~~~~~~~~~~~~~~~~~~~~

Enable the bundle in the kernel::

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new NBGraphics\NewsBundle\NBGraphicsNewsBundle(),
            // ...
        );
    }

Step 3: Update your database schema
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

    $ php bin/console doctrine:schema:update --force

Step 4: Configure list page
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Add the render menu News with::

    {{ render(controller('NBGraphicsNewsBundle:Pages:menuTop')) }}

Step 5: Configure admin page
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Add the render menu admin News available with::

    {% if app.request.attributes.get('_route') starts with "article" %}
        {{ render(controller('NBGraphicsNewsBundle:Article:menu', {'active':true} )) }}
    {% else %}
        {{ render(controller('NBGraphicsNewsBundle:Article:menu', {'active':false} )) }}
    {% endif %}

You can now configure your articles pages in admin page anywhere !