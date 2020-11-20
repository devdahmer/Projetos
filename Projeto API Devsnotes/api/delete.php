<?php
require('../config.php');


$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'delete') {

   parse_str(file_get_contents('php://input'), $input);

   $id = $input['id'] ?? null;
   
   $id = filter_var($id);
   
   if($id) {

    $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    if($sql->rowCount() > 0) {

        $sql = $pdo->prepare("DELETE FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

    } else {
        $array['error'] = 'Id inexistente';
    }


   } else {
       $array['error'] = 'Id não enviados';
   }

} else {
    $array['error'] = 'Metodo não permitido (apenas delete)';
}

require('../return.php');