<?php

namespace Lbmadesia\ApiGenerator\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission\Permission;
use Lbmadesia\ApiGenerator\Repositories\ApiRepository;
use Lbmadesia\ApiGenerator\Api;

/**
 * Class ModuleController.
 *
 * @author Lb madesia <lbmadesia@gmail.com | https://github.com/lbmadesia>
 */
class ApiController extends Controller
{
    public $repository;
    public $generator;
    public $event_namespace = 'app\\Events\\Backend\\';

    /**
     * Constructor.
     *
     * @param ApiRepository $repository
     */
    public function __construct(ApiRepository $repository)
    {
        $this->repository = $repository;
        $this->generator = new ApiGenerator();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('api-generator::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('api-generator::create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->generator->initialize($request->all());
        $this->generator->createController();
        $this->generator->createRouteFiles();
        $this->repository->create($request->all());
        return redirect()->route('admin.apis.index')->with('success','Api Generated Successfully!');
    }


    public function apiRoute(Request $request)
    {
        $api = Api::where('name','=',$request->name)->first();
        if ($api) {
                return response([
                    'type'    => 'error',
                    'message' => 'route exists Already',
                ],404)->header('Content-Type','application/json');
            } else {
                return response( [
                    'type'    => 'success',
                    'message' => 'Table Name Available',
                ],200)->header('Content-Type','application/json');
            }
    }


}
