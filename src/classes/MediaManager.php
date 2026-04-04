<?php

namespace CMSS;

use Intervention\Image\ImageManagerStatic as Image;

class MediaManager
{
    use Singleton;
    use HasLogger;

    private static array $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

    protected function __construct()
    {
        self::load_logger('media');
    }

    private function validate_extension($file): bool
    {
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, self::$allowed_extensions, true)) {
            return false;
        }

        return true;
    }

    private static function save_to_db($metadata): int
    {

        $pdo = Database::getInstance()->pdo();

        try {
            $stmt = $pdo->prepare("
                INSERT INTO cmss_media (url, file_size, date_added, author_id, file_name)
                VALUES (:url, :filesize, NOW(), :author_id, :filename)
            ");

            $stmt->execute([
                ':filename' => $metadata['file_name'],
                ':author_id' => $metadata['author_id'],
                ':url' => $metadata['url'],
                ':filesize' => $metadata['file_size']
            ]);
        } catch (\Throwable $e) {
            Database::getInstance()->handle_error($pdo, $e);
            return -1;
        }

        return (int) $pdo->lastInsertId();
    }

    public function upload($file): Response
    {
        if (!$this->validate_extension($file)) {
            self::error("Attempt to upload incompatible filetype");
            return new Response(415, "Attempt to upload incompatible filetype");
        }

        $file['name'] = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($file['name']));
        $url = site_url() . '/public/uploads/' . $file['name'];

        $path = ROOT_PATH . '/public/uploads/' . $file['name'];
        $upload_dir = dirname($path);
        $thumb_dir = $upload_dir . '/thumbs';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        if (!is_dir($thumb_dir)) {
            mkdir($thumb_dir, 0755, true);
        }

        $metadata = [
            'file_name' => $file['name'],
            'url' => $url,
            'author_id' => 1,
            'file_size' => $file['size']
        ];

        $media_id = self::save_to_db($metadata);

        if ($media_id == -1) {
            return new Response(500, "Couldn't save media to database");
        }

        $success = move_uploaded_file($file['tmp_name'], $path);

        if (!$success) {
            self::error("Couldn't process incoming image");
            return new Response(500, "Couldn't process incoming image");
        }

        $thumbnail_success = self::make_thumbnail($file);

        if (!$thumbnail_success) {
            self::error("Couldn't process incoming image");
            return new Response(500, "Couldn't generate thumbnail");
        }

        $response = new Response(200, "Media uploaded successfully");
        $response->data['media_id'] = $media_id;

        return $response;
    }

    public function delete($media)
    {
        $pdo = Database::getInstance()->pdo();

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("
                DELETE FROM cmss_media
                WHERE media_id = :media_id
            ");

            $stmt->execute([
                ':media_id' => $media['id'],
            ]);

            $pdo->commit();

            return new Response(200, "Media deleted successfully");
        } catch (\Throwable $e) {
            Database::getInstance()->handle_error($pdo, $e);
            Database::getInstance()->error("Couldn't delete media: " . $e->getMessage());
            return new Response(500, "Couldn't delete media");
        }
    }

    private static function make_thumbnail($file)
    {

        $source = ROOT_PATH . '/public/uploads/' . $file['name'];
        $destination = ROOT_PATH . "/public/uploads/thumbs/" . $file['name'];

        try {
            $image = Image::make($source)
                ->resize(75, 75, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

            $image->encode(null, 50)->save($destination);
            return true;

        } catch (\Throwable $e) {
            return false;
        }
    }
}