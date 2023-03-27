<?php

namespace lab3s34;

// TODO: add autoloader
require_once 'Request.php';
require_once 'Repository.php';
require_once 'User.php';
require_once 'UserNotFoundException.php';
require_once 'BadRequestException.php';

$request = \lab3s34\Request::createFromGlobals();

$repository = new \lab3s34\Repository();
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Прытков Д.О. ПИ-228БЗУ</title>
</head>
<body>

<?php if (!$request->isPostMethod()):?>
<form action="s3-4.php" method="post">
    <input type="text" name="login" placeholder="login" value="<?php echo $request->getString('login') ?>">
    <button type="submit">Войти</button>
</form>
<?php endif; ?>

<?php

if ($request->isPostMethod()) {
    $link = '<a href="s3-4.php">Вернуться</a>';

    try {
        $login = $request->getString('login');

        if ($login === null) {
            throw new BadRequestException('Ошибка: login is required field');
        }

        try {
            $user = $repository->getByLogin($login);
        } catch (UserNotFoundException $e) {
            throw new BadRequestException('Вы не зарегистрированный пользователь!');
        }

        echo "Здравствуйте, " . $user->getFIO() . '<br>' . $link;;
    } catch (BadRequestException $e) {
        echo $e->getMessage() . '<br>' . $link;
    }
}

?>

</body>
</html>
