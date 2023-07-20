# Final Project Bootcamp Inosoft Batch 5 (Tim 2)

## 3rd Party Instruction App

**3rd Party Instruction App** adalah sebuah aplikasi berbasis web yang dikerjakan pada Final Project dari sebuah event Bootcamp yang diadakan oleh Inosoft. Aplikasi ini dirancang menggunakan framework Laravel yang dilengkapi dengan Vue.js pada bagian front-end. Aplikasi ini berfungsi untuk memanajemen sekaligus sistem informasi instruksi jasa yang dikerjakan oleh vendor-vendor sebuah perusahaan. Project ini dikerjakan oleh Tim FP 2.

## Installation

### Pulling Repository

Untuk mendapatkan salinan repository ini kami sarankan dilakukan dengan 2 cara yaitu melalui:
- Pull repository ini pada folder lokal yang kosong dan jalankan command
`` git clone https://github.com/MNafisN/FP_Inosoft_Bootcamp.git ``.
- Download arsip repository ini dan ekstrak ke direktori lokal.

### Requirements

- PHP versi 8.1,
- Composer,
- Node js versi 18.x,
- NPM versi 9.x,
- MongoDB server versi 6,
- MongoDB driver yang kompatibel dengan versi PHP di atas.

### Setting Environment

- Pastikan PHP terinstall dengan cara mengecek versinya dengan menjalankan command `` php -v ``.
- Pastikan Composer terinstall dengan cara mengecek versinya dengan menjalankan command `` composer ``.
- Pastikan Node js terinstall dengan cara mengecek versinya dengan menjalankan command `` node -v ``.
- Pastikan NPM terinstall dengan cara mengecek versinya dengan menjalankan command `` npm -v ``.
- Untuk mengimplementasikan database dari MongoDB, sebuah MongoDB driver perlu didownload dari website [PECL  (php.net)](https://pecl.php.net/package/mongodb). Versi yang didownload menyesuaikan versi PHP dan sistem operasi yang digunakan.
  - Untuk pengguna Windows, copy file .dll yang telah didownload ke dalam folder ext di dalam direktori php yang terinstall.
  - Edit file php.ini dan selipkan satu baris code `` extension = php_mongodb.dll `` pada bagian daftar ekstensi php.
  - Perlu diingat bahwa driver MongoDB ini belum mempunyai versi yang dapat diintegrasikan dengan PHP versi 8.2 ke atas dan hanya kompatible dengan PHP versi 8.1 ke bawah.

### Installing Project

Setting file .env project dengan cara menduplikat file .env.example kemudian rename file tersebut menjadi .env dan tentukan nama aplikasi, database yang digunakan, dan juga file system untuk menentukan lokasi penyimpanan file.

> Dikarenakan ada beberapa package yang diinstall pada project ini, ada sebuah ekstensi php yang perlu dipakai yaitu `` extension=gd ``. Pada XAMPP secara default sudah disediakan ekstensi dari package ini, oleh karena itu pada file php.ini tinggal edit baris di atas dengan menghapus simbol titik koma (;) di awal baris.

Daftar command di bawah ini kami sarankan untuk dijalankan secara berurutan agar aplikasi siap dijalankan maupun dikembangkan lagi.
- `` php artisan key:generate --ansi ``
- `` php artisan route cache ``
- `` composer install ``
- `` php artisan jwt:secret ``
- `` php artisan migrate ``
- `` php artisan db:seed ``
- `` npm install ``
