<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\MasterModel;
use DataTables;
use File;

use function GuzzleHttp\Promise\all;

class MasterController extends Controller
{
    protected $MasterModel;
    public function __construct()
    {
        $this->MasterModel = new MasterModel();
    }

    // Category Data

    public function add_category(Request $req)
    {
        if (empty($req->catId)) {
            $rules = array(
                'category' => 'required|unique:category,catName',
                'image' => 'required|mimes:jpeg,jpg,png,gif',
            );
        } else {
            $rules = array(
                'category' => 'required',
                'image' => 'mimes:jpeg,jpg,png,gif',
            );
        }
        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data = $this->MasterModel->add_category($req->all());
            return $data;
        }
    }

    public function category_list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('category')->where(array('is_deleted' => 0));
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    $url = asset('images/' . $row->slug_name);
                    return '<img src="  ' . $url . '/' . $row->image . ' " height="50">';
                })
                ->addColumn('action', function ($row) {
                    $update_btn = '<button title="' . $row->catName . '" class="btn btn-link" onclick="edit_category(this)" data-val="' . $row->catId . '"><i class="far fa-edit"></i></button>';
                    $delete_btn = '<button data-toggle="modal" target="_blank"  title="' . $row->catName . '" class="btn btn-link" onclick="editable_remove(this)" data-val="' . $row->catId . '" tabindex="-1"><i class="fa fa-trash-alt tx-danger"></i></button>';
                    return $update_btn . $delete_btn;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
    }

    public function delete_category(Request $req)
    {
        $data = $this->MasterModel->delete_category($req->all());
        return $data;
    }

    public function getcategorydata(Request $request)
    {
        if ($request->ajax()) {
            $categorydata = DB::table('category')->where(array('catId' => $request->id))->first();
        }
        $data = array();
        $data = ([
            'catId' => $categorydata->catId,
            'catName' => $categorydata->catName,
            'image' => asset('images/' . $categorydata->slug_name) . '/' . $categorydata->image,
        ]);
        $response = array('st' => "success", "msg" => $data);
        return response()->json($response);
    }

    public function getCategory(Request $request)
    {
        $search = $request->searchTerm;
        if ($search == '') {
            $categories = DB::table('category')->where(array('is_deleted' => 0))->select('catId', 'catName')->get();
        } else {
            $categories = DB::table('category')->select('catId', 'catName')->where('catName', 'like', '%' . $search . '%')->where('is_deleted', 0)->limit(10)->get();
        }

        $response = array();
        foreach ($categories as $category) {
            $response[] = array(
                "id" => $category->catId,
                "text" => $category->catName
            );
        }
        return response()->json($response);
    }

    // Image Item Data

    public function add_items(Request $req)
    {
        if (empty($req->itemId)) {
            $rules = array(
                'category' => 'required',
                'images' => 'required',
            );
        } else {
            $rules = array(
                'category' => 'required',
            );
        }
        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data = $this->MasterModel->add_items($req->all());
            return $data;
        }
    }

    public function items_list(Request $request)
    {
        if ($request->ajax()) {
            $builder = DB::table('images as ci');
            if ($request->category_id != '') {
                $builder->where('ci.catId', $request->category_id);
            }
            $builder->where('ci.is_deleted', '0');
            $builder->join('category as c', 'c.catId', '=', 'ci.catId');
            $builder->select('ci.id', 'c.catName', 'c.slug_name', 'ci.images');
            $result = $builder->get();
            return Datatables::of($result)
                ->addIndexColumn()
                ->editColumn('images', function ($row) {
                    $url = asset('images/' . $row->slug_name);
                    return '<img src=" ' . $url . '/' . $row->images . ' " height="50">';
                })
                ->addColumn('action', function ($row) {
                    $update_btn = '<button class="btn btn-link" onclick="edit_item(this)" data-val="' . $row->id . '"><i class="far fa-edit"></i></button>';
                    $delete_btn = '<button data-toggle="modal" target="_blank" class="btn btn-link" onclick="editable_remove(this)" data-val="' . $row->id . '" tabindex="-1"><i class="fa fa-trash-alt tx-danger"></i></button>';
                    return $update_btn . $delete_btn;
                })
                ->rawColumns(['images', 'action'])
                ->make(true);
        }
    }

    public function delete_item(Request $req)
    {
        $data = $this->MasterModel->delete_item($req->all());
        return $data;
    }

    public function getitemdata(Request $request)
    {
        if ($request->ajax()) {
            $itemdata = DB::table('images as cs')
                ->join('category as c', 'c.catId', '=', 'cs.catId')
                ->where(array('id' => $request->id))
                ->select('cs.*', 'c.catName', 'c.slug_name')
                ->get();
        }
        foreach ($itemdata as $item) {
            $data = array();
            $data = ([
                'catId' => $item->catId,
                'id' => $item->id,
                'catName' => $item->catName,
                'image' => asset('images/' . $item->slug_name) . '/' . $item->images,
            ]);
        }
        $response = array('st' => "success", "msg" => $data);
        return response()->json($response);
    }

    // Video Item Data

    public function add_videos(Request $req)
    {
        if (empty($req->videoId)) {
            $rules = array(
                'category' => 'required',
                'videos' => 'required',
            );
        } else {
            $rules = array(
                'category' => 'required',
            );
        }
        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data = $this->MasterModel->add_videos($req->all());
            return $data;
        }
    }

    public function videos_list(Request $request)
    {
        if ($request->ajax()) {
            $builder = DB::table('videos as ci');
            if ($request->category_id != '') {
                $builder->where('ci.catId', $request->category_id);
            }
            $builder->where('ci.is_deleted', '0');
            $builder->join('category as c', 'c.catId', '=', 'ci.catId');
            $builder->select('ci.id', 'c.catName', 'c.slug_name', 'ci.videos');
            $result = $builder->get();
            return Datatables::of($result)
                ->addIndexColumn()
                ->editColumn('videos', function ($row) {
                    $url = asset('videos/' . $row->slug_name);
                    return '<video controls src=" ' . $url . '/' . $row->videos . ' "width="180">';
                })
                ->addColumn('action', function ($row) {
                    $update_btn = '<button class="btn btn-link" onclick="edit_video(this)" data-val="' . $row->id . '"><i class="far fa-edit"></i></button>';
                    $delete_btn = '<button data-toggle="modal" target="_blank" class="btn btn-link" onclick="editable_remove(this)" data-val="' . $row->id . '" tabindex="-1"><i class="fa fa-trash-alt tx-danger"></i></button>';
                    return $update_btn . $delete_btn;
                })
                ->rawColumns(['videos', 'action'])
                ->make(true);
        }
    }

    public function delete_video(Request $req)
    {
        $data = $this->MasterModel->delete_video($req->all());
        return $data;
    }

    public function getvideodata(Request $request)
    {
        if ($request->ajax()) {
            $videodata = DB::table('videos as cs')
                ->join('category as c', 'c.catId', '=', 'cs.catId')
                ->where(array('id' => $request->id))
                ->select('cs.*', 'c.catName', 'c.slug_name')
                ->get();
        }
        foreach ($videodata as $video) {
            $data = array();
            $data = ([
                'catId' => $video->catId,
                'id' => $video->id,
                'catName' => $video->catName,
                'video' => asset('videos/' . $video->slug_name) . '/' . $video->videos,
            ]);
        }
        $response = array('st' => "success", "msg" => $data);
        return response()->json($response);
    }

    // App Setting Data

    public function app_data_list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('settings')->where('is_del', 0)
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $update_btn = '<button class="btn btn-link" title="' . $row->app_name . '" onclick="edit_appdata(this)" data-val="' . $row->id . '"><i class="far fa-edit"></i></button>';
                    $delete_btn = '<button data-toggle="modal" target="_blank" title="' . $row->app_name . '" class="btn btn-link" onclick="editable_remove(this)" data-val="' . $row->id . '" tabindex="-1"><i class="fa fa-trash-alt tx-danger"></i></button>';
                    return $update_btn . $delete_btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getApp(Request $request)
    {
        $search = $request->searchTerm;
        if ($search == '') {
            $apps = DB::table('settings')->where(array('is_del' => 0))->select('id', 'app_name')->get();
        } else {
            $apps = DB::table('settings')->select('id', 'app_name')->where('app_name', 'like', '%' . $search . '%')->where('is_del', 0)->limit(10)->get();
        }

        $response = array();
        foreach ($apps as $app) {
            $response[] = array(
                "id" => $app->id,
                "text" => $app->app_name
            );
        }
        return response()->json($response);
    }

    public function add_app(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'appname' => 'required',
            'packagename' => 'required',
            'accountname' => 'required',
            'appversion' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data = $this->MasterModel->add_app($req->all());
            return $data;
        }
    }

    public function getappdata(Request $request)
    {
        $id = $request->id;
        $app_Data = DB::table('settings')->Where('id', $id)->first();
        $response = array('st' => "success", "msg" => $app_Data);
        return response()->json($response);
    }

    public function delete_appdata(Request $req)
    {
        $data = $this->MasterModel->delete_appdata($req->all());
        return $data;
    }

    // Api Call Data
    public function api_call_list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('api_calls')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    // App By Image Category
    public function add_app_by_image_category(Request $req)
    {
        if (empty($req->appbycatId)) {
            $rules = array(
                'appId' => 'required',
                'categoryId' => 'required',
                'category' => 'required',
                'image' => 'required',
            );
        } else {
            $rules = array(
                'category' => 'required',
            );
        }
        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data = $this->MasterModel->add_app_by_image_category($req->all());
            return $data;
        }
    }

    public function app_by_image_category_list(Request $request)
    {
        if ($request->ajax()) {
            $builder = DB::table('app_by_image_category as ci');
            if ($request->app_id != '' && $request->category_id != '') {
                $builder->where('ci.app_id', $request->app_id);
                $builder->where('ci.category_id', $request->category_id);
            } else if ($request->app_id != '' || $request->category_id != '') {
                $builder->where('ci.app_id', $request->app_id);
                $builder->orwhere('ci.category_id', $request->category_id);
            }
            $builder->where(array('ci.is_del' => 0));
            $builder->join('category as c', 'c.catId', '=', 'ci.category_id');
            $builder->join('settings as s', 's.id', '=', 'ci.app_id');
            $builder->select('ci.id', 's.app_name', 'c.catName', 'ci.name', 'ci.image');
            $result = $builder->get();
            return Datatables::of($result)
                ->addIndexColumn()
                ->editColumn('images', function ($row) {
                    $url = asset('images/appbyimagecategory');
                    return '<img src=" ' . $url . '/' . $row->image . ' " height="50">';
                })
                ->addColumn('action', function ($row) {
                    $update_btn = '<button class="btn btn-link" title="' . $row->name . '" onclick="edit_app_by_image_category(this)" data-val="' . $row->id . '"><i class="far fa-edit"></i></button>';
                    $delete_btn = '<button data-toggle="modal" title="' . $row->name . '" target="_blank" class="btn btn-link" onclick="editable_remove(this)" data-val="' . $row->id . '" tabindex="-1"><i class="fa fa-trash-alt tx-danger"></i></button>';
                    return $update_btn . $delete_btn;
                })
                ->rawColumns(['images', 'action'])
                ->make(true);
        }
    }

    public function delete_app_by_image_category(Request $req)
    {
        $data = $this->MasterModel->delete_app_by_image_category($req->all());
        return $data;
    }

    public function getappbyimagecategorydata(Request $request)
    {
        if ($request->ajax()) {
            $itemdata = DB::table('app_by_image_category as cs')
                ->join('category as c', 'c.catId', '=', 'cs.category_id')
                ->join('settings as s', 's.id', '=', 'cs.app_id')
                ->where(array('cs.id' => $request->id))
                ->select('cs.*', 'c.catName', 's.app_name')
                ->get();
        }
        foreach ($itemdata as $item) {
            $data = array();
            $data = ([
                'id' => $item->id,
                'appId' => $item->app_id,
                'appName' => $item->app_name,
                'catId' => $item->category_id,
                'catName' => $item->catName,
                'name' => $item->name,
                'image' => asset('images/appbyimagecategory') . '/' . $item->image,
            ]);
        }
        $response = array('st' => "success", "msg" => $data);
        return response()->json($response);
    }

    // App By Video Category
    public function add_app_by_video_category(Request $req)
    {
        if (empty($req->appbycatId)) {
            $rules = array(
                'appId' => 'required',
                'categoryId' => 'required',
                'category' => 'required',
                'image' => 'required',
            );
        } else {
            $rules = array(
                'category' => 'required',
            );
        }
        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->toArray()
            ]);
        } else {
            $data = $this->MasterModel->add_app_by_video_category($req->all());
            return $data;
        }
    }

    public function app_by_video_category_list(Request $request)
    {
        if ($request->ajax()) {
            $builder = DB::table('app_by_video_category as ci');
            if ($request->app_id != '' && $request->category_id != '') {
                $builder->where('ci.app_id', $request->app_id);
                $builder->where('ci.category_id', $request->category_id);
            } else if ($request->app_id != '' || $request->category_id != '') {
                $builder->where('ci.app_id', $request->app_id);
                $builder->orwhere('ci.category_id', $request->category_id);
            }
            $builder->where(array('ci.is_del' => 0));
            $builder->join('category as c', 'c.catId', '=', 'ci.category_id');
            $builder->join('settings as s', 's.id', '=', 'ci.app_id');
            $builder->select('ci.id', 's.app_name', 'c.catName', 'ci.name', 'ci.image');
            $result = $builder->get();
            return Datatables::of($result)
                ->addIndexColumn()
                ->editColumn('images', function ($row) {
                    $url = asset('images/appbyvideocategory');
                    return '<img src=" ' . $url . '/' . $row->image . ' " height="50">';
                })
                ->addColumn('action', function ($row) {
                    $update_btn = '<button class="btn btn-link" title="' . $row->name . '" onclick="edit_app_by_video_category(this)" data-val="' . $row->id . '"><i class="far fa-edit"></i></button>';
                    $delete_btn = '<button data-toggle="modal" title="' . $row->name . '" target="_blank" class="btn btn-link" onclick="editable_remove(this)" data-val="' . $row->id . '" tabindex="-1"><i class="fa fa-trash-alt tx-danger"></i></button>';
                    return $update_btn . $delete_btn;
                })
                ->rawColumns(['images', 'action'])
                ->make(true);
        }
    }

    public function delete_app_by_video_category(Request $req)
    {
        $data = $this->MasterModel->delete_app_by_video_category($req->all());
        return $data;
    }

    public function getappbyvideocategorydata(Request $request)
    {
        if ($request->ajax()) {
            $itemdata = DB::table('app_by_video_category as cs')
                ->join('category as c', 'c.catId', '=', 'cs.category_id')
                ->join('settings as s', 's.id', '=', 'cs.app_id')
                ->where(array('cs.id' => $request->id))
                ->select('cs.*', 'c.catName', 's.app_name')
                ->get();
        }
        foreach ($itemdata as $item) {
            $data = array();
            $data = ([
                'id' => $item->id,
                'appId' => $item->app_id,
                'appName' => $item->app_name,
                'catId' => $item->category_id,
                'catName' => $item->catName,
                'name' => $item->name,
                'image' => asset('images/appbyvideocategory') . '/' . $item->image,
            ]);
        }
        $response = array('st' => "success", "msg" => $data);
        return response()->json($response);
    }
}
