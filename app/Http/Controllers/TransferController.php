<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransferService;
use App\User;
use App\Balance;
use Illuminate\Support\Facades\Http;

class TransferController extends Controller
{

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function transferAction(Request $request){

        //VALIDA DADOS DA REQUISIÇÃO

        //PEGANDO OBJETOS DA TRANSFERÊNCIA
        $payer = User::where('cpf_cnpj', $request->payer)->first();
        $payee = User::where('cpf_cnpj', $request->payee)->first();
        $balancePayer = Balance::where('user_uuid',$payer->uuid)->first();

        //VALIDA DADOS DO USUÁRIO (SE PAGADOR É USUÁRIO, SE EXISTE O PAGADOR E RECEPTOR)


        //Chamando o servico de transferência
        $this->transferService->transfer($payer, $payee, $balancePayer->balance);


        //Serviço de Notificação
        //$notification = $this->NotificationTransferController->sentNotification();


        //Retornando o Sucesso
        return response()->json([
            "message" => "Tranferência realizada com sucesso"
        ], 200); 

    }

}
