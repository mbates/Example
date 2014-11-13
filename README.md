## Example Symfony2 / AngularJS Apps

### Install Symfony
- Copy symfony/app/config/parameters.dist.yml to symfony/app/config/parameters.yml and update the details in the file.
- Globally install composer https://getcomposer.org/doc/00-intro.md then run this from the symfony directory

```
composer install
```

### Symfony Permissions

From http://symfony.com/doc/current/book/installation.html

Setting up Permissions

One common issue is that the app/cache and app/logs directories must be writable both by the web server and the command line user. On a UNIX system, if your web server user is different from your command line user, you can run the following commands just once in your project to ensure that permissions will be setup properly.

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

### Symfony Assets
Create a symlink from app/Resources/public to thew web folder

```
$ ln -s /path/to/symfony/app/Resources/public/img /path/to/syfony/web/img
```

### Setup Database

Add a User that has permissions to a schema called 'example' 
from the symfony folder run

```
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create --em=default
$ php app/console doctrine:fixtures:load --fixtures=src/Mbates/Bundle/FixtureBundle/DataFixtures/ORM
```

### Add OAuth Client

from the symfony folder run

```
$ php app/console mbates:oauth-server:client:create --redirect-uri="http://app.mbates.net" --grant-type="authorization_code" --grant-type="password" --grant-type="refresh_token" --grant-type="token" --grant-type="client_credentials"
```

copy the public_id and secret into the angularjs app.js .run function
