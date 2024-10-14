<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $table = 'images'; //Indicamos cual es la tabla que modifica este modelo
    protected $primaryKey = 'id';
    
    //Relación One to Many
    public function comments(): HasMany {
        return $this->hasMany(Comment::class)->orderBy('id', 'desc');
    }
    
    //Relación One to Many
    public function likes(): HasMany{
        return $this->hasMany(Like::class);
    }
    
    //Relación Many to One
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    
}
