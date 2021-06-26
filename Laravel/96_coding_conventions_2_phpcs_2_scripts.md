## composer.json
```json
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi"
        ],
        "phpmd": [
            "./vendor/bin/phpmd --exclude '*/bootstrap/*,*/config/*,*/database/*,*/node_modules/*,*/public/*,*/resources/*,*/routes/*,*/storage/*,*/vendor/*,*/tests/*,*/server.php,*/app/Console/Kernel.php' ./ ansi ./phpmd.xml || exit 0"
        ],
        "phpcs": [
            "./vendor/bin/phpcs --colors --standard=phpcs.xml ./ || exit 0"
        ],
```
