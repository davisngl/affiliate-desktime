<?php

namespace App\Http\Controllers;

class AffiliateCodeStatisticsController extends Controller
{
	public function __invoke()
	{
        return view('statistics', [
            'data' => [],
        ]);
	}
}
