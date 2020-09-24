<?php

$scriptAssets = [];

session_start();

$serverName = $_SERVER["HTTP_HOST"];
$documentRoot = $_SERVER["DOCUMENT_ROOT"];
$uploadFolder = $documentRoot."/uploads";
$request = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];

if (!isset($_SESSION["currentUser"]) && $request != "/login" && $request != "/auth") {
    header("Location: /login");
    die();
}

include "./db.php";
include "./utility.php";
include "./users.php";
include "./user-controller.php";

if ($request == "/login") {
    include "login.html";
    die();
}

if ($request == "/logout") {
    session_destroy();
    header("Location: /login");
    die();
}

if ($request == "/about") {
    $handlerRequest = function() {
        echo "about";
    };
    include "layout.php";
    die();
}

if ($request == "/profile") {
    $handlerRequest = function() {
        echo "profile";
    };
    include "layout.php";
    die();
}

if ($request == "/auth") {
    $login = filter_var($_POST["login"], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

    $user = findUser($login);

    if ($user["active"] && $user["login"] == $login && password_verify($password, $user["password"])) {
        $_SESSION["currentUser"] = $user;
    }

    header("Location: /");

    die();
}

if ($request == '/') {
    $handlerRequest = function() {
        echo $_SESSION["currentUser"]["login"];
    };
    include "layout.php";
    die();
}

http_response_code(404);

die();
