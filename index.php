<?php 


try
{

    /*
    $pdo=new PDO('mysql:dbname=dionise_db;host=localhost','root',''); 
    $pdo->exec('SET CHARACTER SET utf8');

    //select
    
    $id=2;
    $tabela = 'Establishment';
    $stmt= $pdo->prepare('SELECT * FROM '.$tabela.' WHERE id = :id');
    $stmt->execute( array('id' => $id));
    $resultado = $stmt->fetchAll();
    foreach ($resultado as $key)
    {
        //var_dump($key);
    }

    */
    /*
    //Insert
    $name='Stanley Party';
    $description="Stanley's";
    $link="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR9jI2BopTD7CntBP4COWFQc-O6OjwsY-ZS-w&usqp=CAU";
    
    $stmt = $pdo->prepare('INSERT INTO '.$tabela.' (`name`, `description`, `introImage`) 
                                            VALUES (:name, :description, :introImage )');
    
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':introImage', $link);

    $stmt->execute();

    */

    /*
    //Update
    $id=8;
    $name="Stanley's Party";
    $stmt = $pdo->prepare('UPDATE '.$tabela.' SET name = :name WHERE id = :id');
    $stmt->execute( array(
        'id' => $id,
        ':name' => $name    
    ));

    */

    //Delete
    /*
    $id=8;
    $stmt= $pdo->prepare("DELETE FROM ".$tabela." WHERE ID = :ID");
    $stmt->execute(array(
        'ID' => $id
    ));
    */
    
} catch (\throwable $th)
{
    //echo $th;
    //die;
}

//die;






require __DIR__.'/includes/app.php';

use \App\Http\Router;

$obRouter = new Router(URL);

include __DIR__.'/routes/pages.php';

$obRouter->run()->sendResponse();



