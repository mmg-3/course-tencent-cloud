<?php

namespace App\Services\Logic\Account;

use App\Library\Utils\Password as PasswordUtil;
use App\Library\Validators\Common as CommonValidator;
use App\Models\Account as AccountModel;
use App\Models\ImUser as ImUserModel;
use App\Models\User as UserModel;
use App\Services\Logic\Service as LogicService;
use App\Validators\Account as AccountValidator;
use App\Validators\Verify as VerifyValidator;

class Register extends LogicService
{

    public function handle()
    {
        $post = $this->request->getPost();

        $verifyValidator = new VerifyValidator();

        $verifyValidator->checkCode($post['account'], $post['verify_code']);

        $accountValidator = new AccountValidator();

        $accountValidator->checkLoginName($post['account']);

        $data = [];

        if (CommonValidator::phone($post['account'])) {

            $data['phone'] = $accountValidator->checkPhone($post['account']);

            $accountValidator->checkIfPhoneTaken($post['account']);

        } elseif (CommonValidator::email($post['account'])) {

            $data['email'] = $accountValidator->checkEmail($post['account']);

            $accountValidator->checkIfEmailTaken($post['account']);
        }

        $data['password'] = $accountValidator->checkPassword($post['password']);

        $data['salt'] = PasswordUtil::salt();

        $data['password'] = PasswordUtil::hash($data['password'], $data['salt']);

        try {

            $this->db->begin();

            $account = new AccountModel();

            if ($account->create($data) === false) {
                throw new \RuntimeException('Create Account Failed');
            }

            $user = new UserModel();

            $user->id = $account->id;
            $user->name = "user_{$account->id}";

            if ($user->create() === false) {
                throw new \RuntimeException('Create User Failed');
            }

            $imUser = new ImUserModel();

            $imUser->id = $user->id;
            $imUser->name = $user->name;

            if ($imUser->create() === false) {
                throw new \RuntimeException('Create Im User Failed');
            }

            $this->db->commit();

            return $account;

        } catch (\Exception $e) {

            $this->db->rollback();

            $logger = $this->getLogger();

            $logger->error('Register Error ' . kg_json_encode([
                    'line' => $e->getLine(),
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ]));

            throw new \RuntimeException('sys.trans_rollback');
        }
    }

}
