<?php

namespace Modules\FieldService\Database\Seeders;

use App\Models\Role;
use Database\Factories\FeaturePermissionFactory;
use Database\Factories\RolePermissionFactory;
use Illuminate\Database\Seeder;
use Modules\FieldService\Entities\FsSettings;

class FieldServiceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermissionFactory = new RolePermissionFactory;
        $featurePermissionFactory = new FeaturePermissionFactory;

        $standardPermission = ['view', 'create', 'update', 'delete'];
        $featurePermission = ['upload', 'activity', 'import'];

        $campaignPermissions = [...$standardPermission, ...$featurePermission];
        $fpf = $featurePermissionFactory->createFeatureWithPermissions(['campaign'], $campaignPermissions);

        $attendancePermissions = ['view', 'check_in', 'check_out'];
        $fpf = $featurePermissionFactory->createFeatureWithPermissions(['attendance'], $attendancePermissions);

        $questionnairePermissions = [...$standardPermission, 'use'];
        $fpf = $featurePermissionFactory->createFeatureWithPermissions(['questionnaire'], $questionnairePermissions);

        $campaignReportPermissions = ['view'];
        $fpf = $featurePermissionFactory->createFeatureWithPermissions(['campaign report'], $campaignReportPermissions);

        $campaignReportPermissions = ['update'];
        $fpf = $featurePermissionFactory->createFeatureWithPermissions(['campaign setting'], $campaignReportPermissions);
        // if($fpf){
        $defaultRole = Role::where('name', 'Administrator')->first();
        $rolePermissionFactory->attachPermissions($defaultRole);
        // }
        $this->fsSettingsSeeder();
    }

    public function fsSettingsSeeder()
    {
        $this->checkAndSetSetting('isUseCart', false);
        $this->checkAndSetSetting('selectUom', true);
        $this->checkAndSetSetting('selectPkg', false);
    }

    public function checkAndSetSetting($key, $value)
    {
        $isExist = FsSettings::where('key', $key)->exists();
        if (! $isExist) {
            $setting = FsSettings::create([
                'key' => $key,
                'value' => $value,
            ]);

            return $setting;
        } else {
            return true;
        }
    }
}
