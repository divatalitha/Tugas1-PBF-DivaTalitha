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

