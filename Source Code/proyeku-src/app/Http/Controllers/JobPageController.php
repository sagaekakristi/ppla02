<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Job;
use App\JobCategory;
use App\Category;
use Illuminate\Support\Facades\Auth;
use View;
use Validator;
use Input;
use Illuminate\Support\Facades\Redirect;
use Session;

class JobPageController extends Controller
{
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$logged_user_id = Auth::user()->id;
		$job_id = $id;

		$job_info = Job::find($job_id);

		$job_category_info = JobCategory::where('job_id', '=', $job_id)->get();

		$category_array = array();
		foreach ($job_category_info as $a_job_category){
			$a_category_id = $a_job_category->category_id;
			$a_category_value = Category::find($a_category_id)->kategori;
			$category_array[count($category_array)] = $a_category_value;
		}

		$data['job_info'] = $job_info;
		$data['category_array'] = $category_array;

		return View::make('job.show')
			->with('data', $data)
			->with('jobs', $job_info);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// get all the job
        $jobs = Job::all();

        // load the view and pass the jobs
        return View::make('job.index')
            ->with('jobs', $jobs);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// load the create form (app/views/nerds/create.blade.php)
        return View::make('job.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'judul'		=> 'required',
            'deskripsi'	=> 'required',
            'upah_max'	=> 'required|numeric',
            'upah_min'	=> 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('job/create')
                ->withErrors($validator)
                ->withInput(Input::except('password')); // TODO: Check
        } else {
        	$logged_user_id = Auth::user()->id;
            // store
            $new_job = new Job;
            $new_job->freelancer_info_id = $logged_user_id;
            $new_job->judul = Input::get('judul');
            $new_job->deskripsi = Input::get('deskripsi');
            $new_job->upah_max = Input::get('upah_max');
            $new_job->upah_min = Input::get('upah_min');
            $new_job->save();

            // redirect
            //Session::flash('message', 'Successfully created job!');
            return Redirect::to('job');
        }
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// get the job
        $job = Job::find($id);

        // show the edit form and pass the nerd
        return View::make('job.edit')
            ->with('job', $job);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'judul'		=> 'required',
            'deskripsi'	=> 'required',
            'upah_max'	=> 'required|numeric',
            'upah_min'	=> 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('job/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password')); // TODO: Check
        } else {
            // store
            $updated_job = Job::find($id);
            $updated_job->judul = Input::get('judul');
            $updated_job->deskripsi = Input::get('deskripsi');
            $updated_job->upah_max = Input::get('upah_max');
            $updated_job->upah_min = Input::get('upah_min');
            $updated_job->save();

            // redirect
            Session::flash('message', 'Successfully updated job!');
            return Redirect::to('job/' . $id);
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
        $deleted_job = Job::find($id);
        $deleted_job->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the job!');
        return Redirect::to('job');
	}

}
