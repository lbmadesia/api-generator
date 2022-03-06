<?php

namespace Lbmadesia\ApiGenerator;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    protected $table = 'apis';

    protected $fillable = ['view_permission_id', 'name', 'url','controller_path', 'created_by', 'updated_by'];
}
