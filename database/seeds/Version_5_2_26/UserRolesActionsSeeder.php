<?php
namespace CoasterCmsDatabase\Seeds\Version_5_2_26;

use Carbon\Carbon;
use CoasterCms\Models\AdminAction;
use CoasterCms\Models\UserRole;
use CoasterCms\Models\UserRoleAction;
use Illuminate\Database\Seeder;

class UserRolesActionsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = new Carbon;
        $userRoleIds = UserRole::idsByName();
        $controllerActionsIds = AdminAction::idsByControllerAction();

        if (!empty($userRoleIds['Coaster Admin'])) {
            UserRoleAction::insert([
                [
                    'role_id' => $userRoleIds['Coaster Admin'],
                    'action_id' => $controllerActionsIds['themes']['list'],
                    'created_at' => $date,
                    'updated_at' => $date
                ],
                [
                    'role_id' => $userRoleIds['Coaster Admin'],
                    'action_id' => $controllerActionsIds['themes']['export'],
                    'created_at' => $date,
                    'updated_at' => $date
                ]
            ]);
        }
    }

}