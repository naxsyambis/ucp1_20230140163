# Product & Category Management System

Sistem ini menyediakan fitur manajemen kategori dan produk dengan dua role utama:
- **Admin** → Mengelola kategori & produk
- **User** → Melihat produk

---

# Admin Features

## 1. Manajemen Kategori

### a. Melihat Kategori
Admin dapat melihat seluruh daftar kategori.

![Kategori](https://github.com/user-attachments/assets/2c6d43e4-3577-4c2d-97ca-91ef771512f7)

---

### b. Menambahkan Kategori
Admin dapat menambahkan kategori baru.

![Add Kategori](https://github.com/user-attachments/assets/94bbf382-5018-423f-b2af-26d1dd13367a)

---

### c. Mengedit Kategori
Admin dapat mengubah nama kategori.

**Contoh:**
- Sebelum: `Teh`
- Sesudah: `Teh Jepang`

![Edit 1](https://github.com/user-attachments/assets/3e243a69-44ab-403d-bd3c-53f5f711457f)
![Edit 2](https://github.com/user-attachments/assets/c4c38608-ac4a-4c73-9afe-2c5060a716f8)

---

### d. Menghapus Kategori
Admin dapat menghapus kategori.

**Contoh:**
- Kategori: `Jamu`

![Delete 1](https://github.com/user-attachments/assets/a27e6fb6-8407-4a16-834d-ed594422cefa)
![Delete 2](https://github.com/user-attachments/assets/fc7f9201-ad9a-4ecb-ad0a-ce471316cabe)

---

## 2. Manajemen Produk

### Menambahkan Produk dengan Kategori
Admin dapat menambahkan produk dan mengaitkannya dengan kategori tertentu.

![Produk 1](https://github.com/user-attachments/assets/36b7c80b-0259-4cca-ac2c-aaef2bd44e13)
![Produk 2](https://github.com/user-attachments/assets/d59281d8-9c9b-4724-9be4-351b4dc01c84)

---

# User Features

## Melihat Produk
User dapat melihat produk berdasarkan kategori yang tersedia.

![User View](https://github.com/user-attachments/assets/1cae87da-e88f-41a4-857b-54ebef86009a)

---

# System Architecture

## Database Structure

### `categories`
| Field | Type |
|------|------|
| id | int |
| name | string |

### `products`
| Field | Type |
|------|------|
| id | int |
| name | string |
| kategori_id | foreign key |

---

## Relationship

- 1 Category → Many Products
- 1 Product → 1 Category

---

# REST API

| Method | Endpoint | Description |
|--------|---------|------------|
| GET | `/categories` | Get all categories |
| POST | `/categories` | Create category |
| PUT | `/categories/{id}` | Update category |
| DELETE | `/categories/{id}` | Delete category |
| GET | `/products` | Get all products |
| POST | `/products` | Create product |

---

# Pertemuan 9

Gemini
Conversation with Gemini
C. Operasi Product (Lanjutan)

SS GET Product: Menampilkan detail produk berdasarkan ID.

SS PUT Product: Update data produk (misal ganti harga atau stok).

SS DELETE Product: Menghapus produk.





http://127.0.0.1:8000/api/product/1 proses Get



hasilnya eror 500 internal server eror



{

    "message": "Terjadi kesalahan saat mengambil data produk"

}



http://127.0.0.1:8000/api/product proses GET



200 ok tapi ga ada list data yang muncul

Berdasarkan file yang Anda berikan, berikut adalah analisis penyebab error 500 dan mengapa data tidak muncul, serta solusi untuk memperbaikinya:

1. Penyebab Error 500 pada GET /api/product/1
Error ini terjadi karena adanya ketidaksesuaian nama relasi di dalam file ProductController.php dengan yang didefinisikan di Model Product.php.

Masalah: Di ProductController.php, Anda memanggil Product::with('category')->find($id);. Namun, di dalam Model Product.php, nama fungsi relasi yang Anda buat adalah kategori() (menggunakan bahasa Indonesia), bukan category.

Efek: Laravel mencoba mencari relasi bernama category yang tidak eksis, sehingga memicu Throwable exception yang kemudian ditangkap oleh blok catch dan mengembalikan error 500 dengan pesan "Terjadi kesalahan saat mengambil data produk".

Solusi:
Ubah baris kode di app/Http/Controllers/Api/ProductController.php pada fungsi show menjadi:

PHP
$product = Product::with('kategori')->find($id);
2. Penyebab Data Kosong (200 OK) pada GET /api/product
Meskipun statusnya 200 OK, data tidak muncul karena fungsi index di controller Anda masih kosong.

Masalah: Di ProductController.php, fungsi index() tidak memiliki logika kode sama sekali (hanya berisi komentar //).

Efek: Karena fungsi tersebut tidak mengembalikan (return) apa pun, Laravel secara default menganggap request berhasil namun tidak memberikan isi (body) data produk.

Solusi:
Lengkapi fungsi index di app/Http/Controllers/Api/ProductController.php agar mengambil semua data dari database:

PHP
public function index()
{
    try {
        $products = Product::with('kategori')->get();
        return response()->json([
            'message' => 'Daftar produk berhasil diambil',
            'data' => $products
        ], 200);
    } catch (\Throwable $e) {
        return response()->json([
            'message' => 'Gagal mengambil daftar produk',
            'error' => $e->getMessage()
        ], 500);
    }
}
3. Melengkapi Operasi PUT dan DELETE
Untuk menyelesaikan tugas Anda sesuai permintaan (Update dan Delete), Anda perlu mengisi fungsi yang masih kosong di ProductController.php:

Update (PUT):

PHP
public function update(Request $request, string $id)
{
    try {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $product->update($request->all());
        return response()->json([
            'message' => 'Produk berhasil diupdate',
            'data' => $product
        ], 200);
    } catch (\Throwable $e) {
        return response()->json(['message' => 'Gagal update produk'], 500);
    }
}
Delete (DELETE):

PHP
public function destroy(string $id)
{
    try {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Produk berhasil dihapus'], 200);
    } catch (\Throwable $e) {
        return response()->json(['message' => 'Gagal menghapus produk'], 500);
    }
}
Pastikan Anda selalu menyertakan Token Sanctum (Bearer Token) di Header Postman saat melakukan pengujian karena rute-rute ini berada di dalam grup middleware auth:sanctum.

http://127.0.0.1:8000/api/product/1



ga bisa di put



http://127.0.0.1:8000/api/product/1 (Get)



{

    "message": "Product retrieved successfully",

    "data": {

        "id": 1,

        "name": "Kopi Aren",

        "quantity": 5,

        "price": 100000,

        "created_at": "2026-04-25T05:16:58.000000Z",

        "updated_at": "2026-04-25T05:16:58.000000Z",

        "user_id": 1,

        "category_id": 1,

        "kategori": {

            "id": 1,

            "name": "Kopi Susu",

            "created_at": "2026-04-25T05:10:55.000000Z",

            "updated_at": "2026-05-15T11:13:21.000000Z"

        }

    }

}



terus saya melakuakn put



{

        "name": "Kopi Aren",

        "quantity": 5,

        "price": 70000,

        "created_at": "2026-04-25T05:16:58.000000Z",

        "updated_at": "2026-04-25T05:16:58.000000Z",

        "user_id": 1,

        "category_id": 1,

        "kategori": {

            "id": 1,

            "name": "Kopi Susu",

            "created_at": "2026-04-25T05:10:55.000000Z",

            "updated_at": "2026-05-15T11:13:21.000000Z"

        }



tapi ga muncul apa2 dan 200 ok, tapi datanya tidak terganti

Berdasarkan kode yang Anda unggah, alasan mengapa operasi PUT (Update) tidak merubah data meskipun mengembalikan status 200 OK adalah karena fungsi update di dalam ProductController.php Anda saat ini masih kosong (hanya berisi komentar //).

Berikut adalah langkah-langkah untuk memperbaikinya:

1. Perbaiki Logic Update di Controller
Buka file app/Http/Controllers/Api/ProductController.php dan ubah fungsi update menjadi seperti di bawah ini agar sistem benar-benar memproses perubahan data ke database:

PHP
public function update(Request $request, string $id)
{
    try {
        // 1. Cari produk berdasarkan ID
        $product = Product::find($id);

        // 2. Jika produk tidak ditemukan, kirim error 404
        if (!$product) {
            return response()->json([
                'message' => 'Product tidak ditemukan',
            ], 404);
        }

        // 3. Update data (Hanya kolom yang ada di $fillable pada Model Product)
        // Kita menggunakan $request->all() atau bisa memvalidasi manual
        $product->update($request->all());

        return response()->json([
            'message' => 'Produk berhasil diupdate!',
            'data' => $product
        ], 200);

    } catch (\Throwable $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat mengupdate produk',
            'error' => $e->getMessage()
        ], 500);
    }
}
2. Melengkapi Fitur Delete
Agar tugas Anda lengkap, jangan lupa untuk mengisi fungsi destroy di file yang sama:

PHP
public function destroy(string $id)
{
    try {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product tidak ditemukan'], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus!'
        ], 200);

    } catch (\Throwable $e) {
        return response()->json(['message' => 'Gagal menghapus produk'], 500);
    }
}
Tips Pengujian di Postman:
Gunakan Method PUT: Pastikan di Postman Anda memilih method PUT.

Raw JSON: Saat mengirim data PUT, pastikan Anda tidak menyertakan objek kategori di dalam body JSON karena Laravel akan mencoba mencocokkannya dengan kolom di tabel products. Cukup kirim field utamanya saja:

JSON
{
    "name": "Kopi Aren",
    "quantity": 5,
    "price": 70000,
    "category_id": 1
}
Header: Karena rute ini berada di bawah rute yang membutuhkan autentikasi (Sanctum), pastikan Header Authorization (Bearer Token) tetap terpasang.

buatkan juga code untuk melakukan delete dong

Tentu, untuk melengkapi tugas Anda, berikut adalah kode lengkap untuk fungsi destroy (delete) serta perbaikan pada fungsi update agar data benar-benar tersimpan ke database.

Silakan perbarui file app/Http/Controllers/Api/ProductController.php Anda dengan kode berikut:

1. Update Fungsi update
Masalah Anda sebelumnya adalah fungsi ini kosong, sehingga data tidak berubah meskipun statusnya 200 OK. Gunakan kode ini:

PHP
public function update(Request $request, string $id)
{
    try {
        // Cari produk berdasarkan ID
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product tidak ditemukan',
            ], 404);
        }

        // Melakukan update data berdasarkan input dari request
        // Pastikan field seperti 'name', 'quantity', dll sudah ada di $fillable di Model Product
        $product->update($request->all());

        return response()->json([
            'message' => 'Produk berhasil diperbarui!!',
            'data' => $product,
        ], 200);

    } catch (\Throwable $e) {
        Log::error('Error saat update product', [
            'message' => $e->getMessage(),
        ]);

        return response()->json([
            'message' => 'Terjadi kesalahan saat memperbarui produk',
        ], 500);
    }
}
2. Tambahkan Fungsi destroy (Delete)
Tambahkan kode ini di bawah fungsi update untuk menghapus data dari database:

PHP
public function destroy(string $id)
{
    try {
        // Cari produk yang akan dihapus
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product tidak ditemukan',
            ], 404);
        }

        // Hapus produk dari database
        $product->delete();

        return response()->json([
            'message' => 'Produk berhasil dihapus!!',
        ], 200);

    } catch (\Throwable $e) {
        Log::error('Error saat menghapus product', [
            'message' => $e->getMessage(),
        ]);

        return response()->json([
            'message' => 'Terjadi kesalahan saat menghapus produk',
        ], 500);
    }
}
Cara Mengetes di Postman:
DELETE Product:

Method: DELETE

URL: http://127.0.0.1:8000/api/product/1

Header: Pastikan Authorization (Bearer Token) tetap terisi karena rute ini dilindungi middleware auth:sanctum.

Hasil: Anda akan menerima pesan "Produk berhasil dihapus!!".

PUT Product (Tips):

Saat melakukan PUT, kirimkan data dalam bentuk JSON mentah (Raw JSON), dan jangan menyertakan objek relasi kategori di dalamnya. Cukup kirim field utamanya saja seperti:

JSON
{
    "name": "Kopi Aren Update",
    "quantity": 10,
    "price": 75000,
    "category_id": 1
}
Dengan menambahkan kode di atas, semua rute API yang Anda definisikan di routes/api.php (Index, Store, Show, Update, Destroy) sekarang sudah memiliki logika yang berfungsi sepenuhnya.

buatlah ini menjadi tabel dong



Login 

http://127.0.0.1:8000/api/login



<img width="1757" height="622" alt="image" src="https://github.com/user-attachments/assets/a9ecfba5-36cd-430f-b5be-185635509bf2" />



CATEGORIES



http://127.0.0.1:8000/api/categories



<img width="1758" height="721" alt="image" src="https://github.com/user-attachments/assets/0261c3dd-99b3-46e1-80b2-2d5a40de977b" />



http://127.0.0.1:8000/api/categories



<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/4ae10fbb-51ff-490d-9ade-fb68c8eeae6b" />



http://127.0.0.1:8000/api/categories/1



<img width="1761" height="708" alt="image" src="https://github.com/user-attachments/assets/3d7e1296-b89e-4d6d-9851-6677cbdabe2f" />



http://127.0.0.1:8000/api/categories/1



<img width="1753" height="543" alt="image" src="https://github.com/user-attachments/assets/c351c58d-b7b9-4297-bca8-8ea753b9f2f1" />



PRODUCT



http://127.0.0.1:8000/api/product/1



<img width="1765" height="818" alt="image" src="https://github.com/user-attachments/assets/cb797940-0b5e-4b70-9304-415e507c3851" />



http://127.0.0.1:8000/api/product



<img width="1762" height="812" alt="image" src="https://github.com/user-attachments/assets/0b644daf-5d99-4cca-b448-8b285512a66b" />



http://127.0.0.1:8000/api/product/3



<img width="1782" height="746" alt="image" src="https://github.com/user-attachments/assets/19900fbe-94cb-4af9-bd54-f0750ad93c87" />

Tentu, berikut adalah ringkasan dokumentasi API Anda dalam bentuk tabel untuk memudahkan pelaporan atau pengecekan rute.

Tabel Dokumentasi API Endpoint
No	Modul	Nama Fitur	Method	Endpoint	Deskripsi
1	Auth	Login	POST	/api/login	Mendapatkan token akses (Sanctum) untuk autentikasi.
2	Category	Get All Categories	GET	/api/categories	Menampilkan daftar seluruh kategori yang ada.
3	Category	Store Category	POST	/api/categories	Menambahkan data kategori baru ke database.
4	Category	Show Category	GET	/api/categories/{id}	Menampilkan detail kategori berdasarkan ID tertentu.
5	Category	Update Category	PUT	/api/categories/{id}	Memperbarui data kategori (misal: nama kategori).
6	Category	Delete Category	DELETE	/api/categories/{id}	Menghapus data kategori dari database.
7	Product	Get All Products	GET	/api/product	Menampilkan semua daftar produk beserta relasi kategorinya.
8	Product	Store Product	POST	/api/product	Menambahkan produk baru (membutuhkan category_id).
9	Product	Show Product	GET	/api/product/{id}	Menampilkan detail produk spesifik berdasarkan ID.
10	Product	Update Product	PUT	/api/product/{id}	Memperbarui data produk (seperti harga, nama, atau stok).
11	Product	Delete Product	DELETE	/api/product/{id}	Menghapus data produk secara permanen dari sistem.
Catatan Tambahan:

Keamanan: Seluruh endpoint kecuali /api/login berada di dalam middleware auth:sanctum, sehingga Anda wajib menyertakan Bearer Token pada Header di setiap request.

Relasi: Endpoint produk akan menampilkan data kategori secara otomatis melalui Eager Loading yang telah dikonfigurasi di controller.

kayak gini loh yang saya mau



# API Documentation



## Base URL



```http

http://localhost:8000

```



---



# Authentication Module



## 1. Login



| Attribute | Value |

|---|---|

| Module | Auth |

| Feature | Login |

| Method | POST |

| Endpoint | `/api/login` |

| Description | Mendapatkan token akses (Sanctum) untuk autentikasi. |



### Request Body



```json

{

  "email": "user@example.com",

  "password": "password"

}

```



### Success Response



```json

{

  "token": "1|sanctum_access_token"

}

```



---



# Category Module



## 2. Get All Categories



| Attribute | Value |

|---|---|

| Module | Category |

| Feature | Get All Categories |

| Method | GET |

| Endpoint | `/api/categories` |

| Description | Menampilkan daftar seluruh kategori yang ada. |



### Success Response



```json

[

  {

    "id": 1,

    "name": "Elektronik"

  },

  {

    "id": 2,

    "name": "Fashion"

  }

]

```



---



## 3. Store Category



| Attribute | Value |

|---|---|

| Module | Category |

| Feature | Store Category |

| Method | POST |

| Endpoint | `/api/categories` |

| Description | Menambahkan data kategori baru ke database. |



### Request Body



```json

{

  "name": "Makanan"

}

```



### Success Response



```json

{

  "message": "Category created successfully"

}

```



---



## 4. Show Category



| Attribute | Value |

|---|---|

| Module | Category |

| Feature | Show Category |

| Method | GET |

| Endpoint | `/api/categories/{id}` |

| Description | Menampilkan detail kategori berdasarkan ID tertentu. |



### Example Endpoint



```http

GET /api/categories/1

```



### Success Response



```json

{

  "id": 1,

  "name": "Elektronik"

}

```



---



## 5. Update Category



| Attribute | Value |

|---|---|

| Module | Category |

| Feature | Update Category |

| Method | PUT |

| Endpoint | `/api/categories/{id}` |

| Description | Memperbarui data kategori (misal: nama kategori). |



### Request Body



```json

{

  "name": "Elektronik Gaming"

}

```



### Success Response



```json

{

  "message": "Category updated successfully"

}

```



---



## 6. Delete Category



| Attribute | Value |

|---|---|

| Module | Category |

| Feature | Delete Category |

| Method | DELETE |

| Endpoint | `/api/categories/{id}` |

| Description | Menghapus data kategori dari database. |



### Success Response



```json

{

  "message": "Category deleted successfully"

}

```



---



# Product Module



## 7. Get All Products



| Attribute | Value |

|---|---|

| Module | Product |

| Feature | Get All Products |

| Method | GET |

| Endpoint | `/api/product` |

| Description | Menampilkan semua daftar produk beserta relasi kategorinya. |



### Success Response



```json

[

  {

    "id": 1,

    "name": "Laptop",

    "price": 12000000,

    "stock": 5,

    "category": {

      "id": 1,

      "name": "Elektronik"

    }

  }

]

```



---



## 8. Store Product



| Attribute | Value |

|---|---|

| Module | Product |

| Feature | Store Product |

| Method | POST |

| Endpoint | `/api/product` |

| Description | Menambahkan produk baru (membutuhkan category_id). |



### Request Body



```json

{

  "name": "Mouse Gaming",

  "price": 250000,

  "stock": 10,

  "category_id": 1

}

```



### Success Response



```json

{

  "message": "Product created successfully"

}

```



---



## 9. Show Product



| Attribute | Value |

|---|---|

| Module | Product |

| Feature | Show Product |

| Method | GET |

| Endpoint | `/api/product/{id}` |

| Description | Menampilkan detail produk spesifik berdasarkan ID. |



### Example Endpoint



```http

GET /api/product/1

```



### Success Response



```json

{

  "id": 1,

  "name": "Laptop",

  "price": 12000000,

  "stock": 5,

  "category": {

    "id": 1,

    "name": "Elektronik"

  }

}

```



---



## 10. Update Product



| Attribute | Value |

|---|---|

| Module | Product |

| Feature | Update Product |

| Method | PUT |

| Endpoint | `/api/product/{id}` |

| Description | Memperbarui data produk (seperti harga, nama, atau stok). |



### Request Body



```json

{

  "name": "Laptop ASUS ROG",

  "price": 15000000,

  "stock": 7,

  "category_id": 1

}

```



### Success Response



```json

{

  "message": "Product updated successfully"

}

```



---



## 11. Delete Product



| Attribute | Value |

|---|---|

| Module | Product |

| Feature | Delete Product |

| Method | DELETE |

| Endpoint | `/api/product/{id}` |

| Description | Menghapus data produk secara permanen dari sistem. |



### Success Response



```json

{

  "message": "Product deleted successfully"

}

```



---

masukkan link fotonya juga



Login 

http://127.0.0.1:8000/api/login



<img width="1757" height="622" alt="image" src="https://github.com/user-attachments/assets/a9ecfba5-36cd-430f-b5be-185635509bf2" />



CATEGORIES



http://127.0.0.1:8000/api/categories



<img width="1758" height="721" alt="image" src="https://github.com/user-attachments/assets/0261c3dd-99b3-46e1-80b2-2d5a40de977b" />



http://127.0.0.1:8000/api/categories



<img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/4ae10fbb-51ff-490d-9ade-fb68c8eeae6b" />



http://127.0.0.1:8000/api/categories/1



<img width="1761" height="708" alt="image" src="https://github.com/user-attachments/assets/3d7e1296-b89e-4d6d-9851-6677cbdabe2f" />



http://127.0.0.1:8000/api/categories/1



<img width="1753" height="543" alt="image" src="https://github.com/user-attachments/assets/c351c58d-b7b9-4297-bca8-8ea753b9f2f1" />



PRODUCT



http://127.0.0.1:8000/api/product/1



<img width="1765" height="818" alt="image" src="https://github.com/user-attachments/assets/cb797940-0b5e-4b70-9304-415e507c3851" />



http://127.0.0.1:8000/api/product



<img width="1762" height="812" alt="image" src="https://github.com/user-attachments/assets/0b644daf-5d99-4cca-b448-8b285512a66b" />



http://127.0.0.1:8000/api/product/3



<img width="1782" height="746" alt="image" src="https://github.com/user-attachments/assets/19900fbe-94cb-4af9-bd54-f0750ad93c87" />

Berikut adalah format API Documentation yang telah disesuaikan dengan struktur yang Anda inginkan, lengkap dengan data dari kode program dan link foto yang Anda berikan.

API Documentation
Base URL
HTTP
http://127.0.0.1:8000
Authentication Module
1. Login
Attribute	Value
Module	Auth
Feature	Login
Method	POST
Endpoint	/api/login
Description	Mendapatkan token akses (Sanctum) untuk autentikasi.
Request Body
JSON
{
  "email": "admin@gmail.com",
  "password": "password"
}
Success Response
JSON
{
  "token": "3|tL8..."
}
Screenshot
Category Module
2. Get All Categories
Attribute	Value
Module	Category
Feature	Get All Categories
Method	GET
Endpoint	/api/categories
Description	Menampilkan daftar seluruh kategori yang ada.
Success Response
JSON
{
    "data": [
        {
            "id": 1,
            "name": "Kopi Susu",
            "created_at": "2026-04-25T05:10:55.000000Z",
            "updated_at": "2026-05-15T11:13:21.000000Z"
        }
    ]
}
Screenshot
3. Store Category
Attribute	Value
Module	Category
Feature	Store Category
Method	POST
Endpoint	/api/categories
Description	Menambahkan data kategori baru ke database.
Request Body
JSON
{
  "name": "Snack"
}
Screenshot
4. Show Category
Attribute	Value
Module	Category
Feature	Show Category
Method	GET
Endpoint	/api/categories/{id}
Description	Menampilkan detail kategori berdasarkan ID tertentu.
Example Endpoint
GET /api/categories/1

Screenshot
5. Update Category
Attribute	Value
Module	Category
Feature	Update Category
Method	PUT
Endpoint	/api/categories/{id}
Description	Memperbarui data kategori (misal: nama kategori).
Request Body
JSON
{
  "name": "Kopi Susu Update"
}
Screenshot
Product Module
6. Get All Products
Attribute	Value
Module	Product
Feature	Get All Products
Method	GET
Endpoint	/api/product
Description	Menampilkan semua daftar produk beserta relasi kategorinya.
Screenshot
7. Show Product
Attribute	Value
Module	Product
Feature	Show Product
Method	GET
Endpoint	/api/product/{id}
Description	Menampilkan detail produk spesifik berdasarkan ID.
Success Response
JSON
{
    "message": "Product retrieved successfully",
    "data": {
        "id": 1,
        "name": "Kopi Aren",
        "quantity": 5,
        "price": 100000,
        "category_id": 1,
        "kategori": {
            "id": 1,
            "name": "Kopi Susu"
        }
    }
}
Screenshot
8. Store Product
Attribute	Value
Module	Product
Feature	Store Product
Method	POST
Endpoint	/api/product
Description	Menambahkan produk baru (membutuhkan category_id).
Request Body
JSON
{
  "name": "Kopi Hitam",
  "quantity": 10,
  "price": 15000,
  "category_id": 1
}
Screenshot
9. Delete Product
Attribute	Value
Module	Product
Feature	Delete Product
Method	DELETE
Endpoint	/api/product/{id}
Description	Menghapus data produk secara permanen dari sistem.
Success Response
JSON
{
  "message": "Produk berhasil dihapus!!"
}
jadiin satu code full dong supaya tinggal copy paste ke readme.md saya

Authentication Module
1. Login
Attribute	Value
Module	Auth
Feature	Login
Method	POST
Endpoint	/api/login
Description	Mendapatkan token akses (Sanctum) untuk autentikasi.
Request Body
JSON
{
  "email": "admin@gmail.com",
  "password": "password"
}
Success Response
JSON
{
  "token": "3|tL8..."
}
Screenshot
Category Module
2. Get All Categories
Attribute	Value
Module	Category
Feature	Get All Categories
Method	GET
Endpoint	/api/categories
Description	Menampilkan daftar seluruh kategori yang ada.
Success Response
JSON
{
    "data": [
        {
            "id": 1,
            "name": "Kopi Susu",
            "created_at": "2026-04-25T05:10:55.000000Z",
            "updated_at": "2026-05-15T11:13:21.000000Z"
        }
    ]
}
Screenshot
3. Store Category
Attribute	Value
Module	Category
Feature	Store Category
Method	POST
Endpoint	/api/categories
Description	Menambahkan data kategori baru ke database.
Request Body
JSON
{
  "name": "Snack"
}
Screenshot
4. Show Category
Attribute	Value
Module	Category
Feature	Show Category
Method	GET
Endpoint	/api/categories/{id}
Description	Menampilkan detail kategori berdasarkan ID tertentu.
Example Endpoint
GET /api/categories/1

Screenshot
5. Update Category
Attribute	Value
Module	Category
Feature	Update Category
Method	PUT
Endpoint	/api/categories/{id}
Description	Memperbarui data kategori (misal: nama kategori).
Request Body
JSON
{
  "name": "Kopi Susu Update"
}
Screenshot
Product Module
6. Get All Products
Attribute	Value
Module	Product
Feature	Get All Products
Method	GET
Endpoint	/api/product
Description	Menampilkan semua daftar produk beserta relasi kategorinya.
Screenshot
7. Show Product
Attribute	Value
Module	Product
Feature	Show Product
Method	GET
Endpoint	/api/product/{id}
Description	Menampilkan detail produk spesifik berdasarkan ID.
Success Response
JSON
{
    "message": "Product retrieved successfully",
    "data": {
        "id": 1,
        "name": "Kopi Aren",
        "quantity": 5,
        "price": 100000,
        "category_id": 1,
        "kategori": {
            "id": 1,
            "name": "Kopi Susu"
        }
    }
}
Screenshot
8. Store Product
Attribute	Value
Module	Product
Feature	Store Product
Method	POST
Endpoint	/api/product
Description	Menambahkan produk baru (membutuhkan category_id).
Request Body
JSON
{
  "name": "Kopi Hitam",
  "quantity": 10,
  "price": 15000,
  "category_id": 1
}
Screenshot
9. Delete Product
Attribute	Value
Module	Product
Feature	Delete Product
Method	DELETE
Endpoint	/api/product/{id}
Description	Menghapus data produk secara permanen dari sistem.
Success Response
JSON
{
  "message": "Produk berhasil dihapus!!"
}
```"""

with open("README-API-Docs.md", "w") as f:
    f.write(content)


Tentu, ini adalah kode lengkap dalam format Markdown yang bisa langsung Anda copy-paste ke file README.md. Saya sudah menyatukan seluruh modul (Auth, Category, Product) beserta link gambar yang Anda berikan.
MD icon
 README-API-Docs 
MD

Markdown
# API Documentation

## Base URL
```http
[http://127.0.0.1:8000](http://127.0.0.1:8000)
Authentication Module
1. Login
Attribute	Value
Module	Auth
Feature	Login
Method	POST
Endpoint	/api/login
Description	Mendapatkan token akses (Sanctum) untuk autentikasi.
Request Body
JSON
{
  "email": "admin@gmail.com",
  "password": "password"
}
Success Response
JSON
{
  "token": "3|tL8..."
}
Screenshot
Category Module
2. Get All Categories
Attribute	Value
Module	Category
Feature	Get All Categories
Method	GET
Endpoint	/api/categories
Description	Menampilkan daftar seluruh kategori yang ada.
Success Response
JSON
{
    "data": [
        {
            "id": 1,
            "name": "Kopi Susu",
            "created_at": "2026-04-25T05:10:55.000000Z",
            "updated_at": "2026-05-15T11:13:21.000000Z"
        }
    ]
}
Screenshot
3. Store Category
Attribute	Value
Module	Category
Feature	Store Category
Method	POST
Endpoint	/api/categories
Description	Menambahkan data kategori baru ke database.
Request Body
JSON
{
  "name": "Snack"
}
Screenshot
4. Show Category
Attribute	Value
Module	Category
Feature	Show Category
Method	GET
Endpoint	/api/categories/{id}
Description	Menampilkan detail kategori berdasarkan ID tertentu.
Example Endpoint
GET /api/categories/1

Screenshot
5. Update Category
Attribute	Value
Module	Category
Feature	Update Category
Method	PUT
Endpoint	/api/categories/{id}
Description	Memperbarui data kategori (misal: nama kategori).
Request Body
JSON
{
  "name": "Kopi Susu Update"
}
Screenshot
Product Module
6. Get All Products
Attribute	Value
Module	Product
Feature	Get All Products
Method	GET
Endpoint	/api/product
Description	Menampilkan semua daftar produk beserta relasi kategorinya.
Screenshot
7. Show Product
Attribute	Value
Module	Product
Feature	Show Product
Method	GET
Endpoint	/api/product/{id}
Description	Menampilkan detail produk spesifik berdasarkan ID.
Success Response
JSON
{
    "message": "Product retrieved successfully",
    "data": {
        "id": 1,
        "name": "Kopi Aren",
        "quantity": 5,
        "price": 100000,
        "category_id": 1,
        "kategori": {
            "id": 1,
            "name": "Kopi Susu"
        }
    }
}
Screenshot
8. Store Product
Attribute	Value
Module	Product
Feature	Store Product
Method	POST
Endpoint	/api/product
Description	Menambahkan produk baru (membutuhkan category_id).
Request Body
JSON
{
  "name": "Kopi Hitam",
  "quantity": 10,
  "price": 15000,
  "category_id": 1
}
Screenshot
9. Delete Product
Attribute	Value
Module	Product
Feature	Delete Product
Method	DELETE
Endpoint	/api/product/{id}
Description	Menghapus data produk secara permanen dari sistem.
Success Response
JSON
{
  "message": "Produk berhasil dihapus!!"
}




Gemini is AI and can make mistakes.

# API Documentation

## Base URL
```http
http://127.0.0.1:8000
```

---

# Authentication Module

## 1. Login
| Attribute | Value |
|---|---|
| Module | Auth |
| Feature | Login |
| Method | POST |
| Endpoint | `/api/login` |
| Description | Mendapatkan token akses (Sanctum) untuk autentikasi. |

### Request Body
```json
{
  "email": "admin@gmail.com",
  "password": "password"
}
```

### Success Response
```json
{
  "token": "3|tL8..."
}
```

### Screenshot
![Login Screenshot](https://github.com/user-attachments/assets/a9ecfba5-36cd-430f-b5be-185635509bf2)

---

# Category Module

## 2. Get All Categories
| Attribute | Value |
|---|---|
| Module | Category |
| Feature | Get All Categories |
| Method | GET |
| Endpoint | `/api/categories` |
| Description | Menampilkan daftar seluruh kategori yang ada. |

### Success Response
```json
{
    "data": [
        {
            "id": 1,
            "name": "Kopi Susu",
            "created_at": "2026-04-25T05:10:55.000000Z",
            "updated_at": "2026-05-15T11:13:21.000000Z"
        }
    ]
}
```

### Screenshot
![Get All Categories](https://github.com/user-attachments/assets/0261c3dd-99b3-46e1-80b2-2d5a40de977b)

---

## 3. Store Category
| Attribute | Value |
|---|---|
| Module | Category |
| Feature | Store Category |
| Method | POST |
| Endpoint | `/api/categories` |
| Description | Menambahkan data kategori baru ke database. |

### Request Body
```json
{
  "name": "Snack"
}
```

### Screenshot
![Store Category](https://github.com/user-attachments/assets/4ae10fbb-51ff-490d-9ade-fb68c8eeae6b)

---

## 4. Show Category
| Attribute | Value |
|---|---|
| Module | Category |
| Feature | Show Category |
| Method | GET |
| Endpoint | `/api/categories/{id}` |
| Description | Menampilkan detail kategori berdasarkan ID tertentu. |

### Example Endpoint
`GET /api/categories/1`

### Screenshot
![Show Category](https://github.com/user-attachments/assets/3d7e1296-b89e-4d6d-9851-6677cbdabe2f)

---

## 5. Update Category
| Attribute | Value |
|---|---|
| Module | Category |
| Feature | Update Category |
| Method | PUT |
| Endpoint | `/api/categories/{id}` |
| Description | Memperbarui data kategori (misal: nama kategori). |

### Request Body
```json
{
  "name": "Kopi Susu Update"
}
```

### Screenshot
![Update Category](https://github.com/user-attachments/assets/c351c58d-b7b9-4297-bca8-8ea753b9f2f1)

---

# Product Module

## 6. Get All Products
| Attribute | Value |
|---|---|
| Module | Product |
| Feature | Get All Products |
| Method | GET |
| Endpoint | `/api/product` |
| Description | Menampilkan semua daftar produk beserta relasi kategorinya. |

### Screenshot
![Get All Products](https://github.com/user-attachments/assets/0b644daf-5d99-4cca-b448-8b285512a66b)

---

## 7. Show Product
| Attribute | Value |
|---|---|
| Module | Product |
| Feature | Show Product |
| Method | GET |
| Endpoint | `/api/product/{id}` |
| Description | Menampilkan detail produk spesifik berdasarkan ID. |

### Success Response
```json
{
    "message": "Product retrieved successfully",
    "data": {
        "id": 1,
        "name": "Kopi Aren",
        "quantity": 5,
        "price": 100000,
        "category_id": 1,
        "kategori": {
            "id": 1,
            "name": "Kopi Susu"
        }
    }
}
```

### Screenshot
![Show Product](https://github.com/user-attachments/assets/cb797940-0b5e-4b70-9304-415e507c3851)

---

## 8. Store Product
| Attribute | Value |
|---|---|
| Module | Product |
| Feature | Store Product |
| Method | POST |
| Endpoint | `/api/product` |
| Description | Menambahkan produk baru (membutuhkan category_id). |

### Request Body
```json
{
  "name": "Kopi Hitam",
  "quantity": 10,
  "price": 15000,
  "category_id": 1
}
```

### Screenshot
![Store Product](https://github.com/user-attachments/assets/19900fbe-94cb-4af9-bd54-f0750ad93c87)

---

## 9. Delete Product
| Attribute | Value |
|---|---|
| Module | Product |
| Feature | Delete Product |
| Method | DELETE |
| Endpoint | `/api/product/{id}` |
| Description | Menghapus data produk secara permanen dari sistem. |

### Success Response
```json
{
  "message": "Produk berhasil dihapus!!"
}
```
