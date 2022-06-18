<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Http\Requests\Admin\LocationRequest;

class LocationController extends Controller
{
    public function index()
    {
        $active = "location";
        $active_sub = "";

        return view('admin.location.index')
            ->with("active", $active)
            ->with("active_sub", $active_sub);
    }

    public function result()
    {
        $results = Location::latest()->get();
        return DataTables::of($results)
            ->addColumn('action', function ($result) {
                $buttons = [
                    "editAjax" => [
                        'id' => $result->id,
                    ],
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
        if ($id==0) {
            $obj = new Location;
        } else {
            $obj = Location::find($id);
            if (is_null($obj)) {
                return json_encode(['response' => 'success', 'message' => returnMsg('404')]);
            }
        }

        $view = view('admin.location.create-Update')->with("obj", $obj)->render();
        return json_encode(['response' => 'success', 'message' => $view]);
    }
    public function createUpdatePost(LocationRequest $request)
    {
        $data = $request->all();
        $obj = null;
        if ($data["id"] !=0) {
            $obj = Location::find($data["id"]);
            if (is_null($obj)) {
                return json_encode(['response' => 'error', 'message' => returnMsg('404')]);
            }
        }

        if (is_null($obj)) {
            Location::create($data);
            return json_encode(['response' => 'success', 'message' => returnMsg('201')]);
        } else {
            $obj->update($data);
            return json_encode(['response' => 'success', 'message' => returnMsg()]);
        }
    }

    public function action($id, $status)
    {
        $id = clean($id);
        $status = clean($status);
        $obj = Location::find($id);
        if (is_null($obj)) {
            return json_encode(['response' => 'error', 'message' => returnMsg('404')]);
        }

        if (!is_null($obj)) {
            if (in_array($status, [0,1])) {
                $obj->update(['is_active' => $status]);
            } elseif (in_array($status, [2])) {
                $obj->delete();
            }
        }

        return json_encode(['response' => 'success', 'message' =>  returnMsg()]);
    }
}
