<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ibge extends Model
{

    /*Devido snake-case que pluraliza o nome da tabela
      é necessário criar uma variável encapsulada com o nome da tabela.*/
    protected $table = 'ibge';

    /*Necessário configurar para que inserção na base de dados
      ele não busque as colunas de criação e atualização, já que não foram criadas na migration*/
    public $timestamps = false;

    protected $fillable = ['ibge_id', 'ibge_name'];
}
