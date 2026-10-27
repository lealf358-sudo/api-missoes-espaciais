
<?php

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Factory\ServerRequestFactory;

class MissaoTeste extends TestCase
{
    private function criarApp()
    {
        require __DIR__ . '/../src/app.php';
        return $app;
    }

    public function testGetStatus(): void
    {
        $app = $this->criarApp();

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/status');

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals('ok', $corpo['status']);
    }

    public function testGetListaMissoes(): void
    {
        $app = $this->criarApp();

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/missoes');

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertCount(5, $corpo);
        $this->assertEquals('Apollo 11', $corpo[0]['nome']);
    }

    public function testGetBuscaMissao(): void
    {
        $app = $this->criarApp();

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/missoes/1');

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals('Apollo 11', $corpo['nome']);
        $this->assertEquals(1969, $corpo['ano']);
    }

    public function testGetMissaoInexistente(): void
    {
        $app = $this->criarApp();

        $request = (new ServerRequestFactory())
            ->createServerRequest('GET', '/missoes/99');

        $response = $app->handle($request);

        $this->assertEquals(404, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals(
            'Missão não encontrada',
            $corpo['erro']
        );
    }

    public function testPostCriaMissao(): void
    {
        $app = $this->criarApp();

        $dados = [
            'nome' => 'Missão Teste',
            'ano' => 2030,
            'agencia' => 'NASA',
            'status' => 'Planejada'
        ];

        $request = (new ServerRequestFactory())
            ->createServerRequest('POST', '/missoes')
            ->withHeader('Content-Type', 'application/json');

        $request->getBody()->write(json_encode($dados));
        $request->getBody()->rewind();

        $response = $app->handle($request);

        $this->assertEquals(201, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals(6, $corpo['id']);
        $this->assertEquals('Missão Teste', $corpo['nome']);
        $this->assertEquals(2030, $corpo['ano']);
        $this->assertEquals('NASA', $corpo['agencia']);
        $this->assertEquals('Planejada', $corpo['status']);
    }

    public function testPutAtualizaMissao(): void
    {
        $app = $this->criarApp();

        $dados = [
            'nome' => 'Apollo 11 Atualizada',
            'ano' => 1969,
            'agencia' => 'NASA',
            'status' => 'Concluída'
        ];

        $request = (new ServerRequestFactory())
            ->createServerRequest('PUT', '/missoes/1')
            ->withHeader('Content-Type', 'application/json');

        $request->getBody()->write(json_encode($dados));
        $request->getBody()->rewind();

        $response = $app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals('Apollo 11 Atualizada', $corpo['nome']);
        $this->assertEquals(1969, $corpo['ano']);
    }

    public function testPutMissaoInexistente(): void
    {
        $app = $this->criarApp();

        $dados = [
            'nome' => 'Missão Teste',
            'ano' => 2030,
            'agencia' => 'NASA',
            'status' => 'Planejada'
        ];

        $request = (new ServerRequestFactory())
            ->createServerRequest('PUT', '/missoes/99')
            ->withHeader('Content-Type', 'application/json');

        $request->getBody()->write(json_encode($dados));
        $request->getBody()->rewind();

        $response = $app->handle($request);

        $this->assertEquals(404, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals(
            'Missão não encontrada',
            $corpo['erro']
        );
    }

    public function testDeleteExcluiMissao(): void
    {
        $app = $this->criarApp();

        $request = (new ServerRequestFactory())
            ->createServerRequest('DELETE', '/missoes/1');

        $response = $app->handle($request);

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEmpty((string) $response->getBody());
    }

    public function testDeleteMissaoInexistente(): void
    {
        $app = $this->criarApp();

        $request = (new ServerRequestFactory())
            ->createServerRequest('DELETE', '/missoes/99');

        $response = $app->handle($request);

        $this->assertEquals(404, $response->getStatusCode());

        $corpo = json_decode((string) $response->getBody(), true);

        $this->assertEquals(
            'Missão não encontrada',
            $corpo['erro']
        );
    }
}
