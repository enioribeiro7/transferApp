<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\NotificationTransferController;
use App\User;
use App\Balance;

class TransferController extends Controller
{

    public function __construct(NotificationTransferController $NotificationTransferController)
    {
        $this->NotificationTransferController = $NotificationTransferController;
    }

    public function transferAction(Request $request){

        //VALIDA DADOS DA REQUISIÇÃO

        //PEGANDO OBJETOS DA TRANSFERÊNCIA
        $payer = User::where('cpf_cnpj', $request->payer)->first();
        $payee = User::where('cpf_cnpj', $request->payee)->first();
        $balancePayer = Balance::where('user_uuid',$payer->uuid)->first();

        //VALIDA DADOS DO USUÁRIO (SE PAGADOR É USUÁRIO, SE EXISTE O PAGADOR E RECEPTOR)



        //Serviço de Notificação
        $notification = $this->NotificationTransferController->sentNotification();


        //Retornando o Sucesso
        return response()->json([
            "message" => "Tranferência realizada com sucesso"
        ], 200); 

    }

}
