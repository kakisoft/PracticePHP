https://laravel.com/docs/8.x/helpers

## Arr::pluck()
```php
use Illuminate\Support\Arr;

$array = [
    ['developer' => ['id' => 1, 'name' => 'Taylor']],
    ['developer' => ['id' => 2, 'name' => 'Abigail']],
];

$names = Arr::pluck($array, 'developer.name');
//=> ['Taylor', 'Abigail']

$names = Arr::pluck($array, 'developer.name', 'developer.id');
//=>  [1 => 'Taylor', 2 => 'Abigail']
```



