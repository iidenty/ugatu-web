<?php

namespace lab3s35;

require_once 'Request.php';
require_once 'Question.php';
require_once 'BadRequestException.php';

const QUESTION_ID_PREFIX = 'QUESTION_';

$request = \lab3s35\Request::createFromGlobals();

// QUESTION GENERATOR
$questTexts = [
    'Считаете ли Вы, что у многих ваших знакомых хороший характер?',
    'Раздражают ли Вас мелкие повседневные обязанности?',
    'Верите ли Вы, что ваши друзья преданы Вам?',
    'Неприятно ли Вам, когда незнакомый человек делает Вам замечание?',
    'Способны ли Вы ударить собаку или кошку?',
    'Часто ли Вы принимаете лекарства?',
    'Часто ли Вы меняете магазин, в который ходите за продуктами?',
    'Продолжаете ли Вы отстаивать свою точку зрения, поняв, что ошиблись?',
    'Тяготят ли Вас общественные обязанности?',
    'Способны ли Вы ждать более 5 минут, не проявляя беспокойства?',
    'Часто ли Вам приходят в голову мысли о Вашей невезучести?',
    'Сохранилась ли у Вас фигура по сравнению с прошлым?',
    'Можете ли Вы с улыбкой воспринимать подтрунивание друзей?',
    'Нравится ли Вам семейная жизнь?',
    'Злопамятны ли Вы?',
    'Находите ли Вы, что стоит погода, типичная для данного времени года?',
    'Случается ли Вам с утра быть в плохом настроении?',
    'Раздражает ли Вас современная живопись?',
    'Надоедает ли Вам присутствие чужих детей в доме более одного часа?',
    'Надоедает ли Вам делать лабораторные по PHP?',
];

$questScopes = [
    [0, 1],
    [0, 1],
    [1, 0],
    [0, 1],
    [0, 1],
    [0, 1],
    [0, 1],
    [1, 0],
    [1, 0],
    [1, 0],
    [0, 1],
    [0, 1],
    [1, 0],
    [1, 0],
    [0, 1],
    [0, 1],
    [0, 1],
    [0, 1],
    [1, 0],
    [0, 1],
];

$questions = [];

foreach ($questTexts as $key => $text) {
    $questions[] = new Question(
        QUESTION_ID_PREFIX . ((string) $key),
        $text,
        $questScopes[$key][1],
        $questScopes[$key][0]
    );
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Прытков Д.О. ПИ228-БЗУ</title>
</head>
<body>

<style>
    .form-group {
        margin-bottom: 1rem;
    }
</style>

<?php if (!$request->isPostMethod()): ?>
<form action="s3-5.php" method="post">
    <h4>Анкета: "Ваш характер"</h4>
    <div class="form-group">
        <label for="name" style="display: block">Введите ваше имя</label>
        <input type="text" id="name" name="name">
    </div>

    <div class="form-group">
        <b>Ответьте да или нет на следующие вопросы:</b>
    </div>

    <?php foreach ($questions as $question): ?>

    <div class="form-group">
        <label><?php echo $question->getText() ?></label>
        <div class="checkbox-block">
            <input type="radio" name="<?php echo $question->getId() ?>" id="quest-true-<?php echo $question->getId()?>" value="1" checked>
            <label for="quest-true-<?php echo $question->getId()?>">Да</label>
            <input type="radio" name="<?php echo $question->getId() ?>" id="quest-false-<?php echo $question->getId()?>" value="0">
            <label for="quest-false-<?php echo $question->getId()?>">Нет</label>
        </div>
    </div>
    <?php endforeach; ?>

    <button type="submit">Отправить</button>
</form>

<?php endif; ?>

<?php

if ($request->isPostMethod()) {
    try {
        $name = $request->getString('name');

        if ($name === null)
            throw new BadRequestException('Ошибка: name is required field.');

        $scopes = 0;
        foreach ($questions as $question) {
            $answerValue = $request->getBoolean($question->getId());

            if ($answerValue === null)
                throw new BadRequestException('Ошибка: ' . $question->getId() . ' is required field.');

            $scopes += $question->answer($answerValue);
        }

        echo $name . '<br>Результат: ';

        if ($scopes > 15) {
            echo "У Вас покладистый характер";
        } elseif ($scopes > 8) {
            echo "Вы не лишены недостатков, но с вами можно ладить";
        } else {
            echo "Вашим друзьям можно посочувствовать";
        }
    } catch (BadRequestException $e) {
        echo $e->getMessage();
    }
}

?>

</body>
</html>
