<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Todo::with('user')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
        ]);
       
        if (!$validator->passes()){
            return api_response(false, $validator->errors()->all(), 1, 'failed', "Required fields are missing or wrong inputs", null);
        }

        $request['user_id'] = Auth::id();
        $todo = Todo::create($request->all());

        return $todo;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        if (is_null($todo)) {
            return api_response(true, null, 404, 'error', "Todo not found ", null);
        }
        return api_response(true, null, 200, 'success', "successfully fetched todo", $todo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'description' => 'required',
            'priority' => 'required',
            'due_date' => 'required',
        ]);
        
        if (!$validator->passes()){
            return api_response(false, $validator->errors()->all(), 1, 'failed', "Required fields are missing or wrong inputs", null);
        }

        $todo->update($request->all());

        return api_response(true, null, 201, 'success', "successfully updated todo", $todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if (is_null($todo)) {
            return api_response(true, null, 404, 'error', "todo not found ", null);
        }
        $todo->delete();
        return api_response(true, null, 201, 'success', "successfully deleted todo", $todo);
    }
}
