<?php
session_start();
if(!isset($_SESSION["admin"])){
    header("location:../admin/login.php");
    exit;
}

include_once "../class/vaga.class.php";
include_once "../class/vagaDAO.class.php";

$objVaga = new Vaga();
$objVaga->setUniversal("id", $_POST["id"]);
$objVaga->setUniversal("titulo", $_POST["titulo"]);
$objVaga->setUniversal("empresa", $_POST["empresa"]);
$objVaga->setUniversal("categoria_id", $_POST["categoria_id"]);
$objVaga->setUniversal("descricao", $_POST["descricao"]);
$objVaga->setUniversal("requisitos", $_POST["requisitos"]);
$objVaga->setUniversal("salario", $_POST["salario"]);
$objVaga->setUniversal("localizacao", $_POST["localizacao"]);
$objVaga->setUniversal("tipo_contrato", $_POST["tipo_contrato"]);
$objVaga->setUniversal("contato_email", $_POST["contato_email"]);
$objVaga->setUniversal("contato_telefone", $_POST["contato_telefone"]);
$objVaga->setUniversal("ativa", $_POST["ativa"]);

// Handle image upload
$imagemNome = null;

if(isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0){
    // Get file info
    $arquivo = $_FILES["imagem"];
    $nomeArquivo = $arquivo["name"];
    $tipoArquivo = $arquivo["type"];
    $tamanhoArquivo = $arquivo["size"];
    $tmpArquivo = $arquivo["tmp_name"];
    
    // Check if it's a valid image
    $extensoesPermitidas = array("jpg", "jpeg", "png", "gif", "webp");
    $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));
    
    if(in_array($extensao, $extensoesPermitidas)){
        // Check file size (max 5MB)
        if($tamanhoArquivo <= 5000000){
            // Generate unique filename
            $novoNome = uniqid() . "." . $extensao;
            $destino = "../img/" . $novoNome;
            
            // Move uploaded file
            if(move_uploaded_file($tmpArquivo, $destino)){
                $imagemNome = $novoNome;
                
                $objVagaDAO = new VagaDAO();
                $vagaAtual = $objVagaDAO->buscarPorId($_POST["id"]);
                if(!empty($vagaAtual["imagem"]) && file_exists("../img/" . $vagaAtual["imagem"])){
                    unlink("../img/" . $vagaAtual["imagem"]);
                }
            }
        }
    }
}

// Set image if uploaded, otherwise keep the old one
if($imagemNome !== null){
    $objVaga->setUniversal("imagem", $imagemNome);
} else {
    // Keep the existing image
    $objVagaDAO = new VagaDAO();
    $vagaAtual = $objVagaDAO->buscarPorId($_POST["id"]);
    $objVaga->setUniversal("imagem", $vagaAtual["imagem"]);
}

$objVagaDAO = new VagaDAO();
if($objVagaDAO->editar($objVaga)){
    header("location:listar.php?sucesso=editar");
}
else{
    header("location:editar.php?id=".$_POST["id"]."&erro=sim");
}
?>