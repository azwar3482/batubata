<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\JobListing;
use App\Services\DynamicCompetencyService;

$job = JobListing::find(26);
echo "Job: {$job->title}\n";
echo "Required skills: " . json_encode($job->required_skills) . "\n\n";

$service = app(DynamicCompetencyService::class);
$competencies = $service->generateFromJobListing($job);

echo "Generated " . $competencies->count() . " competencies:\n";
foreach ($competencies as $comp) {
    echo "  - [{$comp->category}] {$comp->name} (id: {$comp->id})\n";
}
