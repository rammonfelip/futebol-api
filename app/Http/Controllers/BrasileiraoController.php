<?php

namespace App\Http\Controllers;

use App\Services\FutebolAPIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BrasileiraoController extends Controller
{
    public function __construct(
        protected FutebolAPIService $apiService
    )
    {}

    public function campeonato():Response
    {
        try {
            $campeonato = $this->apiService->getCampeonato();

            return response()->json([
                'nome' => $campeonato->nome_popular,
                'temporada' => $campeonato->temporada,
                'logo' => $campeonato->image_url
            ]);
        } catch (\Throwable $th) {
            Log::info('Erro ao buscar campeonato: ' . $th->getMessage());

            return response()->json(['message' => 'Erro ao buscar dados do campeonato'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function tabela()
    {
        try {
            return $this->apiService->getTabela();
        } catch (\Throwable $th) {
            Log::info('Erro ao buscar tabela: ' . $th->getMessage());

            return response()->json(['message' => 'Erro ao buscar dados da tabela'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function proximasPartidas(int $timeId)
    {
        try {
            return $this->apiService->getPartidas($timeId);
        } catch (\Throwable $th) {
            Log::info('Erro ao buscar partidas: ' . $th->getMessage());

            return response()->json(['message' => 'Erro ao buscar partidas'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
