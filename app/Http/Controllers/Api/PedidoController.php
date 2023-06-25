<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    private $pedido;

    /*Criando a função construtora da model Pedido*/
    public function __construct(\App\Models\Pedido $pedido){
        $this->pedido = $pedido;
    }

    /*Função com retorno para tratativa de Erro do JSON*/
    public function error_json(){
        return response()->json(['Erro'=>'Ocorreu um erro no envio ou recebimento do JSON, por favor contate o suporte!']);
    }

    /**Função que retorna a listagem de pedidos(Exceto excluídos) **/
    public function get_pedidos(){
        $pedidos = $this->pedido->all();
        return response()->json($pedidos);
    }

    /*Função para consulta única de pedido*/
    public function unique_pedido($id){
        $pedido = $this->pedido::find($id);
        if($pedido){
            return response()->json($pedido);
        }
        elseif($pedido == null){
            return $this->error_json();
        }
    }

    /*Função com retorno da listagem somente dos pedidos que já foram excluídos)*/
    public function get_recycle_pedidos(){
        $pedidos = $this->pedido::onlyTrashed()->get();
        return response()->json($pedidos);
    }

    /*Função para cadastrar um novo pedido*/
    public function set_pedido(Request $request){
        $data = $request->all();
        //Teste para verificação do valor do campo 'status
        $test_bool = $request->filled('status');
        if($test_bool == 1){
            $status = $data['status'];
            if($status == 'ACTIVE'){
                $pedido = $this->pedido->create($data);
                return response()->json($pedido);
            }
            else{
                return $this->error_json();
            }
        }
        else{
            $pedido = $this->pedido->create($data);
            return response()->json($pedido);
        }
    }

    /*Função para atualizar dados de um pedido*/
    public function update_pedido(Request $request){
        $data = $request->all();
        $pedido = $this->pedido->find($data['id']);
        $pedido->update($data);
        return response()->json($pedido);
    }

    /*Função para deletar(não permanentemente, já que utilizei o softdelete())*/
    public function recycle_pedido($id){
        $pedido = $this->pedido::withTrashed()->findOrFail($id);
        if ($pedido->trashed()) {
            return response()->json(['Alerta' => 'O pedido de id '.$id.' ja foi deletado anteriormente, porem e possivel restaura-lo ou deleta-lo por completo, consulte a layout de integracao da API para saber como proseguir.']);
        } else {
            $pedido->delete();
            return response()->json(['Sucesso' => 'O pedido de id '.$id.' foi removido com sucesso!!']);
        }
    }

    /*Função para restaurar um pedido que foi 'reciclado'*/
    public function restore_pedido($id){
        $pedido = $this->pedido::withTrashed()->findOrFail($id);
        if ($pedido->trashed()){
            $pedido->restore();
            return response()->json($pedido);
        }
        else{
            return response()->json(['Alerta'=>'O pedido buscado não se encontra deletado.']);
        }
    }


    /*Função para forçar a exclusão de um registro*/
    public function force_delete($id){
        $pedido = \App\Models\Pedido::withTrashed()->findOrFail($id);
        if ($pedido->trashed()){
            $pedido->forceDelete();
            return response()->json(['Sucesso'=>'O pedido de id '.$id.' foi deletado com sucesso!']);
        }
        else{
            return response()->json(['Alerta'=>'Para sua segurança o pedido não se encontra reciclado na base de dados, para exclui-lo envie uma requisição utilizando o metodo DELETE para o endpoint raiz \pedidos e envie uma requisicao para este mesmo endpoint no qual você se encontra']);
        }
    }
}
