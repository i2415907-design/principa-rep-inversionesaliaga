<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$schema = \DB::select('DESCRIBE avisos');
foreach ($schema as $col) {
    echo $col->Field . "\t" . $col->Type . "\n";
}
