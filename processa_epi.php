<?php
// /epis/processa_epi.php
session_start();

// Recua uma pasta para encontrar as configurações e as classes
require_once '../config/Database.php';
require_once '../classes/EPI.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Instancia a base de dados e a classe EPI
    $database = new Database();
    $db = $database->getConnection();
    
    $epi = new EPI($db);
    
    // Passa os dados que vieram do formulário para os atributos da classe
    $epi->CA = $_POST['CA'];
    $epi->Categoria = $_POST['Categoria'];
    $epi->status = $_POST['status'];
    $epi->Validade = $_POST['validade'];
    $epi->primeiro_uso = $_POST['primeiro_uso'];
    
    // Executa a gravação
    if ($epi->cadastrar()) {
        $_SESSION['mensagem_sucesso'] = "Equipamento registado com sucesso no inventário!";
        header("Location: form_epi.php"); // Volta para o formulário para poderes registar mais
        exit;
    } else {
        $_SESSION['erro_cadastro'] = "Ocorreu um erro ao registar o equipamento.";
        header("Location: form_epi.php");
        exit;
    }
}
?>