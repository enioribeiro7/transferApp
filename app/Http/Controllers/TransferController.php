<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\TransferValidateController;
use App\Http\Controllers\NotificationTransferController;
use App\User;
use App\Balance;

class TransferController extends Controller
{

    public function __construct(TransferValidateController $TransferValidateController, NotificationTransferController $NotificationTransferController)
    {
        $this->TransferValidateController = $TransferValidateController;
        $this->NotificationTransferController = $NotificationTransferController;
    }

    public function transferAction(Request $request){

        //Pegando objetos da transferência
        $payer = User::where('cpf_cnpj', $request->payer)->first();
        $payee = User::where('cpf_cnpj', $request->payee)->first();
        $balancePayer = Balance::where('user_uuid',$payer->uuid)->first();

        //VALIDA DADOS DO USUÁRIO (SE PAGADOR É USUÁRIO, SE EXISTE O PAGADOR E RECEPTOR)

        //VALIDA DADOS DA REQUISIÇÃO

        //VALIDA SALDO

        //CONSULTA VALIDADOR EXTERNO
        $authorization = $this->TransferValidateController->getAuthorization();
        if ($authorization != 200) {

            //remove saldo do usuário
            return response()->json([
                "message" => "Tranferência não autorizada"
            ], 401); 

        }


        //Atualiza saldo do usuário
        $newBalancePayer = floatval($balancePayer->balance) - floatval($request->valor);
        $balance = Balance::find($balancePayer->id);
        $balance->balance =  $newBalancePayer;
        $balance->save();

        //Serviço de Notificação
        $notification = $this->NotificationTransferController->sentNotification();


        //Retornando o Sucesso
        return response()->json([
            "message" => "Tranferência realizada com sucesso"
        ], 200); 

    }


    public function teste(){

        $requestData = '{
            "valor": "50,00",
            "payer": "33922288819",
            "payee": "10702387401"
        }';

        $requestData = json_decode($requestData);

        $payer = User::where('cpf_cnpj', $requestData->payer)->first();
        $payee = User::where('cpf_cnpj', $requestData->payee)->first();

        return json_encode($payer);


    }
}
