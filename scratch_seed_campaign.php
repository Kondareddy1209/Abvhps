
<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\FundraisingCampaign;

// Ensure cover image exists
$coverDir = storage_path('app/public/campaigns/covers');
if (!is_dir($coverDir)) {
    mkdir($coverDir, 0777, true);
}
copy(public_path('images/logo_abvhps.png'), $coverDir . '/temple_renovation.png');

$campaign = FundraisingCampaign::firstOrCreate(
    ['title' => 'TEMPLE RENOVATION & VEDA PATHASHALA SEVA'],
    [
        'description' => 'Sacred initiative dedicated to the restoration of ancient heritage temples, establishing Vedic learning centers for rural youth, and supporting daily Annadanam seva across Andhra Pradesh.',
        'target_amount' => 500000.00,
        'raised_amount' => 145000.00,
        'end_date' => '2026-12-31',
        'cover_image' => 'campaigns/covers/temple_renovation.png',
        'status' => 'active'
    ]
);

echo "Campaign ID: " . $campaign->id . " | Title: " . $campaign->title . "\n";
