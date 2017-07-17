# PHP Simple Database Sql ORM
### Installation

Use [Composer](https://getcomposer.org/)

```json
"require" : {
    "robertasproniu/php-simple-db-orm": "~1.0"
}
```

### Initialize
```php
require_once 'vendor/autoload.php';

use SimpleDataBaseOrm\Database;
use SimpleDataBaseOrm\DatabaseConnection;
use SimpleDataBaseOrm\DatabaseConfiguration;

$configuration = [
    'default'       => 'default',
    'connections'   => [
        'default' => [
            'driver'    => 'mysql',
            'hostname'  => 'database_hostname',
            'username'  => 'database_username',
            'password'  => 'database_password',
            'database'  => 'database_name'
        ],
        // optional can have multiple databases
        'remote' => [
            'driver'    => 'mysql',
            'hostname'  => 'database_hostname',
            'username'  => 'database_username',
            'password'  => 'database_password',
            'database'  => 'database_name'
        ]
    ]
]

$dbConfiguration =  new DatabaseConfiguration($configuration); // OR $dbConfiguration = new DatabaseConfiguration("path/to/database_cfg.php"); "path/to/database_cfg.php" should return an array

$database = new Database(new DatabaseConnection, $dbConfiguration);
```

### Usage

Examples selecting, inserting, updating and deleting data from or into `products` table.

```php

// SELECT * FROM `products` WHERE `price` = ?

$results = $database->select()
    ->from('products')
    ->where('price', 99)
    ->execute();

print_r($results); // [] of results (associative arrays);


// INSERT INTO `products` ( `name` , `price` ) VALUES ( ? , ? )

$results = $database->insert(['name', 'price'])
    ->into('products')
    ->values([ 'ProductName', 199 ])
    ->execute();
    
print_r($results); // [ 'id' => {{ insertedId }} ] OR [];


// UPDATE `products` SET `price` = ? WHERE `id` = ?

$results = $database->update([ 'price' => 199))
    ->table('products')
    ->where('id', 1)
    ->execute();

print_r($results); // [ 'rows' => {{ numberOfAffectedRows }} ] OR [];


// DELETE FROM `products` WHERE `id` = ?

$results = $database->delete()
    ->from('products')
    ->where('id', 1)
    ->execute();

print_r($results); // [ 'rows' => {{ numberOfAffectedRows }} ] OR [];

```

### Using Transaction
```php
$database->transaction(function() use ($database) {
    // multiple queries
    $database->insert(['name', 'price'])
        ->into('products')
        ->values([ 'ProductName', 199 ])
        ->execute();
        
    $database->update([ 'price' => 199))
        ->table('products')
        ->where('id', 1)
        ->execute();
});

//OR 

$database->transaction(function($database){
    $database->delete()
        ->from('products')
        ->where('id', 1)
        ->execute();
});
```

### Switching between database connections
```php
$database->connection('remote');
```



