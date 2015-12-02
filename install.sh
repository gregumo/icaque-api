php -d memory_limit=-1 composer.phar install
bin/console doctrine:database:create
bin/console doctrine:schema:update --force
mkdir -p var/jwt
openssl genrsa -out var/jwt/private.pem -aes256 4096
openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem