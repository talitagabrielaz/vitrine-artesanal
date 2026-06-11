<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nome', 'descricao', 'preco', 'imagem_url', 'catalogo_pdf_url', 'usuario_id', 'categoria_id'])]
class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
