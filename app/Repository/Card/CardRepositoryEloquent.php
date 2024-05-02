<?php

namespace App\Repository\Card;

use App\Models\Card;
use App\Repository\Card\CardRepositoryInterface;
use App\Exceptions\MyException;

class CardRepositoryEloquent implements CardRepositoryInterface
{
    public function __construct(
        protected Card $model
    ) {
    }
    
    public function create($request): array
    {
        try {
            $card = $this->model->create([
                'user_id' => $request->user_id,
                'number' => $request->number,
                'balance' => $request->balance,
            ]);
        } catch (\Exception $e) {
            throw new MyException('Erro ao cadastrar o cartão: ' . $e->getMessage());
        }
        return (array) $card->toArray();
    }

    public function updateBalance(float $new_balance_value, string $card_id): array
    {
        $new_balance = $this->model->where('id', $card_id)->update([
            'balance' => $new_balance_value
        ]);

        return (array) $new_balance;
    } 
    public function get(string $card_id): array
    {
        try {
            $user = $this->model::findOrFail($card_id)->get('*');
        } catch (\Exception $e) {
            throw new MyException('Erro ao listar cartão: ' . $e->getMessage());
        }

        return (array) $user->toArray();
    }
}
