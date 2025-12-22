<?php
class ConnectionFactory {
    private static $pdo = null;

    private function __construct() {}

    public static function getConnection() {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=sql207.infinityfree.com;dbname=if0_37436691_lambe_lambe;charset=utf8', 
                    'if0_37436691',                              
                    '7HEWnyi0PP4Hk8',                             
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
        }
        return self::$pdo; 
    }
}
?>