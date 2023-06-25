<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Pedido extends Model
{
    //Utilizando SoftDeletes para a criação e inserção de dados na coluna 'deleted_at'
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'category', 'status', 'quantity'];
}
