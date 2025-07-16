<?php

namespace App\Repositories\User\Contracts;

use App\Repositories\Base\Contracts\QueryableRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface extends QueryableRepositoryInterface
{
    /**
     * Return All Users
     */
    public function getUsers(): Collection;

    public function getActiveUsers(): Collection;
}
