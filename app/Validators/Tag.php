<?php

namespace App\Validators;

use App\Caches\MaxTagId as MaxTagIdCache;
use App\Caches\Tag as TagCache;
use App\Exceptions\BadRequest as BadRequestException;
use App\Models\Tag as TagModel;
use App\Repos\Tag as TagRepo;

class Tag extends Validator
{

    /**
     * @param int $id
     * @return TagModel
     * @throws BadRequestException
     */
    public function checkTagCache($id)
    {
        $this->checkId($id);

        $tagCache = new TagCache();

        $tag = $tagCache->get($id);

        if (!$tag) {
            throw new BadRequestException('tag.not_found');
        }

        return $tag;
    }

    public function checkTag($id)
    {
        $this->checkId($id);

        $tagRepo = new TagRepo();

        $tag = $tagRepo->findById($id);

        if (!$tag) {
            throw new BadRequestException('tag.not_found');
        }

        return $tag;
    }

    public function checkId($id)
    {
        $id = intval($id);

        $maxIdCache = new MaxTagIdCache();

        $maxId = $maxIdCache->get();

        if ($id < 1 || $id > $maxId) {
            throw new BadRequestException('tag.not_found');
        }
    }

    public function checkName($name)
    {
        $value = $this->filter->sanitize($name, ['trim', 'striptags']);

        $length = kg_strlen($value);

        if ($length < 2) {
            throw new BadRequestException('tag.name_too_short');
        }

        if ($length > 50) {
            throw new BadRequestException('tag.name_too_long');
        }

        return $value;
    }

    public function checkPriority($priority)
    {
        $value = $this->filter->sanitize($priority, ['trim', 'int']);

        if ($value < 1 || $value > 255) {
            throw new BadRequestException('tag.invalid_priority');
        }

        return $value;
    }

    public function checkPublishStatus($status)
    {
        if (!in_array($status, [0, 1])) {
            throw new BadRequestException('tag.invalid_publish_status');
        }

        return $status;
    }

    public function checkIfNameExists($name)
    {
        $tagRepo = new TagRepo();

        $tag = $tagRepo->findByName($name);

        if ($tag) {
            throw new BadRequestException('tag.name_existed');
        }
    }

}
