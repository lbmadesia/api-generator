<?php

namespace Lbmadesia\ApiGenerator\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Lbmadesia\ApiGenerator\Repositories\ApiRepository;

class ApiTableController extends Controller
{
    /**
     * @var ApiRepository
     */
    protected $api;

    /**
     * @param ApiRepository $api
     */
    public function __construct(ApiRepository $api)
    {
        $this->api = $api;
    }

    /**
     * @param Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return Datatables::of($this->api->getForDataTable())
            ->escapeColumns(['name', 'url', 'view_permission_id'])
            ->addColumn('controller_path', function ($api) {
                return base64_decode($api->controller_path);
            })
            ->addColumn('url', function ($api) {
                return base64_decode($api->url);
            })
            ->addColumn('created_by', function ($api) {
                return $api->created_by;
            })
            ->make(true);
    }
}
