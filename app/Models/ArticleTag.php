<?php

namespace App\Models;

class ArticleTag extends Model
{

    /**
     * 主键编号
     *
     * @var int
     */
    public $id = 0;

    /**
     * 文章编号
     *
     * @var int
     */
    public $article_id = 0;

    /**
     * 标签编号
     *
     * @var int
     */
    public $tag_id = 0;

    /**
     * 创建时间
     *
     * @var int
     */
    public $create_time = 0;

    public function getSource(): string
    {
        return 'kg_article_tag';
    }

    public function beforeCreate()
    {
        $this->create_time = time();
    }

}