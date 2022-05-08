<?php

namespace app\engine;
use app\engine\Db;
use app\models\entities\Session as SessionEntity;
use app\models\repositories\{SessionRepository, UserRepository};

class Session
{
    protected $session;
    protected $user = null;

    public function __construct()
    {
        if (!$this->getSession()) {
            $this->startSession();
        }
    }

    protected function getSession()
    {
        if (
            array_key_exists(COOKIE_NAME, $_COOKIE) and
            $_COOKIE[COOKIE_NAME] != ''
        ) {
            $session = (new SessionRepository())->getWhere(
                'key',
                $_COOKIE[COOKIE_NAME]
            );
            if ($session) {
                if (
                    $session->expires != null and
                    intval($session->expires < time())
                ) {
                    return false;
                }
                $this->session = $session;
                if ($session->user_id != null) {
                    $user = (new UserRepository())->getOne($session->user_id);
                    $this->user = $user;
                }
                return true;
            }
        }
        return false;
    }

    protected function startSession()
    {
        $session_key = bin2hex(random_bytes(32));
        $this->session = new SessionEntity($session_key);
        (new SessionRepository())->insert($this->session);
        setcookie(COOKIE_NAME, $session_key, ['httponly' => true]);
    }

    public function auth($login, $password, $remember)
    {
        $user = (new UserRepository())->getWhere('login', $login);
        if (password_verify($password, $user->password)) {
            $this->session->user_id = $user->id;
            if ($remember) {
                $expires = time() + 60 * 60 * 24 * 7;
                $this->session->expires = $expires;
                setcookie(COOKIE_NAME, $this->session->key, [
                    'expires' => $expires,
                    'httponly' => true,
                ]);
            } else {
                setcookie(COOKIE_NAME, $this->session->key, [
                    'httponly' => true,
                ]);
            }
            (new SessionRepository())->save($this->session);
            $this->user = $user;
            return true;
        }
        return false;
    }

    public function getKey()
    {
        return $this->session->key;
    }

    public function getId()
    {
        return $this->session->id;
    }

    public function getLogin()
    {
        return $this->user->login;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function isAuthenticated()
    {
        return isset($this->user);
    }

    public function destroy()
    {
        $this->session->expires = 0;
        (new SessionRepository())->save($this->session);
        $this->user = null;
        unset($_COOKIE[COOKIE_NAME]);
        setcookie(COOKIE_NAME, '', time() - 3600);
    }
}
