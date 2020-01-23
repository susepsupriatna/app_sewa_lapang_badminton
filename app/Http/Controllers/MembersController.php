<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MembersController extends Controller
{

    public function store(Request $request)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $input = $request->all();
            $validationRules = [
                'nama_member'   => 'required|min:5',
                'alamat'        => 'required|min:5',
                'no_telp'       => 'required|numeric',
            ];
            $validator = \Validator::make($input, $validationRules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $member = Member::create($input);
            return response()->json($member, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $member = Member::OrderBy("id", "DESC")->paginate(5)->toArray();
            $response = [
                "total_count" => $member["total"], 
                "limit"       => $member["per_page"],
                "pagination"  => [
                    "next_page"    => $member["next_page_url"], 
                    "current_page" => $member["current_page"],
                ],
                "data" => $member["data"],
            ];
            return response()->json($response, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function show(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $member = Member::find($id);
            if (!$member) {
                abort(404);
            }
            return response()->json($member, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function update(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $input = $request->all();
            $member = Member::find($id);
            if (!$member) {
                abort(404);
            }
            $member->fill($input);
            $member->save();
            return response()->json($member, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $member = Member::find($id);
            if (!$member) {
                abort(404);
            }
            $member->delete();
            $message = ['message' => 'Deleted successfully', 'member_id' => $id];
            return response()->json($message, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

}
