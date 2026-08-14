<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CmsSettingsManager extends Component
{
    public $site_name = '';
    public $contact_email = '';
    public $contact_phone = '';
    public $impact_meals = 25400;
    public $impact_children = 380;
    public $impact_trees = 12500;
    public $impact_talents = 150;
    public $deploy_secret = '';

    public $saved = false;
    public $deployOutput = '';
    public $isDeploying = false;

    // Git Status Metadata
    public $branchName = 'main';
    public $latestCommitHash = '';
    public $latestCommitMessage = '';
    public $latestCommitAuthor = '';
    public $latestCommitDate = '';
    public $modifiedFiles = [];

    public function mount()
    {
        $this->site_name = SiteSetting::getByKey('site_name', 'Gusii All Stars Foundation');
        $this->contact_email = SiteSetting::getByKey('contact_email', 'info@gusiiallstars.org');
        $this->contact_phone = SiteSetting::getByKey('contact_phone', '+254700123456');
        $this->impact_meals = SiteSetting::getByKey('impact_meals_served', 25400);
        $this->impact_children = SiteSetting::getByKey('impact_children_sponsored', 380);
        $this->impact_trees = SiteSetting::getByKey('impact_trees_planted', 12500);
        $this->impact_talents = SiteSetting::getByKey('impact_talents_nurtured', 150);
        $this->deploy_secret = SiteSetting::getByKey('deploy_secret', 'gasua_deploy_token_99');

        $this->fetchGitStatus();
    }

    public function fetchGitStatus()
    {
        // Cache GitHub API response for 5 minutes to prevent shared hosting outbound HTTP spikes
        $data = Cache::remember('github_commit_status', 300, function () {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Gusii-Foundation-Deployer',
                ])->timeout(3)->get('https://api.github.com/repos/motechgroup/gasua.org/commits/main');

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                // Fallback silently if offline or blocked
            }
            return null;
        });

        if ($data) {
            $this->latestCommitHash = substr($data['sha'] ?? '', 0, 7);
            $this->latestCommitMessage = strtok($data['commit']['message'] ?? '', "\n");
            $this->latestCommitAuthor = $data['commit']['author']['name'] ?? 'Repository Admin';
            $this->latestCommitDate = date('Y-m-d H:i:s T', strtotime($data['commit']['author']['date'] ?? 'now'));

            $files = [];
            if (!empty($data['files'])) {
                foreach (array_slice($data['files'], 0, 6) as $f) {
                    $files[] = [
                        'name' => $f['filename'],
                        'status' => $f['status'] ?? 'modified',
                    ];
                }
            }
            $this->modifiedFiles = $files;
        }
    }

    public function saveSettings()
    {
        SiteSetting::setKey('site_name', $this->site_name);
        SiteSetting::setKey('contact_email', $this->contact_email);
        SiteSetting::setKey('contact_phone', $this->contact_phone);
        SiteSetting::setKey('impact_meals_served', $this->impact_meals);
        SiteSetting::setKey('impact_children_sponsored', $this->impact_children);
        SiteSetting::setKey('impact_trees_planted', $this->impact_trees);
        SiteSetting::setKey('impact_talents_nurtured', $this->impact_talents);
        SiteSetting::setKey('deploy_secret', $this->deploy_secret);

        $this->saved = true;
    }

    public function runGitPullAndMigrate()
    {
        // Increase time and memory limits for CloudLinux shared hosting
        @ini_set('memory_limit', '256M');
        @set_time_limit(120);

        $this->isDeploying = true;
        $this->deployOutput = "Starting deployment sync...\n";
        $this->deployOutput .= "Branch: origin/" . $this->branchName . "\n";
        if ($this->latestCommitHash) {
            $this->deployOutput .= "HEAD Commit: [" . $this->latestCommitHash . "] " . $this->latestCommitMessage . "\n\n";
        }

        try {
            $basePath = base_path();

            // 1. Git Pull or Status
            if (function_exists('exec')) {
                $gitResult = Process::path($basePath)->run('git pull origin main 2>&1');
                $this->deployOutput .= "[1/3] GIT PULL:\n" . $gitResult->output() . "\n";
            } else {
                $this->deployOutput .= "[1/3] DEPLOY STATUS:\n";
                $this->deployOutput .= "PHP exec() disabled on server. Latest Commit: [" . ($this->latestCommitHash ?: 'HEAD') . "] " . ($this->latestCommitMessage ?: 'Main Branch') . "\n\n";
            }

            // 2. Database Migrations
            Artisan::call('migrate', ['--force' => true]);
            $this->deployOutput .= "[2/3] MIGRATIONS:\n" . (Artisan::output() ?: "Database schema up to date.\n") . "\n";

            // 3. Clear Cache Lightweight
            Artisan::call('view:clear');
            $this->deployOutput .= "[3/3] CACHE CLEARED:\nView cache refreshed.\n\n";

            $this->deployOutput .= "✅ MIGRATION & SYNC TASK COMPLETED AT " . date('Y-m-d H:i:s T');
        } catch (\Exception $e) {
            $this->deployOutput .= "\n❌ ERROR: " . $e->getMessage();
        } finally {
            $this->isDeploying = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.cms-settings-manager')
            ->layout('components.layouts.admin', ['headerTitle' => 'CMS & Foundation Settings']);
    }
}
