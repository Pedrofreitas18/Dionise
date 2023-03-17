<?php
namespace App\Model\Entity;

use \App\Model\DBConnection\Database;

class Testimony{
    public $id;
    public $nome;
    public $mensagem;
    public $data;

    public function cadastrar(){
        $this->data = date('Y-m-d H:i:s');
        
        $return = Database::simpleInsert('depoimentos', [
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data
        ]);

        $this->id = $return['ID'];
        return true;
    }

    public static function getTestimonies(){
        $query = "SELECT * FROM `depoimentos` ORDER BY ID DESC LIMIT 5";
        $result = Database::customQuery($query);
        
        if (mysqli_num_rows($result) > 0) {
            $return = [];
            while($row = mysqli_fetch_assoc($result)) {
                $obTestimony = new Testimony;
                $obTestimony->id = $row['ID'];
                $obTestimony->nome = $row['nome'];
                $obTestimony->mensagem = $row['mensagem'];
                $obTestimony->data = $row['data'];
                array_push($return, $obTestimony);
            }
            return $return;
          } else {
            echo "0 results";
          }
        exit;
    }
}