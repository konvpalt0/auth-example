<?php

if ($request == '/users') {
    $scriptAssets[] = '/assets/js/users-list-component.js';
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

    array_push($scriptAssets, '/assets/js/user-edit-component.js');
    array_push($scriptAssets, '/assets/js/user-edit-reducer.js');

    include 'layout.php';

    die();
}

if ($request == '/api/users') {
    if ($requestMethod == 'GET') {
        $limit = filter_var($_GET["limit"], FILTER_VALIDATE_INT);
        $page = filter_var($_GET["page"], FILTER_VALIDATE_INT);
        echo json_encode(getUsers($limit, $page));
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

        if (!empty($_FILES)) {
            $folder = "/home/konvpalto/PhpstormProjects/auth-example/uploads";
            $file_path = upload_image($_FILES["picture"], $folder);
            $file_path_exploded = explode('/', $file_path);
            $file_name = $file_path_exploded[count($file_path_exploded) - 1];
            $file_url = "http://auth.ru/uploads/".$file_name;
            $attributes["image"] = $file_url;
        }

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
