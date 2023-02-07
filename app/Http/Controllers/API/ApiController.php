<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiModel;

class ApiController extends Controller
{
    protected $ApiModel;
    public function __construct()
    {
        $this->ApiModel = new ApiModel();
    }
    public function get_category()
    {
        // if (!empty($req)) {
        $data = $this->ApiModel->get_category();
        return response()->json($data);

        // return response()->tojson([$data]);
        // }
    }
}
