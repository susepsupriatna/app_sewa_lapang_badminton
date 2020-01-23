<?php

namespace App\Http\Controllers\PublicController;

use App\Http\Controllers\Controller;
use App\Models\Lapang;

class LapangController extends Controller
{

    public function index()
    {
        $lapang = Lapang::select('id', 'nama_lapang', 'jenis_karpet', 'harga_per_jam', 'foto')
        ->OrderBy("id", "DESC")->paginate(10)->toArray();

        $response = [
			"total_count" => $lapang["total"],
			"limit" => $lapang["per_page"],
			"pagination" => [
				"next_page" => $lapang["next_page_url"],
				"current_page" => $lapang["current_page"]
			],
			"data" => $lapang["data"],
		];

        return response()->json($response, 200);
    }

    public function show($id)
    {
        $lapang = Lapang::select('id', 'nama_lapang', 'jenis_karpet', 'harga_per_jam', 'foto')->find($id);
        if (!$lapang) {
			abort(404);
		}
        return response()->json($lapang, 200);
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
