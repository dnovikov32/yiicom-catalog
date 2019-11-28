# Yii commerce catalog module

### Install

**app/backend/config/main.php**
```php
// Enable backend routes
'modules' => [
    ...
    'catalog' => [
        'class' => yiicom\catalog\backend\Module::class
    ],
],
```

**app/frontend/config/main.php**
```php
// Enable frontend routes
'modules' => [
    ...
    'catalog' => [
        'class' => yiicom\catalog\frontend\Module::class
    ],
],

// Override default theme
'view' => [
    'theme' => [
        'pathMap' => [
            ...
            '@yiicom/catalog' => '@app/themes/catalog',
        ]
    ]
],
```


**app/console/config/main.php**
```php
// Enable module commands
'modules' => [
    ...
    'catalog' => [
        'class' => yiicom\catalog\console\Module::class
    ],
],

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




### Vue application setup

Add module store to Vue application general store

**app/backend/assets/src/store/store.js**
```js
import catalogCategories from '../../../../vendor/yiicom/yiicom-catalog/src/backend/assets/src/store/categories.js'

export default new Vuex.Store({
    modules: {
        'catalog-categories': catalogCategories
    }

});
```

Add module routes to Vue router

**app/backend/assets/src/index.js**
```js
import catalogRoutes from '../../../vendor/yiicom/yiicom-catalog/src/backend/assets/src/routes/catalog.js';

const router = new VueRouter({
    mode: 'hash',
    linkActiveClass: 'active',
    routes: [
        ... catalogRoutes
    ],
});
```

Add module styles

**app/backend/assets/src/sass/main.scss**
```scss
@import '../../../../vendor/yiicom/yiicom-catalog/src/backend/assets/src/sass/catalog';
```



