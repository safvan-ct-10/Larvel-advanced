<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Admin\UserRequest;

class UserController extends Controller
{
    public function index()
    {
        $active = "user";
        $active_sub = "";

        return view('admin.user.index')
            ->with("active", $active)
            ->with("active_sub", $active_sub);
    }

    public function result()
    {
        $results = User::latest()->get();
        return DataTables::of($results)
            ->addColumn('action', function ($result) {
                $buttons = [
                    "edit" => route('user.create.update', [$result->id]),
                    "status" => [
                        "id" => $result->id,
                        "status" => $result->is_active,
                        "datatable_id" => "datatable",
                    ],
                    "delete" => [
                        "id" => $result->id,
                        "datatable_id" => "datatable",
                    ],
                ];
                return actionButtons($buttons);
            })
            ->addIndexColumn()
            ->escapeColumns([])
            ->setRowId('id')
            ->make(true);
    }


    public function createUpdate($id = 0)
    {
        $active = "user";
        $active_sub = "";

        if ($id==0) {
            $obj = new User;
        } else {
            $obj = User::find($id);
            if (is_null($obj)) {
                return redirect()->route('user.index')->with('error', returnMsg('404'));
            }
        }

        return view('admin.user.create-Update')
            ->with("obj", $obj)
            ->with("active", $active)
            ->with("active_sub", $active_sub);
    }
    public function createUpdatePost(UserRequest $request)
    {
        $data = $request->all();

        $obj = null;
        if ($data["id"] !=0) {
            $obj = User::find($data["id"]);
            if (is_null($obj)) {
                return redirect()->route('user.index')->with('error', returnMsg('404'));
            }
        }

        if(is_null($data['password'])) {
            unset($data['password']);
        }

        if (is_null($obj)) {
            $res = User::create($data);
            return redirect()->route('user.create.update', [$res->id])->with('success', returnMsg('201'));
        } else {
            $obj->update($data);
            return redirect()->route('user.create.update', [$obj->id])->with('success', returnMsg());
        }
    }

    public function action($id, $status)
    {
        $id = clean($id);
        $status = clean($status);

        if (in_array($status, [0,1])) {
            User::where("id",$id)->update(['is_active' => $status]);
        } elseif (in_array($status, [2])) {
            $obj = User::find($id);
            if (!is_null($obj)) {
                $obj->delete();
            }
        }

        return json_encode(['response' => 'success', 'message' =>  returnMsg()]);
    }
}
