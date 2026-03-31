<?php

namespace CMSS;

class Settings
{
    use Singleton;

    private $site_title = '';
    private $favicon = '';

    private string $settings_file;

    private function __construct()
    {
        $this->settings_file = ROOT_PATH . '/src/config/settings.json';
        $this->load();
    }

    public function get_site_title()
    {
        return $this->site_title;
    }

    public function get_favicon()
    {
        return $this->favicon;
    }

    public function set_site_title($site_title)
    {
        $this->site_title = $site_title;
    }

    public function set_favicon($favicon)
    {
        $this->favicon = $favicon;
    }

    public function save($site_title, $favicon)
    {
        $this->set_site_title($site_title);
        $this->set_favicon($favicon);

        $data = [
            'site_title' => $this->site_title,
            'favicon' => $this->favicon,
        ];

        $dir = dirname($this->settings_file);

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $written = file_put_contents(
            $this->settings_file,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            LOCK_EX
        );

        if ($written === false) {
            return new Response(500, 'Failed to save settings');
        }

        return new Response(200, 'Settings Saved');
    }

    private function load(): void
    {
        if (!file_exists($this->settings_file)) {
            return;
        }

        $contents = file_get_contents($this->settings_file);

        if ($contents === false) {
            return;
        }

        $data = json_decode($contents, true);

        if (!is_array($data)) {
            return;
        }

        $this->site_title = $data['site_title'];
        $this->favicon = $data['favicon'];
    }
}