<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c1 = App\Models\Miembro::where('categoria', 'Conquistador')->update(['categoria' => 'Conquistadores']);
echo "Conquistador -> Conquistadores: $c1\n";
$c2 = App\Models\Miembro::where('categoria', 'Castorsito')->update(['categoria' => 'Castorcitos']);
echo "Castorsito -> Castorcitos: $c2\n";

unlink(__FILE__);
echo "Done\n";
