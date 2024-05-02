<?php

namespace App\Repository\User;

interface UserRepositoryInterface
{
    public function create(Request $request): array;
    public function update(Request $request): array;
    public function getAllWithCardsAndExpenses(string $user_id, $user_type): array;
    public function getUsersToSendMail($card_id): array;
    public function get(string $user_id): array;
    public function delete(string $id): bool;
}
