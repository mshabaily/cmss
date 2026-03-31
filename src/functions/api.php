<?php

use CMSS\Database;

function cmss_asset($path): string
{
    return site_url() . '/assets/' . $path;
}

function cmss_partial($path): string
{
    return ROOT_PATH . '/src/partials/' . $path;
}

function cmss_header()
{
    include cmss_partial('header.php');
}

function cmss_footer()
{
    include cmss_partial('footer.php');
}

function cmss_sidebar()
{
    include cmss_partial('sidebar.php');
}

function site_url(): string
{
    $scheme = $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    return "$scheme://$host";
}

function current_url(): string
{
    return ltrim($_SERVER['REQUEST_URI'], '/');
}

function current_location(): string
{

    if (str_contains($_SERVER['REQUEST_URI'], 'load-media')) {
        return site_url() . '/cmss/media';
    }

    if (str_contains($_SERVER['REQUEST_URI'], 'media-select')) {
        return site_url() . '/cmss/media';
    }

    return site_url() . $_SERVER['REQUEST_URI'];
}


function cmss_template($id)
{
    try {
        $pdo = Database::getInstance()->pdo();
    } catch (\Throwable $e) {
        Database::getInstance()->error("Connection failed: " . $e->getMessage());
        return;
    }

    $id = (int) $id;

    try {
        $stmt = $pdo->prepare("SELECT * FROM cmss_templates WHERE template_id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);

        $template = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($template) {
            return $template;
        } else {
            Database::getInstance()->error("Template corrupt!");
        }

    } catch (\Throwable $e) {
        Database::getInstance()->error("Couldn't get template: " . $e->getMessage());
    }
}

function cmss_page($id)
{
    try {
        $pdo = Database::getInstance()->pdo();
    } catch (\Throwable $e) {
        Database::getInstance()->error("Connection failed: " . $e->getMessage());
        return;
    }

    $id = (int) $id;

    try {
        $stmt = $pdo->prepare("SELECT * FROM cmss_pages WHERE page_id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);

        $page = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($page) {
            return $page;
        } else {
            Database::getInstance()->error("Page corrupt!");
        }

    } catch (\Throwable $e) {
        Database::getInstance()->error("Couldn't get page: " . $e->getMessage());
    }
}

function cmss_templates($count = -1)
{
    try {
        $pdo = Database::getInstance()->pdo();
    } catch (\Throwable $e) {
        Database::getInstance()->error("Connection failed: " . $e->getMessage());
        return;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM cmss_templates ORDER BY date_added DESC");
        $stmt->execute();

        $templates = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($count > -1) {
            return array_slice($templates, 0, $count);
        } else {
            return $templates;
        }

    } catch (\Throwable $e) {
        Database::getInstance()->error("Couldn't get templates: " . $e->getMessage());
    }
}

function cmss_pages($count = -1)
{
    try {
        $pdo = Database::getInstance()->pdo();
    } catch (\Throwable $e) {
        Database::getInstance()->error("Connection failed: " . $e->getMessage());
        return;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM cmss_pages ORDER BY date_added DESC");
        $stmt->execute();

        $pages = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($count > -1) {
            return array_slice($pages, 0, $count);
        } else {
            return $pages;
        }

    } catch (\Throwable $e) {
        Database::getInstance()->error("Couldn't get pages: " . $e->getMessage());
    }
}

function cmss_media($id)
{
    try {
        $pdo = Database::getInstance()->pdo();
    } catch (\Throwable $e) {
        Database::getInstance()->error("Connection failed: " . $e->getMessage());
        return;
    }

    $id = (int) $id;

    try {
        $stmt = $pdo->prepare("SELECT * FROM cmss_media WHERE media_id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);

        $media = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($media) {
            return $media;
        } else {
            Database::getInstance()->error("Couldn't get media (invalid data)");
        }

    } catch (\Throwable $e) {
        Database::getInstance()->error("Couldn't get media (pdo error) : " . $e->getMessage());
    }
}

function cmss_user($id)
{
    try {
        $pdo = Database::getInstance()->pdo();
    } catch (\Throwable $e) {
        Database::getInstance()->error("Connection failed: " . $e->getMessage());
        return;
    }

    $id = (int) $id;

    try {
        $stmt = $pdo->prepare("SELECT * FROM cmss_users WHERE user_id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user) {
            return $user;
        } else {
            Database::getInstance()->error("User not found!");
        }

    } catch (\Throwable $e) {
        Database::getInstance()->error("Couldn't get user: " . $e->getMessage());
    }
}

function cmss_all_media()
{
    try {
        $pdo = Database::getInstance()->pdo();
    } catch (\Throwable $e) {
        Database::getInstance()->error("Connection failed: " . $e->getMessage());
        return;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM cmss_media ORDER BY date_added DESC");
        $stmt->execute();

        $media = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($media) {
            return $media;
        }

    } catch (\Throwable $e) {
        Database::getInstance()->error("Couldn't get media: " . $e->getMessage());
    }
}

function cmss_current_user()
{
    return cmss_user($_SESSION['user_id']);
}

function cmss_user_role()
{
    return cmss_current_user()['role'];
}

function cmss_is_user_logged_in(): bool
{
    return (!empty($_SESSION['user_id']));
}

function cmss_login_user($id): bool
{
    $id_valid = cmss_user($id) ? true : false;

    if ($id_valid) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;
    }

    return $id_valid;
}

function cmss_logout()
{
    unset($_SESSION['user_id']);
}

function cmss_users($count = -1)
{
    try {
        $pdo = Database::getInstance()->pdo();
    } catch (\Throwable $e) {
        Database::getInstance()->error("Connection failed: " . $e->getMessage());
        return;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM cmss_users ORDER BY date_added DESC");
        $stmt->execute();

        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if ($count > -1) {
            return array_slice($users, 0, $count);
        } else {
            return $users;
        }

    } catch (\Throwable $e) {
        Database::getInstance()->error("Couldn't get users: " . $e->getMessage());
    }
}

function url_format($input): string
{
    $input = strtolower($input);
    $input = preg_replace('/[^a-z0-9]+/', '-', $input);
    return trim($input, '-');
}

function url_unique($url)
{
    $count = 0;
    $i = 0;
    $pages = cmss_pages();
    $max = count($pages);
    $original = $url;

    while ($i < $max) {
        foreach ($pages as $page) {
            if ($page['url'] == $url) {
                $url = $original . '-' . ++$count;
                $i = 0;
            }

            $i++;
        }
    }

    return $url;
}

function cmss_field($key)
{
    try {
        $pdo = Database::getInstance()->pdo();
    } catch (\Throwable $e) {
        Database::getInstance()->error("Connection failed: " . $e->getMessage());
        return;
    }

    $url = current_url();

    try {
        $stmt = $pdo->prepare("SELECT * FROM cmss_pages WHERE url = :url LIMIT 1");
        $stmt->execute([':url' => $url]);

        $page = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$page) {
            Database::getInstance()->error("Couldn't find page");
        }

    } catch (\Throwable $e) {
        Database::getInstance()->error("Couldn't get page: " . $e->getMessage());
    }

    $fields = json_decode($page['fields'] ?? '[]', true);

    foreach ($fields as $field) {
        if ($field['fieldkey'] == $key) {
            if ($field['fieldtype'] == 'image.php') {
                return cmss_media($field['value']);
            }

            if ($field['fieldtype'] == 'loop.php') {
                $return = [];

                foreach ($field['value'] as $row) {
                    $row_data = [];

                    foreach ($row as $subfield) {
                        $row_data[$subfield['fieldkey']] = $subfield['value'];
                    }

                    $return[] = $row_data;
                }

                return $return;
            }

            return $field['value'];
        }
    }
}

function cmss_thumbnail($media)
{
    $url = $media['url'];
    $base = rtrim(dirname($url), '/');
    return $base . '/thumbs/' . $media['file_name'];
}

