-- =====================================================
-- EventHub database
-- Member 1: [Name] - Database
-- Import this file in phpMyAdmin (Import tab)
-- =====================================================

CREATE DATABASE IF NOT EXISTS eventhub_db;
USE eventhub_db;

DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS events;

-- Table 1: the events students can register for
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    venue VARCHAR(100) NOT NULL,
    seats INT NOT NULL,
    description TEXT
);

-- Table 2: each student registration (linked to an event)
CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    student_name VARCHAR(100) NOT NULL,
    student_id VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Sample events
INSERT INTO events (title, event_date, venue, seats, description) VALUES
('Web Development Workshop', '2026-12-05', 'Lab 3', 40, 'Build your first website with HTML, CSS and PHP.'),
('Coding Competition', '2026-12-12', 'Main Hall', 60, 'Solve programming problems in teams of two.'),
('Career Guidance Talk', '2026-12-18', 'Auditorium', 100, 'Industry speakers share tips for internships and jobs.'),
('Annual Sports Meet', '2027-01-09', 'University Ground', 200, 'Track events, cricket and football for all faculties.');
