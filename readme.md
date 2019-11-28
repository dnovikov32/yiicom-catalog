# Yii commerce catalog module

### Install


**app/console/config/main.php**
```php
// Enable module migrations 
'params' => [
    ...
    'yii.migrations' => [
        ...
        '@yiicom/catalog/migrations',
    ],
],
```

Run migrations to create tables **catalog_categories** and **catalog_products**
```bash
php yii migrate
```