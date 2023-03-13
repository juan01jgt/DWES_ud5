<?php
class Connection {
    private $config = array();
    private function __construct($connection,$host,$name,$username,$password)
    {
        $this->config = [
            'connection' => $connection,
            'host' => $host,
            'name' => $name,
            'username' => $username,
            'password' => $password,
        ];
    }
    public function connect(){
        
        try{
            $pdo = new PDO(
                    $this->config['connection'] . ':host=' . $this->config['host'] . ';dbname=' . $this->config['name'],
                    $this->config['username'],
                    $this->config['password']
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }
    }
    public static function getInstance($connection,$host,$name,$username,$password){
        static $instance = null;
        if($instance === null){
            $instance = new static($connection,$host,$name,$username,$password);
        }
        return $instance;
    }
}
?>
