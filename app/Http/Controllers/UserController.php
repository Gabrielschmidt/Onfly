<?php

namespace App\Http\Controllers;

use App\Service\User\UserService;
use Illuminate\Http\Request;
use App\Exceptions\MyException;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service,
    ) {
    }
    
    public function create(Request $request)
    {
        try {
            $user = $this->service->create(json_decode($request->getContent()));
            return response()->json(['message' => $user], Response::HTTP_OK);
        } catch (MyException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = $this->service->update(json_decode($request->getContent()));
            return response()->json(['message' => $user], Response::HTTP_OK);
        } catch (MyException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    public function list(string $id)
    {
        try {
            $user = $this->service->get($id);
            return response()->json(['message' => $user], Response::HTTP_OK);
        } catch (MyException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Usuário excluído com sucesso.'], Response::HTTP_OK);
        } catch (MyException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}