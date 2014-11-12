Server Application & API based on [Symfony 2 REST Edition](https://packagist.org/packages/gimler/symfony-rest-edition)

Symfony REST Edition
========================
Welcome to the Symfony REST Edition - a fully-functional Symfony2
application that you can use as the skeleton for your new applications.

This document contains information on how to download, install, and start
using Symfony. For a more detailed explanation, see the [Installation][1]
chapter of the Symfony Documentation.

1) Installing the REST Edition
----------------------------------

When it comes to installing the Symfony REST Edition, you have the
following options.

### Use Composer (*recommended*)

As Symfony uses [Composer][2] to manage its dependencies, the recommended way
to create a new project is to use it.

If you don't have Composer yet, download it following the instructions on
http://getcomposer.org/ or just run the following command:

    curl -s http://getcomposer.org/installer | php

Then, use the `create-project` command to generate a new Symfony application:

    php composer.phar create-project gimler/symfony-rest-edition --stability=dev path/to/install

Composer will install Symfony and all its dependencies under the
`path/to/install` directory.

### Download an Archive File

To quickly test Symfony, you can also download an [archive][3] of the Standard
Edition and unpack it somewhere under your web server root directory.

If you downloaded an archive "without vendors", you also need to install all
the necessary dependencies. Download composer (see above) and run the
following command:

    php composer.phar install

2) Checking your System Configuration
-------------------------------------

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

Access the `config.php` script from a browser:

    http://localhost/path/to/symfony/app/web/config.php

If you get any warnings or recommendations, fix them before moving on.

3) Set Symfony Permissions
-------------------------------------

Make sure the Permissions are setup on your machine

From http://symfony.com/doc/current/book/installation.html

1. Using ACL on a system that supports chmod +a

Many systems allow you to use the chmod +a command. Try this first, and if you get an error - try the next method. This uses a command to try to determine your web server user and set it as HTTPDUSER:

```
$ rm -rf app/cache/*
$ rm -rf app/logs/*

$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo chmod +a "$HTTPDUSER allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
$ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
```

2. Using ACL on a system that does not support chmod +a

Some systems don't support chmod +a, but do support another utility called setfacl. You may need to enable ACL support on your partition and install setfacl before using it (as is the case with Ubuntu). This uses a command to try to determine your web server user and set it as HTTPDUSER:

```
$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
```


3) Parameters
-------------------------------------

Use parameters.dist.yml to set the parameters for your database.

What's inside?
---------------

The Symfony REST Edition is configured with the following defaults:

  * Twig is the only configured template engine;

  * Translations are activated

  * Doctrine ORM/DBAL is configured;

  * Swiftmailer is configured;

  * Annotations for everything are enabled.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * [**AsseticBundle**][12] - Adds support for Assetic, an asset processing
    library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][15] (in dev/test env) - Adds code generation
    capabilities

  * **AcmeDemoBundle** (in dev/test env) - A demo bundle with some example
    code

  * [**FOSRestBundle**][16] - Adds rest functionality

  * [**NelmioApiDocBundle**][17] - Add API documentation features

  * [**BazingaHateoasBundle**][18] - Adds HATEOAS support

  * [**HautelookTemplatedUriBundle**][19] - Adds Templated URIs (RFC 6570) support

  * [**BazingaRestExtraBundle**][20]

Enjoy!

[1]:  http://symfony.com/doc/2.1/book/installation.html
[2]:  http://getcomposer.org/
[3]:  https://github.com/gimler/symfony-rest-edition/archive/master.zip
[4]:  http://symfony.com/doc/2.1/quick_tour/the_big_picture.html
[5]:  http://symfony.com/doc/2.1/index.html
[6]:  http://symfony.com/doc/2.1/bundles/SensioFrameworkExtraBundle/index.html
[7]:  http://symfony.com/doc/2.1/book/doctrine.html
[8]:  http://symfony.com/doc/2.1/book/templating.html
[9]:  http://symfony.com/doc/2.1/book/security.html
[10]: http://symfony.com/doc/2.1/cookbook/email.html
[11]: http://symfony.com/doc/2.1/cookbook/logging/monolog.html
[12]: http://symfony.com/doc/2.1/cookbook/assetic/asset_management.html
[15]: http://symfony.com/doc/2.1/bundles/SensioGeneratorBundle/index.html
[16]: https://github.com/FriendsOfSymfony/FOSRestBundle
[17]: https://github.com/nelmio/NelmioApiDocBundle
[18]: https://github.com/willdurand/BazingaHateoasBundle
[19]: https://github.com/hautelook/TemplatedUriBundle
[20]: https://github.com/willdurand/BazingaRestExtraBundle
