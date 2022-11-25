<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

//Fetch all Records
$app->get('/students/all', function(Request $request, Response $response){

    $db = new DB();
    $conn=$db->connect_db();

    $result=$conn->query("SELECT * FROM students");
    if($result->num_rows>0)
    {
        $output = $result->fetch_all(MYSQLI_ASSOC);
        $db=null;
        $response->getBody()->write(json_encode($output));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }
    else{
        $error=array('message' => 'No Record Found.');

        $response->getBody()->write(json_encode($error));
        
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);
    }
});

//Fetch Single Record by ID
$app->get('/students/{id}', function(Request $request, Response $response, array $args){
    $sid=$args['id'];

    $db = new DB();
    $conn=$db->connect_db();

    $result=$conn->query("SELECT * FROM students WHERE id='$sid'");
    if($result->num_rows>0)
    {
        $output = $result->fetch_assoc();
        //echo json_encode($output);
    
        $db=null;
        $response->getBody()->write(json_encode($output));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }
    else{
        $error=array('message' => 'No Record Found.');

        $response->getBody()->write(json_encode($error));
        
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);
    }
});

//Insert Single Record
$app->post('/students/add', function(Request $request, Response $response, array $args){
    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data['sname'];
    $age = $data['age'];
    $contact = $data['contact'];

    $db = new DB();
    $conn=$db->connect_db();

    $result=$conn->query("INSERT INTO students(sname, age, contact) VALUES ('{$name}', {$age}, '{$contact}')");
    if($result)
    {
        $output = array('message' => 'Record Added Successfully.');
    
        $db=null;
        $response->getBody()->write(json_encode($output));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }
    else{
        $error=array('message' => 'Record Not Inserted.');

        $response->getBody()->write(json_encode($error));
        
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);
    }
});

//Delete Single Record
$app->delete('/students/{id}', function(Request $request, Response $response, array $args){
    $sid=$args['id'];   
    $db = new DB();
    $conn=$db->connect_db();

    $check = $conn->query("SELECT * FROM students WHERE id={$sid}");
    if($check->num_rows > 0)
    {
        $result=$conn->query("DELETE FROM students WHERE id='$sid'");
        if($result)
        {
            $output = array('message' => 'Record Deleted Successfully.');
        
            $db=null;
            $response->getBody()->write(json_encode($output));
            return $response
                ->withHeader('content-type','application/json')
                ->withStatus(200);
        }
        else{
            $error=array('message' => 'Record Not Deleted.');

            $response->getBody()->write(json_encode($error));
            
            return $response
                ->withHeader('content-type','application/json')
                ->withStatus(500);
        }
    }
    else{
        $error=array('message' => 'No Record Found For This ID.');

        $response->getBody()->write(json_encode($error));
        
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);
    }
});

//UPDATE Single Record
$app->put('/students/update', function(Request $request, Response $response, array $args){
    $data = json_decode(file_get_contents("php://input"), true);

    $sid = $data['id'];
    $name = $data['sname'];
    $age = $data['age'];
    $contact = $data['contact'];
    $db = new DB();
    $conn=$db->connect_db();

    $check = $conn->query("SELECT * FROM students WHERE id={$sid}");
    if($check->num_rows > 0)
    {
        $result=$conn->query("UPDATE students SET sname = '{$name}', age = '{$age}', contact = '{$contact}' WHERE id = {$sid}");
        if($result)
        {
            $output = array('message' => 'Record Updated Successfully.');
        
            $db=null;
            $response->getBody()->write(json_encode($output));
            return $response
                ->withHeader('content-type','application/json')
                ->withStatus(200);
        }
        else{
            $error=array('message' => 'Record not Updated.');

            $response->getBody()->write(json_encode($error));
            
            return $response
                ->withHeader('content-type','application/json')
                ->withStatus(500);
        }
    }
    else{
        $error=array('message' => 'No Record Found For This ID.');

        $response->getBody()->write(json_encode($error));
        
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);
    }

    
});
