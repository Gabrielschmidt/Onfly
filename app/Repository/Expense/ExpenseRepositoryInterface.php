<?php

namespace App\Repository\Expense;

interface ExpenseRepositoryInterface
{
    public function create($request): array;
    // public function get($user_id, $type_user): array;
    // public function update(UpdateSupportDTO $dto): stdClass|null;
    // public function delete(string $id): void;
}
