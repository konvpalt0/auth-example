<?php

if ($request == '/users') {
    $scriptAssets[] = '/assets/js/users-component.js';
    include 'layout.php';

    die();
}

if ($request == '/users/create') {
    $scriptAssets[] = '/assets/js/users-create-component.js';
    $scriptAssets[] = '/assets/js/users-create-reducer.js';
    include 'layout.php';

    die();
}

if (startsWith($request, '/users/')) {
    $path = explode('/', $request);
    $userUuid = $path[count($path) - 1];

    $user = getUser($userUuid);

    array_push($scriptAssets, '/assets/js/user-card-component.js');
    array_push($scriptAssets, '/assets/js/user-card-reducer.js');

    include 'layout.php';

    die();
}

if ($request == '/api/users') {
    if ($requestMethod == 'GET') {
        echo json_encode(getUsers());
        die();
    }

    if ($requestMethod == 'POST') {
        $login = filter_var($_POST["login"], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        $password = password_hash($password, PASSWORD_BCRYPT);
        echo createUser($login, $password);
        die();
    }
}

if (startsWith($request, '/api/users/')) {
    $path = explode('/', $request);
    $userUuid = $path[count($path) - 1];
    $user = getUser($userUuid);

    if (is_null($user)) {
        http_response_code('404');
        die();
    }

    if ($requestMethod == 'GET') {
        echo json_encode(getUser($userUuid));
        die();
    }

    if ($requestMethod == 'POST') {
        $login = filter_var($_POST["login"], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
        $active = filter_var($_POST['active'], FILTER_SANITIZE_STRING);

        $attributes = [];

        if (!empty($login)) {
            $attributes['login'] = $login;
        }

        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $attributes['password'] = $password;
        }

        if (!empty($active)) {
            $active = true;
        } else {
            $active = false;
        }
        $attributes['active'] = $active;

        editUser($userUuid, $attributes);

        die();
    }

    if ($requestMethod == 'DELETE') {
        deleteUser($userUuid);
    }

    echo json_encode($users);
    die();
}
