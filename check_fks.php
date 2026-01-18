<?php
$output = "";
try {
    $pdo = new PDO('sqlite:database/database.sqlite');
    $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $fks = $pdo->query("PRAGMA foreign_key_list($table)")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($fks as $fk) {
            $output .= "Table [$table] references [" . $fk['table'] . "] via column [" . $fk['from'] . "] pointing to [" . $fk['to'] . "]. On Delete: [" . $fk['on_delete'] . "]\n";
        }
    }
} catch (Exception $e) {
    $output .= "Error: " . $e->getMessage();
}
file_put_contents('fk_all_results.txt', $output);
echo "Done! Results written to fk_all_results.txt\n";
