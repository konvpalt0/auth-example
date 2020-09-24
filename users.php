<?php

define('USERS_FILE', "users-file.json");

function createUser($login, $password) {
    $pdo = getConnection();
    $statement = $pdo->prepare("insert into users(login, password) values(?, ?) returning *");
    $statement->execute([$login, password_hash($password, PASSWORD_BCRYPT)]);
    return $statement->fetch();
}

function editUser($user, $attributes) {
    $pdo = getConnection();

    $login = $attributes["login"] ?? $user["login"];
    $password = $attributes["password"] ?? $user["password"];
    $password = password_hash($password, PASSWORD_BCRYPT);
    $active = $attributes["active"] ?? $user["active"];
    $image = $attributes["image"] ?? $user["image"];

    $statement = $pdo->prepare("update users set login = ?, password = ?, active = ? image = ? where id = ?");
    $statement->execute([$login, $password, $active, $image, $user["id"]]);
}

function deleteUser($uuid) {
    editUser($uuid, ["active" => false]);
}

function getUser($uuid) {
    $pdo = getConnection();
    $statement = $pdo->prepare("select * from users where id = ?");
    $statement->execute([$uuid]);
    var_dump($statement->fetch());
    die();
    return $statement->fetch();
}

function getUsers() {
    $pdo = getConnection();
    $statement = $pdo->prepare("select * from users limit ? offset ?");
    $limit = 5;
    $page = 0;
    $statement->execute([$limit, $page*$limit]);

    return $statement->fetchAll();
}

function findUser($login) {
    $db = getConnection();

    $statement = $db->prepare("select * from users where login = ?");
    $statement->execute([$login]);
    $user = $statement->fetch();
    if ($user === false) {
        return null;
    } else {
        return $user;
    }
}
