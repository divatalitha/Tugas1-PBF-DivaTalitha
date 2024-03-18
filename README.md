
# Diva Talitha_220302081

## Apa itu CodeIgniter ?
CodeIgniter adalah kerangka kerja (framework) pengembangan aplikasi web berbasis PHP yang bersifat open-source. 

## Keunggulan CodeIgniter
* Performa cepat: Codeigniter merupakan framework yang paling cepat dibanding framework yang lain. Karena tidak menggunakan template engine dan ORM yang dapat memperlambat proses.
* Konfigurasi yang minim (nearly zero configuration): tentu saja untuk menyesuaikan dengan database dan keleluasaan routing tetap diizinkan melakukan konfigurasi dengan mengubah beberapa file konfigurasi seperti database.php atau autoload.php, namun untuk menggunakan codeigniter dengan setting standard, anda hanya perlu mengubah sedikit saja pada file di folder config.
* Memiliki banyak komunitas: Komunitas CI di indonesia cukup ramai, tutorialnya pun mudah dicari.

## Instalasi
#### *Instalasi Manual*
1. Download Codeigniter https://codeigniter.com/download
2. Ekstrak File ZIP Codeigniter ke htdocs jika menggunakan XAMPP, tetapi jika menggunakan laragon bisa disimpan dimana saja.
3. Atur Konfigurasi: Buka file app\Config\App.php dan sesuaikan konfigurasi aplikasi sesuai kebutuhan Anda. Misalnya, konfigurasi nama aplikasi, timezone, dll.
4. Atur Routing: Konfigurasikan routing aplikasi Anda sesuai kebutuhan. Ini dapat dilakukan dalam file app\Config\Routes.php. Anda dapat menentukan rute untuk setiap permintaan yang masuk ke aplikasi Anda.
5. Konfigurasi Database (Opsional): Jika aplikasi Anda menggunakan database, atur koneksi basis data Anda dalam file app\Config\Database.php.
6. Jalankan server dengan masuk ke root projek -> lalu buka terminal, kemudian ketik perintah berikut 
``` shell
$ cd projek root
$ php spark server
```
7. Buka kembali servernya di http://localhost:8080
![Screenshot 2024-03-18 105945](https://github.com/divatalitha/Tugas1_PBF/assets/127199859/0e434e6e-e4ac-4f50-8379-fab10a166dfc)

#### *Instalasi Composer*
1. Buka laragon -> root, ubah rootnya menjadi folder yang akan digunakan untuk menyimpan file download.
2. Masuk ke terminal laragon, lalu masuk ke folder simpan
3. Kemudian ketik perintah berikut.
``` shell
$ composer create-project codeigniter4/appstarter project-root
``` 
Note: perintah pertama untuk mendownload data secara penuh

``` shell
$ composer install --no-dev
```
Note: perintah kedua untuk mendownload data lebih sedikit dan tidak terlalu banyak memenuhi penyimpanan.

4. Jalankan server dengan perintah berikut.
``` shell
$ cd projek root
$ php spark serve
```
#### *Konfigurasi Awal*
1. Atur mode development
Masuk ke dalam file **.env** Ubah setelan `CI_ENVIRONMENT` menjadi `development` untuk menampilkan error atau mengaktifkan mode debugging
![dev](https://github.com/divatalitha/Tugas1_PBF/assets/127199859/58bf4e00-8a30-4808-9c28-08c6a44cd58d)

2. pada bagian `app.baseURL` di isi dengan server localhost
![Screenshot 2024-03-18 120853](https://github.com/divatalitha/Tugas1_PBF/assets/127199859/54f3df79-d9b6-4d99-9950-75713d098806) 

## Bangun Aplikasi pertama
#### *Static Pages*
1. SetUp Routing 
Buka `app/Config/Routes.php`, lalu tambahkan baris perintah berikut untuk menyambungkan ke controller **Pages.php**
``` shell
$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
```
Keterangan : 

- ‘pages’ → Untuk URL
- pages::class → Nama class pada controller
- ‘index’ → Method yang ada pada class
2. Membuat controller dengan membuat file baru bernama **Pages.php**
```php
<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view($page = 'home')
    {
        
    }
}
```
3. Membuat folder `templates` pada `view`, lalu tambahkan file **header.php** dan **footer.php** (File app/Views/templates)

- **header.php**
```php
<!doctype html>
<html>
<head>
    <title>CodeIgniter Tutorial</title>
</head>
<body>

    <h1><?= esc($title) ?></h1>
```
File app/Views/templates/header.php
- **footer.php**
```php
  <footer>footer</footer>
<em>&copy; 2024</em>
</body>

</html>
```
File app/Views/templates/footer.php

4. Menambah logika ke controller
Membuat folder baru `pages` yang ada di view, lalu buat file bernama **home.php** dan **about.php** (File app/Views/pages)

- **home.php**
```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>

<body>
    <h1>Welcome to the Home Page</h1>
</body>

</html>
```
File app/Views/pages/home.php

- **about.php**
```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Page</title>
</head>

<body>
    <h1>About Me</h1>
    <p>Ini adalah halaman tentang situs web.</p>
</body>

</html>
```
File app/Views/pages/about.php

5. Melengkapi method view() pada controller
**Pages.php**
```php
<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; // Add this line

class Pages extends BaseController
{
    // ...

    public function view($page = 'home')
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        return view('templates/header', $data)
            . view('pages/' . $page)
            . view('templates/footer');
    }
}
```
Menjadi
```php
<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; //untuk mengimpor kelas PageNotFoundException
//CodeIgniter\Exceptions. tidak ada folder fisik yang secara langsung menampungnya di struktur proyek standar ini berasal dari default sistem ci

class Pages extends BaseController
{
		
    public function index()
    {
        // Menampilkan halaman utama (welcome_message.php)
        return view('welcome_message');
    }

    public function view($page = 'home')
    {
     

        // Mengecek apakah halaman yang diminta ada
        if (!is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Jika tidak ada, lempar PageNotFoundException
            throw new PageNotFoundException($page);
        }

        // Mengatur judul halaman berdasarkan nama halaman
        $data['title'] = ucfirst($page); // Kapitalkan huruf pertama

        // Memuat template header, halaman statis (home, about), dan footer
        return view('templates/header', $data)
            . view('pages/' . $page, $data)
            . view('templates/footer');
    }
}
```
Note: Akan menampilkan view header, pages (home / about), footer

6. Lalu masuk ke URL localhost
http://localhost:8080

- **home.php**
![Screenshot 2024-03-18 124641](https://github.com/divatalitha/Tugas1_PBF/assets/127199859/85be54ac-905b-40d2-ba5d-4bebd2e8e31a)

- **about.php**
![Screenshot 2024-03-18 124842](https://github.com/divatalitha/Tugas1_PBF/assets/127199859/c3acc6fc-10a8-477c-92a3-0a3e96e35677)

### *News Section*
1. Membuat database dengan nama `codeigniter4`, lalu buat tabel dengan perintah berikut
```sql
CREATE TABLE news (
    id INT AUTO_INCREMENT,
    title VARCHAR(128) NOT NULL,
    information VARCHAR(128) NOT NULL,
    detail TEXT NOT NULL,
    PRIMARY KEY (id)
);
```
2. Masukkan data menggunakan perintah berikut
```sql
INSERT INTO news (title, information, detail) VALUES 
('Teknologi: Solusi Lingkungan', 'Teknologi mengatasi tantangan lingkungan', 'Dalam menghadapi masalah lingkungan, teknologi telah menjadi pendorong solusi efektif.'),
('Seni sebagai Solusi dan Inspirasi', 'Sebagai sumber solusi dan inspirasi', 'Sebagai solusi dan sumber inspirasi, seni mengingatkan kita akan kekuatan imajinasi dan keberanian untuk memperjuangkan perubahan positif dalam dunia yang kompleks ini.'),
('Pembukaan Museum', 'Pameran karya seni', 'Sebagai penjaga ingatan kolektif, museum memberikan akses kepada masyarakat untuk menjelajahi dan memahami kekayaan budaya yang ada di sekitar mereka.');
```
3. Menghubungkan ke database
```php
database.default.hostname = localhost
database.default.database = codeigniter4
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
 ```
 4. Buat model baru yang bernama **NewsModel.php**
 ```php
 <?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
}
```
File app/Models/NewsModel.php

5. Tambahkan method `NewsModel::getNews()` pada **NewsModel.php**
```php
public function getNews($information = false)
    {
        if ($information === false) {
            return $this->findAll();
        }

        return $this->where(['information' => $information])->first();
    }
```
6. Menambah peraturan routing
Modifikasi **routes.php** menjadi seperti ini
```php
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

use App\Controllers\Pages;
use App\Controllers\News; // Tambah baris ini

$routes->get('news', [News::class, 'index']);           // Tambah baris ini
$routes->get('news/(:segment)', [News::class, 'show']); // Tambah baris ini

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
```
File app/Config/Routes.php

7. Membuat controller baru 
Buat controller baru di `File app/Controllers/News.php`
```php
<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews();
    }

    public function show($information = null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($information);
    }
}
```
8. Melengkapi method News::index() pada **News.php**
```php
<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data = [
            'news'  => $model->getNews(),
            'title' => 'News archive',
        ];

        return view('templates/header', $data)
            . view('news/index')
            . view('templates/footer');
    }

    // ...
}
```
9. Membuat file **index.php** pada `File app/Views/news/index.php`
```php
<h2><?= esc($title) ?></h2>

<?php if (! empty($news) && is_array($news)): ?>

    <?php foreach ($news as $news_item): ?>

        <h3><?= esc($news_item['title']) ?></h3>

        <div class="main">
            <?= esc($news_item['detail']) ?>
        </div>
        <p><a href="/news/<?= esc($news_item['information'], 'url') ?>">View article</a></p> <!-- terhubung ke controller News.php -->

    <?php endforeach ?>

<?php else: ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

<?php endif ?>
```
10. Melengkapi method News::show() pada **News.php**
```php
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
```
11. Membuat tampilan **view.php** pada `File app/Views/news/view.php`
```php
<h2><?= esc($news['title']) ?></h2>
<p><?= esc($news['detail']) ?></p>
```
### *Create News Items* 
1. Aktifkan filter CSRF
```php
<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    // ...

    public $methods = [
        'post' => ['csrf'],
    ];

    // ...
}
```
File app/Config/Filters.php
2. Menambah peraturan routes
```php
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

use App\Controllers\Pages;
use App\Controllers\News; // Tambah baris ini

$routes->get('news', [News::class, 'index']);           // Tambah baris ini

$routes->get('news/new', [News::class, 'new']); // Tambah baris ini (poin create News items)
$routes->post('news', [News::class, 'create']); // Tambah baris ini (poin create News items)

$routes->get('news/(:segment)', [News::class, 'show']); // Tambah baris ini

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
```
File app/Config/Routes.php

3. Membuat Form pada Views dengan nama **create.php**
```php
<!-- Ini adalah bagian dari tampilan yang menampilkan judul halaman. -->
<!-- menghasilkan judul yang telah di-escape untuk mencegah serangan XSS (Cross-Site Scripting) -->
<h2><?= esc($title) ?></h2>


<?= session()->getFlashdata('error') ?> <!-- Ini digunakan untuk menampilkan pesan kesalahan (error) yang disimpan dalam session flash data -->
<?= validation_list_errors() ?> <!-- Ini digunakan untuk menampilkan daftar kesalahan (errors) yang dihasilkan dari validasi form. -->

<form action="/news" method="post">
    <?= csrf_field() ?> <!-- fitur keamanan CSRF (Cross-Site Request Forgery) yang secara otomatis menambahkan token CSRF ke dalam form untuk mencegah serangan CSRF. -->

    <label for="title">Title</label> <!-- label untuk input judul. -->
    <input type="input" name="title" value="<?= set_value('title') ?>"> <!-- Membuat field input untuk judul, dengan nilai default dari fungsi set_value() -->
    <br>

    <label for="body">Text</label>  <!-- Membuat label untuk field teks -->
    <textarea name="body" cols="45" rows="4"><?= set_value('body') ?></textarea> <!-- Membuat field textarea untuk teks, dengan nilai default dari fungsi set_value() -->
    <br>

    <input type="submit" name="submit" value="Create news item"> <!-- Membuat tombol submit -->
</form>

```
File app/Viws/news/create.php

4. Menambah method News::new() pada **News.php**
```php
public function new()
    {
        helper('form');

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/create')
            . view('templates/footer');
    }
```
File app/Controllers/News.php

5. Menambah method News::create() pada **News.php** untuk membuat items berita
```php
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
```
6. Buat file **succsess.php** dalam folder view
```php
<p>News item created successfully.</p>
```
File app/Views/news/success.php

7. Perbarui Model **NewsModel.php** 
```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    protected $allowedFields = ['title', 'information', 'detail'];
}
```
File app/Models/NewsModel.php

8. Coba pada URL yang telah ditambahkan
- http://localhost:8080/news
![Screenshot 2024-03-18 141947](https://github.com/divatalitha/Tugas1_PBF/assets/127199859/68281db5-dcb7-4e78-934e-44aa93faef07)

- http://localhost:8080/news/new
![Screenshot 2024-03-18 142125](https://github.com/divatalitha/Tugas1_PBF/assets/127199859/cfd36d40-af3e-49f0-ba50-ef599e3507e5)

## CodeIgniter4 Overview
### *Struktur Aplikasi*
```plain text
app/
    Config/         Menyimpan file konfigurasi
    Controllers/    Controller menentukan alur program
    Database/       Menyimpan file migrasi dan seed basis data
    Filters/        Menyimpan kelas filter yang dapat dijalankan sebelum dan setelah controller
    Helpers/        Helpers menyimpan kumpulan fungsi mandiri
    Language/       Dukungan multi bahasa membaca string bahasa dari sini
    Libraries/      Kelas-kelas yang berguna yang tidak cocok dalam kategori lainnya
    Models/         Models bekerja dengan database untuk merepresentasikan entitas bisnis
    ThirdParty/     Pustaka pihak ketiga yang dapat digunakan dalam aplikasi
    Views/          Views membentuk HTML yang ditampilkan kepada klien
```

Tambahan:
- ***public*** → Menyimpan asset seperti CSS,Javascript, or Image
- ***writable*** → Menyimpan direktori apa pun yang perlu ditulis selama masa pakai 
- ***test*** → Menyimpan file pengujian
- ***vendor / system*** → Menyimpan file yang membentuk kerangka kerja itu sendiri.

### *Models, View, and Controllers*
- ***Model***
Komponen Model bertanggung jawab untuk mengelola data aplikasi, termasuk operasi pengambilan, penyimpanan, dan pembaruan data. Model merepresentasikan struktur data aplikasi serta aturan bisnis yang terkait dengan data tersebut.

- ***View***
Komponen View bertanggung jawab untuk menampilkan informasi kepada pengguna. Ini dapat berupa halaman HTML, antarmuka pengguna grafis, atau elemen tampilan lainnya yang mempresentasikan data dari Model kepada pengguna.

- ***Controller***
Komponen Controller bertindak sebagai perantara antara Model dan View. Controller menerima input dari pengguna melalui antarmuka pengguna, memproses permintaan, berinteraksi dengan Model untuk memanipulasi data, dan kemudian mengirimkan data yang diperlukan ke View untuk ditampilkan kepada pengguna.

## Topik Umum
### *Konfigurasi*
- Membuat file konfigurasi
Meletakkan konfigurasi di folder `config`
```php
<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class CustomClass extends BaseConfig
{
    public $siteName  = 'My Great Site';
    public $siteEmail = 'webmaster@example.com';
    // ...
}
```
### *CodeIgniter URL*
Mempelajari struktur URL

1. Base URL -> https://www.example.com/ci-blog/ -> Seperti localhost:8080
2. URI path -> /ci-blog/blog/news/2022/10 -> File Folder
3. Route path -> /blog/news/2022/10 -> Routes
4. Query -> page=2 -> Parameter yang diambil 

### *Global Functions and Constanta*
1. Global function
- Service Accessors
-> esc()
```shell
esc($data[, $context = 'html'[, $encoding]])
```
Keterangan : 

Parameter 

- $data (string | array) → Informasi yang akan lolos.
- $context (string) → Konteks melarikan diri. Defaultnya adalah 'html'.
- $encoding (string) → Pengkodean karakter string. (`html,js,css,url,attr,raw`)

-> csrf_field()
String dengan HTML untuk input tersembunyi dengan semua informasi CSRF yang diperlukan

## Controller dan Routing
### *URI Routing*
Mengatur peraturan routes

proses pengaturan cara CodeIgniter mengurai permintaan HTTP yang diterimanya untuk menentukan tindakan yang akan diambil dan kontroler mana yang akan memprosesnya.

contoh:

peraturan route dasar
```php
$routes->get('/', 'Home::index');
```
Dapat ditulis dalam berbagai bentuk:
```php
$routes->get('news', 'News::index');
```
```php
$routes->get('news', [\App\Controllers\News::class,'index']);
```
```php
 $routes->get('/coba', function (){
     echo 'hello world!';
 )}
```
### *Placeholder*
- (:any)
Mencocokan semua karakter hingga akhir URL

- (:segment)
Cocok dengan karakter apapun kecuali garis miring yang membatasi 

- (:num)
Cocok dengan bilangan bulat 

- (:alpha)
Cocok dengan string karakter alfabet 

- (:alphanum)
Cocok dengan string karakter alfabet atau bilangan bulat atau kombinasi keduanya

- (:hash)
sama seperti (:segment), tapi dapat dengan mudah melihat rute mana yang menggunakan ID hash
































