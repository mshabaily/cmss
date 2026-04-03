<?php

namespace CMSS;

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;

class Router
{
    use Singleton, HasLogger;

    private string $request_method;
    private string $raw_uri;
    private string $uri;

    private function __construct()
    {
        self::load_logger('router');

        $this->request_method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->raw_uri = $_SERVER['REQUEST_URI'] ?? '/';

        try {
            $this->process_uri();
        } catch (\Throwable $e) {
            $this->error('Error processing URI: ' . $e->getMessage());
            throw $e;
        }
    }

    public function dispatch(): void
    {
        try {
            $this->dispatch_routes();
        } catch (\Throwable $e) {
            $this->error('Error during dispatch: ' . $e->getMessage());
            http_response_code(500);
            echo "Internal Server Error";
        }
    }

    private function process_uri(): void
    {
        $uri = $this->raw_uri;

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);
        $uri = rtrim($uri, '/') ?: '/';

        $this->uri = $uri;
    }

    private function get_endpoints(): array
    {
        $routes = [];
        $endpoint_dir = ROOT_PATH . '/src/endpoints';

        $files = glob($endpoint_dir . '/*.php');

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $path = "/cmss/$name";
            $endpoint = "endpoints/$name.php";

            $routes[] = ['GET', $path, $endpoint];
            $routes[] = ['POST', $path, $endpoint];
        }

        $routes[] = ['GET', "/cmss", "/endpoints/dashboard.php"];
        $routes[] = ['POST', "/cmss", "/endpoints/dashboard.php"];

        $front_page = Settings::getInstance()->get_front_page();

        foreach (cmss_pages() as $page) {
            $template = cmss_template($page['template_id']);
            $handler = "/../templates/" . url_format($template['title']) . ".php";
            
            if ($page['page_id'] == $front_page) {
                $routes[] = ['GET', "/", $handler];
                $routes[] = ['POST', "/", $handler];
            } else {
                $routes[] = ['GET', "/" . $page['url'], $handler];
                $routes[] = ['POST', "/" . $page['url'], $handler];
            }
        }

        return $routes;
    }

    private function create_dispatcher(): Dispatcher
    {
        return simpleDispatcher(function (RouteCollector $r) {
            foreach ($this->get_endpoints() as [$method, $path, $handler]) {
                $r->addRoute($method, $path, $handler);
            }
        });
    }

    public function dispatch_routes(): void
    {
        $dispatcher = $this->create_dispatcher();
        $routeInfo = $dispatcher->dispatch($this->request_method, $this->uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                $this->error("Route not found: {$this->uri}");
                echo "404 Not Found";
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                http_response_code(405);
                header('Allow: ' . implode(', ', $allowedMethods));
                $this->error("Method not allowed: {$this->request_method} for {$this->uri}");
                echo "405 Method Not Allowed";
                break;

            case Dispatcher::FOUND:
                $this->log("Route found: {$this->request_method} {$this->uri}");
                $this->load_endpoint($routeInfo);
                break;
        }
    }

    private function load_head()
    {
        $head = ROOT_PATH . '/src/partials/head.php';
        include $head;
    }

    private function load_tail()
    {
        $tail = ROOT_PATH . '/src/partials/tail.php';
        include $tail;
    }

    public function redirect(string $url): void
    {
        if (!headers_sent()) {
            header("Location: $url");
        } else {
            echo "<script>window.location.href = '$url';</script>";
        }
        exit;
    }

    private function is_ajax_request(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function load_endpoint(array $routeInfo): void
    {
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $file = ROOT_PATH . '/src/' . ltrim($handler, '/\\');

        if (is_file($file)) {
            try {
                $ajax = $this->is_ajax_request();

                if (!$ajax) {
                    $this->load_head();
                }

                include $file;

                if (!$ajax) {
                    $this->load_tail();
                }
            } catch (\Throwable $e) {
                $this->error("Error loading endpoint $handler: " . $e->getMessage());
                http_response_code(500);
                echo "Internal Server Error";
            }
        } else {
            $this->error("Handler file not found: $file");
            http_response_code(500);
            echo "Handler file not found: $file";
        }
    }
}
