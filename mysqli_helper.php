<?php
/**
 * Helper para obtener configuración de MySQL
 * Funciona tanto en Railway como en desarrollo local
 */

function getMySQLConfig() {
    if (getenv('MYSQL_HOST')) {
        // Railway
        return [
            'host' => getenv('MYSQL_HOST'),
            'user' => getenv('MYSQL_USER'),
            'password' => getenv('MYSQL_PASSWORD'),
            'database' => getenv('MYSQL_DATABASE')
        ];
    } else {
        // Local
        return [
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
            'database' => 'notas'
        ];
    }
}

function getConnection() {
    $config = getMySQLConfig();
    $conexion = new mysqli(
        $config['host'],
        $config['user'],
        $config['password'],
        $config['database']
    );
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    return $conexion;
}
?>