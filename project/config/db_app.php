<?php

return [
    'connection_string' => 'pgsql:host=localhost;port=5432;dbname=database',
    'user'=>'databaseuser',
    'password'=>'databasepassword',
    'conn_opt' => array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            # All sessions will be saved in RDBMS while you don't kill them or restart httpd
            # Diff for localhost DB to coonect to database instance aprox 5 ms
            #,\PDO::ATTR_PERSISTENT => true
            ),
    'init_sql' => array (
        "set datestyle = 'German';"
    )
];

