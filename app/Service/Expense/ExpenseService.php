<?php

namespace App\Service\Expense;

use App\Repository\Expense\ExpenseRepositoryInterface;
use App\Repository\Card\CardRepositoryInterface;
use App\Repository\User\UserRepositoryInterface;
use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\MyException;

class ExpenseService
{
    public function __construct(
        protected ExpenseRepositoryInterface $repository,
        protected CardRepositoryInterface $cardRepositoryInterface,
        protected UserRepositoryInterface $userRepositoryInterface,
    ) {
    }

    public function create($request): array
    {
        $new_balance_value = $this->verifyBalance($request);
        if (!is_numeric($new_balance_value)) {
            throw new MyException('Erro ao processar saldo!');
        }

        $new_expense = $this->repository->create($request);
        if (!$new_expense) {
            throw new MyException('Erro ao processar nova transação!');
        }

        $update_balance = $this->cardRepositoryInterface->updateBalance($new_balance_value, $request->card_id);
        if (!$update_balance) {
            throw new MyException('Erro ao atualizar saldo!');
        }

        $users_to_send_mail = $this->userRepositoryInterface->getUsersToSendMail($request->card_id);
        $this->sendMail($users_to_send_mail, $request);

        return $new_expense;
    }

    private function sendMail($users, $request){
        foreach ($users as $user) {
            try {
                Mail::to($user['email'])->send(new NotificationEmail($user['name'], $request->card_id,  $request->transaction));
            } catch (\Exception $e) {
                throw new MyException('Erro ao enviar email!' . $e->getMessage());
            }
        }
    }

    private function verifyBalance($request){
        $verify_balance = $this->cardRepositoryInterface->get($request->card_id);
        if ($verify_balance[0]['balance'] < $request->transaction) {
            throw new MyException('Saldo insuficiente para transação!');
        }

        return $verify_balance[0]['balance'] - $request->transaction;
    }

    private function getUser($user_id){
        $user = $this->userRepositoryInterface->get($user_id);
        if (!$user) {
            throw new MyException('Não foi possível localizar o usuário!');
        }

        return $user;
    }

    public function get(string $user_id): array
    {
        $user_type = $this->getUser($user_id)[0]['type_user_id'];

        if (!$user_type) {
            throw new MyException('Erro ao listar tipo do usuário.');
        }

        $all_data_from_cards_and_expenses = $this->userRepositoryInterface->getAllWithCardsAndExpenses($user_id, $user_type);
        if (!$all_data_from_cards_and_expenses) {
            throw new MyException('Erro ao listar dados de transação por usuário.');
        }

        return $all_data_from_cards_and_expenses;
    }
}
