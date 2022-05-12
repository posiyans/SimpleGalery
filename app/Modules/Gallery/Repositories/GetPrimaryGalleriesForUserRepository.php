<?php

namespace App\Modules\Gallery\Repositories;

use App\Models\User;
use App\Modules\Gallery\Models\MediaDirModel;

/**
 * Получить корневые галереи пользователя или публичные
 */
class GetPrimaryGalleriesForUserRepository
{

    private $query;

    public function __construct(User $user)
    {
        $this->query = MediaDirModel::query();
        $this->query->where('parent_id', null);
        $this->query->where(function ($q) use($user){
            $q->where('user_id', $user->id)->orWhere('access','public');
        });
    }

    public function run()
    {
        return $this->query->get();
    }
}
