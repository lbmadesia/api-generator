<?php

namespace Lbmadesia\ApiGenerator\Repositories;

use Lbmadesia\ApiGenerator\Api;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Models\Permission\Permission;
use Illuminate\Support\Str;

/**
 * Class ApiRepository.
 */
class ApiRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Api::class;

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin('users', 'users.id', '=', 'apis.created_by')
            ->select([
                'apis.id',
                'apis.name',
                'apis.url',
                'apis.controller_path',
                'apis.view_permission_id',
                'apis.created_by',
                'apis.updated_by',
                'users.name as created_by',
            ]);
    }

    /**
     * @param array $input
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {


            $mod = [
                'name'               => $input['name'],
                'url'                => base64_encode($input['url']),
                'controller_path'    => base64_encode($input['controller_path']),
                'created_by'         => auth()->user()->id,
            ];

            $create = Api::create($mod);
            if($create)
                return $create;

        throw new GeneralException('There was some error in creating the Api. Please Try Again.');
    }
}
