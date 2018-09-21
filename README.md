# artisanplus
artisan commands package.

## Commands list:
* php artisan make:repository {Model} 
  * required argument Model
* php artisan make:service {Name} {?--folder=}
  * required argument Name
  * optional parameter folder which will create additional namespace postfix after default config postfix and move file there
 
## Configs
  * commands - list of commands mentioned by listing of class names
  * namespaces - list of default namespaces
  
## Example of usage

### make:repository

php artisan make:repository User --folder=One/Two
will create UserRepository.php in app_path(your/config/path/One/Two)

### make:service

php artisan make:service Service
will create ServiceRepository.php in app_path(your/config/path/)

and php artisan make:service One/Two/Service
will create ServiceRepository.php in app_path(your/config/path/One/Two/)