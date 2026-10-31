<?php
session_start();

// Só permite o acesso se vier de um formulário via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Chama a conexão e a classe
    require_once '../config/Database.php';
    require_once '../classes/EPI.php';

    $database = new Database();
    $db = $database->getConnection();

    $epi = new EPI($db);

    // Recebe os dados do formulário e guarda nas variáveis da classe
    $epi->Categoria    = $_POST['Categoria'];
    $epi->CA           = $_POST['CA'];
    $epi->status       = $_POST['status'];
    $epi->primeiro_uso = $_POST['primeiro_uso'];
    $epi->Validade     = $_POST['validade'];

    // Executa a função cadastrar()
    if ($epi->cadastrar()) {
        // Se der certo, volta para a lista
        header("Location: listar_epis.php");
        exit;
    } else {
        // Se der erro, volta para o formulário com aviso
        $_SESSION['erro_cadastro'] = "Erro ao cadastrar equipamento. Tente novamente.";
        header("Location: form_epi.php");
        exit;
    }
} else {
    // Se tentarem aceder ao ficheiro pelo URL diretamente, manda para o painel
    header("Location: ../painel.php");
    exit;
}
?>