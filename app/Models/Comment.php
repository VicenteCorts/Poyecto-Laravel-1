<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    
    //Relación Many to One
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    //Relación Many to One
    public function image(): BelongsTo {
        return $this->belongsTo(Image::class);
    }
}
