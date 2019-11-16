<?php
namespace app\rbac;

use app\models\User;
use Yii;
use \yii\rbac\Rule;

class UserRoleRule extends Rule
{
    public $name = 'userRole';

    /**
     * @param int $user User id
     * @param \yii\rbac\Item $item
     * @param array $params
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->role;

            if ($item->name === User::ROLE_ADMIN) {
                return $role == User::ROLE_ADMIN;
            } elseif ($item->name === User::ROLE_USER) {
                return $role == User::ROLE_USER || $role == User::ROLE_USER;
            }
        }
        return false;
    }
}