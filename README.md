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
