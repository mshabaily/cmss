<?php

namespace CMSS;

class TemplateManager
{

    use Singleton;

    private static function new_template($template, $pdo): int
    {
        $stmt = $pdo->prepare("
                    INSERT INTO cmss_templates (title, fields, date_added, author_id)
                    VALUES (:title, :fields, NOW(), :author_id)
                ");

        $stmt->execute([
            ':title' => $template['title'],
            ':fields' => $template['fields'],
            ':author_id' => $template['author_id'],
        ]);

        return (int) $pdo->lastInsertId();
    }

    private static function update_template($template, $pdo): void
    {
        Database::getInstance()->log(json_encode($template));

        $stmt = $pdo->prepare("
                    UPDATE cmss_templates
                    SET title = :title,
                    fields = :fields
                    WHERE template_id = :id
                ");

        $stmt->execute([
            ':title' => $template['title'],
            ':fields' => $template['fields'],
            ':id' => $template['template_id'],
        ]);
    }

    public function save($template): Response
    {
        $pdo = Database::getInstance()->pdo();

        try {
            $pdo->beginTransaction();

            if ($template['template_id'] != -1) {
                self::update_template($template, $pdo);
            } else {
                $template['template_id'] = self::new_template($template, $pdo);
            }

            $pdo->commit();
        } catch (\Throwable $e) {
            Database::getInstance()->handle_error($pdo, $e);
            return new Response(500, "Couldn't save template");
        }

        $response = new Response(200, "Template save successful");
        $response->data['template_id'] = $template['template_id'];
        return $response;
    }

    public function delete($template): Response
    {
        $pdo = Database::getInstance()->pdo();

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("
                DELETE FROM cmss_templates
                WHERE template_id = :template_id
            ");

            $stmt->execute([
                ':template_id' => $template['id'],
            ]);

            $pdo->commit();

            return new Response(200, "Template deleted successfully");
        } catch (\Throwable $e) {
            Database::getInstance()->handle_error($pdo, $e);
            Database::getInstance()->error("Couldn't delete template: " . $e->getMessage());
            return new Response(500, "Couldn't delete template");
        }
    }
}

?>