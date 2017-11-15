<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleCategary extends Model
{
    protected $table = 'article_categary';

    protected $fillable = [
        'pid', 'name', 'sort',
    ];
}
