Step 1: Setting up the bundle
=============================

A) Download the Bundle
----------------------

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

.. code-block:: bash

    $ composer require jacoz/symfony-api-bundle:dev-master

B) Enable the Bundle
--------------------

Then, enable the bundle by adding the following line in the ``app/AppKernel.php`` file of your project:

.. code-block:: php

    // app/AppKernel.php
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...
                new Jacoz\Symfony\ApiBundle\JacozSymfonyApiBundle(),
            );

            // ...
        }
    }
