<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function store(Request $request)
    {
        // $upload = request()
        //     ->file('file')
        //     ->storeAs(
        //         path: 'todo',
        //         name: request()->file('file')->getClientOriginalName(),
        //         options: ['disk' => 's3']
        //     );

        Todo::query()->create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'assigned_to_id' => $request->get('assigned_to_id')
        ]);
    
        return redirect()->route('todo.index');
    }

    
    public function update(Todo $todo)
    {

        $todo->fill([
            'title'          => request()->title,
            'description'    => request()->description,
            'assigned_to_id' => request()->assigned_to_id
        ]);
    
        $todo->save();

        return redirect()->route('todo.index');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todo.index');
    }
}
