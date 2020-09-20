<?php

define('USERS_FILE', "users-file.json");

function createUser($login, $password)
{
    $users = getUsers();
    $uuid = gen_uuid();
    $users[] = ["login" => $login, "password" => $password, "uuid" => $uuid, "active" => true];
    file_put_contents(USERS_FILE, json_encode($users));
    return $uuid;
}

function editUser($uuid, $attributes)
{
    $users = array_map(function($user) use($uuid, $attributes) {
        if ($user['uuid'] == $uuid) {
            return array_merge($user, $attributes);
        } else {
            return $user;
        }
    }, getUsers());

    file_put_contents(USERS_FILE, json_encode($users));
}

function deleteUser($uuid)
{
    editUser($uuid, ["active" => false]);
}

function getUser($uuid)
{
    foreach (getUsers() as $user) {
        if ($user['uuid'] == $uuid) {
            return $user;
        }
    }
    http_response_code('404');
    return null;
}

function getUsers($limit, $page)
{
    if (file_exists(USERS_FILE)) {
        $result = json_decode(file_get_contents(USERS_FILE), true);
        $result = array_slice($result, $page * $limit, $limit);
        return $result;
    }
    throw new Error('users-file not exist');

}
