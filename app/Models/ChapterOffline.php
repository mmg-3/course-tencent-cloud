<?php

namespace App\Models;

class ChapterOffline extends Model
{

    /**
     * 主键编号
     *
     * @var int
     */
    public $id = 0;

    /**
     * 课程编号
     *
     * @var int
     */
    public $course_id = 0;

    /**
     * 章节编号
     *
     * @var int
     */
    public $chapter_id = 0;

    /**
     * 开始时间
     *
     * @var int
     */
    public $start_time = 0;

    /**
     * 结束时间
     *
     * @var int
     */
    public $end_time = 0;

    /**
     * 创建时间
     *
     * @var int
     */
    public $create_time = 0;

    /**
     * 更新时间
     *
     * @var int
     */
    public $update_time = 0;

    public function getSource(): string
    {
        return 'kg_chapter_offline';
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