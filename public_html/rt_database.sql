-- Membuat database
CREATE DATABASE rt_database;
USE rt_database;

-- Membuat tabel users
CREATE TABLE users (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'resident') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Membuat tabel residents
CREATE TABLE residents (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    nik VARCHAR(16) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    gender ENUM('L', 'P') NOT NULL,
    birth_place VARCHAR(50) NOT NULL,
    birth_date DATE NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(15),
    occupation VARCHAR(50),
    status ENUM('permanent', 'contract', 'new') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Membuat tabel finance
CREATE TABLE finance (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
    description TEXT NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Membuat tabel activities
CREATE TABLE activities (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    location VARCHAR(100) NOT NULL,
    description TEXT,
    status ENUM('upcoming', 'ongoing', 'completed') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Membuat tabel announcements
CREATE TABLE announcements (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Menambahkan user admin
INSERT INTO users (username, password, role) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Menambahkan contoh data warga
INSERT INTO residents (nik, name, gender, birth_place, birth_date, address, phone, occupation, status) 
VALUES ('3201011234560001', 'Ahmad Dahlan', 'L', 'Jakarta', '1980-05-15', 'Jl. Contoh No. 1', '081234567890', 'Pegawai Swasta', 'permanent');

INSERT INTO residents (nik, name, gender, birth_place, birth_date, address, phone, occupation, status) 
VALUES ('3201011234560002', 'Siti Nurhaliza', 'P', 'Bandung', '1985-08-20', 'Jl. Contoh No. 2', '081234567891', 'Ibu Rumah Tangga', 'permanent');

-- Menambahkan contoh data keuangan
INSERT INTO finance (date, description, type, amount) 
VALUES ('2023-01-01', 'Iuran Bulan Januari', 'income', 5000000);

INSERT INTO finance (date, description, type, amount) 
VALUES ('2023-01-15', 'Pembelian Alat Kebersihan', 'expense', 500000);

-- Menambahkan contoh data kegiatan
INSERT INTO activities (title, date, location, description, status) 
VALUES ('Gotong Royong Bersih-bersih Lingkungan', '2023-02-01', 'Halaman RT', 'Kegiatan gotong royong membersihkan lingkungan RT', 'completed');

INSERT INTO activities (title, date, location, description, status) 
VALUES ('Rapat Rutin Bulanan', '2023-03-05', 'Balai RT', 'Rapat rutin untuk membahas program kerja RT', 'upcoming');

-- Menambahkan contoh data pengumuman
INSERT INTO announcements (title, content) 
VALUES ('Libur Nasional', 'Diberitahukan kepada seluruh warga RT 01 bahwa dalam rangka Hari Kemerdekaan Republik Indonesia, akan ada libur nasional pada tanggal 17 Agustus 2023.');

INSERT INTO announcements (title, content) 
VALUES ('Pembayaran Iuran Bulanan', 'Diberitahukan kepada seluruh warga RT 01 bahwa iuran bulanan untuk bulan Agustus 2023 sudah dapat dibayarkan mulai tanggal 1 Agustus 2023.');