<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $auth = service('authorization');

        // Roles
        $auth->createGroup('superadmin', 'Super-Administrators. The top of the food chain.');
        $auth->createGroup('admin', 'Administrators');
        $auth->createGroup('moderator', 'Moderators');
        $auth->createGroup('user', 'Everyday users.');
        $auth->createGroup('guest', 'Visitors who are not logged in.');

        // Permissions
        $auth->createPermission('post', 'Create new topics and reply to existing topics.');

        // Assign
        $auth->addPermissionToGroup('post', 'superadmin');
        $auth->addPermissionToGroup('post', 'admin');
        $auth->addPermissionToGroup('post', 'moderator');
        $auth->addPermissionToGroup('post', 'user');
    }
}
