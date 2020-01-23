<?php

namespace App\Http\Controllers;

use App\Models\Lapang;
use Illuminate\Http\Request;

class LapangController extends Controller
{
    
    public function store(Request $request)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $input = $request->all();
            $validationRules = [
                'nama_lapang'   => 'required|min:5|unique:lapang',
                'jenis_karpet'  => 'required|in:interlock,vinyl',
                'harga_per_jam' => 'required|numeric',
                'foto'          => 'required',
            ];
            $validator = \Validator::make($input, $validationRules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $lapang = new Lapang;
            $lapang->nama_lapang    = $request->input('nama_lapang');
            $lapang->jenis_karpet   = $request->input('jenis_karpet');
            $lapang->harga_per_jam  = $request->input('harga_per_jam');
            
            if ($request->hasFile('foto')) {
                $imageName = str_replace(" ","_", $request->input('nama_lapang'));
                $request->file('foto')->move(storage_path('uploads/images'), $imageName);
                $current_image_path = storage_path('avatar');
            }

            $lapang->foto = $imageName;
            $lapang->save();
            return response()->json($lapang, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $lapang = Lapang::OrderBy("id", "DESC")->paginate(5)->toArray();
            $response = [
                "total_count" => $lapang["total"], 
                "limit"       => $lapang["per_page"],
                "pagination"  => [
                    "next_page"    => $lapang["next_page_url"], 
                    "current_page" => $lapang["current_page"],
                ],
                "data" => $lapang["data"],
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
            $lapang = Lapang::find($id);
            if (!$lapang) {
                abort(404);
            }
            return response()->json($lapang, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function update(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
                $input = $request->all();
                $lapang = Lapang::find($id);
                if (!$lapang) {
                    abort(404);
                }
                $lapang->fill($input);
                $lapang->save();
                return response()->json($lapang, 200);
            
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $lapang = Lapang::find($id);
            if (!$lapang) {
                abort(404);
            }
            $lapang->delete();
            $message = ['message' => 'Deleted successfully', 'lapang_id' => $id];
            return response()->json($message, 200);
        }else{
            return response('Not acceptable', 406);
        }
    }

    public function image($imageName)
    {
        $imagePath = storage_path('uploads/images/'.$imageName);
        if (file_exists($imagePath)) {
            $file = file_get_contents($imagePath);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        }
        return response()->json([
            "message" => "Image not found"
        ],401);
    }

}
