Hola!

se installa simplemente con el comando composer install, en el mismo composer se crea la db mediante command de consola y se realiza la populacion de la misma pegandole a la api solicitada.

Para correr la API php artisan serve


 "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi",
            "@php artisan db:create",
            "@php artisan migrate:and-seed",
            "@php artisan entities:populate"


Saludos y gracias            
