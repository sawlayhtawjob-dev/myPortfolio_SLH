USE myportfolio_slh;

-- =========================================================
-- UPDATE PROFILE
-- =========================================================

UPDATE profile
SET
    summary = 'Results-driven Web & Full-Stack Developer with professional experience in web development, custom WordPress solutions, PHP, ReactJS, responsive UI development, CMS management, web maintenance, CMS data migration, and cross-platform application testing with Flutter. Currently working as a Freelance Web Developer, developing database-driven web applications and custom CMS solutions. ITPEC (IP Test) certified with conversational Japanese proficiency (JLPT N4).',
    profile_image = 'assets/images/profile.jpeg'
WHERE id = 1;


-- =========================================================
-- UPDATE PROJECT ORDER
-- =========================================================

UPDATE projects
SET sort_order = sort_order + 1
WHERE sort_order >= 1;


-- =========================================================
-- ADD PERSONAL PORTFOLIO PROJECT
-- =========================================================

INSERT INTO projects
(
    title,
    category,
    description,
    technologies,
    url,
    image,
    sort_order,
    featured
)
SELECT
    'Personal Portfolio & Content Management System',
    'Freelance / Self-Developed',
    'A modern, responsive personal portfolio website built with a custom PHP and MySQL-based content management system. The project combines a professional portfolio experience with an administration system that allows content to be managed without directly editing the website code.',
    'PHP, MySQL, JavaScript, HTML5, CSS3, PDO',
    'https://sawlayhtaw.great-site.net',
    '',
    1,
    1
WHERE NOT EXISTS
(
    SELECT 1
    FROM projects
    WHERE title = 'Personal Portfolio & Content Management System'
);


-- =========================================================
-- UPDATE EXPERIENCE ORDER
-- =========================================================

UPDATE experience
SET sort_order = sort_order + 1
WHERE sort_order >= 1;


-- =========================================================
-- ADD FREELANCE EXPERIENCE
-- =========================================================

INSERT INTO experience
(
    role,
    company,
    period,
    description,
    sort_order
)
SELECT
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
WHERE NOT EXISTS
(
    SELECT 1
    FROM experience
    WHERE role = 'Freelance Web Developer'
      AND company = 'Self-Employed / Freelance'
);