<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

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
        $this->isDeploying = true;
        $this->deployOutput = "Starting deployment process...\n";

        try {
            $basePath = base_path();

            // 1. Git pull (safely check if exec is allowed)
            if (function_exists('exec')) {
                $gitResult = Process::path($basePath)->run('git pull origin main 2>&1');
                $this->deployOutput .= "[1/4] GIT PULL:\n" . $gitResult->output() . "\n";
            } else {
                $this->deployOutput .= "[1/4] GIT PULL:\n(PHP exec() is disabled on this shared host. Migrations & cache clearing will run natively via PHP Artisan).\n\n";
            }

            // 2. Run Database Migrations natively via Artisan
            Artisan::call('migrate', ['--force' => true]);
            $this->deployOutput .= "[2/4] MIGRATIONS:\n" . Artisan::output() . "\n";

            // 3. Clear & Re-cache Configurations
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            $this->deployOutput .= "[3/4] CACHE CLEARED:\nConfiguration, views, and application cache refreshed.\n\n";

            // 4. Storage Link check
            if (!file_exists(public_path('storage'))) {
                if (function_exists('symlink')) {
                    Artisan::call('storage:link');
                    $this->deployOutput .= "[4/4] STORAGE LINK:\nPublic storage symlink created.\n";
                } else {
                    $this->deployOutput .= "[4/4] STORAGE LINK:\nSymlink function restricted.\n";
                }
            } else {
                $this->deployOutput .= "[4/4] STORAGE LINK:\nStorage link exists.\n";
            }

            $this->deployOutput .= "\n✅ DEPLOYMENT & MIGRATION TASK COMPLETED SUCCESSFULLY AT " . date('Y-m-d H:i:s T');
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
