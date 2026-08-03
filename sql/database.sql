-- ============================================================
-- Njenga Sam Portfolio - Database Schema
-- ============================================================
CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;
-- ------------------------------------------------------------
-- Admin Users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- Default admin: username = admin, password = admin123 (CHANGE IN PRODUCTION!)
INSERT INTO admin_users (username, password_hash)
VALUES (
        'admin',
        '$2y$10$3q89xjFLiu.SpW4lfT5IbOkXsWYNfrEbZY29f1KbCQCZTGNWfb2LS'
    ) ON DUPLICATE KEY
UPDATE username = username;
-- ------------------------------------------------------------
-- Projects (Recent Works)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    short_desc TEXT,
    full_desc TEXT,
    image VARCHAR(255) DEFAULT NULL,
    url VARCHAR(255) DEFAULT NULL,
    category VARCHAR(100) DEFAULT 'Web Development',
    display_order INT DEFAULT 0,
    is_published TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- Seed sample projects
INSERT INTO projects (
        title,
        slug,
        short_desc,
        full_desc,
        image,
        url,
        category,
        display_order,
        is_published
    )
VALUES (
        'Writing Devs',
        'writing-devs',
        'A static blog-style web page project with elegant typography and category navigation.',
        'Writing Devs is a static, content-focused web page highlighting a clean editorial layout. It features category chips, an article card grid, and a pagination scrollbar. The project demonstrates strong typography, spacing, and accessible navigation patterns.',
        'mage7.jpg',
        'https://njengasam.com/writing_dev/',
        'Web Development',
        1,
        1
    ),
    (
        'Image Resizer',
        'image-resizer',
        'An image resizer app for developers with a clean, modern interface.',
        'Image Resizer is a developer utility that lets users upload and resize images quickly. It features a lightweight, modern UI with straightforward file handling and download options.',
        'image8.jpg',
        'https://njengasam.com/imageResizer',
        'Developer Tool',
        2,
        1
    ),
    (
        'DigiChem',
        'digichem',
        'A digital drug store stock management system for pharmacy operations.',
        'DigiChem is a digital drug store stock management system supporting digital record tracking, inventory workflows, supplier ordering, and sales processing. It is designed with system architecture principles to keep inventory updates consistent and reduce operational errors during high-volume sales.',
        'image1.jpg',
        '',
        'Business System',
        3,
        1
    ),
    (
        'Arch',
        'arch',
        'A template for an architectural company website with gallery layout.',
        'Arch is a responsive template for an architectural company website. It showcases a gallery-driven layout ideal for presenting projects, portfolios, and studio information.',
        'image2.jpg',
        'https://njengasam.com/architecture',
        'Web Template',
        4,
        1
    ),
    (
        'Getright',
        'getright',
        'A template for a firm or company website with a corporate feel.',
        'Getright is a corporate website template for a firm or company. It provides a clean, professional layout suited for service businesses, with sections for services, team, and contact.',
        'image3.jpg',
        'https://njengasam.com/arch',
        'Web Template',
        5,
        1
    ),
    (
        'Find-x',
        'find-x',
        'A search engine that surfs the web and collects links.',
        'Find-x is a search engine concept that surfs the web and collects links. It is an experimental project focused on link aggregation and search experience.',
        'image4.jpg',
        '',
        'Experiment',
        6,
        1
    ),
    (
        'Get Updated',
        'get-updated',
        'A free open-source website for data sharing.',
        'Get Updated is a free, open-source website for data sharing. It aims to provide a simple, collaborative platform for distributing and discovering information.',
        'image5.jpg',
        '',
        'Open Source',
        7,
        1
    ),
    (
        'Luciana',
        'luciana',
        'A personal brand project currently under development.',
        'Luciana is a project currently under development. More details coming soon as the project evolves.',
        'image6.jpg',
        '',
        'In Development',
        8,
        0
    );
-- ------------------------------------------------------------
-- Testimonials
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100) NOT NULL,
    client_role VARCHAR(100) DEFAULT NULL,
    content TEXT NOT NULL,
    rating TINYINT DEFAULT 5,
    is_approved TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
INSERT INTO testimonials (
        client_name,
        client_role,
        content,
        rating,
        is_approved
    )
VALUES (
        'Jane M.',
        'Startup Founder',
        'Sam delivered a reliable web application that transformed how we manage our operations. His systems thinking and business-minded approach made all the difference.',
        5,
        1
    ),
    (
        'David K.',
        'Product Manager',
        'Great communicator and a pragmatic developer. He translated complex requirements into maintainable features quickly.',
        5,
        1
    ),
    (
        'Company X',
        'Client',
        'Professional, responsive, and thorough. Sam helped us streamline our workflows and improve our technical operations.',
        4,
        1
    );
-- ------------------------------------------------------------
-- Contact Messages
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    subject VARCHAR(255) DEFAULT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;