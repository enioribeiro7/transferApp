<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAuthorizedTransferException;
use App\Exceptions\NotEnoughBalanceException;
use App\Exceptions\NotificationTransferException;
use Illuminate\Http\Request;
use App\Services\TransferService;
use App\User;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function transferAction(Request $request){

        //VALIDA DADOS DA REQUISIÇÃO
        $validator = Validator::make($request->all(), [
            'payer' => 'required|integer',
            'payee' => 'required|integer',
            'amount' => 'required',
        ],[
            'required' => 'The :attribute is required'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()], 400);
        }
        
        //PEGANDO OBJETOS DA TRANSFERÊNCIA
        $payer = User::where('cpf_cnpj', $request->payer)->first();
        $payee = User::where('cpf_cnpj', $request->payee)->first();
        
        //VALIDA DADOS DO USUÁRIO (SE PAGADOR É USUÁRIO, SE EXISTE O PAGADOR E RECEPTOR)
        if (!$payer || $payer->user_type_uuid != '4abc3646-9f97-49b1-ad30-eaff9b1e0eb3') {
            return response()->json(["message" => 'Payer not allowed or payer does not exist'], 401);
        }

        if (!$payee) {
            return response()->json(["message" => 'Payee does not exist'], 401);
        }

        //Chamando o servico de transferência
        try {
            $result = $this->transferService->transfer($payer, $payee, $request->amount);
            return response()->json(["message" => 'Transfer Success!'], 200);
            
        } catch (NotEnoughBalanceException $exception) {

            return response()->json(["message" => $exception->getMessage()], 401);

        } catch (NotAuthorizedTransferException $exception) {

            return response()->json(["message" => $exception->getMessage()], 401);

        } catch (NotificationTransferException $exception) {

            return response()->json(["message" => $exception->getMessage()], 200);
        }
        
    }

}
