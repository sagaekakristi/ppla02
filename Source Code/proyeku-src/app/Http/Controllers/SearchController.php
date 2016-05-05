<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller{

	public function search($search){

        $search = urldecode($search);

        $jobs = DB::table('job')
                    -> join('users', 'users.id', '=', 'job.freelancer_info_id')
                    -> join('user_info', 'user_info.user_id', '=', 'users.id')
                    -> select('users.name', 'user_info.alamat', 'job.judul', 'job.deskripsi', 'job.upah_max', 'job.upah_min', 'job.id', 'user_info.profile_picture_link')
                    -> where('judul', 'LIKE', '%'.$search.'%')
                    -> where('user_info.alamat', 'LIKE', '%'.$location.'%')
                    -> where('job.upah_max', '>=', $upah_max)
                    -> where('job.upah_min', '>=', $upah_min)
                    -> paginate(2);

        if(count($jobs)==0){
        	return View('search')
        	->with('message','unexist')
        	->with('search', $search);
        } else{
        	return View('search')
        	->with('jobs', $jobs)
        	->with('search', $search);
        }
    }

}