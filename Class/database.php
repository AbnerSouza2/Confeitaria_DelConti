<?php
class Database {
    private $hostname;
    private $bancodedados;
    private $usuario;
    private $senha;
    public $conexao;

    public function __construct($hostname, $bancodedados, $usuario, $senha) {
        $this->hostname = $hostname;
        $this->bancodedados = $bancodedados;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->conectar(); // Conecta automaticamente ao instanciar a classe
    }

    public function conectar() {
        $this->conexao = new mysqli($this->hostname, $this->usuario, $this->senha, $this->bancodedados);
        if ($this->conexao->connect_errno) {
            error_log("Falha ao conectar ao banco de dados: (" . $this->conexao->connect_errno . ") " . $this->conexao->connect_error);
            exit("Falha ao conectar ao banco de dados: (" . $this->conexao->connect_errno . ") " . $this->conexao->connect_error);
        }
    }

    public function fecharConexao() {
        $this->conexao->close();
    }

    public function executarConsulta($sql, $params = array()) {
        if ($this->conexao->ping()) {
            $stmt = $this->conexao->prepare($sql);
            
            if ($stmt === false) {
                error_log("Erro ao preparar a consulta: " . $this->conexao->error);
                return false;
            }
            
            if ($params) {
                // Liga os parâmetros
                $types = ''; // Tipos de dados dos parâmetros
                $bindParams = array(); // Parâmetros a serem vinculados
                foreach ($params as $param) {
                    if (is_int($param)) {
                        $types .= 'i'; // Inteiro
                    } elseif (is_float($param)) {
                        $types .= 'd'; // Double
                    } elseif (is_string($param)) {
                        $types .= 's'; // String
                    } else {
                        $types .= 'b'; // Blob
                    }
                    $bindParams[] = $param;
                }
                $stmt->bind_param($types, ...$bindParams);
            }
            
            // Executa a consulta
            if (!$stmt->execute()) {
                error_log("Erro ao executar a consulta: " . $stmt->error);
                return false;
            }
            
            // Retorna o resultado
            return $stmt->get_result();
        } else {
            // Reconecta se a conexão estiver fechada
            $this->conectar();
            
            // Verifica se a reconexão foi bem-sucedida
            if ($this->conexao->ping()) {
                // Executa a consulta após reconectar
                return $this->executarConsulta($sql, $params);
            } else {
                // Se a reconexão falhar, retorna false
                error_log("Erro ao reconectar ao banco de dados.");
                return false;
            }
        }
    }
    
    public function obterErro() {
        return $this->conexao->error;
    }


    public static function realizarLogout() {
        session_start(); // Inicia a sessão

        // Destruir todas as variáveis de sessão
        $_SESSION = array();

        // Se desejar destruir a sessão completamente, é necessário limpar o cookie de sessão
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destruir a sessão
        session_destroy();

        // Redirecionar para o index.php
        header("Location: index.php");
        exit();
    }




}




?>
