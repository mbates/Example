## Example Symfony2 / AngularJS Apps

### Symfony Permissions

$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
$ sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
$ sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs

### Setup Database

Add a User that has permissions to a schema called 'example' 
from the symfony folder run
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:create --em=default
$ php app/console doctrine:fixtures:load --fixtures=src/Mbates/Bundle/FixtureBundle/DataFixtures/ORM

### Add OAuth Client

from the symfony folder run
$ php app/console mbates:oauth-server:client:create --redirect-uri="http://app.mbates.net" --grant-type="authorization_code" --grant-type="password" --grant-type="refresh_token" --grant-type="token" --grant-type="client_credentials"
copy the public_id and secret into the angularjs app.js .run function