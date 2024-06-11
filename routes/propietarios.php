<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/propietarios/{idPropietario}', function (Request $request, Response $response, array $args) {
    $idPropietario = $args['idPropietario'];
    $sql = "SELECT * FROM propietarios WHERE idPropietario = $idPropietario";

    try {
        $db = new DB();
        $connection = $db->connect();

        $statement = $connection->query($sql);
        $propietario = $statement->fetch(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($propietario));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array('error' => array('text' => $e->getMessage()));
        $response->getBody()->write(json_encode($error));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);
    }
});

$app->post('/propietarios', function (Request $request, Response $response, array $args) {
    $queryParams = $request->getQueryParams();
    $nombres = $queryParams['nombres'];
    $apellidos = $queryParams['apellidos'];
    $fechaNacimiento = $queryParams['fechaNacimiento'];
    $genero = $queryParams['genero'];
    $telefono = $queryParams['telefono'];
    $email = $queryParams['email'];

    $sql = "INSERT INTO propietarios (nombres, apellidos, fechaNacimiento, genero, telefono, email) VALUES (:nombres, :apellidos, :fechaNacimiento, :genero, :telefono, :email)";

    try {
        $db = new DB();
        $connection = $db->connect();

        $statement = $connection->prepare($sql);
        $statement->bindParam(':nombres', $nombres);
        $statement->bindParam(':apellidos', $apellidos);
        $statement->bindParam(':fechaNacimiento', $fechaNacimiento);
        $statement->bindParam(':genero', $genero);
        $statement->bindParam(':telefono', $telefono);
        $statement->bindParam(':email', $email);

        $propietario = $statement->execute();

        $db = null;
        $response->getBody()->write(json_encode(array('message' => 'Propietario creado correctamente')));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    } catch (PDOException $e) {
        $error = array('error' => array('text' => $e->getMessage()));
        $response->getBody()->write(json_encode($error));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);
    }
});
