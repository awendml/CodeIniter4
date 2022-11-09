<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
    	$data = [
    		'title' => 'Home | WebCodeigniter'
    	];
    	return view('pages/home', $data);
    }
    public function about()
    {
    	$data = [
    		'title' => 'About me'
    	];
    	return view('pages/about', $data);

    }

    public function contact()
    {
    	$data = [
    		'title' => 'Contact us',
    		'alamat' => [
    			[
    				'tipe' => 'Rumah',
    				'alamat' => 'Jln. K.S Tubun',
    				'kota' => 'Kendari'
    			],
    			[
    				'tipe' => 'Sekret',
    				'alamat' => 'Jln. Sakio',
    				'kota' => 'Kendari'
    			]
    		]
    	];

    	return view('pages/contact', $data);
    }
}
