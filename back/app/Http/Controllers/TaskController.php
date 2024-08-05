<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function getTasks(){
        $tasks = Task::all();

        return $tasks;
    }

    public function getInfoTask(Request $request){
        $task_id = $request->id;

        $task = Task::find($task_id)->get();

        return $task;
    }

    public function createTask(Request $request){

        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);

        $task = new Task;
        $task->name=$request->name;
        $task->description=$request->description;
        $task->status=0;

        if($task->save()){
            return true;
        }
        else{
            return false;
        }
    }

    public function updateTask(Request $request){        
        $task_id = $request->id;

        $task = Task::find($task_id);

        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
            'status' => 'required|boolean',
        ]);

        $task->name=$request->name;
        $task->description=$request->description;
        $task->status=$request->status;
        $task->save();

        if($task->save()){
            return true;
        }
        else{
            return false;
        }
    }

    public function deleteTask(Request $request){
        $task_id = $request->id;

        $task = Task::find($task_id);

        $task->delete();
    }
}
