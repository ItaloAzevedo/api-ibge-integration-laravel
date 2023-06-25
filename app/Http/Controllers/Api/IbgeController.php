<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class IbgeController extends Controller
{
    /*Criada uma váriavel para acesso da URL nasque será utilizada nas
    funções integrador_ibge() e consulta_ibge()*/
    private $url = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados/33/municipios';
    private $ibge;

    /*Criando a função construtora para acessar a model Ibge*/
    public function __construct(\App\Models\Ibge $ibge){
        $this->ibge = $ibge;
    }


    /*Função que no primeiro momento irá fazer a consulta na API Externa, e logo após fazer a consulta
    irá rodar uma comparação de dados, verificando se o dado 'id' da API do IBGE se encontra cadastrado
    na base de dados da API comparando com a campo 'ibge_id';

    Se não encontrar os dados ela irá cadastrar cada registro e dará um retorno confirmando que os dados
    foram importados com sucesso, e que a proxima requisição a ser feita nessa rota já será uma consulta da
    tabela IBGE da base de dados com os dados integrados.
    */
    public function integrador_ibge(){
        $resposta_ibge = \Http::get($this->url);
        $dados_ibge = json_decode($resposta_ibge,true);//true irá converter o objeto em arrays associativos
        foreach($dados_ibge as $dado_ibge) {
            $dado_existente = \App\Models\Ibge::where('ibge_id', $dado_ibge['id'])->first();
            if(!$dado_existente){
                \App\Models\Ibge::create(['ibge_id'=>$dado_ibge['id'],'ibge_name'=>$dado_ibge['nome']]);
            }
            else{
                $dados_banco = $this->ibge->all();
                return response()->json($dados_banco);
            }
        }
        return response()->json(['menssagem'=>['Os dados foram importados com sucesso, faça uma nova requisição para este mesmo endpoint para consultar os dados registrados na base de dados!']]);
    }


    /*Função de consulta a API externa do IBGE*/
    public function consulta_ibge(){
        $resposta = \Http::get($this->url);
        return response()->json($resposta->json());
    }
}
