<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterModel extends Model
{
    use HasFactory;

    // Category

    public function add_category($req)
    {
        if ($req['catId']) {

            if (isset($req['image']) && $req['image']->getError() == 0) {

                $iOriginal = DB::table('category')->Where('catId', $req['catId'])->first();
                $slug_name = $iOriginal->slug_name;

                if (isset($iOriginal->image) && !empty($iOriginal->image)) {

                    $iOriginal = public_path('images/' . $slug_name) . '/' . $iOriginal->image;

                    if (file_exists($iOriginal))

                        @unlink($iOriginal);
                }

                $file = $req['image'];
                $extension = $file->extension();
                $fileName = md5(uniqid() . time()) . '.' . $extension;
                $file->move(public_path('/images/' . $slug_name), $fileName);
                $data['image'] = $fileName;
            }
            $data['catName'] = $req['category'];

            DB::table('category')->where('catId', $req['catId'])->update($data);
            return response()->json(['st' => 'success', 'msg' => 'Update Successfully..',]);
        } else {
            $slug_name = str_replace(' ', '_', strtolower($req['category']));
            if (isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) {
                $file = $req['image'];
                $extension = $file->extension();
                $fileName = md5(uniqid() . time()) . '.' . $extension;
                $file->move(public_path('/images/' . $slug_name), $fileName);
                $data['image'] = $fileName;
            }

            $data['catName'] = $req['category'];
            $data['slug_name'] = $slug_name;

            DB::table('category')->insert($data);
            return response()->json(['st' => 'success', 'msg' => 'Category added..',]);
        }
    }

    public function delete_category($req)
    {
        $id = $req['id'];
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

    // Images
    public function add_items($req)
    {
        if ($req['itemId']) {

            if (isset($req['images'][0]) && $req['images'][0]->getError() == 0) {

                $iOriginal = DB::table('category')->Where('catId', $req['category'])->first();
                $slug_name = $iOriginal->slug_name;

                $iImage = DB::table('images')->Where('id', $req['itemId'])->first();

                if (isset($iImage->images) && !empty($iImage->images)) {

                    $iImage = public_path('images/' . $slug_name) . '/' . $iImage->images;

                    if (file_exists($iImage))

                        @unlink($iImage);
                }

                $file = $req['images'][0];
                $extension = $file->extension();
                $fileName = md5(uniqid() . time()) . '.' . $extension;
                $file->move(public_path('/images/' . $slug_name . '/'), $fileName);
                $data['images'] = $fileName;
            }
            $data['catId'] = $req['category'];
            $data['is_new'] = $req['new'];

            DB::table('images')->where('id', $req['itemId'])->update($data);
            return response()->json(['st' => 'success', 'msg' => 'Update Successfully..',]);
        } else {

            $iOriginal = DB::table('category')->Where('catId', $req['category'])->first();
            $slug_name = $iOriginal->slug_name;

            foreach ($req['images'] as  $key => $photo) {
                $file = $photo->getClientOriginalName();
                $extension = $photo->extension();
                $fileName = md5(uniqid() . time()) . '.' . $extension;
                $photo->move(public_path('images/' . $slug_name . '/'), $fileName);
                $data = array(
                    'catId' => $req['category'],
                    'images' => $fileName,
                    'is_new' => $req['new'],
                );
                DB::table('images')->insert($data);
            }

            return response()->json(['st' => 'success', 'msg' => 'Image added..',]);
        }
    }

    public function delete_item($req)
    {
        $id = $req['id'];
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

    // Videos
    public function add_videos($req)
    {
        if ($req['videoId']) {

            if (isset($req['videos'][0]) && $req['videos'][0]->getError() == 0) {

                $iOriginal = DB::table('category')->Where('catId', $req['category'])->first();
                $slug_name = $iOriginal->slug_name;

                $iVideos = DB::table('videos')->Where('id', $req['videoId'])->first();

                if (isset($iVideos->videos) && !empty($iVideos->videos)) {

                    $iVideos = public_path('videos/' . $slug_name) . '/' . $iVideos->videos;

                    if (file_exists($iVideos))

                        @unlink($iVideos);
                }

                $file = $req['videos'][0];
                $extension = $file->extension();
                $fileName = md5(uniqid() . time()) . '.' . $extension;
                $file->move(public_path('/videos/' . $slug_name . '/'), $fileName);
                $data = array(
                    'catId' => $req['category'],
                    'videos' => $fileName,
                    'is_new' => $req['new'],
                );

                DB::table('videos')->where('id', $req['videoId'])->update($data);
            }
            return response()->json(['st' => 'success', 'msg' => 'Update Successfully..',]);
        } else {

            $iOriginal = DB::table('category')->Where('catId', $req['category'])->first();
            $slug_name = $iOriginal->slug_name;

            foreach ($req['videos'] as  $key => $photo) {
                $file = $photo->getClientOriginalName();
                $extension = $photo->extension();
                $fileName = md5(uniqid() . time()) . '.' . $extension;
                $photo->move(public_path('videos/' . $slug_name . '/'), $fileName);
                $data = array(
                    'catId' => $req['category'],
                    'videos' => $fileName,
                    'is_new' => $req['new'],
                );

                DB::table('videos')->insert($data);
            }
            return response()->json(['st' => 'success', 'msg' => 'Video added..',]);
        }
    }

    public function delete_video($req)
    {
        $id = $req['id'];
        $drdata = DB::table('videos')->where('id', $id)->update(array('is_deleted' => 1));
        if ($drdata) {
            $response['success'] = 1;
            $response['msg'] = 'Delete successfully';
        } else {
            $response['success'] = 0;
            $response['msg'] = 'Invalid ID.';
        }
        return response()->json($response);
    }

    // App Data
    public function add_app($req)
    {
        if (empty($req['appId'])) {
            $request_token = Str::random(15);
        } else {
            $request_token = $req['request_token'];
        }
        $data = array(
            'app_name' => $req['appname'],
            'package_name' => $req['packagename'],
            'account_name' => $req['accountname'],
            'app_version' => $req['appversion'],
            'request_token' => $request_token
        );

        if ($req['appId']) {
            DB::table('settings')->where('id', $req['appId'])->update($data);
            return response()->json(['st' => 'success', 'msg' => 'Update Successfully..',]);
        } else {
            DB::table('settings')->insert($data);
            return response()->json(['st' => 'success', 'msg' => 'App Data added..',]);
        }
    }

    public function delete_appdata($req)
    {
        $id = $req['id'];
        $drdata = DB::table('settings')->where('id', $id)->update(array('is_del' => 1));
        if ($drdata) {
            $response['success'] = 1;
            $response['msg'] = 'Delete successfully';
        } else {
            $response['success'] = 0;
            $response['msg'] = 'Invalid ID.';
        }
        return response()->json($response);
    }

    // App by Image category
    public function add_app_by_image_category($req)
    {
        if ($req['appbycatId']) {

            if (isset($req['image']) && $req['image']->getError() == 0) {

                $iOriginal = DB::table('app_by_image_category')->Where('id', $req['appbycatId'])->first();

                if (isset($iOriginal->image) && !empty($iOriginal->image)) {

                    $iOriginal = public_path('/images/appbyimagecategory/') . $iOriginal->image;

                    if (file_exists($iOriginal))

                        @unlink($iOriginal);
                }

                $file = $req['image'];
                $extension = $file->extension();
                $fileName = md5(uniqid() . time()) . '.' . $extension;
                $file->move(public_path('/images/appbyimagecategory/'), $fileName);
            }
            $data = array(
                'app_id' => $req['appId'],
                'category_id' => $req['categoryId'],
                'name' => $req['category'],
                'image' => $fileName
            );

            DB::table('app_by_image_category')->where('id', $req['appbycatId'])->update($data);
            return response()->json(['st' => 'success', 'msg' => 'Update Successfully..',]);
        } else {

            if (isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) {
                $file = $req['image'];
                $extension = $file->extension();
                $fileName = md5(uniqid() . time()) . '.' . $extension;
                $file->move(public_path('/images/appbyimagecategory/'), $fileName);
            }
            $data = array(
                'app_id' => $req['appId'],
                'category_id' => $req['categoryId'],
                'name' => $req['category'],
                'image' => $fileName
            );

            DB::table('app_by_image_category')->insert($data);
            return response()->json(['st' => 'success', 'msg' => 'Category added..',]);
        }
    }

    public function delete_app_image_by_category($req)
    {
        $id = $req['id'];
        $drdata = DB::table('app_by_image_category')->where('id', $id)->update(array('is_del' => 1));
        if ($drdata) {
            $response['success'] = 1;
            $response['msg'] = 'Delete successfully';
        } else {
            $response['success'] = 0;
            $response['msg'] = 'Invalid ID.';
        }
        return response()->json($response);
    }

    // App by Video category
    public function add_app_by_video_category($req)
    {
        if ($req['appbycatId']) {

            if (isset($req['image']) && $req['image']->getError() == 0) {

                $iOriginal = DB::table('app_by_video_category')->Where('id', $req['appbycatId'])->first();

                if (isset($iOriginal->image) && !empty($iOriginal->image)) {

                    $iOriginal = public_path('/images/appbyvideocategory/') . $iOriginal->image;

                    if (file_exists($iOriginal))

                        @unlink($iOriginal);
                }

                $file = $req['image'];
                $extension = $file->extension();
                $fileName = md5(uniqid() . time()) . '.' . $extension;
                $file->move(public_path('/images/appbyvideocategory/'), $fileName);
            }
            $data = array(
                'app_id' => $req['appId'],
                'category_id' => $req['categoryId'],
                'name' => $req['category'],
                'image' => $fileName
            );

            DB::table('app_by_video_category')->where('id', $req['appbycatId'])->update($data);
            return response()->json(['st' => 'success', 'msg' => 'Update Successfully..',]);
        } else {

            if (isset($_FILES['image']['error']) && $_FILES['image']['error'] == 0) {
                $file = $req['image'];
                $extension = $file->extension();
                $fileName = md5(uniqid() . time()) . '.' . $extension;
                $file->move(public_path('/images/appbyvideocategory/'), $fileName);
            }
            $data = array(
                'app_id' => $req['appId'],
                'category_id' => $req['categoryId'],
                'name' => $req['category'],
                'image' => $fileName
            );

            DB::table('app_by_video_category')->insert($data);
            return response()->json(['st' => 'success', 'msg' => 'Category added..',]);
        }
    }

    public function delete_app_by_video_category($req)
    {
        $id = $req['id'];
        $drdata = DB::table('app_by_video_category')->where('id', $id)->update(array('is_del' => 1));
        if ($drdata) {
            $response['success'] = 1;
            $response['msg'] = 'Delete successfully';
        } else {
            $response['success'] = 0;
            $response['msg'] = 'Invalid ID.';
        }
        return response()->json($response);
    }
}
