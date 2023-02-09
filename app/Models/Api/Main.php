<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Main extends Model
{
    use HasFactory;

    function get_client_ip()
    {
        $ipAddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipAddress = 'UNKNOWN';
        return $ipAddress;
    }

    public function ApiCallData($req)
    {
        $request_token = $req->header('request-token');
        $data = DB::table('settings')->where('request_token', $request_token)->first();

        $ipAddress = $this->get_client_ip();
        $app_token = Str::random(15);
        $Api_CallData = array(
            'app_id' => $data->id,
            'device_id' => $req['device_id'],
            'package_name' => $req['package_name'],
            'app_version' => $req['app_version'],
            'version_code' => $req['app_version_code'],
            'app_token' => $app_token,
            'ip_address' => $ipAddress
        );
        $register = DB::table('api_calls')
            ->insert($Api_CallData);
        return $Api_CallData;
    }

    public function CategoryData($req)
    {
        $CategoryData = DB::table('category')->where('catId', $req->category_id)->where('is_deleted', 0)->first();
        $data = array([
            'id' => $CategoryData->catId,
            'category_name' => $CategoryData->catName,
            'category_image' => asset('images/' . $CategoryData->slug_name . '/' . $CategoryData->image),
        ]);
        return $data;
    }

    public function ImagesData($req)
    {
        $ImagesData = DB::table('images as im')
            ->join('category as ca', 'ca.catId', '=', 'im.catId')
            ->select('im.*', 'ca.catName', 'ca.slug_name')
            ->where('im.is_deleted', 0)
            ->get();

        foreach ($ImagesData as $Images) {
            $data = array([
                'id' => $Images->id,
                'category_name' => $Images->catName,
                'category_image' => asset('images/' . $Images->slug_name . '/' . $Images->images),
                'is_new' => $Images->is_new,
            ]);
        }
        return $data;
    }
}
