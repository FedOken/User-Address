<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\UserRoleRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $rule = new UserRoleRule();
        $auth->add($rule);

        $admin = $auth->createRole('admin');
        $admin->ruleName = $rule->name;
        $auth->add($admin);

        $user = $auth->createRole('user');
        $user->ruleName = $rule->name;
        $auth->add($user);

        $auth->addChild($admin,$user);
    }
}