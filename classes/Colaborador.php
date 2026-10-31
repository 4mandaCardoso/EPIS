<?php
// /classes/Colaborador.php

class Colaborador {
    private $conn;
    private $table_name = "colaborador";

    public $id_colaborador;
    public $nome;
    public $cpf;
    public $cargo;
    public $telefone;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cadastrar() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome, cpf, cargo, telefone, status) 
                  VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);

        if($stmt->execute([
            $this->nome, 
            $this->cpf, 
            $this->cargo, 
            $this->telefone, 
            $this->status
        ])) {
            return true;
        }
        return false;
    }

    public function contarTodos() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'];
    }

    public function listarTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_colaborador = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id) {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = ?, cpf = ?, cargo = ?, telefone = ?, status = ? 
                  WHERE id_colaborador = ?";
        
        $stmt = $this->conn->prepare($query);

        if($stmt->execute([
            $this->nome, 
            $this->cpf, 
            $this->cargo, 
            $this->telefone, 
            $this->status,
            $id
        ])) {
            return true;
        }
        return false;
    }

    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_colaborador = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt->execute([$id])) {
            return true;
        }
        return false;
    }
}
?>