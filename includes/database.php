<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$database = null;
$databaseError = null;

try {
$database = new PDO(
    'mysql:host=sql300.infinityfree.com;dbname=if0_43109764_click_slick;charset=utf8mb4',
    'if0_43109764',
    'dnxgsIk3Zh3hZ',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]
);
    $database->exec("CREATE TABLE IF NOT EXISTS contact_messages (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(120) NOT NULL,
        email VARCHAR(190) NOT NULL,
        phone VARCHAR(40) NULL,
        message TEXT NOT NULL,
        status ENUM('new','read','archived') NOT NULL DEFAULT 'new',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_contact_status (status),
        INDEX idx_contact_created (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $database->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        reviewer_name VARCHAR(120) NOT NULL,
        reviewer_email VARCHAR(190) NULL,
        rating TINYINT UNSIGNED NOT NULL,
        message TEXT NOT NULL,
        status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_reviews_status (status),
        INDEX idx_reviews_created (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $database->exec("CREATE TABLE IF NOT EXISTS admin_users (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(80) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $database->exec("CREATE TABLE IF NOT EXISTS services (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(120) NOT NULL UNIQUE,
        description TEXT NULL,
        price_label VARCHAR(80) NULL,
        is_active TINYINT(1) NOT NULL DEFAULT 1,
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    foreach ([
        'preferred_time' => "TIME NULL AFTER preferred_date",
        'vehicle_make' => "VARCHAR(80) NULL AFTER vehicle",
        'vehicle_model' => "VARCHAR(80) NULL AFTER vehicle_make",
        'vehicle_year' => "SMALLINT UNSIGNED NULL AFTER vehicle_model",
        'vehicle_type' => "VARCHAR(40) NULL AFTER vehicle_year",
        'vehicle_color' => "VARCHAR(50) NULL AFTER vehicle_type",
        'service_location' => "VARCHAR(40) NULL AFTER location",
        'service_address' => "VARCHAR(255) NULL AFTER service_location"
    ] as $column => $definition) {
        $columnCheck = $database->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'bookings' AND COLUMN_NAME = ?");
        $columnCheck->execute([$column]);
        if (!(int) $columnCheck->fetchColumn()) {
            $database->exec("ALTER TABLE bookings ADD COLUMN {$column} {$definition}");
        }
    }
} catch (PDOException $exception) {
    $databaseError = 'Database connection is currently unavailable.';
}

function db(): PDO
{
    global $database;
    if (!$database) {
        throw new RuntimeException('Database connection is unavailable.');
    }
    return $database;
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf(): bool
{
    return isset($_POST['csrf_token'], $_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], (string) $_POST['csrf_token']);
}

$siteConfig = [
    'company_name' => 'Click Slick Auto Detailing',
    'tagline' => 'Professional auto detailing focused on quality, convenience, and attention to detail.',
    'phone' => '520-710-7339',
    'phone_href' => 'tel:+15207107339',
    'sms_href' => 'sms:+15207107339?body=Hi%20Click%20Slick%20Auto%20Detailing!%20I%27d%20like%20to%20book%20a%20detailing%20service.%20Can%20you%20please%20provide%20your%20available%20schedule%3F',
    'email' => 'hello@clickslickdetail.com',
    'location' => 'Tucson, AZ, United States',
    'map_embed_url' => 'https://www.google.com/maps?q=32.250942,-110.9987685&z=15&output=embed',
    'directions_url' => 'https://www.google.com/maps/dir/?api=1&destination=32.250942%2C-110.9987685',
    'service_area' => 'Mobile detailing available throughout Tucson, AZ',
    'business_hours' => 'Mon - Sat: 8:00 AM - 6:00 PM',
    'facebook' => 'facebook.com/clickslickautodetailing',
    'facebook_url' => 'https://www.facebook.com/clickslickautodetailing',
    'instagram' => '@clickslickdetail',
    'address' => 'Mobile service available by appointment',
    'meta_title' => 'Click Slick Auto Detailing | Professional Auto Detailing',
    'meta_description' => 'Professional auto detailing focused on exceptional attention to detail, quality results, and convenient service. Call or text Click Slick Auto Detailing to schedule.'
];

$serviceOptions = [
    'Interior Detail',
    'Exterior Detail',
    'Full Detail',
    'Maintenance Detail',
    'Premium Detail',
    'Custom Service'
];

if ($database) {
    $serviceSeed = $database->prepare('INSERT IGNORE INTO services (name) VALUES (?)');
    foreach ($serviceOptions as $serviceOption) {
        $serviceSeed->execute([$serviceOption]);
    }
}

$serviceCards = [
    [
        'name' => 'Interior Detailing',
        'description' => 'Deep cleaning and refreshing of your vehicle interior for a healthier, more polished cabin.',
        'price' => 'Starting at $XX',
        'features' => ['Vacuuming', 'Surface cleaning', 'Dashboard detailing', 'Seats & door panels', 'Interior refresh']
    ],
    [
        'name' => 'Exterior Detailing',
        'description' => 'Restore shine, remove grime, and protect the finish with careful exterior care.',
        'price' => 'Starting at $XX',
        'features' => ['Exterior wash', 'Wheel cleaning', 'Paint cleaning', 'Tire care', 'Finish enhancement']
    ],
    [
        'name' => 'Full Interior & Exterior Detail',
        'description' => 'A complete vehicle refresh from the inside out for a polished, showroom-ready result.',
        'price' => 'Starting at $XX',
        'features' => ['Interior + exterior care', 'Detail-focused finishing', 'Fresh, polished look', 'Popular package'],
        'highlight' => true
    ],
    [
        'name' => 'Maintenance Detail',
        'description' => 'Keep your vehicle looking its best with a regular detail designed for repeat care.',
        'price' => 'Starting at $XX',
        'features' => ['Regular upkeep', 'Quick refresh', 'Interior tidy-up', 'Exterior shine']
    ],
    [
        'name' => 'Premium / Custom Detail',
        'description' => 'A tailored package based on the condition of your vehicle and what it needs most.',
        'price' => 'Starting at $XX',
        'features' => ['Custom treatment plan', 'Condition-based care', 'Attention to detail', 'Tailored results']
    ]
];

$testimonials = [
    [
        'quote' => 'The car looks brand new. I would highly recommend Click Slick. An added bonus is he came to me!',
        'author' => 'Johnathan Mougin'
    ],
    [
        'quote' => 'Your flexibility and the thorough, professional job you do are truly impressive!',
        'author' => 'Dionne Brown'
    ],
    [
        'quote' => 'My car surface now looks better than brand new.',
        'author' => 'Arash Foroozan'
    ],
    [
        'quote' => 'The results were amazing! Excellent quality and outstanding customer service.',
        'author' => 'Brian Hoffman'
    ],
    [
        'quote' => 'Very detailed on what he does, even the small spots are gone.',
        'author' => 'Aivin Trinidad'
    ],
    [
        'quote' => 'I really appreciate the attention to detail from Click Slick.',
        'author' => 'Emiliano Saucedo'
    ],
    [
        'quote' => 'She looks as good as the day I brought her home!',
        'author' => 'Andreina Torrey'
    ],
    [
        'quote' => 'Ron did an amazing job with my car detailing.',
        'author' => 'Mary Wolfe'
    ],
    [
        'quote' => 'The best!',
        'author' => 'Timothy Brock'
    ]
];

$faqs = [
    [
        'question' => 'Do you offer mobile detailing?',
        'answer' => 'Yes, mobile detailing is available by appointment for customers who want the convenience of professional care at their location.'
    ],
    [
        'question' => 'How long does detailing take?',
        'answer' => 'The time depends on the vehicle size, condition, and selected service. Larger or heavily soiled vehicles may require more time to achieve the best results.'
    ],
    [
        'question' => 'Do I need to provide water or electricity?',
        'answer' => 'Water and power requirements can vary by service and location. These details should be confirmed when scheduling your appointment.'
    ],
    [
        'question' => 'What vehicles do you detail?',
        'answer' => 'Click Slick works with cars, SUVs, trucks, sports cars, and luxury vehicles as needed, with service tailored to each vehicle.'
    ],
    [
        'question' => 'Can you remove stains or pet hair?',
        'answer' => 'Some results depend on the material, age of the stain, and how deeply it is set in. Call or text us so we can discuss what is realistic for your vehicle.'
    ],
    [
        'question' => 'Do you offer recurring detailing?',
        'answer' => 'Recurring service can be discussed based on your needs and maintenance schedule. We can help you plan what works best for your vehicle.'
    ],
    [
        'question' => 'How do I book?',
        'answer' => 'Call or text us directly and we will help you choose a service and find an available time.'
    ]
];
?>
