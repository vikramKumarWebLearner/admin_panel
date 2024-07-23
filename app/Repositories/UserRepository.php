<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version July 24, 2021, 2:31 am UTC
*/

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function getUsersByWhere(string $field, string $value)
    {
        return User::where($field, $value)->get();
    }

    public function getUsersDataByEmailTokenCount(string $email, string $token)
    {
        return User::where('email', $email)
                    ->where('remember_token', $token)
                    ->count();
    }
}
