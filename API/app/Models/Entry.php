<?php

namespace App\Models;

use App\Enums\Tipo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    /** @use HasFactory<\Database\Factories\EntryFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'data',
        'descricao',
        'tipo',
        'valor'
    ];

    protected $casts = [
        'tipo' => Tipo::class,
        'data' => 'date',
    ];

    public function setDataAttribute($value): void
    {
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
            $this->attributes['data'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['data'] = Carbon::parse($value)->format('Y-m-d');
        }
    }
}
