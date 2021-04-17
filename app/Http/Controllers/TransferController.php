<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransferService;
use App\User;
use Illuminate\Support\Facades\DB;

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
        //$balancePayer = Balance::where('user_uuid',$payer->uuid)->first();

        //VALIDA DADOS DO USUÁRIO (SE PAGADOR É USUÁRIO, SE EXISTE O PAGADOR E RECEPTOR)


        //Chamando o servico de transferência
        $result = $this->transferService->transfer($payer, $payee, $request->value);

        //Serviço de Notificação
        //$notification = $this->NotificationTransferController->sentNotification();
        
        
        
        return $result;
        
    }

}
