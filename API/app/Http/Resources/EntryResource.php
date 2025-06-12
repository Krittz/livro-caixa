<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'data' => Carbon::parse($this->data)->format('d/m/Y'),
            'descricao' => $this->descricao,
            'tipo' => $this->tipo->value,
            'valor' => 'R$ ' . number_format($this->valor, 2, ',', '.'),
        ];
    }
}
