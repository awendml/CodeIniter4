<?php

namespace App\Controllers;

use App\Models\ComicsModel;

class Comics extends BaseController
{
	protected $comicsModel;
	public function __construct()
	{
        $this->comicsModel = new ComicsModel();

	}
    public function index()
    {
        // $comics = $this->comicsModel->findAll();

        $data = [
            'title' => 'Comic List',
            'comics' => $this->comicsModel->getComics()
        ];



        return view('comic/index', $data);
    }


    public function detail($slug)
    {
    	$data = 
    	[
    		'title' => 'Comic Detail',
    		'comics' => $this->comicsModel->getComics($slug)
    	];

    	// If comic doesn't exist

    	if (empty($data['comics'])) {
    		throw new \CodeIgniter\Exceptions\PageNotFoundException('Comic title ' . $slug . ' not found ');
    		
    	}

    	return view('comic/detail', $data);
    }


    public function create()
    {
    	// session();
    	$data = 
    	[
    		'title' => 'Adding data form',
    		'validation' => \Config\Services::validation()
    	];

    	return view('comic/create', $data);
    }

    public function save()
    {

    	// input validation
    	if (!$this->validate([
    		'title' => [
    			'rules' => 'required|is_unique[comics.title]',
    			'errors' => [
    				'required' => '{field} comic must be included.',
    				'is_unique' => '{field} comic already registered'
    			]
    		],

            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Image too large',
                    'is_mime' => 'its not an image',
                    'mime_in' => 'its not an image',

                ]
            ]
    	])) {

            return redirect()->to('/Comics/create')->withInput();
    	}

        // Ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        // Apakah tidak ada gambar yang di upload
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.png';
        }else{            
        // Ambil  nama file sampul
        $namaSampul = $fileSampul->getName();
        // Pindahkan file ke folder img
        $fileSampul->move('img');
        }


    	$slug = url_title($this->request->getVar('title'), '-', true);
    	$this->comicsModel->save([
    		'title' => $this->request->getVar('title'),
    		'slug' => $slug,
    		'penulis' => $this->request->getVar('penulis'),
    		'penerbit' => $this->request->getVar('penerbit'),
    		'sampul' => $namaSampul

    	]);

    	session()->setFlashdata('pesan', 'Successfully added data');

    	return redirect()->to('/comics');
    }


    public function delete($id)
    {
        // Cari gambar berdasarkan id
        $comic = $this->comicsModel->find($id);

        // Cek jika gambarnya default
        if ($comic['sampul'] != 'default.png') {    
        // Hapus gambar
        unlink('img/' . $comic['sampul']);
        }

    	$this->comicsModel->delete($id);
    	 session()->setFlashdata('pesan', 'Successfully deleted data');
    	return redirect()->to('/comics');  
    }

    public function edit($slug)
    {
    	$data = 
    	[
    		'title' => 'Edit data form',
    		'validation' => \Config\Services::validation(),
    		'comics' => $this->comicsModel->getComics($slug)
    	];

    	return view('comic/edit', $data);
    }


    public function update($id)
    {
    	// cek title
    	$oldComic = $this->comicsModel->getComics($this->request->getVar('slug'));
    	if ($oldComic['title'] == $this->request->getVar('title')) {
    		$rule_title = 'required';
    	} else {
    		$rule_title = 'required|is_unique[Comics.title]';
    	}

    	    if (!$this->validate([
    		'title' => [
    			'rules' => $rule_title,
    			'errors' => [
    				'required' => '{field} comic must be included.',
    				'is_unique' => '{field} comic already registered'
    			]
    		],

            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Image too large',
                    'is_mime' => 'its not an image',
                    'mime_in' => 'its not an image',

                ]
            ]
    	])) {

    		return redirect()->to('/comics/edit' . $this->request->getVar('slug'))->withInput();
    	}

        $fileSampul = $this->request->getFile('sampul');

        // Cek gambar, apakah masih gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        }else{
            $namaSampul = $fileSampul->getName();
            // Pindahkan gambar
            $fileSampul->move('img', $namaSampul);
            // Hapus gambar lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

    	   $slug = url_title($this->request->getVar('title'), '-', true);
    	$this->comicsModel->save([
    		'id' => $id,
    		'title' => $this->request->getVar('title'),
    		'slug' => $slug,
    		'penulis' => $this->request->getVar('penulis'),
    		'penerbit' => $this->request->getVar('penerbit'),
    		'sampul' => $namaSampul

    	]);

    	session()->setFlashdata('pesan', 'Successfully update data');

    	return redirect()->to('/comics');
    }
}







