<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <?php

            set_time_limit(0);

            if ($_GET['action'])
            {

                $page = null;
                
                switch ($_GET['action'])
                {

                    case 'sales':                   $page = 'sales'; break;
                    case 'promo':                   $page = 'set_item_promo_status'; break;
                    case 'item-display-analyzer':   $page = 'item-display-analyzer'; break;
                    case 'visibility':              $page = 'check_item_visible'; break;

                }

                if ( $page !== null )
                    include 'pages/' . $page . '.php';

            }

            else
            {

                echo '  <ul>
                            <li>
                                <a href="?action=visibility"><b>Проверить отображение товара на сайтах</b></a><br><br>
                            </li>
                            <li>
                                <a href="?action=sales"><b>Выставить товары на распродажу</b></a><br>
                                Информация по работе с программой:
                                <ul>
                                    <li>Файлы с информацией о распродажах хранятся в каталоге "/data/sales/"</li>
                                    <li>Файлы должны быть сохранены в формате MS Excel 97-2003 (.xls)</li>
                                    <li>Файлы должны быть сохранены в кодировке "windows-1251"</li>
                                    <li>Программа автоматически сканирует все файлы в указанном каталоге и всех подкаталогах</li>
                                    <li>Первая строка каждого файла является заголовком и игнорируется</li>
                                    <li>В первом столбце каждой строки должно храниться имя товара</li>
                                    <li>Столбец с индексом "i" соответствует значению распродажи для товара на "i-1" сайте</li>
                                    <li>Если для данного сайта указаны значения "0" или "1", для него будет установлено соответствуюшщее значение</li>
                                    <li>Если для данного сайта указано значение "" (пустая ячейка) значение распродажи для данного сайта изменено не будет</li>
                                </ul>
                                Возможные ошибки:
                                <ul>
                                    <li>Item named <i>"foo"</i> not found! - товар с данным именем не найден</li>
                                    <li>Item named <i>"foo"</i> is ambiguous! - имя товара не уникально</li>
                                    <li>Invalid sale value: <i>"foo"</i> - неверное значение распродажи</li>
                                    <li>Invalid site id: <i>"foo"</i> - неверный идентификатор сайта</li>
                                    <li>Couldn`t set sale status of <i>"foo"</i> to <i>"bar"</i> on site <i>"baz"</i> - ошибка сохранения распродажи</li>
                                </ul>
                                <br>
                            </li>
                            <li>
                                <a href="?action=promo"><b>Выставить товары на акцию</b></a><br>
                                Информация по работе с программой:
                                <ul>
                                    <li>Файлы с информацией о распродажах хранятся в каталоге "/data/promo/"</li>
                                    <li>Файлы должны быть сохранены в формате MS Excel 97-2003 (.xls)</li>
                                    <li>Файлы должны быть сохранены в кодировке "windows-1251"</li>
                                    <li>Программа автоматически сканирует все файлы в указанном каталоге и всех подкаталогах</li>
                                    <li>Первая строка каждого файла является заголовком и игнорируется</li>
                                    <li>В первом столбце каждой строки должно храниться имя товара</li>
                                    <li>Столбец с индексом "i" соответствует значению акции для товара на "i-1" сайте</li>
                                    <li>Если для данного сайта указаны значения "0" или "1", для него будет установлено соответствуюшщее значение</li>
                                    <li>Если для данного сайта указано значение "" (пустая ячейка) значение акции для данного сайта изменено не будет</li>
                                </ul>
                                Возможные ошибки:
                                <ul>
                                    <li>Item named <i>"foo"</i> not found! - товар с данным именем не найден</li>
                                    <li>Item named <i>"foo"</i> is ambiguous! - имя товара не уникально</li>
                                    <li>Invalid sale value: <i>"foo"</i> - неверное значение акции</li>
                                    <li>Invalid site id: <i>"foo"</i> - неверный идентификатор сайта</li>
                                    <li>Couldn`t set sale status of <i>"foo"</i> to <i>"bar"</i> on site <i>"baz"</i> - ошибка сохранения акции</li>
                                </ul>
                                <br>
                            </li>
                            <li>
                                <a href="?action=item-display-analyzer"><b>Анализировать отсутствие товара на сайте</b></a><br><br>
                            </li>
                        </ul>
                    ';

            }

        ?>
    </body>
</html>