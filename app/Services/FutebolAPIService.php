<?php

namespace App\Services;

use App\Models\Campeonato;
use App\Models\Tabela;
use Illuminate\Support\Facades\Http;

class FutebolAPIService
{
    private string $apiBaseUrl;
    private string $apiKey;
    private string $brasileiraoId;

    public function __construct()
    {
        $this->apiKey = config('services.futebol_api.api_key');
        $this->apiBaseUrl = config('services.futebol_api.base_url');
        $this->brasileiraoId = config('services.futebol_api.brasileirao_id');
    }

    public function getCampeonato()
    {
        $data = $this->makeRequest("campeonatos/$this->brasileiraoId");

        return Campeonato::updateOrCreate([
            'external_id' => $data['campeonato_id']
        ],[
            'nome' => $data['nome'],
            'slug' => $data['slug'],
            'nome_popular' => $data['nome_popular'],
            'temporada' => $data['edicao_atual']['temporada'],
            'image_url' => $data['logo']
        ]);
    }

    public function getTabela()
    {
        $data = $this->makeRequest("campeonatos/$this->brasileiraoId/tabela");

        foreach ($data as $value) {
            Tabela::updateOrCreate([
                'campeonato_id' => $this->brasileiraoId,
                'time_id' => $value['time']['time_id']
            ],[
                'time_nome' => $value['time']['nome_popular'],
                'time_sigla' => $value['time']['sigla'],
                'time_logo' => $value['time']['escudo'],
                'posicao' => $value['posicao'],
                'pontos' => $value['pontos'],
                'jogos' => $value['jogos'],
                'vitorias' => $value['vitorias'],
                'empates' => $value['empates'],
                'derrotas' => $value['derrotas'],
            ]);
        }

        return Tabela::where('campeonato_id', $this->brasileiraoId)
            ->orderBy('posicao')
            ->get();
    }

    public function getPartidas(int $timeId)
    {
        $response = $this->makeRequest("times/$timeId/partidas/proximas");
        $data = [];

        foreach ($response as $partidas) {
            foreach ($partidas as $partida) {
                $data[] = [
                    'campeonato' => $partida['campeonato']['nome'],
                    'placar' => $partida['placar'],
                    'data' => $partida['data_realizacao'],
                    'hora' => $partida['hora_realizacao'],
                    'estadio' => $partida['estadio']['nome_popular'],
                ];
            }
        }

        return $data;
    }

    private function makeRequest(string $endpoint, array $params = []): array
    {
        $maxAttempts = 5;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            $attempt++;

            $response = Http::withToken($this->apiKey)
                ->get($this->apiBaseUrl . $endpoint, $params);

            if ($response->successful())
                return $response->json();

            throw new \Exception("Erro na API: " . $response->status());
        }

        throw new \Exception("Tentativas Excedidas para " . $endpoint);
    }
}
