<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Exception;

class ImportSqlCommand extends Command
{
    protected $signature = 'import:sql
                            {path=database/sql : Папка с .sql файлами}
                            {--stop-on-error : Остановиться при первой ошибке}';

    protected $description = 'Импортирует .sql файлы из папки, с отключением внешних ключей и безопасным выполнением.';

    public function handle()
    {

    $path = base_path('database/sql'); // путь к папке с .sql файлами
        $orderFile = $path . '/order.txt'; // если есть — используем порядок

        $files = [];


            $files = glob($path . '/*.sql');
            sort($files, SORT_NATURAL);


        if (empty($files)) {
            echo "❌ Нет файлов для импорта в {$path}\n";
            exit(1);
        }

        $driver = DB::getDriverName();
        $isPostgres = $driver === 'pgsql';

// === Отключаем внешние ключи ===
        if ($isPostgres) {
            DB::statement('SET session_replication_role = replica;');
            echo "🔧 Отключены проверки FK (PostgreSQL)\n";
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            echo "🔧 Отключены проверки FK (MySQL)\n";
        }

// === Импорт файлов ===
        foreach ($files as $file) {
            $name = basename($file);
            echo "→ Импорт: {$name} ... ";
            $sql = trim(file_get_contents($file));

            if ($sql === '') {
                echo "пропущен (пустой)\n";
                continue;
            }

            try {
                DB::unprepared($sql);
                echo "OK\n";
            } catch (Throwable $e) {
                echo "Ошибка: {$e->getMessage()}\n";
            }
        }

// === Включаем внешние ключи обратно ===
        if ($isPostgres) {
            DB::statement('SET session_replication_role = DEFAULT;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        echo "✅ Проверки FK включены обратно. Импорт завершён.\n";

    }
}
