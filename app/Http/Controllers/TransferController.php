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

        //Chamando o servico de transferência
        try {

            $result = $this->transferService->transfer($payer, $payee, $request->amount);

        } catch (NotEnoughBalanceException $exception) {
            
            return response()->json([
                "message" => $exception->getMessage()
            ], 401);

        } catch (NotAuthorizedTransferException $exception) {

            return response()->json([
                "message" => $exception->getMessage()
            ], 401);
        } catch (NotificationTransferException $exception) {

            return response()->json([
                "message" => $exception->getMessage()
            ], 401);
        }

        
        if ($result) {
            return response()->json([
                "message" => 'Tranferência realizada com sucesso!'
            ], 200);
        }
        
    }

}
