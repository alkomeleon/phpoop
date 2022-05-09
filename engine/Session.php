<?php

namespace app\engine;
use app\engine\{Db, App};
use app\models\entities\Session as SessionEntity;

class Session
{
    protected $session;
    protected $user = null;
    protected $cookie_name = null;

    public function __construct()
    {
        $this->cookie_name = App::call()->config['COOKIE_NAME'];
        if (!$this->getSession()) {
            $this->startSession();
        }
    }

    protected function getSession()
    {
        if (
            array_key_exists($this->cookie_name, $_COOKIE) and
            $_COOKIE[$this->cookie_name] != ''
        ) {
            $session = App::call()->sessionRepository->getWhere(
                'key',
                $_COOKIE[$this->cookie_name]
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
                    $user = App::call()->userRepository->getOne(
                        $session->user_id
                    );
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
        App::call()->sessionRepository->insert($this->session);
        setcookie($this->cookie_name, $session_key, ['httponly' => true]);
    }

    public function auth($login, $password, $remember)
    {
        $user = App::call()->userRepository->getWhere('login', $login);
        if (password_verify($password, $user->password)) {
            $this->session->user_id = $user->id;
            if ($remember) {
                $expires = time() + 60 * 60 * 24 * 7;
                $this->session->expires = $expires;
                setcookie($this->cookie_name, $this->session->key, [
                    'expires' => $expires,
                    'httponly' => true,
                ]);
            } else {
                setcookie($this->cookie_name, $this->session->key, [
                    'httponly' => true,
                ]);
            }
            App::call()->sessionRepository->save($this->session);
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
        App::call()->sessionRepository->save($this->session);
        $this->user = null;
        unset($_COOKIE[$this->cookie_name]);
        setcookie($this->cookie_name, '', time() - 3600);
    }
}
