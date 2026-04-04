<?php

namespace CMSS;

class PageManager
{
    use Singleton;

    static private function new_page($page, $pdo): int
    {
        $stmt = $pdo->prepare("
            INSERT INTO cmss_pages (title, fields, date_added, author_id, url, template_id)
            VALUES (:title, :fields, NOW(), :author_id, :url, :template_id)
        ");

        $stmt->execute([
            ':title' => $page['title'],
            ':fields' => $page['fields'],
            ':author_id' => $page['author_id'],
            ':url' => $page['url'],
            ':template_id' => $page['template_id']
        ]);

        return (int) $pdo->lastInsertId();
    }

    static private function update_page($page, $pdo): void
    {
        $stmt = $pdo->prepare("
            UPDATE cmss_pages
            SET title = :title,
            fields = :fields,
            url = :url,
            template_id = :template_id
                WHERE page_id = :id
        ");

        $stmt->execute([
            ':title' => $page['title'],
            ':fields' => $page['fields'],
            ':id' => $page['page_id'],
            ':url' => $page['url'],
            ':template_id' => $page['template_id']
        ]);
    }

    public function save($page): Response
    {
        $pdo = Database::getInstance()->pdo();

        try {
            $pdo->beginTransaction();

            if ($page['page_id'] != -1) {
                self::update_page($page, $pdo);
            } else {
                $page['page_id'] = self::new_page($page, $pdo);
            }

            $pdo->commit();
        } catch (\Throwable $e) {
            Database::getInstance()->handle_error($pdo, $e);
            return new Response(500, "Couldn't save page");
        }

        $response = new Response(200, "Page save successful");
        $response->data['page_id'] = $page['page_id'];
        return $response;
    }

    public function delete($page): Response
    {
        $pdo = Database::getInstance()->pdo();

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("
                DELETE FROM cmss_pages
                WHERE page_id = :page_id
            ");

            $stmt->execute([
                ':page_id' => $page['id'],
            ]);

            $pdo->commit();

            return new Response(200, "Page deleted successfully");
        } catch (\Throwable $e) {
            Database::getInstance()->handle_error($pdo, $e);
            Database::getInstance()->error("Couldn't delete page: " . $e->getMessage());
            return new Response(500, "Couldn't delete page");
        }
    }
}