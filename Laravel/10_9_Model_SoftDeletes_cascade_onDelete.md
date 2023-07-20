soft delete だと cascade による削除が上手く動かない。
ライブラリにより対処。

## michaeldyrynda/laravel-cascade-soft-deletes
https://github.com/michaeldyrynda/laravel-cascade-soft-deletes

```
composer require dyrynda/laravel-cascade-soft-deletes
```


```php
class BasicInformation extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;

    protected $cascadeDeletes = ['residentialBuildingCalculationSetting'];

    public function residentialBuildingCalculationSetting()
    {
        return $this->hasOne(ResidentialBuildingCalculationSetting::class);
    }

}
```
