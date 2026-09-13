SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS certifications;
DROP TABLE IF EXISTS education;
DROP TABLE IF EXISTS experience;
DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS skills;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS admins;

SET FOREIGN_KEY_CHECKS = 1;


-- =========================================================
-- ADMINS
-- =========================================================

CREATE TABLE admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);


-- =========================================================
-- PROFILE
-- =========================================================

CREATE TABLE profile (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    role VARCHAR(150) NOT NULL,
    summary TEXT,
    phone VARCHAR(50),
    email VARCHAR(150),
    location VARCHAR(150),
    portfolio_url VARCHAR(255),
    github_url VARCHAR(255),
    profile_image VARCHAR(255) DEFAULT 'assets/images/profile.jpeg',
    cv_file VARCHAR(255) DEFAULT 'assets/cv/cv.pdf',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);


-- =========================================================
-- SKILLS
-- =========================================================

CREATE TABLE skills (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    icon VARCHAR(100) DEFAULT '',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================================
-- PROJECTS
-- =========================================================

CREATE TABLE projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(150) DEFAULT '',
    description TEXT,
    technologies VARCHAR(500) DEFAULT '',
    url VARCHAR(255) DEFAULT '',
    image VARCHAR(255) DEFAULT '',
    sort_order INT DEFAULT 0,
    featured TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);


-- =========================================================
-- EXPERIENCE
-- =========================================================

CREATE TABLE experience (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(150) NOT NULL,
    company VARCHAR(150) NOT NULL,
    period VARCHAR(100) NOT NULL,
    description TEXT,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================================
-- EDUCATION
-- =========================================================

CREATE TABLE education (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    degree VARCHAR(200) NOT NULL,
    institution VARCHAR(200) NOT NULL,
    period VARCHAR(100) DEFAULT '',
    description TEXT,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================================
-- CERTIFICATIONS
-- =========================================================

CREATE TABLE certifications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    issuer VARCHAR(200) DEFAULT '',
    certification_date VARCHAR(100) DEFAULT '',
    credential_url VARCHAR(255) DEFAULT '',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================================
-- CONTACT MESSAGES
-- =========================================================

CREATE TABLE messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(200) DEFAULT '',
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =========================================================
-- DEFAULT ADMIN
-- =========================================================
-- Username: admin
-- Password: password
--
-- IMPORTANT:
-- Change this password after installation.
-- =========================================================

INSERT INTO admins (
    username,
    password_hash
) VALUES (
    'admin',
    '$2y$12$SXXQzvZuJLnvLO9VkDk6wOiIWt2lPqINrPFSmunJ0rvMVplCmQdtu'
);


-- =========================================================
-- PROFILE
-- =========================================================

INSERT INTO profile (
    full_name,
    role,
    summary,
    phone,
    email,
    location,
    portfolio_url,
    github_url,
    profile_image,
    cv_file
) VALUES (
    'SAWLAYHTAW',
    'Web Developer / Full-Stack Developer',
    'Results-driven Web & Full-Stack Developer with professional experience in web development, custom WordPress solutions, PHP, ReactJS, responsive UI development, CMS management, web maintenance, CMS data migration, and cross-platform application testing with Flutter. Currently working as a Freelance Web Developer, developing database-driven web applications and custom CMS solutions. ITPEC (IP Test) certified with conversational Japanese proficiency (JLPT N4).',
    '+66 81 402 6913',
    'sawlayhtaw.job@gmail.com',
    'BangPhli, SamutPrakan, Thailand',
    'https://sawlayhtaw.great-site.net',
    'https://github.com/sawlayhtawjob-dev',
    'assets/images/profile.jpeg',
    'assets/cv/cv.pdf'
);


-- =========================================================
-- SKILLS
-- =========================================================

INSERT INTO skills
(name, category, icon, sort_order)
VALUES

('HTML5', 'Web Development', 'html5', 1),
('CSS3', 'Web Development', 'css3', 2),
('JavaScript', 'Web Development', 'javascript', 3),
('PHP', 'Web Development', 'php', 4),
('ReactJS', 'Web Development', 'react', 5),
('jQuery', 'Web Development', 'jquery', 6),
('WordPress', 'Web Development', 'wordpress', 7),

('Flutter', 'Secondary Skills', 'flutter', 8),
('Python', 'Secondary Skills', 'python', 9),

('Microsoft Power Apps', 'Low-Code & Tools', 'powerapps', 10),
('Power Automate', 'Low-Code & Tools', 'powerautomate', 11),
('GitHub', 'Low-Code & Tools', 'github', 12),
('Photoshop / PSD to Web', 'Low-Code & Tools', 'photoshop', 13),

('CMS Data Migration', 'Specialized Knowledge', 'database', 14),
('Multi-Platform Testing', 'Specialized Knowledge', 'testing', 15),
('ITPEC Certified', 'Specialized Knowledge', 'certificate', 16);


-- =========================================================
-- PROJECTS
-- =========================================================

INSERT INTO projects
(title, category, description, technologies, url, image, sort_order, featured)
VALUES

(
    'Personal Portfolio & Content Management System',
    'Freelance / Self-Developed',
    'A modern, responsive personal portfolio website built with a custom PHP and MySQL-based content management system. The project combines a professional portfolio experience with an administration system that allows content to be managed without directly editing the website code.',
    'PHP, MySQL, JavaScript, HTML5, CSS3, PDO',
    'https://sawlayhtaw.great-site.net',
    '',
    1,
    1
),

(
    'Bionly',
    'Web + Cross-Platform Support',
    'Maintained web applications and supported Flutter cross-platform testing across iOS, Android, and Windows for bionly.jp.',
    'Web Development, Flutter, Cross-Platform Testing',
    'https://bionly.jp',
    '',
    2,
    1
),

(
    'Arise Myanmar',
    'Full-Stack WordPress',
    'Developed myanmar.arise.co.jp from scratch, managing full-stack architecture, custom themes, and backend integration.',
    'PHP, WordPress, Custom Theme, Backend',
    'https://myanmar.arise.co.jp',
    '',
    3,
    1
),

(
    'Japanese Municipal Websites',
    'Frontend + CMS + Data Migration',
    'Converted Photoshop PSD designs into responsive web interfaces and managed legacy site data migration (データ移行), content updates, and CMS maintenance for Japanese municipal websites.',
    'HTML5, CSS3, JavaScript, CMS, PSD to Web, Data Migration',
    'https://city.nobeoka.miyazaki.jp',
    '',
    4,
    1
),

(
    'Power Platform',
    'Internal Workflow Automation',
    'Researched and implemented internal workflow tools using Microsoft Power Apps and Power Automate.',
    'Power Apps, Power Automate, Workflow Automation',
    '',
    '',
    5,
    1
);


-- =========================================================
-- EXPERIENCE
-- =========================================================

INSERT INTO experience
(role, company, period, description, sort_order)
VALUES

(
    'Freelance Web Developer',
    'Self-Employed / Freelance',
    '2026 – Present',
    'Building responsive, database-driven web applications and custom CMS solutions with a focus on clean architecture, responsive interfaces, and practical content management systems.

What I work on:
- Develop responsive web applications using PHP, MySQL, HTML5, CSS3, and JavaScript.
- Build custom CMS and admin dashboard solutions for managing website content.
- Implement CRUD-based content management for projects, skills, experience, education, and certifications.
- Develop responsive interfaces with Light/Dark Mode, animations, and interactive components.
- Manage project assets, profile content, CV files, and other website resources through administrative interfaces.',
    1
),

(
    'Programmer',
    'Arise Myanmar Co., Ltd.',
    'July 2021 – March 2024',
    'Front-End & CMS Development (Japan Municipal Sites): Converted Photoshop (PSD) designs into responsive web interfaces and managed legacy site data migration (データ移行), content updates, and CMS maintenance for Japanese municipal websites (e.g., city.nobeoka.miyazaki.jp).

Web & Cross-Platform Support: Maintained web applications and supported Flutter cross-platform testing across iOS, Android, and Windows for bionly.jp.

Full-Stack WordPress Development: Developed myanmar.arise.co.jp from scratch, managing full-stack architecture, custom themes, and backend integration.

Low-Code Automation: Researched and implemented internal workflow tools using Microsoft Power Apps and Power Automate.',
    2
),

(
    'Front-End Web Developer Intern',
    'Arise Myanmar Co., Ltd.',
    'May 2019 – February 2020',
    'CMS Data Migration (データ移行): Executed web system data migration and content edits to maintain updated site structures.

WordPress & PHP Development: Gained hands-on experience in WordPress theme customization, PHP development, and core web architecture.',
    3
);


-- =========================================================
-- EDUCATION
-- =========================================================

INSERT INTO education
(degree, institution, period, description, sort_order)
VALUES
(
    'Bachelor of Computer Science (B.C.Sc)',
    'University of Computer Studies, Hpa-an',
    '2014–2020',
    '',
    1
);


-- =========================================================
-- CERTIFICATIONS
-- =========================================================

INSERT INTO certifications
(name, issuer, certification_date, credential_url, sort_order)
VALUES

(
    'ITPEC Information Technology Professional (IP Test)',
    'ITPEC',
    'October 2017',
    '',
    1
),

(
    'JLPT N4',
    'Japanese-Language Proficiency Test',
    'July 2022',
    '',
    2
);