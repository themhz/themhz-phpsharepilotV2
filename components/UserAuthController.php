<?php

namespace SharePilotV2\Components;

class UserAuthController {
    private $auth;

    public function __construct($db) {
        $this->auth = new UserAuth($db);
    }

    public function handleRequest() {
        // checking if a token cookie is set
        if (isset($_COOKIE['token'])) {

            // if the user has a token, authenticate them
            $user = $this->auth->authenticate();


            // if the token is invalid or expired, ask them to log in again
            if (!$user) {
                return ["userAuth"=> false, "message" =>"Session expired. Please log in again."];
            } else {
                $_SESSION["user"] = $user;
                return ["userAuth"=> true, "message" =>"Welcome back, {$user['email']}."];
            }
        } else {
            // if no token cookie is set, the user is not logged in
            // handle registration or login

            // handle registration
            if (isset($_POST['register'])) {
//                $email = $_POST['email'];
//                $password = $_POST['password'];

                $email = RequestHandler::get("register");
                $password = RequestHandler::get("password");

                if ($this->auth->register($email, $password)) {
                    return ["userAuth"=> false, "message" =>"Registration successful."];
                } else {
                    return ["userAuth"=> false, "message" =>"Registration failed."];
                }
            }


            // handle login
            if (RequestHandler::get("page")=="login") {
                $email = RequestHandler::get('email');
                $password = RequestHandler::get('password');

                if ($this->auth->login($email, $password)) {
                    return ["userAuth"=> true, "message" =>"Login successful."];
                } else {
                    return ["userAuth"=> false, "message" =>"Invalid email or password."];
                }
            }
        }

        return ["userAuth"=> false, "message" =>"Not authenticated."];
    }
}

