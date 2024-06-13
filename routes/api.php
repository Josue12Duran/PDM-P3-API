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
        $propietario = $statement->fetchAll(PDO::FETCH_OBJ);

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
    $body = $request->getBody();
    $queryParams = json_decode($body, true);
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
        $response->getBody()->write(json_encode(array($propietario, 'message' => 'Propietario creado correctamente')));

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

$app->get('/inmuebles', function (Request $request, Response $response) {
    $sql = "SELECT * FROM inmuebles";

    try {
        $db = new DB();
        $connection = $db->connect();

        $statement = $connection->query($sql);
        $inmuebles = $statement->fetchAll(PDO::FETCH_OBJ);

        $db = null;
        $response->getBody()->write(json_encode($inmuebles));

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

$app->post('/inmuebles', function (Request $request, Response $response, array $args) {
    $body = $request->getBody();
    $queryParams = json_decode($body, true);
    $departamento = $queryParams['departamento'];
    $municipio = $queryParams['municipio'];
    $residencia = $queryParams['residencia'];
    $calle = $queryParams['calle'];
    $poligono = $queryParams['poligono'];
    $numeroCasa = $queryParams['numeroCasa'];
    $idPropietario = $queryParams['idPropietario'];

    $sql = "INSERT INTO inmuebles (departamento, municipio, residencia, calle, poligono, numeroCasa, idPropietario) VALUES (:departamento, :municipio, :residencia, :calle, :poligono, :numeroCasa, :idPropietario)";

    try {
        $db = new DB();
        $connection = $db->connect();

        $statement = $connection->prepare($sql);
        $statement->bindParam(':departamento', $departamento);
        $statement->bindParam(':municipio', $municipio);
        $statement->bindParam(':residencia', $residencia);
        $statement->bindParam(':calle', $calle);
        $statement->bindParam(':poligono', $poligono);
        $statement->bindParam(':numeroCasa', $numeroCasa);
        $statement->bindParam(':idPropietario', $idPropietario);

        $inmueble = $statement->execute();

        $db = null;
        $response->getBody()->write(json_encode(array($inmueble, 'message' => 'Inmueble creado correctamente')));

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
