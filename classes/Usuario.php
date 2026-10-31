<?php
// /classes/Usuario.php

class Usuario {
    private $conn;
    private $table_name = "usuario";

    public $id_usuario;
    public $nome;
    public $usuario;
    public $senha;
    public $nivel_acesso;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cadastrar() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome, usuario, senha, nivel_acesso, status) 
                  VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);

        if($stmt->execute([
            $this->nome, 
            $this->usuario, 
            $this->senha, 
            $this->nivel_acesso, 
            $this->status
        ])) {
            return true;
        }
        return false;
    }

    public function listarTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    // A função que estava a faltar e causou o erro!
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id) {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = ?, usuario = ?, senha = ?, nivel_acesso = ?, status = ? 
                  WHERE id_usuario = ?";
        
        $stmt = $this->conn->prepare($query);

        if($stmt->execute([
            $this->nome, 
            $this->usuario, 
            $this->senha, 
            $this->nivel_acesso, 
            $this->status,
            $id
        ])) {
            return true;
        }
        return false;
    }

    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt->execute([$id])) {
            return true;
        }
        return false;
    }
}
?>