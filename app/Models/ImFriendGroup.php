<?php

namespace App\Models;

use Phalcon\Mvc\Model\Behavior\SoftDelete;

class ImFriendGroup extends Model
{

    /**
     * 主键编号
     *
     * @var int
     */
    public $id;

    /**
     * 名称
     *
     * @var string
     */
    public $name;

    /**
     * 优先级
     *
     * @var int
     */
    public $priority;

    /**
     * 状态
     *
     * @var int
     */
    public $deleted;

    /**
     * 成员数
     *
     * @var int
     */
    public $user_count;

    /**
     * 创建时间
     *
     * @var int
     */
    public $create_time;

    /**
     * 更新时间
     *
     * @var int
     */
    public $update_time;

    public function getSource(): string
    {
        return 'kg_im_friend_group';
    }

    public function initialize()
    {
        parent::initialize();

        $this->addBehavior(
            new SoftDelete([
                'field' => 'deleted',
                'value' => 1,
            ])
        );
    }

    public function beforeCreate()
    {
        $this->create_time = time();
    }

    public function beforeUpdate()
    {
        $this->update_time = time();
    }

}
