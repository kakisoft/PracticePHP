# StyleCI
```
blankline_after_open_tag
single_quote ereg_to_preg
```


## .php_cs
```php
return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers([
        'blankline_after_open_tag',
        'single_quote',
        'ereg_to_preg',
    ]);
```


# PHP-CS-Fixer

## ereg_to_preg
非推奨になっている ereg系 の処理を pregに変換します


