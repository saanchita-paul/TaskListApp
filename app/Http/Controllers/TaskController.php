<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Auth;

class TaskController extends Controller
{
    public function list(){
        if (Auth::user()->role == 1 || Auth::user()->role == 2) {
            $task= Task::all();
        }
        return response()->json([
            'success' => true,
            'message'=> "Data fetched succesfully",
            'data' => $task,
            ]);
    }

    public function store(Request $request)
    {
        // $user_id = Auth::user()->id;
    //     if (Auth::user()->role == 1 || Auth::user()->role == 2) {
    //         $data = new Task();
    //         $data->name = $request->name;
    //         $data->slug = $request->slug;
    //         $data->description = $request->description;
    //         $data->user_id = Auth::user()->id;
    //         $data->save();
    //     }
    //    return response()->json([
    //     'success' => true,
    //     'message'=> "Data inserted succesfully",
    //     'data' => $data,
    //     ]);
        if (Auth::user()->role == 1 || Auth::user()->role == 2) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'description' => 'nullable|string',
            ]);
            if($validator->fails()) {
            //$task['status'] = 'error';
            if(empty($request->name)){
                $task['name'] = 'error';
            }
            if(empty($request->description)){
                $task['description'] = 'error';
            }
            $task['message']='Something is missing';
            return json_encode($task);
            }
            $data = new Task;
            $data->name = $request->name;
            $data->slug = Str::slug($request->name, '-');
            $data->description = $request->description;
            $data->user_id = Auth::user()->id;
            $data->save();
        }
            return response()->json([
                'success' => true,
                'message'=> "Data inserted succesfully",
                'data' => $data,
            ]);

    }

    public function update(Request $request,$id)
    {
        //$user_id = Auth::user()->id;
        if (Auth::user()->role == 1 || Auth::user()->role == 2) {
            $data = Task::find($id);
            
            $data->name = $request->name;
            $data->slug = Str::slug($request->name, '-');
            $data->description = $request->description;
            //$data->user_id = Auth::user()->id;
            $data->update($request->all());
        }
        return response()->json([
            'success' => true,
            'message'=> "Data updated succesfully",
            'data' => $data,
            ]);

    }

    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        if (Auth::user()->role == 1 || Auth::user()->role == 2) {
            $task= Task::destroy($id);
        }
        return response()->json([
            'success' => true,
            'message'=> "Data deleted succesfully",
            'data' => $task,
            ]);
    }


    public function deleteUserTask($userid, $taskid)
    {
        if (Auth::user()->role == 2) {
            $task= Task::destroy($taskid);
        }
        elseif(Auth::user()->role == 1){
            return response()->json([
                'message'=> "You don't have permision to delete this record."
            ]);
        }
        return response()->json([
            'success' => true,
            'message'=> "Data deleted succesfully",
            'data' => $task,
            ]);
    }
}
