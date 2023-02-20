<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {

	public function search(Request $request) {
		\Unsplash\HttpClient::init([
			'applicationId'	=>	config('services.unsplash.key'),
			'secret'		=> 	config('services.unsplash.secret'),
			'callbackUrl'	=> 	'',
			'utmSource' 	=> 	'VlogAI'
		]);
		$search = $request->heading_text;
		$page = 1;
		$per_page = 1;
		$orientation = 'landscape';

		$res = \Unsplash\Search::photos($search, $page, $per_page, $orientation);
		$images = $res->getResults();
		return response()->json(['images' => $images]);
	}
}
