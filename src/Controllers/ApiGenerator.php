<?php

namespace Lbmadesia\ApiGenerator\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Class Generator.
 *
 * @author Lb madesia <lbmadesia@gmail.com | https://github.com/lbmadesia>
 */
class ApiGenerator
{

    /**
     * Files Object.
     */
    protected $files;

    /**
     * Directory Name.
     */
    protected $directory;

       /**
     * Route Path.
     */
    protected $route_path = 'routes\\Api\\';
    protected $route;
    protected $route_controller;

    /**
     * Api Path.
     */
    protected $api_path;

    /**
     * auth
     */
    protected $auth;

    /**
     * auth
     */

    protected $model_namespace;
    protected $model_name;
    protected $name;


    protected $controller;
    protected $table_controller;
    protected $controller_namespace = 'App\\Http\\Controllers\\Api\\V1\\';

   public $last_index;
   public $modelname;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->files = new Filesystem();
    }

    /**
     * Initialization.
     *
     * @param array $input
     */
    public function initialize($input)
    {
        //Module
        $this->route = str_replace(' ' , '',$input['name']);
        $this->name = str_replace(' ' , '', Str::singular(ucfirst($input['name'])));

        //Directory
        $this->directory = str_replace(' ' , '', Str::singular(ucfirst($input['folder'])));


        //Model
        $this->model_namespace = $input['model_class'];

        $this->modelname = explode('\\',$this->model_namespace);
        $this->last_index = (count($this->modelname)-1);
        $this->model_name = $this->modelname[$this->last_index];

        //api_path
        $this->api_path = $input['api_path'];

        $this->controller = $this->name.'Controller';
        if(trim($input['folder']) != '')
            $this->route_controller = $this->directory.'/'.$this->controller;
        else
            $this->route_controller = $this->controller;

        //Generate Namespaces
        $this->createNamespacesAndValues();
        if(isset($input['auth']))
          $this->auth = true;
        else
            $this->auth = false;
    }

    /**
     * @return void
     */
    private function createNamespacesAndValues()
    {
        //Controller Namespace
        if($this->directory != "")
            $this->controller_namespace .= $this->directory.'\\';

    }



    public function getRoutePath()
    {
        return $this->route_path;
    }




    /**
     * @return void
     */
    public function createDirectory($path)
    {
        $this->files->makeDirectory($path, 0777, true, true);
    }



    public function createController()
    {
        $this->createDirectory($this->getBasePath($this->controller_namespace, true));
        //Getting stub file content
        $file_contents = $this->files->get($this->getStubPath().'Controller.stub');
        //Replacements to be done in controller stub
        $replacements = [
            'DummyModelNamespace'         => $this->model_namespace,
            'dummy_model_name'                  => $this->model_name,
            'DummyArgumentName'           => strtolower($this->model_name),
            'DummyController'             => $this->controller,
            'DummyNamespace'              => ucfirst($this->removeFileNameFromEndOfNamespace($this->controller_namespace)),
        ];

        $this->generateFile(false, $replacements, lcfirst($this->controller_namespace.$this->controller), $file_contents);
    }

    /**
     * @return void
     */
    public function createRouteFiles()
    {

        $api_file = base_path('routes/api.php');

        //file_contents of Backend.php
        $file_contents = file_get_contents($api_file);
        //If this is already not there, then only append
        $data = "\n/*\n* Start Routes From Api Generator\n*/\n Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1', 'as' => 'v1.'], function () { \n require 'Api/api.php'; \n }); \n/*\n*route with auth\n*/\n Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1', 'as' => 'v1.', 'middleware' => 'auth:sanctum'], function () { \n require 'Api/apiAuth.php'; \n }); \n/*\n* End Routes From Api Generator\n*/\n";
        if (!strpos($file_contents, "require 'Api/api.php'")) {
            $content = $data;
            //Appending into api.php file
            file_put_contents($api_file, $content, FILE_APPEND);
        }
        if($this->auth){
            $api_auth = base_path('routes/Api/apiAuth.php');
            $file_contents = file_get_contents($api_auth);
            $data = "Route::apiResource('".$this->route."', '".$this->route_controller."');";
            if (!strpos($file_contents, $data)) {
                $content = "\n".$data."\n";
                //Appending into api.php file
                file_put_contents($api_auth, $content, FILE_APPEND);
            }
        }
        else{
            $api_noauth = base_path('routes/Api/api.php');
            $file_contents = file_get_contents($api_noauth);
            $data = "Route::apiResource('".$this->route."', '".$this->route_controller."');";
            if (!strpos($file_contents, $data)) {
                $content = "\n".$data."\n";
                //Appending into api.php file
                file_put_contents($api_noauth, $content, FILE_APPEND);
            }
        }
    }




    /**
     * Generating the file by
     * replacing placeholders in stub file.
     *
     * @param $stub_name Name of the Stub File
     * @param $replacements [array] Array of the replacement to be done in stub file
     * @param $file [string] full path of the file
     * @param $contents [string][optional] file contents
     */
    public function generateFile($stub_name, $replacements, $file, $contents = null)
    {
        if ($stub_name) {
            //Getting the Stub Files Content
            $file_contents = $this->files->get($this->getStubPath().$stub_name.'.stub');
        } else {
            //Getting the Stub Files Content
            $file_contents = $contents;
        }
        //Replacing the stub
        $file_contents = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $file_contents
        );
        $this->files->put(base_path(escapeSlashes($file)).'.php', $file_contents);
    }

    /**
     * getting the stub folder path.
     *
     * @return string
     */
    public function getStubPath()
    {
        $path = resource_path('views'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'api-generator'.DIRECTORY_SEPARATOR.'Stubs'.DIRECTORY_SEPARATOR);
        $package_stubs_path = base_path('vendor'.DIRECTORY_SEPARATOR.'lbmadesia'.DIRECTORY_SEPARATOR.'api-generator'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'Stubs'.DIRECTORY_SEPARATOR);
        if($this->files->exists($path))
            return $path;
        else
            return $package_stubs_path;
    }

    /**
     * getBasePath
     *
     * @param string $namespace
     * @param bool $status
     * @return string
     */
    public function getBasePath($namespace, $status = false)
    {
        if ($status) {
            return base_path(escapeSlashes($this->removeFileNameFromEndOfNamespace($namespace, $status)));
        }

        return base_path(lcfirst(escapeSlashes($namespace)));
    }

    /**
     * Removes the filename from the passed the namespace
     *
     * @param string $namespace
     * @return string
     */
    public function removeFileNameFromEndOfNamespace($namespace)
    {
        $namespace = explode('\\', $namespace);

        unset($namespace[count($namespace) - 1]);

        return lcfirst(implode('\\', $namespace));
    }

    /**
     * Modify strings by removing content between $beginning and $end.
     *
     * @param string $beginning
     * @param string $end
     * @param string $string
     *
     * @return string
     */
    public function delete_all_between($beginning, $end, $string)
    {
        $beginningPos = strpos($string, $beginning);
        $endPos = strpos($string, $end);
        if ($beginningPos === false || $endPos === false) {
            return $string;
        }

        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

        return str_replace($textToDelete, '', $string);
    }
}
