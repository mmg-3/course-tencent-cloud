<?php

namespace App\Repos;

use App\Library\Paginator\Adapter\QueryBuilder as PagerQueryBuilder;
use App\Models\Consult as ConsultModel;
use App\Models\ConsultLike as ConsultLikeModel;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\ResultsetInterface;

class Consult extends Repository
{

    public function paginate($where = [], $sort = 'latest', $page = 1, $limit = 15)
    {
        $builder = $this->modelsManager->createBuilder();

        $builder->from(ConsultModel::class);

        $builder->where('1 = 1');

        if (!empty($where['id'])) {
            $builder->andWhere('id = :id:', ['id' => $where['id']]);
        }

        if (!empty($where['course_id'])) {
            $builder->andWhere('course_id = :course_id:', ['course_id' => $where['course_id']]);
        }

        if (!empty($where['owner_id'])) {
            $builder->andWhere('owner_id = :owner_id:', ['owner_id' => $where['owner_id']]);
        }

        if (isset($where['private'])) {
            $builder->andWhere('private = :private:', ['private' => $where['private']]);
        }

        if (isset($where['published'])) {
            $builder->andWhere('published = :published:', ['published' => $where['published']]);
        }

        if (isset($where['deleted'])) {
            $builder->andWhere('deleted = :deleted:', ['deleted' => $where['deleted']]);
        }

        switch ($sort) {
            case 'priority':
                $orderBy = 'priority ASC, id DESC';
                break;
            default:
                $orderBy = 'id DESC';
                break;
        }

        $builder->orderBy($orderBy);

        $pager = new PagerQueryBuilder([
            'builder' => $builder,
            'page' => $page,
            'limit' => $limit,
        ]);

        return $pager->paginate();
    }

    /**
     * @param int $id
     * @return ConsultModel|Model|bool
     */
    public function findById($id)
    {
        return ConsultModel::findFirst($id);
    }

    /**
     * @param array $ids
     * @param array|string $columns
     * @return ResultsetInterface|Resultset|ConsultModel[]
     */
    public function findByIds($ids, $columns = '*')
    {
        return ConsultModel::query()
            ->columns($columns)
            ->inWhere('id', $ids)
            ->execute();
    }

    /**
     * @param int $chapterId
     * @param int $userId
     * @return ConsultModel|Model|bool
     */
    public function findUserLastChapterConsult($chapterId, $userId)
    {
        return ConsultModel::findFirst([
            'conditions' => 'chapter_id = ?1 AND owner_id = ?2 AND deleted = 0',
            'bind' => [1 => $chapterId, 2 => $userId],
            'order' => 'id DESC',
        ]);
    }

    public function countConsults()
    {
        return (int)ConsultModel::count(['conditions' => 'deleted = 0']);
    }

    public function countLikes($consultId)
    {
        return (int)ConsultLikeModel::count([
            'conditions' => 'consult_id = :consult_id: AND deleted = 0',
            'bind' => ['consult_id' => $consultId],
        ]);
    }

}