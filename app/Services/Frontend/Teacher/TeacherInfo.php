<?php

namespace App\Services\Frontend\Teacher;

use App\Models\User as UserModel;
use App\Services\Frontend\Service;
use App\Services\Frontend\UserTrait;

class TeacherInfo extends Service
{

    use UserTrait;

    public function getUser($id)
    {
        $user = $this->checkUser($id);

        return $this->handleUser($user);
    }

    protected function handleUser(UserModel $user)
    {
        $user->avatar = kg_ci_img_url($user->avatar);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'title' => $user->title,
            'about' => $user->about,
            'location' => $user->location,
            'gender' => $user->gender,
            'vip' => $user->vip,
            'locked' => $user->locked,
        ];
    }

}