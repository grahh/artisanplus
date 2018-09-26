# artisanplus
artisan commands package.

#Installation
* composer require grahh/artisanplus
* php artisan vendor:publish --provider="Grahh\\Artisanplus\\ArtisanplusProvider"
* php artisan config:cache

## Commands list:

```php 
php artisan make:repository {Model}
// required argument Model
```
 
```php
php artisan make:service {Name} {?--folder=}
// required argument Name
// optional parameter folder which will create additional namespace postfix after default config postfix and move file there
```

```php
php artisan make:vo {Name}
//creates Value Object
```
 
## Configs
  * commands - list of commands mentioned by listing of class names
  * namespaces - list of default namespaces
  
## Example of usage

### make:repository

```php
php artisan make:repository User --folder=One/Two
//will create UserRepository.php in app_path(your/config/path/One/Two)
```

### make:service

```php
php artisan make:service Service
//will create ServiceRepository.php in app_path(your/config/path/)
```

and 
```php
php artisan make:service One/Two/Service
//will create ServiceRepository.php in app_path(your/config/path/One/Two/)
```

### make:vo

```php
php artisan:make Some
//creates immutable Value Object Some.php
```
