<?php

namespace App\Validators;

use App\Caches\Article as ArticleCache;
use App\Caches\MaxArticleId as MaxArticleIdCache;
use App\Exceptions\BadRequest as BadRequestException;
use App\Library\Validators\Common as CommonValidator;
use App\Models\Article as ArticleModel;
use App\Repos\Article as ArticleRepo;

class Article extends Validator
{

    /**
     * @param int $id
     * @return ArticleModel
     * @throws BadRequestException
     */
    public function checkArticleCache($id)
    {
        $this->checkId($id);

        $articleCache = new ArticleCache();

        $article = $articleCache->get($id);

        if (!$article) {
            throw new BadRequestException('article.not_found');
        }

        return $article;
    }

    public function checkArticle($id)
    {
        $this->checkId($id);

        $articleRepo = new ArticleRepo();

        $article = $articleRepo->findById($id);

        if (!$article) {
            throw new BadRequestException('article.not_found');
        }

        return $article;
    }

    public function checkId($id)
    {
        $id = intval($id);

        $maxIdCache = new MaxArticleIdCache();

        $maxId = $maxIdCache->get();

        if ($id < 1 || $id > $maxId) {
            throw new BadRequestException('article.not_found');
        }
    }

    public function checkCategory($id)
    {
        $validator = new Category();

        return $validator->checkCategory($id);
    }

    public function checkTitle($title)
    {
        $value = $this->filter->sanitize($title, ['trim', 'string']);

        $length = kg_strlen($value);

        if ($length < 5) {
            throw new BadRequestException('article.title_too_short');
        }

        if ($length > 50) {
            throw new BadRequestException('article.title_too_long');
        }

        return $value;
    }

    public function checkCover($cover)
    {
        $value = $this->filter->sanitize($cover, ['trim', 'string']);

        if (!CommonValidator::url($value)) {
            throw new BadRequestException('article.invalid_cover');
        }

        return kg_cos_img_style_trim($value);
    }

    public function checkSummary($summary)
    {
        $value = $this->filter->sanitize($summary, ['trim', 'string']);

        $length = kg_strlen($value);

        if ($length > 255) {
            throw new BadRequestException('article.summary_too_long');
        }

        return $value;
    }

    public function checkContent($content)
    {
        $value = $this->filter->sanitize($content, ['trim']);

        $length = kg_strlen($value);

        if ($length < 10) {
            throw new BadRequestException('article.content_too_short');
        }

        if ($length > 30000) {
            throw new BadRequestException('article.content_too_long');
        }

        return $value;
    }

    public function checkSourceType($type)
    {
        if (!array_key_exists($type, ArticleModel::sourceTypes())) {
            throw new BadRequestException('article.invalid_source_type');
        }

        return (int)$type;
    }

    public function checkSourceUrl($url)
    {
        $url = $this->filter->sanitize($url, ['trim', 'string']);

        if (!CommonValidator::url($url)) {
            throw new BadRequestException('article.invalid_source_url');
        }

        return $url;
    }

    public function checkFeatureStatus($status)
    {
        if (!in_array($status, [0, 1])) {
            throw new BadRequestException('article.invalid_feature_status');
        }

        return $status;
    }

    public function checkPublishStatus($status)
    {
        if (!in_array($status, [0, 1])) {
            throw new BadRequestException('article.invalid_publish_status');
        }

        return $status;
    }

}
