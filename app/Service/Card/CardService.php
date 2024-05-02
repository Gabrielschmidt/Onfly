<?php

namespace App\Service\Card;

use App\Repository\Card\CardRepositoryInterface;
use App\Exceptions\MyException;

class CardService
{
    public function __construct(
        protected CardRepositoryInterface $repository,
    ) {
    }

    public function create($request): array
    {
        if ($request->balance <= 0) {
            throw new MyException('Saldo não pode ser zero ou negativo!');
        }

        $card = $this->repository->create($request);

        if (!$card) {
            throw new MyException('Erro ao criar cartão.');
        }

        return $card;
    }

    public function get(string $cardId): array
    {
        return $this->repository->get($cardId);
    }

    // public function new(CreateSupportDTO $dto): stdClass
    // {
    //     return $this->repository->new($dto);
    // }

    // public function update(UpdateSupportDTO $dto): stdClass|null
    // {
    //     return $this->repository->update($dto);
    // }

    // public function delete(string $id): void
    // {
    //     $this->repository->delete($id);
    // }    
}
