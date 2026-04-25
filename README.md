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

