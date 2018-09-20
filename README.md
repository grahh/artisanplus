# artisanplus
artisan commands package.

## Commands list:
* php artisan make:repository {Model} {?--namespace=}
  * required argument Model
  * optional parameter namespace which will create additional namespace postfix after default config postfix
* php artisan make:service {Name} {?--namespace=}
  * required argument Name
  * optional parameter namespace which will create additional namespace postfix after default config postfix
 
## Configs
  * commands - list of commands mentioned by listing of class names
  * namespaces - list of default namespaces
  
## Example of usage

### make:repository

php artisan make:repository User --namespace="One\Two"
will create UserRepository.php in app_path(your/config/path/One/Two)


php artisan make:service Service --namespace="One\Two"
will create ServiceRepository.php in app_path(your/config/path/One/Two)

## Caution

* don't miss quotes after --namespace=. always put them if namespace contains >1 word because windows will eat it and linux will parse as OneTwo if you will put One\Two 