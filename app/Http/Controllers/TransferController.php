<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAuthorizedTransferException;
use App\Exceptions\NotEnoughBalanceException;
use App\Exceptions\NotificationTransferException;
use Illuminate\Http\Request;
use App\Services\TransferService;
use App\User;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransferController extends Controller
{
    public const MESSAGE_SUCCESS = 'Transfer Success!';
    

    public function __construct(
        TransferService $transferService
    ) {
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
            return response()->json([$validator->errors()], Response::HTTP_BAD_REQUEST);
        }
        
        $payer = User::where('cpf_cnpj', $request->payer)->first();
        $payee = User::where('cpf_cnpj', $request->payee)->first();

        if (!$payee || !$payer) {
            return response()->json(["message" => 'Payee or Payer do not exist'], Response::HTTP_UNAUTHORIZED);
        }

        try {
            $result = $this->transferService->transfer($payer, $payee, $request->amount);

            return response()->json(["message" => self::MESSAGE_SUCCESS], Response::HTTP_OK);
            
        } catch (NotEnoughBalanceException $exception) {

            return response()->json(["message" => $exception->getMessage()], Response::HTTP_UNAUTHORIZED);

        } catch (NotAuthorizedTransferException $exception) {

            return response()->json(["message" => $exception->getMessage()], Response::HTTP_UNAUTHORIZED);

        } catch (NotificationTransferException $exception) {

            return response()->json(["message" => self::MESSAGE_SUCCESS], Response::HTTP_OK);

        } catch (\Throwable $exception) {

            return response()->json(["message" => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }

}
