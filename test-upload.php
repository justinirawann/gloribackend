<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$service = App\Models\Service::find(2);
if ($service) {
    echo "Service: {$service->name}\n";
    echo "Banner: {$service->banner_image}\n";
    echo "Banner exists: " . ($service->banner_image ? 'YES' : 'NO') . "\n";
} else {
    echo "Service ID 2 not found\n";
}
