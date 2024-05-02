<?php

namespace App\Repository\User;


use App\Models\User;
use App\Repository\User\UserRepositoryInterface;
use App\Exceptions\MyException;
use PhpParser\Node\Stmt\Catch_;

class UserRepositoryEloquent implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ) {
    }
    
    public function create($request): array
    {
        try {
            $user = $this->model->create([
                'type_user_id' => $request->type_user_id,
                'name' => $request->name,
                'email' => $request->email,
            ]);
        } catch (\Exception $e) {
            throw new MyException('Erro ao cadastrar o usuário: ' . $e->getMessage());
        }
        return (array) $user->toArray();
    }

    public function update($request): array
    {
        try {
            $user = $this->model::findOrFail($request->id);
            $user->update([
                'type_user_id' => $request->type_user_id,
                'name' => $request->name,
                'email' => $request->email,
            ]);
        } catch (\Exception $e) {
            throw new MyException('Erro ao atualizar o usuário: ' . $e->getMessage());
        }

        return (array) $user->toArray();
    }  

    public function get(string $user_id): array
    {
        try {
            $user = $this->model::findOrFail($user_id)->get('*');
        } catch (\Exception $e) {
            throw new MyException('Erro ao listar usuário: ' . $e->getMessage());
        }

        return (array) $user->toArray();
    }

    public function getUsersToSendMail($card_id): array
    {
        $user_from_card = $this->model::leftJoin('cards', 'cards.user_id','=','users.id')->where('cards.id',$card_id)->first();
        $users_to_send_mail = $this->model::where('type_user_id', 2)->union($user_from_card)->get();

        return $users_to_send_mail->toArray();
    }

    public function getAllWithCardsAndExpenses(string $user_id, $type_user_id): array
    {
        $users = $this->model::with('cards.expenses')
        ->where(function ($query) use ($type_user_id, $user_id) {
            if ($type_user_id == 2) {
                $query->where('id', $user_id);
            }
        })
        ->get();

        $userData = $users->map(function ($user) {
            return [
                'name' => $user->name,
                'cards' => $user->cards->map(function ($card) {
                    return [
                        'number' => $card->number,
                        'balance' => $card->balance,
                        'expenses' => $card->expenses->map(function ($expense) {
                            return [
                                'transaction' => $expense->transaction,
                                'date' => $expense->created_at,
                            ];
                        })->toArray(),
                    ];
                })->toArray()
            ];
        });

        return $userData->toArray();
    }

    public function delete($id): bool
    {
        try {
            $user = $this->model::findOrFail($id);
            $user->delete();
            return true;
        } catch (\Exception  $e) {
            throw new MyException('Erro ao excluir o usuário: ' . $e->getMessage());
        }
    }
}
