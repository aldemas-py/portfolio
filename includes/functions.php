 <?php

    /**
     * Njenga Sam Portfolio - Helper Functions
     */

    require_once __DIR__ . '/config.php';

    /**
     * Sanitize output for HTML
     */
    function h($str)
    {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Generate a URL-friendly slug
     */
    function createSlug($string)
    {
        $string = strtolower(trim($string));
        $string = preg_replace('/[^a-z0-9-]/', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        return trim($string, '-');
    }

    /**
     * Format date nicely
     */
    function formatDate($date, $format = 'F j, Y')
    {
        return date($format, strtotime($date));
    }

    /**
     * Truncate text
     */
    function truncateText($text, $length = 120)
    {
        if (strlen($text) <= $length) return $text;
        return substr($text, 0, $length) . '...';
    }

    /**
     * Check if admin is logged in
     */
    function isAdminLoggedIn()
    {
        startSession();

        if (!isset($_SESSION['admin_id'])) {
            return false;
        }

        if (isset($_SESSION['last_activity'])) {
            $inactive = time() - $_SESSION['last_activity'];
            if ($inactive > SESSION_TIMEOUT) {
                adminLogout('Session expired due to inactivity. Please log in again.');
                return false;
            }
        }

        $_SESSION['last_activity'] = time();
        return true;
    }

    /**
     * Redirect if not admin
     */
    function requireAdmin()
    {
        if (!isAdminLoggedIn()) {
            header('Location: ' . SITE_URL . '/admin/login.php?expired=1');
            exit;
        }
    }

    /**
     * Complete admin logout - destroys session securely
     */
    function adminLogout($redirectMessage = '')
    {
        startSession();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        if ($redirectMessage) {
            session_start();
            $_SESSION['logout_message'] = $redirectMessage;
            session_write_close();
        }

        return true;
    }

    /**
     * Get all published projects
     */
    function getProjects()
    {
        $db = getDB();
        return $db->query("SELECT * FROM projects WHERE is_published = 1 ORDER BY display_order ASC, created_at DESC")->fetchAll();
    }

    /**
     * Get all projects (admin view)
     */
    function getAllProjects()
    {
        $db = getDB();
        return $db->query("SELECT * FROM projects ORDER BY display_order ASC, created_at DESC")->fetchAll();
    }

    /**
     * Resolve a project image path. Checks uploads/ first (admin uploads),
     * then falls back to images/ (seeded project images).
     */
    function projectImage($filename)
    {
        if (!$filename) {
            return null;
        }
        $base = __DIR__ . '/..';
        $filename = basename($filename); // sanitize
        if (file_exists($base . '/uploads/' . $filename)) {
            return SITE_URL . '/uploads/' . $filename;
        }
        if (file_exists($base . '/images/' . $filename)) {
            return SITE_URL . '/images/' . $filename;
        }
        return null;
    }

    /**
     * Resolve a testimonial image path. Checks uploads/ first (admin uploads),
     * then falls back to images/ (seeded images).
     */
    function testimonialImage($filename)
    {
        if (!$filename) {
            return null;
        }
        $base = __DIR__ . '/..';
        $filename = basename($filename); // sanitize
        if (file_exists($base . '/uploads/' . $filename)) {
            return SITE_URL . '/uploads/' . $filename;
        }
        if (file_exists($base . '/images/' . $filename)) {
            return SITE_URL . '/images/' . $filename;
        }
        return null;
    }

    /**
     * Get a single project by slug
     */
    function getProjectBySlug($slug)
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM projects WHERE slug = ? LIMIT 1");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    /**
     * Get approved testimonials
     */
    function getTestimonials()
    {
        $db = getDB();
        return $db->query("SELECT * FROM testimonials WHERE is_approved = 1 ORDER BY created_at DESC")->fetchAll();
    }

    /**
     * Get all testimonials (admin)
     */
    function getAllTestimonials()
    {
        $db = getDB();
        return $db->query("SELECT * FROM testimonials ORDER BY created_at DESC")->fetchAll();
    }

    /**
     * Upload an image file and return the filename
     */
    function uploadImage($file, $existingFile = null)
    {
        $uploadDir = __DIR__ . '/../uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (empty($file) || !isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return $existingFile;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Invalid file type. Allowed: JPG, PNG, GIF, WEBP');
        }

        if ($file['size'] > $maxSize) {
            throw new Exception('File too large. Maximum size is 5MB.');
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('proj_') . '_' . time() . '.' . strtolower($ext);
        $destPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            if ($existingFile && file_exists($uploadDir . $existingFile)) {
                unlink($uploadDir . $existingFile);
            }
            return $filename;
        }

        throw new Exception('Failed to upload file.');
    }

    /**
     * Delete an uploaded image
     */
    function deleteImage($filename)
    {
        if ($filename) {
            $path = __DIR__ . '/../uploads/' . $filename;
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    /**
     * Get admin stats
     */
    function getDashboardStats()
    {
        $db = getDB();
        $stats = [];
        $stats['total_projects'] = $db->query("SELECT COUNT(*) FROM projects WHERE is_published = 1")->fetchColumn();
        $stats['total_testimonials'] = $db->query("SELECT COUNT(*) FROM testimonials WHERE is_approved = 1")->fetchColumn();
        $stats['pending_testimonials'] = $db->query("SELECT COUNT(*) FROM testimonials WHERE is_approved = 0")->fetchColumn();
        $stats['total_messages'] = $db->query("SELECT COUNT(*) FROM messages")->fetchColumn();
        $stats['unread_messages'] = $db->query("SELECT COUNT(*) FROM messages WHERE is_read = 0")->fetchColumn();
        return $stats;
    }

    /**
     * Save a contact message
     */
    function saveContactMessage($name, $email, $phone, $subject, $message)
    {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $phone, $subject, $message]);
    }

    /**
     * Get service offerings (featured services for the homepage)
     */
    function getServices()
    {
        return [
            [
                'title' => 'Web & Mobile Development',
                'icon' => '&#128187;',
                'desc' => 'Responsive web apps and Android applications built with clean, maintainable code and a business-first mindset.',
                'color' => '#2563EB',
            ],
            [
                'title' => 'API Integration & Backend',
                'icon' => '&#128736;',
                'desc' => 'REST APIs, database design, and backend systems that keep your data flowing reliably and securely.',
                'color' => '#7964E8',
            ],
            [
                'title' => 'IT & Systems Support',
                'icon' => '&#128295;',
                'desc' => 'Hardware/software troubleshooting, network basics, and operational support refined in high-pressure environments.',
                'color' => '#059669',
            ],
            [
                'title' => 'System Architecture',
                'icon' => '&#128506;',
                'desc' => 'Architectural thinking that scales delivery — turning requirements into maintainable, deployable solutions.',
                'color' => '#F59E0B',
            ],
            [
                'title' => 'Business Workflow Solutions',
                'icon' => '&#128200;',
                'desc' => 'Analytics dashboards, process improvement, and tools that turn business operations into data-driven decisions.',
                'color' => '#DC2626',
            ],
            [
                'title' => 'UX/UI & Design',
                'icon' => '&#127912;',
                'desc' => 'Simple, thoughtful, interactive designs for web and mobile that put users first.',
                'color' => '#7C3AED',
            ],
        ];
    }