Getting Started With SeoBundle
==============================

SeoBundle allows you to load the route to customize to have a better natural referencing on search engines.

Prerequisites
-------------

This version of the bundle requires Symfony 3.2+.

Installation
------------

Installation is a quick (I promise!) 6 step process:

1. Download SeoBundle
2. Enable SeoBundle
3. Update your database schema
4. Add tags on your routing for detect the SEO
5. Launch the route search command
6. Configure SEO tags for pages in your admin page

Step 1: Download SeoBundle
~~~~~~~~~~~~~~~~~~~~~~~~~~

Download SeoBundle with repository:

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
            new NBGraphics\SeoBundle\NBGraphicsSeoBundle(),
            // ...
        );
    }

Step 3: Update your database schema
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code-block:: bash

    $ php bin/console doctrine:schema:update --force

Step 4: Add tags on your routing for detect the SEO
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In routing, just add defaults options (seo & page)::

    <?php
    // src/YourBundle/Controller/YourController.php

    /**
     * @Route(
     *     "/",
     *     name="name_route",
     *     defaults={
     *          "seo": true,
     *          "page": "Page Accueil"
     *     }
     *  )
     */
    public function homePageAction()
    {
        return $this->render('@NBGraphicsSeoBundle/home.html.twig');
    }

Step 5: Launch the route search command
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now, launch the command line for import the route to customize:

.. code-block:: bash

    $ php bin/console seo:load-routes

All routes tagged seo: true are now imported in your SEO admin !

Step 6: Configure SEO tags for pages in your admin page
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Add the render menu SEO available with::

    {% if app.request.attributes.get('_route') starts with "seo" %}
        {{ render(controller('NBGraphicsSeoBundle:Seo:menu', {'active':true} )) }}
    {% else %}
        {{ render(controller('NBGraphicsSeoBundle:Seo:menu', {'active':false} )) }}
    {% endif %}

You can now configure your SEO pages in admin page anywhere !