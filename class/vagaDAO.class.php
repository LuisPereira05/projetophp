<?php
include_once "vaga.class.php";

class VagaDAO{
    private $conexao;
    
    public function __construct(){
        $this->conexao = new PDO(
            "mysql:host=localhost; dbname=bancophp",
            "root", ""
        );
    }
    
    public function inserir(Vaga $vaga){
        $sql = $this->conexao->prepare("
            INSERT INTO vaga (titulo, descricao, requisitos, salario, localizacao, 
            tipo_contrato, empresa, contato_email, contato_telefone, imagem, categoria_id, ativa) 
            VALUES (:titulo, :descricao, :requisitos, :salario, :localizacao, 
            :tipo_contrato, :empresa, :contato_email, :contato_telefone, :imagem, :categoria_id, :ativa)
        ");
        $sql->bindValue(":titulo", $vaga->getUniversal("titulo"));
        $sql->bindValue(":descricao", $vaga->getUniversal("descricao"));
        $sql->bindValue(":requisitos", $vaga->getUniversal("requisitos"));
        $sql->bindValue(":salario", $vaga->getUniversal("salario"));
        $sql->bindValue(":localizacao", $vaga->getUniversal("localizacao"));
        $sql->bindValue(":tipo_contrato", $vaga->getUniversal("tipo_contrato"));
        $sql->bindValue(":empresa", $vaga->getUniversal("empresa"));
        $sql->bindValue(":contato_email", $vaga->getUniversal("contato_email"));
        $sql->bindValue(":contato_telefone", $vaga->getUniversal("contato_telefone"));
        $sql->bindValue(":imagem", $vaga->getUniversal("imagem"));
        $sql->bindValue(":categoria_id", $vaga->getUniversal("categoria_id"));
        $sql->bindValue(":ativa", $vaga->getUniversal("ativa"));
        return $sql->execute();
    }
    
    public function listar(){
        $sql = $this->conexao->prepare("
            SELECT v.*, c.nome as categoria_nome 
            FROM vaga v 
            INNER JOIN categoria c ON v.categoria_id = c.id 
            ORDER BY v.created_at DESC
        ");
        $sql->execute();
        return $sql->fetchAll();
    }
    
    public function listarAtivas(){
        $sql = $this->conexao->prepare("
            SELECT v.*, c.nome as categoria_nome 
            FROM vaga v 
            INNER JOIN categoria c ON v.categoria_id = c.id 
            WHERE v.ativa = 1 
            ORDER BY v.created_at DESC
        ");
        $sql->execute();
        return $sql->fetchAll();
    }
    
    public function listarPorCategoria($categoria_id){
        $sql = $this->conexao->prepare("
            SELECT v.*, c.nome as categoria_nome 
            FROM vaga v 
            INNER JOIN categoria c ON v.categoria_id = c.id 
            WHERE v.ativa = 1 AND v.categoria_id = :categoria_id 
            ORDER BY v.created_at DESC
        ");
        $sql->bindValue(":categoria_id", $categoria_id);
        $sql->execute();
        return $sql->fetchAll();
    }
    
    public function buscarPorId($id){
        $sql = $this->conexao->prepare("
            SELECT v.*, c.nome as categoria_nome 
            FROM vaga v 
            INNER JOIN categoria c ON v.categoria_id = c.id 
            WHERE v.id=:id
        ");
        $sql->bindValue(":id", $id);
        $sql->execute();
        return $sql->fetch();
    }
    
    public function editar(Vaga $vaga){
        $sql = $this->conexao->prepare("
            UPDATE vaga SET titulo=:titulo, descricao=:descricao, requisitos=:requisitos, 
            salario=:salario, localizacao=:localizacao, tipo_contrato=:tipo_contrato, 
            empresa=:empresa, contato_email=:contato_email, contato_telefone=:contato_telefone, 
            categoria_id=:categoria_id, ativa=:ativa, imagem=:imagem WHERE id=:id
        ");
        $sql->bindValue(":titulo", $vaga->getUniversal("titulo"));
        $sql->bindValue(":descricao", $vaga->getUniversal("descricao"));
        $sql->bindValue(":requisitos", $vaga->getUniversal("requisitos"));
        $sql->bindValue(":salario", $vaga->getUniversal("salario"));
        $sql->bindValue(":localizacao", $vaga->getUniversal("localizacao"));
        $sql->bindValue(":tipo_contrato", $vaga->getUniversal("tipo_contrato"));
        $sql->bindValue(":empresa", $vaga->getUniversal("empresa"));
        $sql->bindValue(":contato_email", $vaga->getUniversal("contato_email"));
        $sql->bindValue(":contato_telefone", $vaga->getUniversal("contato_telefone"));
        $sql->bindValue(":categoria_id", $vaga->getUniversal("categoria_id"));
        $sql->bindValue(":ativa", $vaga->getUniversal("ativa"));
        $sql->bindValue(":imagem", $vaga->getUniversal("imagem"));
        $sql->bindValue(":id", $vaga->getUniversal("id"));
        return $sql->execute();
    }
        
    public function alterarStatus($id, $ativa){
        $sql = $this->conexao->prepare("UPDATE vaga SET ativa=:ativa WHERE id=:id");
        $sql->bindValue(":ativa", $ativa);
        $sql->bindValue(":id", $id);
        return $sql->execute();
    }
    
    public function excluir($id){
        // Get the vaga to delete its image file
        $vaga = $this->buscarPorId($id);
        
        // Delete the record from database
        $sql = $this->conexao->prepare("DELETE FROM vaga WHERE id=:id");
        $sql->bindValue(":id", $id);
        $resultado = $sql->execute();
        
        // If deletion was successful and vaga had an image, delete the image file
        if($resultado && !empty($vaga["imagem"])){
            $caminhoImagem = "../img/" . $vaga["imagem"];
            if(file_exists($caminhoImagem)){
                unlink($caminhoImagem);
            }
        }
        
        return $resultado;
    }
    
    public function listarCandidatos($vaga_id){
        $sql = $this->conexao->prepare("
            SELECT u.* FROM usuario u 
            INNER JOIN candidatura c ON u.id = c.usuario_id 
            WHERE c.vaga_id = :vaga_id 
            ORDER BY c.data_candidatura DESC
        ");
        $sql->bindValue(":vaga_id", $vaga_id);
        $sql->execute();
        return $sql->fetchAll();
    }
    
    public function candidatar($usuario_id, $vaga_id){
        $sql = $this->conexao->prepare("
            INSERT INTO candidatura (usuario_id, vaga_id) 
            VALUES (:usuario_id, :vaga_id)
        ");
        $sql->bindValue(":usuario_id", $usuario_id);
        $sql->bindValue(":vaga_id", $vaga_id);
        return $sql->execute();
    }
    
    public function verificarCandidatura($usuario_id, $vaga_id){
        $sql = $this->conexao->prepare("
            SELECT * FROM candidatura 
            WHERE usuario_id=:usuario_id AND vaga_id=:vaga_id
        ");
        $sql->bindValue(":usuario_id", $usuario_id);
        $sql->bindValue(":vaga_id", $vaga_id);
        $sql->execute();
        return $sql->rowCount() > 0;
    }

    public function listarComPaginacao($limite, $offset){
        $sql = $this->conexao->prepare("
            SELECT v.*, c.nome as categoria_nome 
            FROM vaga v 
            INNER JOIN categoria c ON v.categoria_id = c.id 
            ORDER BY v.created_at DESC
            LIMIT :limite OFFSET :offset
        ");
        $sql->bindValue(":limite", $limite, PDO::PARAM_INT);
        $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function listarAtivasComPaginacao($limite, $offset){
        $sql = $this->conexao->prepare("
            SELECT v.*, c.nome as categoria_nome 
            FROM vaga v 
            INNER JOIN categoria c ON v.categoria_id = c.id 
            WHERE v.ativa = 1 
            ORDER BY v.created_at DESC
            LIMIT :limite OFFSET :offset
        ");
        $sql->bindValue(":limite", $limite, PDO::PARAM_INT);
        $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function listarPorCategoriaComPaginacao($categoria_id, $limite, $offset){
        $sql = $this->conexao->prepare("
            SELECT v.*, c.nome as categoria_nome 
            FROM vaga v 
            INNER JOIN categoria c ON v.categoria_id = c.id 
            WHERE v.ativa = 1 AND v.categoria_id = :categoria_id 
            ORDER BY v.created_at DESC
            LIMIT :limite OFFSET :offset
        ");
        $sql->bindValue(":categoria_id", $categoria_id);
        $sql->bindValue(":limite", $limite, PDO::PARAM_INT);
        $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function contarAtivas(){
        $sql = $this->conexao->prepare("
            SELECT COUNT(*) as total FROM vaga WHERE ativa = 1
        ");
        $sql->execute();
        return $sql->fetch()["total"];
    }

    public function contarPorCategoria($categoria_id){
        $sql = $this->conexao->prepare("
            SELECT COUNT(*) as total FROM vaga 
            WHERE ativa = 1 AND categoria_id = :categoria_id
        ");
        $sql->bindValue(":categoria_id", $categoria_id);
        $sql->execute();
        return $sql->fetch()["total"];
    }

    public function contarTodas(){
        $sql = $this->conexao->prepare("SELECT COUNT(*) as total FROM vaga");
        $sql->execute();
        return $sql->fetch()["total"];
    }
}