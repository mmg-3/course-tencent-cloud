<?php

namespace App\Models;

class ReviewLike extends Model
{

    /**
     * 主键编号
     *
     * @var int
     */
    public $id = 0;

    /**
     * 评价编号
     *
     * @var int
     */
    public $review_id = 0;

    /**
     * 用户编号
     *
     * @var int
     */
    public $user_id = 0;

    /**
     * 创建时间
     *
     * @var int
     */
    public $create_time = 0;

    public function getSource(): string
    {
        return 'kg_review_like';
    }

    public function beforeCreate()
    {
        $this->create_time = time();
    }

}