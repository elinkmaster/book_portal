<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EbookTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'book_id',
        'instanceid',
        'year',
        'month',
        'isbn' ,
        'class_of_trade',
        'line_item_no',
        'transactiondate',
        'teritorysold',
        'quantity',
        'agentid',
        'price',
        'proceeds',
        'royalty'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
