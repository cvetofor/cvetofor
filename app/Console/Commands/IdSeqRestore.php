<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class IdSeqRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:id_seq_restore {--print}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        if ($this->option('print')) {
            $this->print();
        } else {
            $this->_run();
        }

        return Command::SUCCESS;
    }

    public function print()
    {
        $tables = \DB::select('SELECT * FROM pg_catalog.pg_tables    WHERE schemaname != \'pg_catalog\' AND         schemaname != \'information_schema\';');
        $result = '';
        foreach ($tables as $key => $t) {
            $array = get_object_vars($t);
            $table = $array['schemaname'].'.'.$array['tablename'];

            $result .= "SELECT MAX(id) FROM ${table};
                SELECT nextval('${table}_id_seq');
                BEGIN;
                LOCK TABLE ${table} IN EXCLUSIVE MODE;
                SELECT setval('${table}_id_seq', COALESCE((SELECT MAX(id)+1 FROM ${table}), 1), false);
                COMMIT;";
        }

        $this->info($result);
    }

    public function _run()
    {
        $tables = \DB::select('SELECT * FROM pg_catalog.pg_tables    WHERE schemaname != \'pg_catalog\' AND         schemaname != \'information_schema\';');
        $result = '';
        foreach ($tables as $key => $t) {
            $result = '';
            $array = get_object_vars($t);
            $table = $array['schemaname'].'.'.$array['tablename'];

            $result .= "SELECT MAX(id) FROM ${table};


            -- Then run...
            -- This should be higher than the last result.
            SELECT nextval('${table}_id_seq');

            -- If it's not higher... run this set the sequence last to your highest id.
            -- (wise to run a quick pg_dump first...)

            BEGIN;
            -- protect against concurrent inserts while you update the counter
            LOCK TABLE ${table} IN EXCLUSIVE MODE;
            -- Update the sequence
            SELECT setval('${table}_id_seq', COALESCE((SELECT MAX(id)+1 FROM ${table}), 1), false);
            COMMIT;";

            try {
                \DB::raw($result);
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
            }
        }
    }
}
