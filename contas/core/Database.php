<?php
require_once __DIR__ . '/../config/config.php';

// Classe Database que define a conexão PDO com o MySQL, esta será usada em todos os Models
class Database {
    private static $instance = null;
    private $pdo;

    // Cria a conexão com o banco de dados ao ser instanciada
    private function __construct() {
        // Pega as configurações definidas no arquivo config.php
        $host = DB_HOST;
        $db = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASSWORD;
        $charset = 'utf8mb4';

        // Define de onde vem os dados a serem manipulados
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        // Configura as opções de manusear erros, como os dados serão recebidos e se o PDO usa a emulação de prepared statements 
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        try { // Tenta criar uma conexão PDO passando os dados informados anteriormente
            $this->pdo = new PDO($dsn, $user, $pass, $options);
            
        } catch (PDOException $e) { // Para a execução do código em caso de erro e manda o erro que ocorreu no PDO
            
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getInstance() { // Este método garante que só haja uma conexão PDO
        if (self::$instance === null) { // Checa a existência da instância
            self::$instance = new self(); // Cria uma instância caso ela não exista
        }
        return self::$instance->pdo; // Retorna a instância criada anteriormente e continua retornando esta instância...
                                    // evitando a criação de múltiplas instâncias
    }
}
