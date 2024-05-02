<?php

namespace App\Repository\Card;

use App\DTO\Supports\{
    CreateSupportDTO,
    UpdateSupportDTO
};
use App\Enums\SupportStatus;
use stdClass;

interface CardRepositoryInterface
{
    public function create(Request $dto): array;
    public function get(string $cardId): array;
    public function updateBalance(float $newBalanceValue, string $cardId): array;
    // public function delete(string $id): void;
}
