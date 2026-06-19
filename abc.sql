USE qldichvu;

-- CREATE TABLE sinhvien (
--     MaSV VARCHAR(20) PRIMARY KEY,
--     HoTen VARCHAR(100) NOT NULL,
--     Email VARCHAR(100) UNIQUE,
--     SDT VARCHAR(15)
-- );

-- CREATE TABLE nhanvien_xuly (
--     MaNV INT AUTO_INCREMENT PRIMARY KEY,
--     HoTen VARCHAR(100) NOT NULL,
--     BoPhan VARCHAR(100)
-- );

-- CREATE TABLE taikhoan (
--     MaTK INT AUTO_INCREMENT PRIMARY KEY,

--     Username VARCHAR(100) UNIQUE NOT NULL,
--     Password VARCHAR(255) NOT NULL,

--     VaiTro ENUM('SinhVien','NhanVien') NOT NULL,

--     MaSV VARCHAR(20) NULL,
--     MaNV INT NULL,

--     FOREIGN KEY (MaSV)
--         REFERENCES sinhvien(MaSV),

--     FOREIGN KEY (MaNV)
--         REFERENCES nhanvien_xuly(MaNV)
-- );

-- CREATE TABLE yeucau_dichvu (
--     MaYC INT AUTO_INCREMENT PRIMARY KEY,

--     MaSV VARCHAR(20) NOT NULL,

--     LoaiDichVu VARCHAR(100) NOT NULL,

--     NoiDung TEXT NOT NULL,

--     NgayGui DATETIME DEFAULT CURRENT_TIMESTAMP,

--     TrangThai ENUM(
--         'ChoXuLy',
--         'DangXuLy',
--         'HoanThanh'
--     ) DEFAULT 'ChoXuLy',

--     FOREIGN KEY (MaSV)
--         REFERENCES sinhvien(MaSV)
-- );

-- CREATE TABLE phancong (
--     MaPC INT AUTO_INCREMENT PRIMARY KEY,

--     MaYC INT NOT NULL,

--     MaNV INT NOT NULL,

--     NgayPhanCong DATETIME DEFAULT CURRENT_TIMESTAMP,

--     NgayHoanThanh DATETIME NULL,

--     TrangThai ENUM(
--         'DangXuLy',
--         'HoanThanh'
--     ) DEFAULT 'DangXuLy',

--     FOREIGN KEY (MaYC)
--         REFERENCES yeucau_dichvu(MaYC),

--     FOREIGN KEY (MaNV)
--         REFERENCES nhanvien_xuly(MaNV)
-- );

-- INSERT INTO sinhvien
-- VALUES
-- (
-- 'PH12345',
-- 'Mai The Huong',
-- 'huong@gmail.com',
-- '0123456789'
-- );

-- INSERT INTO taikhoan
-- (
-- Username,
-- Password,
-- VaiTro,
-- MaSV
-- )
-- VALUES
-- (
-- 'PH12345',
-- '123456',
-- 'SinhVien',
-- 'PH12345'
-- );

-- INSERT INTO nhanvien_xuly
-- (
-- HoTen,
-- BoPhan
-- )
-- VALUES
-- (
-- 'Nguyen Van A',
-- 'Dao Tao'
-- );

-- SHOW TABLES;
-- DESCRIBE nhanvien_xuly;
-- INSERT INTO nhanvien_xuly(HoTen,BoPhan)
-- VALUES('Nguyen Van A','Dao Tao');

-- INSERT INTO taikhoan
-- (Username,Password,VaiTro,MaNV)
-- VALUES
-- ('nv01','123456','NhanVien',1);

-- -- CREATE TABLE admin (
--     MaAdmin INT AUTO_INCREMENT PRIMARY KEY,
--     Username VARCHAR(100) UNIQUE,
--     Password VARCHAR(255)
-- );
-- INSERT INTO admin(
--     Username,
--     Password
-- )
-- VALUES(
--     'admin',
--     '123456'
-- );
-- DESCRIBE sinhvien;
-- DESCRIBE nhanvien_xuly;
-- DESCRIBE yeucau_dichvu;
-- ALTER TABLE yeucau_dichvu
-- ADD MaNV INT NULL;
-- DESCRIBE yeucau_dichvu;

