<?php

namespace App\Validators;

use App\Exceptions\BadRequest as BadRequestException;
use App\Models\Refund as RefundModel;
use App\Repos\Refund as RefundRepo;

class Refund extends Validator
{

    public function checkRefund($id)
    {
        $tradeRepo = new RefundRepo();

        $trade = $tradeRepo->findById($id);

        if (!$trade) {
            throw new BadRequestException('refund.not_found');
        }

        return $trade;
    }

    public function checkReviewStatus($status)
    {
        $list = [RefundModel::STATUS_APPROVED, RefundModel::STATUS_REFUSED];

        if (!in_array($status, $list)) {
            throw new BadRequestException('refund.invalid_review_status');
        }

        return $status;
    }

    public function checkApplyNote($note)
    {
        $value = $this->filter->sanitize($note, ['trim', 'string']);

        $length = kg_strlen($value);

        if ($length < 2) {
            throw new BadRequestException('refund.apply_note_too_short');
        }

        if ($length > 255) {
            throw new BadRequestException('refund.apply_note_too_long');
        }

        return $value;
    }

    public function checkReviewNote($note)
    {
        $value = $this->filter->sanitize($note, ['trim', 'string']);

        $length = kg_strlen($value);

        if ($length < 2) {
            throw new BadRequestException('refund.review_note_too_short');
        }

        if ($length > 255) {
            throw new BadRequestException('refund.review_note_too_long');
        }

        return $value;
    }

    public function checkIfAllowReview($refund)
    {
        if ($refund->status != RefundModel::STATUS_PENDING) {
            throw new BadRequestException('refund.review_not_allowed');
        }
    }

}