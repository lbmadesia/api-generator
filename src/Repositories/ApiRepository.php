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
    public function create(array $input, array $permissions)
    {
        $api = Api::where('name', $input['name'])->first();

        if (!$api) {
            $name = $input['model_name'];
            $model = strtolower($name);

            foreach ($permissions as $permission) {
                $perm = [
                    'name'         => $permission,
                    'display_name' => ucfirst(str_replace('-', ' ', $permission)).' Permission',
                ];
                //Creating Permission
                $per = Permission::firstOrCreate($perm);
            }

            $mod = [
                'view_permission_id' => "view-$model-permission",
                'name'               => $input['name'],
                'url'                => 'admin.'. Str::plural($model).'.index',
                'created_by'         => auth()->user()->id,
            ];

            $create = Api::create($mod);

            return $create;
        }
        else {
            return $api;
        }

        throw new GeneralException('There was some error in creating the Api. Please Try Again.');
    }
}
