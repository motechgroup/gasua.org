<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SiteSetting;

class CmsSettingsManager extends Component
{
    public $site_name = '';
    public $contact_email = '';
    public $contact_phone = '';
    public $impact_meals = 25400;
    public $impact_children = 380;
    public $impact_trees = 12500;
    public $impact_talents = 150;

    public $saved = false;

    public function mount()
    {
        $this->site_name = SiteSetting::getByKey('site_name', 'Gusii All Stars Foundation');
        $this->contact_email = SiteSetting::getByKey('contact_email', 'info@gusiiallstars.org');
        $this->contact_phone = SiteSetting::getByKey('contact_phone', '+254700123456');
        $this->impact_meals = SiteSetting::getByKey('impact_meals_served', 25400);
        $this->impact_children = SiteSetting::getByKey('impact_children_sponsored', 380);
        $this->impact_trees = SiteSetting::getByKey('impact_trees_planted', 12500);
        $this->impact_talents = SiteSetting::getByKey('impact_talents_nurtured', 150);
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

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.admin.cms-settings-manager')
            ->layout('components.layouts.admin', ['headerTitle' => 'CMS & Foundation Settings']);
    }
}
