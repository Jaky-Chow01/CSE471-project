-- ============================================================
--  BloodLink2 — Database Schema & Seed Data
--  Import via phpMyAdmin or: mysql -u root -p < bloodlink2.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS bloodlink2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bloodlink2;

-- ── DONORS ──────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS donors (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  name              VARCHAR(100)  NOT NULL,
  initials          VARCHAR(5)    NOT NULL,
  blood_group       VARCHAR(5)    NOT NULL,
  location          VARCHAR(200)  NOT NULL,
  lat               DECIMAL(10,7) NOT NULL,
  lng               DECIMAL(10,7) NOT NULL,
  phone             VARCHAR(20)   NOT NULL,
  email             VARCHAR(100)  DEFAULT NULL,
  last_donation     DATE          DEFAULT NULL,
  min_wait          INT           NOT NULL DEFAULT 90,
  availability_today TINYINT(1)  NOT NULL DEFAULT 1,
  created_at        TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── POST-DONATION CARE ───────────────────────────────────────
CREATE TABLE IF NOT EXISTS donor_care (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  donor_id          INT           NOT NULL,
  hydration_start   TIME          NOT NULL DEFAULT '08:00:00',
  hydration_end     TIME          NOT NULL DEFAULT '20:00:00',
  rest_start        TIME          NOT NULL DEFAULT '09:00:00',
  rest_end          TIME          NOT NULL DEFAULT '17:00:00',
  nutrition_start   TIME          NOT NULL DEFAULT '07:00:00',
  nutrition_end     TIME          NOT NULL DEFAULT '21:00:00',
  updated_at        TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (donor_id) REFERENCES donors(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ── BLOOD REQUESTS ───────────────────────────────────────────
CREATE TABLE IF NOT EXISTS blood_requests (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  blood_group VARCHAR(5)   NOT NULL,
  hospital    VARCHAR(150) NOT NULL,
  units       INT          NOT NULL DEFAULT 1,
  urgency     ENUM('low','high','critical') NOT NULL DEFAULT 'high',
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── SEED: DONORS ─────────────────────────────────────────────
INSERT INTO donors (name, initials, blood_group, location, lat, lng, phone, email, last_donation, min_wait, availability_today) VALUES
('Arif Hossain',  'AH', 'A-',  '124/ABC Road, Dhaka',          23.8103000, 90.4125000, '01711-000001', 'arif@gmail.com',   DATE_SUB(CURDATE(), INTERVAL 98  DAY), 90, 1),
('Bashir Ahmed',  'BA', 'AB+', '44/ABC Lane, Old Dhaka',        23.7500000, 90.3750000, '01711-000002', 'bashir@gmail.com', DATE_SUB(CURDATE(), INTERVAL 120 DAY), 90, 1),
('Chandra Mitra', 'CM', 'O-',  '65/ABC Street, Wari, Dhaka',   23.8200000, 90.4000000, '01711-000003', 'chandra@gmail.com',DATE_SUB(CURDATE(), INTERVAL 60  DAY), 90, 0),
('Delwar Islam',  'DI', 'B+',  '12/XYZ Colony, Dhaka',         23.7800000, 90.4200000, '01711-000004', 'delwar@gmail.com', DATE_SUB(CURDATE(), INTERVAL 200 DAY), 90, 1),
('Ema Sultana',   'ES', 'O+',  '88/Mirpur Road, Dhaka',        23.8000000, 90.3600000, '01711-000005', 'ema@gmail.com',    DATE_SUB(CURDATE(), INTERVAL 150 DAY), 90, 1),
('Farhan Rahman', 'FR', 'A+',  'Gulshan Avenue, Dhaka',        23.7936000, 90.4148000, '01712-345678', 'farhan@email.com', DATE_SUB(CURDATE(), INTERVAL 45  DAY), 90, 0),
('Rida Khanom',   'RK', 'B-',  'Dhanmondi Road 27, Dhaka',     23.7461000, 90.3742000, '01719-876543', 'rida@email.com',   DATE_SUB(CURDATE(), INTERVAL 97  DAY), 90, 1);

-- ── SEED: CARE SCHEDULES ─────────────────────────────────────
INSERT INTO donor_care (donor_id, hydration_start, hydration_end, rest_start, rest_end, nutrition_start, nutrition_end) VALUES
(1, '08:00', '20:00', '09:00', '17:00', '07:00', '21:00'),
(2, '07:00', '19:00', '08:00', '18:00', '06:00', '20:00');

-- ── SEED: ACTIVE BLOOD REQUESTS ──────────────────────────────
INSERT INTO blood_requests (blood_group, hospital, units, urgency) VALUES
('A-',  'Dhaka Medical College', 2, 'high'),
('O-',  'Square Hospital',       1, 'critical'),
('AB+', 'BIRDEM General Hospital',1,'high');
