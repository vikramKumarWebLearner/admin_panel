<?php

namespace App\Repositories;

use App\Models\UserTest;
use App\Repositories\BaseRepository;

/**
 * Class UserTestRepository
 * @package App\Repositories
 * @version March 5, 2024, 11:50 am +07
*/

class UserTestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'role_name'
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
        return UserTest::class;
    }
}
