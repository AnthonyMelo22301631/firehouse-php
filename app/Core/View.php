<?php
namespace App\Core;

class View {
    public static function render(string $view, array $params = []): string {
        extract($params, EXTR_SKIP);
        ob_start();

        // ✅ Caminho corrigido — views fora da pasta "app"
        $file = __DIR__ . '/../../views/' . $view . '.php';

        if (!file_exists($file)) {
            http_response_code(404);
            echo "❌ View não encontrada: $file";
            return ob_get_clean();
        }

        require $file;
        return ob_get_clean();
    }
}
