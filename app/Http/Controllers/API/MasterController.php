<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Main;
use App\Models\Api\Validation;

class MasterController extends Controller
{
    protected $Main;
    protected $Validation;

    public function __construct()
    {
        $this->Main = new Main();
        $this->Validation = new Validation();
    }

    public function ApiCallData(Request $req)
    {
        $validation_data = $this->Validation->ApiCallData($req);
        if ($validation_data->original['statuscode'] == 1) {
            $data = $this->Main->ApiCallData($req);
            return response()->json([
                "statuscode" => 1,
                "msg" => "Api Call successfully.",
                "data" => $data
            ]);
        } else {
            return $validation_data;
        }
    }

    // Status Image Data
    public function StatusImageCategoryData(Request $req)
    {
        $validation_data = $this->Validation->StatusImageCategoryData($req);
        if ($validation_data->original['statuscode'] == 1) {
            $data = $this->Main->StatusImageCategoryData($req);
            return response()->json([
                "statuscode" => 1,
                "msg" => "success!!.",
                "data" => $data
            ]);
        } else {
            return $validation_data;
        }
    }


    public function StatusImagesData(Request $req)
    {
        $validation_data = $this->Validation->StatusImagesData($req);
        if ($validation_data->original['statuscode'] == 1) {
            $data = $this->Main->StatusImagesData($req);
            return response()->json([
                "statuscode" => 1,
                "msg" => "success!!.",
                "data" => $data
            ]);
        } else {
            return $validation_data;
        }
    }

    // Status Video Data
    public function StatusVideoCategoryData(Request $req)
    {
        $validation_data = $this->Validation->StatusVideoCategoryData($req);
        if ($validation_data->original['statuscode'] == 1) {
            $data = $this->Main->StatusVideoCategoryData($req);
            return response()->json([
                "statuscode" => 1,
                "msg" => "success!!.",
                "data" => $data
            ]);
        } else {
            return $validation_data;
        }
    }

    public function StatusVideosData(Request $req)
    {
        $validation_data = $this->Validation->StatusVideosData($req);
        if ($validation_data->original['statuscode'] == 1) {
            $data = $this->Main->StatusVideosData($req);
            return response()->json([
                "statuscode" => 1,
                "msg" => "success!!.",
                "data" => $data
            ]);
        } else {
            return $validation_data;
        }
    }

    public function AppByImageCategoryData(Request $req)
    {
        $validation_data = $this->Validation->AppByImageCategoryData($req);
        if ($validation_data->original['statuscode'] == 1) {
            $data = $this->Main->AppByImageCategoryData($req);
            return response()->json([
                "statuscode" => 1,
                "msg" => "success!!.",
                "data" => $data
            ]);
        } else {
            return $validation_data;
        }
    }

    public function AppByVideoCategoryData(Request $req)
    {
        $validation_data = $this->Validation->AppByVideoCategoryData($req);
        if ($validation_data->original['statuscode'] == 1) {
            $data = $this->Main->AppByVideoCategoryData($req);
            return response()->json([
                "statuscode" => 1,
                "msg" => "success!!.",
                "data" => $data
            ]);
        } else {
            return $validation_data;
        }
    }
}
