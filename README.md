# SlimMicroService
The goal of this micro service is to provide a minimum viable service which performs validation of entities by using the schema of the underlaying storage. So sorry girls noSQL not included, joke aside you can as well provide a validation schema for your entities.

## Requirements
* PHP (v5.6.X or higher)
* MySQL (v5.5.X or higher) to run the included example
* phpcpd, phpcs, phpdoc, phpunit & ant (only if you want to run the full build)

## Installation
```
composer require mlatzko/SlimMicroService
```

## Set up the service on localhost:8080
This will create the entity classes required to access the database.
```
./setup.sh
```

## Run the service on localhost:8080
This will use the PHP built-in server to launch a server.
```
./run.sh
```

## Special Thanks
Jan and Andreas from http://aero-code.com/. See also their repositories https://github.com/PiMastah and https://github.com/amandiel.

## License
https://github.com/mlatzko/SlimMicroService/blob/master/LICENSE
