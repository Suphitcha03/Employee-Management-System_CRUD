# 👥 Employee Management System (CRUD)

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
A web-based Employee Management System featuring core CRUD operations, built with PHP, PDO, and MySQL. It includes a secure, basic authentication system.

---

## ✨ คุณสมบัติหลัก (Key Features)

* **ระบบจัดการข้อมูลพนักงานเต็มรูปแบบ (Full CRUD):** รองรับการเพิ่ม, อ่าน, แก้ไข และลบข้อมูลพนักงานอย่างสมบูรณ์แบบ
* **การออกแบบฐานข้อมูลเชิงสัมพันธ์:** ออกแบบและใช้งานฐานข้อมูลจำนวน 5 ตาราง โดยใช้ Primary Keys, Foreign Keys และ Unique Constraints เพื่อรักษาความถูกต้องและความสอดคล้องกันของข้อมูล (Data Integrity)
* **ระบบเข้าสู่ระบบและยืนยันตัวตนที่ปลอดภัย:** พัฒนาระบบ Login & Authentication โดยใช้ Session-based Authentication และการทำ Password Hashing
* **ป้องกันการโจมตีทางไซเบอร์ (Security Hardening):** 
  * ใช้ **PDO Prepared Statements** เพื่อป้องกันการโจมตีประเภท SQL Injection
  * ประยุกต์ใช้เทคนิค **Input Sanitization** เพื่อลดความเสี่ยงต่อการเกิด Cross-Site Scripting (XSS)
* **การควบคุมสิทธิ์เข้าถึง (Authorization):** วางระบบ Access Control จำกัดสิทธิ์ไม่ให้ผู้ใช้งานที่ยังไม่ได้ล็อกอินสามารถเข้าถึงหน้าเว็บที่ได้รับการปกป้องไว้ได้
* **ระบบจัดการรูปภาพ:** พัฒนาฟังก์ชันอัปโหลดและบริหารจัดการรูปภาพโปรไฟล์ของพนักงาน
* **ระบบติดตามสถานะพนักงาน:** สร้างระบบจัดการสถานะ (Active, Resigned, Terminated) พร้อมระบบอัปเดตข้อมูลอัตโนมัติเพื่อนำไปแสดงผลบนแดชบอร์ด
* **แดชบอร์ดสรุปผลภาพรวม:** พัฒนาหน้าแดชบอร์ดแบบโต้ตอบเพื่อแสดงสถิติจำนวนพนักงาน โดยจำแนกกลุ่มตามแผนกและสถานะการทำงานของบุคลากร

---

## 🛠️ เทคโนโลยีที่ใช้ (Technologies Used)
* **Back-end:** PHP, PDO
* **Database:** MySQL, PhpMyAdmin
* **Front-end:** HTML5, CSS3, JavaScript, Bootstrap
* **Security:** Session Authentication, Password Hashing, Prepared Statements

---

## 🌐 ลิงก์เข้าชมผลงาน (Live Demo)

คุณสามารถเข้าชมหน้าต่างอินเทอร์เฟซและระบบของแอปพลิเคชันเวอร์ชันออนไลน์ได้ที่ลิงก์ด้านล่างนี้:
👉 **[Live Demo Website](ใส่ลิงก์ของคุณตรงนี้)**

> 🔒 **Note:** The live demo is exclusively dedicated for interview presentations. Public access is restricted as credentials (ID and Password) are required and must be requested directly from the owner.
> 
> *(เนื่องจากนโยบายความปลอดภัยและความเป็นส่วนตัวของข้อมูล ชุดข้อมูลเข้าสู่ระบบสำหรับสิทธิ์ Admin จะถูกเก็บเป็นความลับ หากคุณเป็นผู้ประเมินผลงาน หรือกรรมการสอบสัมภาษณ์ที่ต้องการทดสอบระบบ CRUD บนหน้าเว็บไซต์จริง กรุณาติดต่อขอรับสิทธิ์เข้าใช้งานชั่วคราวได้โดยตรงผ่านอีเมลด้านล่างนี้ครับ)*

📧 **อีเมลสำหรับติดต่อขอสิทธิ์เข้าใช้งาน:** suphitchach03@gmail.com

---

## 👤 ผู้พัฒนา (Author)
* **GitHub:** [@Suphitcha03](https://github.com/Suphitcha03)
