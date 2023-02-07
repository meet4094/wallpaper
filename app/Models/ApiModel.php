<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;
use DB;

class ApiModel extends Model
{
    public function get_category()
    {
        $builder = DB::table('category');
        $builder->select('catId', 'background', 'catName');
        $builder->where('is_deleted', 0);
        $results = $builder->get();
        $data = array();
        foreach ($results as $result) {
            $data[] = $result;
        }
        if (!empty($data)) {
            $msg = array('st' => 'success', 'msg' => 'found', 'data' => $data);
        } else {
            $msg = array('st' => 'failed', 'msg' => 'Data not found', 'data' => array());
        }
        return $msg;
    }
}
