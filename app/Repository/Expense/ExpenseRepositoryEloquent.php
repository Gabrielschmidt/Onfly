<?php

namespace App\Repository\Expense;

use App\Models\Expense;
use App\Repository\Expense\ExpenseRepositoryInterface;
use App\Exceptions\MyException;

class ExpenseRepositoryEloquent implements ExpenseRepositoryInterface
{
    public function __construct(
        protected Expense $model,
    ) {
    }
    
    public function create($request): array
    {
        try {
            $user = $this->model->create([
                'card_id' => $request->card_id,
                'transaction' => $request->transaction,
            ]);
        } catch (\Exception $e) {
            throw new MyException('Erro ao cadastrar a transação: ' . $e->getMessage());
        }
        return (array) $user->toArray();

        // $user = $this->model->create([
        //     'card_id' => $request->card_id,
        //     'transaction' => $request->transaction,
        // ]);
        // return (array) $user->toArray();
    }

    // public function get($user_id, $type_user_admin = null): array
    // {
    //     $users = $this->modelUser::with('cards.expenses')->get(); 
    //     $userData = $users->map(function ($user) {
    //         return [
    //             'name' => $user->name,
    //             'cards' => $user->cards->map(function ($card) {
    //                 return [
    //                     'number' => $card->number,
    //                     'balance' => $card->balance,
    //                     'expenses' => $card->expenses->map(function ($expense) {
    //                         return [
    //                             'transaction' => $expense->transaction,
    //                             'date' => $expense->created_at,
    //                         ];
    //                     })->toArray(),
    //                 ];
    //             })->toArray()
    //         ];
    //     });

    //     return $userData->toArray();
    // }

    // public function update(UpdateSupportDTO $dto): stdClass|null
    // {
    //     if (!$support = $this->model->find($dto->id)) {
    //         return null;
    //     }

    //     if (Gate::denies('owner', $support->user->id)) {
    //         abort(403, 'Not Authorized');
    //     }

    //     $support->update(
    //         (array) $dto
    //     );

    //     return (object) $support->toArray();
    // }    

    // public function delete(string $id): void
    // {
    //     $support = $this->model->findOrFail($id);

    //     if (Gate::denies('owner', $support->user->id)) {
    //         abort(403, 'Not Authorized');
    //     }

    //     $support->delete();
    // }
}
