<?php

namespace App\Http\Controllers;

use App\Service\Card\CardService;
use Illuminate\Http\Request;
use App\Exceptions\MyException;
use Illuminate\Http\Response;

class CardController extends Controller
{
    public function __construct(
        protected CardService $service,
    ) {
    }
    
    public function create(Request $request)
    {
        try {
            $card = $this->service->create(json_decode($request->getContent()));
            return response()->json(['message' => $card], Response::HTTP_OK);
        } catch (MyException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function list(string $cardId)
    {
        try {
            $card = $this->service->get($cardId);
            return response()->json(['message' => $card], Response::HTTP_OK);
        } catch (MyException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}