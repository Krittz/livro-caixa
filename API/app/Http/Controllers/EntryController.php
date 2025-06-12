<?php

namespace App\Http\Controllers;

use App\Http\Actions\Entry\StoreEntryAction;
use App\Http\Actions\Entry\UpdateEntryAction;
use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use App\Http\Resources\EntryResource;
use App\Models\Entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EntryController extends Controller
{

    public function index(Request $request)
    {
        $query = Entry::query();

        // Filtro por descrição
        if ($request->filled('descricao')) {
            $query->where('descricao', 'like', '%' . $request->descricao . '%');
        }
        //Filtro por tipo (entrada ou saída)
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        //Fitlro por data específica
        if ($request->filled('data')) {
            try {
                $dataFormatada = \Carbon\Carbon::createFromFormat('d/m/Y', $request->data)->format('Y-m-d');
                $query->whereDate('data', $dataFormatada);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Formato de data inválido. Use DD/MM/AAAA.',
                    'code' => 422,
                ], 422);
            }
        }

        // Ordenação (campo + direção)
        if ($request->filled('sort_by')) {
            $sortBy = $request->sort_by;
            $direction = $request->get('sort_dir', 'asc');
            if (in_array($sortBy, ['data', 'descricao', 'valor']) && in_array($direction, ['asc', 'desc'])) {
                $query->orderBy($sortBy, $direction);
            }
        } else {
            $query->orderByDesc('data'); // padrão
        }

        // Paginação
        $entries = $query->paginate(10);

        // return EntryResource::collection($entries);
        return Response::success(EntryResource::collection($entries));
    }
    public function store(StoreEntryRequest $request, StoreEntryAction $action)
    {
        $entry = $action($request->validated());
        return Response::success(new EntryResource($entry), 'Lançamento criado com sucesso!', 201);
    }
    public function sumary()
    {
        $totalEntradas = Entry::where('tipo', 'entrada')->sum('valor');
        $totalSaidas = Entry::where('tipo', 'saida')->sum('valor');
        $caixaAtual = $totalEntradas - $totalSaidas;



        $start = now()->subMonth();
        $end = now();

        $prevEntradas = Entry::where('tipo', 'entrada')
            ->whereBetween('created_at', [$start->copy()->subMonth(), $start])
            ->sum('valor');

        $prevSaidas = Entry::where('tipo', 'saida')
            ->whereBetween('created_at', [$start->copy()->subMonth(), $start])
            ->sum('valor');

        $prevCaixa = $prevEntradas - $prevSaidas;

        return Response::success(
            [
                'total_entradas' => $totalEntradas,
                'total_saidas' => $totalSaidas,
                'caixa_atual' => $caixaAtual,
                'changes' => [
                    'entradas' => $this->calculateChange($prevEntradas, $totalEntradas),
                    'saidas' => $this->calculateChange($prevSaidas, $totalSaidas),
                    'caixa' => $this->calculateChange($prevCaixa, $caixaAtual),
                ],
            ],
        );
    }

    public function calculateChange($previous, $current)
    {
        if ($previous == 0) {
            return $current == 0 ? 0 : 100;
        }
        return round((($current - $previous) / $previous) * 100, 2);
    }
    public function update(UpdateEntryRequest $request, string $id, UpdateEntryAction $action)
    {
        $entry = Entry::findOrFail($id);
        $updatedEntry = $action($entry, $request->validated());

        return Response::success(new EntryResource($updatedEntry), 'Lançamento atualizado com sucesso!');
    }
    public function destroy(string $id)
    {

        $entry = Entry::findOrFail($id);
        $entry->delete();

        return Response::success(null, 'Lançamento excluído com sucesso!', 204);
    }
    public function show(string $id)
    {
        $entry = Entry::findOrFail($id);
        return Response::success(new EntryResource($entry));
    }
}
