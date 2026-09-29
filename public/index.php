<?php

require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$app->addErrorMiddleware(true, true, true);

$missoes = [
    [
        "id" => 1,
        "nome" => "Apollo 11",
        "ano" => 1969,
        "agencia" => "NASA",
        "status" => "Concluída"
    ],
    [
        "id" => 2,
        "nome" => "Voyager 1",
        "ano" => 1977,
        "agencia" => "NASA",
        "status" => "Em operação"
    ],
    [
        "id" => 3,
        "nome" => "Artemis II",
        "ano" => 2026,
        "agencia" => "NASA",
        "status" => "Planejada"
    ],
    [
        "id" => 4,
        "nome" => "Mars Pathfinder",
        "ano" => 1996,
        "agencia" => "NASA",
        "status" => "Concluída"
    ],
    [
        "id" => 5,
        "nome" => "James Webb",
        "ano" => 2021,
        "agencia" => "NASA",
        "status" => "Em operação"
    ]
];

/* GET /status */
$app->get('/status', function (Request $request, Response $response) {

    $dados = [
        "status" => "ok"
    ];

    $response->getBody()->write(json_encode($dados));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});


/* GET /missoes */
$app->get('/missoes', function (Request $request, Response $response) use (&$missoes) {

    $response->getBody()->write(json_encode($missoes));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});


/* GET /missoes/{id} */
$app->get('/missoes/{id}', function (Request $request, Response $response, array $args) use (&$missoes) {

    $id = (int) $args['id'];

    foreach ($missoes as $missao) {

        if ($missao['id'] === $id) {

            $response->getBody()->write(json_encode($missao));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }

    $erro = [
        "erro" => "Missão não encontrada"
    ];

    $response->getBody()->write(json_encode($erro));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});


/* POST /missoes */
$app->post('/missoes', function (Request $request, Response $response) use (&$missoes) {

    $dados = $request->getParsedBody();

    $novaMissao = [
        "id" => count($missoes) + 1,
        "nome" => $dados['nome'],
        "ano" => $dados['ano'],
        "agencia" => $dados['agencia'],
        "status" => $dados['status']
    ];

    $missoes[] = $novaMissao;

    $response->getBody()->write(json_encode($novaMissao));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
});


/* PUT /missoes/{id} */
$app->put('/missoes/{id}', function (Request $request, Response $response, array $args) use (&$missoes) {

    $id = (int) $args['id'];

    $dados = $request->getParsedBody();

    foreach ($missoes as &$missao) {

        if ($missao['id'] === $id) {

            $missao['nome'] = $dados['nome'];
            $missao['ano'] = $dados['ano'];
            $missao['agencia'] = $dados['agencia'];
            $missao['status'] = $dados['status'];

            $response->getBody()->write(json_encode($missao));

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }

    $erro = [
        "erro" => "Missão não encontrada"
    ];

    $response->getBody()->write(json_encode($erro));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});


/* DELETE /missoes/{id} */
$app->delete('/missoes/{id}', function (Request $request, Response $response, array $args) use (&$missoes) {

    $id = (int) $args['id'];

    foreach ($missoes as $indice => $missao) {

        if ($missao['id'] === $id) {

            unset($missoes[$indice]);

            return $response->withStatus(204);
        }
    }

    $erro = [
        "erro" => "Missão não encontrada"
    ];

    $response->getBody()->write(json_encode($erro));

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});


$app->run();