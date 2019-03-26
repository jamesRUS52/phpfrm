PHP Framework

make a composer.json file in root folder of your app

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


composer install

copy project template from vendor/james.rus52/phpfrm to your root folder

it look like this after that



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


