<?php

use yii\db\Migration;
use common\models\User;

class m170324_123836_init_users extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;
        $roleUser = $auth->getRole('user');
        $roleModerator = $auth->getRole('moderator');
        $roleAdmin = $auth->getRole('admin');

        /* Admin */
        $admin = new User([
            'username' => 'admin',
            'email' => 'admin@youch.me',
            'status' => User::STATUS_ACTIVE
        ]);
        $admin->setPassword('12341234');
        $admin->generateAuthKey();
        $admin->generatePasswordResetToken();
        if($admin->save()) $auth->assign($roleAdmin, $admin->id);

        /* Moderator */
        $moderator = new User([
            'username' => 'moderator',
            'email' => 'moderator@youch.me',
            'status' => User::STATUS_ACTIVE
        ]);
        $moderator->setPassword('12341234');
        $moderator->generateAuthKey();
        $moderator->generatePasswordResetToken();
        if($moderator->save()) $auth->assign($roleModerator, $moderator->id);

        /* User */
        $user = new User([
            'username' => 'user',
            'email' => 'user@youch.me',
            'status' => User::STATUS_ACTIVE
        ]);
        $user->setPassword('12341234');
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        if($user->save()) $auth->assign($roleUser, $user->id);
    }

    public function down()
    {
        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
