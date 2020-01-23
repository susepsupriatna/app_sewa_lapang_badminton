<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use Illuminate\Http\Request;

class SewaController extends Controller
{
    public function store(Request $request)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $input = $request->all();
            $validationRules = [
                'user_id'       => 'required|exists:users,id',
                'member_id'     => 'required|exists:members,id',
                'lapang_id'     => 'required|exists:lapang,id',
                'tanggal'       => 'required|min:10',
                'jam_mulai'     => 'required|numeric',
                'jam_selesai'   => 'required|numeric',
            ];
            $validator = \Validator::make($input, $validationRules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $sewa = Sewa::create($input);
            return response()->json($sewa, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $sewa = Sewa::OrderBy("id", "DESC")->paginate(5)->toArray();
            $response = [
                "total_count" => $sewa["total"], 
                "limit"       => $sewa["per_page"],
                "pagination"  => [
                    "next_page"    => $sewa["next_page_url"], 
                    "current_page" => $sewa["current_page"],
                ],
                "data" => $sewa["data"],
            ];
            return response()->json($response, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function show(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json') {
            $sewa = Sewa::find($id);
            if (!$sewa) {
                abort(404);
            }
            return response()->json($sewa, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function update(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $contentTypeHeader = $request->header('Content-Type');
            if ($contentTypeHeader === 'application/json') {
                $input = $request->all();
                $sewa = Sewa::find($id);
                if (!$sewa) {
                    abort(404);
                }
                $sewa->fill($input);
                $sewa->save();
                return response()->json($sewa, 200);
            }else{
                return response('Unsupported Media Type', 415);
            }
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $sewa = Sewa::find($id);
            if (!$sewa) {
                abort(404);
            }
            $sewa->delete();
            $message = ['message' => 'Deleted successfully', 'sewa_id' => $id];
            return response()->json($message, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

}
