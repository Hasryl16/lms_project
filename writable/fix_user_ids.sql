-- SQL Script to Fix User IDs to Custom Format (A001, L001, S001, etc.)
-- Run this in your phpMyAdmin or MySQL client on the db_lms database

-- Step 1: Drop ALL foreign key constraints that reference users.id
ALTER TABLE courses DROP FOREIGN KEY IF EXISTS courses_dosen_id_foreign;
ALTER TABLE enrollments DROP FOREIGN KEY IF EXISTS enrollments_mahasiswa_id_foreign;
ALTER TABLE submissions DROP FOREIGN KEY IF EXISTS submissions_mahasiswa_id_foreign;

-- Step 2: Change column type from INT to VARCHAR(10) in users table
ALTER TABLE users MODIFY COLUMN id VARCHAR(10) NOT NULL;

-- Step 3: Update the user IDs in users table
UPDATE users SET id = 'A001' WHERE email = 'admin@gmail.com';
UPDATE users SET id = 'A002' WHERE email = 'admin@edu.com';
UPDATE users SET id = 'L001' WHERE email = 'dosen@gmail.com';
UPDATE users SET id = 'L002' WHERE email = 'lecturer@edu.com';
UPDATE users SET id = 'S001' WHERE email = 'fatur@gmail.com';
UPDATE users SET id = 'S002' WHERE email = 'student@edu.com';

-- Step 4: Change foreign key columns to VARCHAR(10)
ALTER TABLE courses MODIFY COLUMN dosen_id VARCHAR(10);
ALTER TABLE enrollments MODIFY COLUMN mahasiswa_id VARCHAR(10);
ALTER TABLE submissions MODIFY COLUMN mahasiswa_id VARCHAR(10);

-- Step 5: Map foreign keys to new user IDs (all courses have dosen_id = 0, map to L001)
UPDATE courses SET dosen_id = 'L001' WHERE dosen_id = '0';

-- Step 6: Recreate foreign key constraints
ALTER TABLE courses ADD CONSTRAINT courses_dosen_id_foreign 
    FOREIGN KEY (dosen_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE enrollments ADD CONSTRAINT enrollments_mahasiswa_id_foreign 
    FOREIGN KEY (mahasiswa_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE submissions ADD CONSTRAINT submissions_mahasiswa_id_foreign 
    FOREIGN KEY (mahasiswa_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;

-- Step 7: Verify the changes
-- SELECT id, name, email, role FROM users ORDER BY role, id;
-- SELECT id, dosen_id, title FROM courses;
