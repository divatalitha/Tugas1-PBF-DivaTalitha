<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException; //baru

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data = [
            'news'  => $model->getNews(),
            'title' => 'Artikel Berita',
        ];

        return view('templates/header', $data)
            . view('news/index')
            . view('templates/footer');
    }

    public function show($information = null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($information);

        if (empty($data['news'])) {
            throw new PageNotFoundException('Cannot find the news item: ' . $information);
        }

        $data['title'] = $data['news']['title'];

        return view('templates/header', $data)
            . view('news/view')
            . view('templates/footer');
    }

    public function new()
    {
        helper('form');

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/create')
            . view('templates/footer');
    }


    public function create()
{
    // Load helper form untuk memudahkan penggunaan fungsi pembuatan formulir dalam CodeIgniter.
    helper('form');

    // Mengambil data dari permintaan POST yang dikirimkan.
    $data = $this->request->getPost(['title', 'detail']);

    // Validasi data yang diterima.
    if (! $this->validateData($data, [
        'title' => 'required|max_length[255]|min_length[3]',
        'detail'  => 'required|max_length[5000]|min_length[10]',
    ])) {
        // Jika data tidak valid, kembali ke halaman pembuatan entri baru.
        return $this->new();
    }

    // Mendapatkan data yang telah divalidasi.
    $post = $this->validator->getValidated();

    // Mendapatkan instance dari model NewsModel.
    $model = model(NewsModel::class);

    // Menyimpan data berita baru ke dalam database.
    $model->save([
        'title' => $post['title'],
        'information'  => url_title($post['title'], '-', true), // Membuat slug berdasarkan judul untuk digunakan dalam URL.
        'detail'  => $post['detail'],
    ]);

    // Menampilkan tampilan berhasil membuat berita baru.
    return view('templates/header', ['title' => 'Create a news item'])
        .view('news/success')
        .view('templates/footer');
}

}
