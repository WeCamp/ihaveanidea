I Have an Idea
=======

## Discovery of "Idea's worth spreading"

#### You will need:

- git
- composer
- a mysql database

#### Run the following commands:

- git clone [project]
- composer install
- php app/console doctrine:schema:update --force
- php app/console fos:user:create

#### To view the site, do:

- app/console server run

And access http://127.0.0.1:8000 in a browser
