<?php

namespace App\Repositories;

use App\Models\Testing;
use App\Repositories\BaseRepository;

/**
 * Class TestingRepository
 * @package App\Repositories
 * @version March 4, 2024, 12:42 pm +07
*/

class TestingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type'
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
        return Testing::class;
    }
}
