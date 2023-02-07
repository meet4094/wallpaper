<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Str;
use File;

class MasterController extends Controller
{
    public function add_category(Request $req)
    {
        if (empty($req->catId)) {
            $rules = array(
                'category' => 'required|unique:category,catName',
                'image' => 'required',
            );
        } else {
            $rules = array(
                'category' => 'required',
                'image' => 'required',
            );
        }
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        } else {
            if ($req) {
                $catFolder = ucfirst(str_replace(' ', '_', strtolower($req->category)));
                $path = public_path('images/' . $catFolder);
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $imageName = 'catIMG_1' . '.jpg';
                if ($req->catId) {
                    $catData = DB::table('category')->where('catId', $req->catId)->first();
                    $explode = explode('/', $catData->image);
                    $editbg = File::exists(public_path('images/' . $explode[1] . '/' . $imageName)) ? true : false;
                    if ($editbg) {
                        File::delete(public_path('images/' . $explode[1] . '/' . $imageName));
                    }
                } else {
                    $exists = File::exists(public_path('images/' . $catFolder . '/' . $imageName)) ? true : false;
                    if ($exists) {
                        File::delete(public_path('images/' . $catFolder . '/' . $imageName));
                    }
                }
                if ($req->image) {
                    $req->image->move(public_path('images/' . $catFolder), $imageName);
                    $image_path = 'images/' . $catFolder . '/' . $imageName;
                }
                $data = array(
                    'image' => $image_path,
                    'catName' => $req->category,
                );
                if (empty($req->catId)) {
                    $data['created_at'] = date('Y-m-d H:i');
                    $data['created_by'] = Auth::User()->id;
                    DB::table('category')->insert($data);
                    return response()->json(['st' => 'success', 'msg' => 'Category Added',]);
                } else {
                    $data['updated_at'] = date('Y-m-d H:i');
                    $data['updated_by'] = Auth::User()->id;
                    DB::table('category')->where('catId', $req->catId)->update($data);
                    return response()->json(['st' => 'success', 'msg' => 'Category Updated',]);
                }
            }
        }
    }

    public function category_list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('category')->where(array('is_deleted' => 0));
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return '<img src=" ' . $row->image . ' " height="50">';
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
        $id = $req->post('id');
        $drdata = DB::table('category')->where('catId', $id)->update(array('is_deleted' => 1));
        if ($drdata) {
            $response['success'] = 1;
            $response['msg'] = 'Delete successfully';
        } else {
            $response['success'] = 0;
            $response['msg'] = 'Invalid ID.';
        }
        return response()->json($response);
    }

    public function getcategorydata(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('category')->where(array('catId' => $request->id))->first();
        }
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

    public function add_items(Request $req)
    {
        $rules = array(
            'catId' => 'required',
            'images' => 'required',
        );
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->toArray()]);
        } else {
            if ($req->hasFile('images')) {
                $catFolder = ucfirst(str_replace(' ', '_', strtolower($req->catName)));

                // $allowedfileExtension = ['pdf', 'jpg', 'png', 'docx'];
                // $files = $req->file('images');
                // foreach ($files as $file) {
                // $extension = $file->getClientOriginalExtension();
                // $check = in_array($extension, $allowedfileExtension);
                // if ($req->images) {
                foreach ($req->images as $photo) {
                    $for_path = $photo->getClientOriginalName();
                    $photo->move(public_path('images/' . $catFolder . '/'), $for_path);
                    $image_path = $catFolder . '/' . $for_path;
                    $data = array(
                        'catId' => $req->catId,
                        'images' => $image_path,
                        'is_new' => $req->new,
                        'created_at' => date('Y-m-d H:i'),
                        'created_by' => Auth::User()->id,
                    );
                    DB::table('images')->insert($data);
                }
                return response()->json(['st' => 'success', 'msg' => 'Images Added',]);
            } else {
                return response()->json(['st' => 'failed', 'msg' => 'Failed to add',]);
            }
        }
    }

    public function items_list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('images as ci')->where(array('ci.is_deleted' => 0))
                ->join('category as c', 'c.catId', '=', 'ci.catId')
                ->select('ci.id', 'c.catName', 'ci.images')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('images', function ($row) {
                    return '<img src=" images/' . $row->images . ' " height="50">';
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
        $id = $req->post('id');
        $drdata = DB::table('images')->where('id', $id)->update(array('is_deleted' => 1));
        if ($drdata) {
            $response['success'] = 1;
            $response['msg'] = 'Delete successfully';
        } else {
            $response['success'] = 0;
            $response['msg'] = 'Invalid ID.';
        }
        return response()->json($response);
    }

    public function getitemdata(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('images as cs')
                ->join('category as c', 'c.catId', '=', 'cs.catId')
                ->where(array('id' => $request->id))
                ->select('cs.*', 'c.catName')
                ->get();
        }
        $response = array('st' => "success", "msg" => $data[0]);
        return response()->json($response);
    }
}
