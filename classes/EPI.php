<?php
// /classes/EPI.php

class EPI {
    private $conn;
    private $table_name = "epi";

    public $id_epi;
    public $CA;
    public $Categoria;
    public $status;
    public $Validade;
    public $primeiro_uso;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function cadastrar() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (CA, Categoria, status, Validade, primeiro_uso) 
                  VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);

        if($stmt->execute([
            $this->CA, 
            $this->Categoria, 
            $this->status, 
            $this->Validade, 
            $this->primeiro_uso
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
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id_epi DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    public function contarPorStatus($status_desejado) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE status = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$status_desejado]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'];
    }

    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_epi = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_epi = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt->execute([$id])) {
            return true;
        }
        return false;
    }

    // NOVA FUNÇÃO: Atualiza os dados de um equipamento existente
    public function atualizar($id) {
        $query = "UPDATE " . $this->table_name . " 
                  SET CA = ?, Categoria = ?, status = ?, Validade = ?, primeiro_uso = ? 
                  WHERE id_epi = ?";
        
        $stmt = $this->conn->prepare($query);

        if($stmt->execute([
            $this->CA, 
            $this->Categoria, 
            $this->status, 
            $this->Validade, 
            $this->primeiro_uso,
            $id
        ])) {
            return true;
        }
        return false;
    }
}
?>