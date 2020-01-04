# Mini Web Framework on PHP

## How to install
make a composer.json file in root folder of your app
```json
{
    "autoload" : {
        "psr-4" : {
            "app\\": "app"
        }
    },
    "require" : {
        "james.rus52/phpfrm": "dev-master",
        "phpmailer/phpmailer": "~6.0",
    }
}
```
Install framework
```
composer install
```

copy project template from vendor/james.rus52/phpfrm to your root folder

it look like this after that


```
/
  /app
    /controllers
       /AppController.php
       /MainController.php
    /models
       /AppModel.php
       /MainModel.php
    /views
       /Main
         /index.php
       /layouts
         /default.php
   /widgets
     /menu
       /Menu.php
       /layout_app.php
  /public
    /index.php
    /.htaccess
    /js
    /css
    /img
    /plugins
  /tmp
    /cache
  /logs
  /.htaccess
  /vendor
    /james.rus52/phpfrm
  /composer.json
```

## How to use
Change your website layout in /views/layouts/default.php
Make additional pages like index.php
 1. Make a controller in /app/controllers extedded of AppController class
 2. Make a model in /app/models extedded of AppModel class
 3. Make a view in /app/views/<ControllerName>
    
## Configuration
You can manage routes and settings at /config folder
