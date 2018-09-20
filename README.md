# artisanplus
artisan commands package.

## Commands list:
* php artisan make:repository {Model} {?--namespace=}
  * required argument Model
  * optional parameter namespace which will create additional namespace postfix after default config postfix
* php artisan make:service {?--namespace=}
  * no required arguments
  * optional parameter namespace which will create additional namespace postfix after default config postfix
 
## Configs
  * commands - list of commands mentioned by listing of class names
  * namespaces - list of default namespaces
