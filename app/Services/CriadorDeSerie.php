<?php

namespace App\Services;

use App\Models\{Serie, Temporada};
use Illuminate\Support\Facades\DB;

class CriadorDeSerie 
{
    public function criarSerie(string $nomeserie, int $qtdTemporadas, int $epPorTemporada) : Serie
    {
        $serie = null;

        DB::beginTransaction();
        $serie = Serie::create(['nome' => $nomeserie]);
        $this->criaTemporadas($qtdTemporadas, $epPorTemporada, $serie);
        DB::commit();

        return $serie;
    }

    private function criaTemporadas(int $qtdTemporadas, int $epPorTemporada, Serie $serie)
    {
        for ($i = 1; $i <= $qtdTemporadas; $i++) {
            $temporada = $serie->temporadas()->create(['numero' => $i]);
            $this->criaEpisodios($epPorTemporada, $temporada);
        }
    }

    private function criaEpisodios($epPorTemporada, Temporada $temporada)
    {
        for ($j = 1; $j <= $epPorTemporada; $j++) {
            $temporada->episodios()->create(['numero' => $j]);
        }
    }
}