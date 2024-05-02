<?php

namespace App\Service\User;

use App\Repository\User\UserRepositoryInterface;
use App\Exceptions\MyException;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository,
    ) {
    }

    public function create($request): array
    {
        $user = $this->repository->create($request);

        if (!$user) {
            throw new MyException('Erro ao criar usuário.');
        }

        return $user;
    }

    public function update($request): array
    {
        $user = $this->repository->update($request);
        if (!$user) {
            throw new MyException('Erro ao atualizar usuário.');
        }
        return $user;
    }

    public function get(string $id): array
    {
        $user = $this->repository->get($id);

        if (!$user) {
            throw new MyException('Erro ao listar dados do usuário.');
        }

        return $user;
    }
    public function delete(string $id): void
    {
        if (!$this->repository->delete($id)) {
            throw new MyException('Erro ao excluir o usuário.');
        } 
    }
}
