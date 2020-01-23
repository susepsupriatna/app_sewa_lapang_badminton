<?php

namespace App\Http\Controllers\PublicController;

use App\Http\Controllers\Controller;
use App\Models\Sewa;

class SewaController extends Controller
{

    public function index()
    {
        $sewa = Sewa::select('id', 'member_id', 'lapang_id', 'tanggal', 'jam_mulai', 'jam_selesai')
        ->with(['member' => function ($query){
        	$query->select('id', 'nama_member');
        }])
        ->with(['lapang' => function ($query){
        	$query->select('id', 'nama_lapang', 'foto');
        }])
        ->with(['pembayaran' => function ($query){
        	$query->select('sewa_id', 'status')->where('status', 'lunas');
        }])
        ->OrderBy("id", "DESC")->paginate(5)->toArray();
        $response = [
			"total_count" => $sewa["total"],
			"limit" => $sewa["per_page"],
			"pagination" => [
				"next_page" => $sewa["next_page_url"],
				"current_page" => $sewa["current_page"]
			],
			"data" => $sewa["data"],
		];
        return response()->json($response, 200);
    }

}
