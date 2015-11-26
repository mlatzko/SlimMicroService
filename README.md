# SlimMicroService
this piece of software provides a skeleton to create micro services which has
one or multiple single RestFul(Like) interface which represents a database
tables without foreign key handling. The service only provides CRUD without
search capability.

### How does it work?
Create a database, configure db & entities, generate entities & start server.

### When to use?
Wanna build a service in under 15 minutes for one database table.

## Requirements
* PHP (v5.6.X or higher)
* MySQL (v5.5.X or higher) to run the included example
* phpcpd, phpcs, phpdoc, phpunit & ant (only if you want to run the full build)

## Generate Doctrine based entities.
This will create the entity classes required to access the database.
```
./setup-svc-entties.sh
```

## Run the service on localhost:8080
This will use the PHP built-in server to launch a server.
```
./start-server.sh
```

## Special Thanks
Jan and Andreas from http://aero-code.com/. See also their repositories
https://github.com/PiMastah and https://github.com/amandiel.

## Uses
https://github.com/slimphp/Slim<br>
https://github.com/Seldaek/monolog<br>
https://github.com/hassankhan/config<br>
https://github.com/fuelphp/validation<br>
https://github.com/doctrine/doctrine2

## License
https://github.com/mlatzko/SlimMicroService/blob/master/LICENSE
