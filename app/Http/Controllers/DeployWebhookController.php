<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

class DeployWebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $expectedSecret = SiteSetting::getByKey('deploy_secret', 'gasua_deploy_token_99');
        $providedSecret = $request->query('secret') ?? $request->header('X-Deploy-Secret');

        if (empty($providedSecret) || $providedSecret !== $expectedSecret) {
            return response()->json(['success' => false, 'message' => 'Unauthorized deployment token.'], 403);
        }

        $basePath = base_path();
        $logs = [];

        try {
            // 1. Git pull
            $gitResult = Process::path($basePath)->run('git pull origin main 2>&1');
            $logs[] = "GIT PULL:\n" . $gitResult->output();

            // 2. Run Database Migrations
            Artisan::call('migrate', ['--force' => true]);
            $logs[] = "MIGRATIONS:\n" . Artisan::output();

            // 3. Clear Caches
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            $logs[] = "CACHE CLEARED";

            // 4. Storage Link check
            if (!file_exists(public_path('storage'))) {
                Artisan::call('storage:link');
            }

            return response()->json([
                'success' => true,
                'message' => 'Shared hosting code pull & migrations executed successfully.',
                'logs' => $logs,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Deployment failure: ' . $e->getMessage(),
            ], 500);
        }
    }
}
