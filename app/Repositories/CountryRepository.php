<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\BaseRepository;

/**
 * Class CountryRepository
 * @package App\Repositories
 * @version June 23, 2023, 4:23 pm +07
*/

class CountryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'short_code',
        'code',
        'status',
        'image'
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
        return Country::class;
    }

    public function getAllCountriesForClient()
    {
        return Country::pluck('name', 'id');
    }
}
