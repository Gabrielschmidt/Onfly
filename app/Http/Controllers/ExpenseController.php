<?php

namespace App\Http\Controllers;

use App\Service\Expense\ExpenseService;
use Illuminate\Http\Request;
use App\Exceptions\MyException;
use Illuminate\Http\Response;

class ExpenseController extends Controller
{
    public function __construct(
        protected ExpenseService $service,
    ) {
    }
    
    public function create(Request $request)
    {
        try {
            $expense = $this->service->create(json_decode($request->getContent()));
            return response()->json(['message' => $expense], Response::HTTP_OK);
        } catch (MyException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function list(string $user_id)
    {
        try {
            $expense = $this->service->get($user_id);
            return response()->json(['message' => $expense], Response::HTTP_OK);
        } catch (MyException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}