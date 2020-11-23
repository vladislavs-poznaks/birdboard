<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' =>  Project::all()
        ]);
    }

    public function store(ProjectStoreRequest $request)
    {

        Project::create($request->all());

        return redirect(route('projects.index'));
    }
}
