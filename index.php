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
                                <a href="?action=visibility"><b>��������� ����������� ������ �� ������</b></a><br><br>
                            </li>
                            <li>
                                <a href="?action=sales"><b>��������� ������ �� ����������</b></a><br>
                                ���������� �� ������ � ����������:
                                <ul>
                                    <li>����� � ����������� � ����������� �������� � �������� "/data/sales/"</li>
                                    <li>����� ������ ���� ��������� � ������� MS Excel 97-2003 (.xls)</li>
                                    <li>����� ������ ���� ��������� � ��������� "windows-1251"</li>
                                    <li>��������� ������������� ��������� ��� ����� � ��������� �������� � ���� ������������</li>
                                    <li>������ ������ ������� ����� �������� ���������� � ������������</li>
                                    <li>� ������ ������� ������ ������ ������ ��������� ��� ������</li>
                                    <li>������� � �������� "i" ������������� �������� ���������� ��� ������ �� "i-1" �����</li>
                                    <li>���� ��� ������� ����� ������� �������� "0" ��� "1", ��� ���� ����� ����������� ���������������� ��������</li>
                                    <li>���� ��� ������� ����� ������� �������� "" (������ ������) �������� ���������� ��� ������� ����� �������� �� �����</li>
                                </ul>
                                ��������� ������:
                                <ul>
                                    <li>Item named <i>"foo"</i> not found! - ����� � ������ ������ �� ������</li>
                                    <li>Item named <i>"foo"</i> is ambiguous! - ��� ������ �� ���������</li>
                                    <li>Invalid sale value: <i>"foo"</i> - �������� �������� ����������</li>
                                    <li>Invalid site id: <i>"foo"</i> - �������� ������������� �����</li>
                                    <li>Couldn`t set sale status of <i>"foo"</i> to <i>"bar"</i> on site <i>"baz"</i> - ������ ���������� ����������</li>
                                </ul>
                                <br>
                            </li>
                            <li>
                                <a href="?action=promo"><b>��������� ������ �� �����</b></a><br>
                                ���������� �� ������ � ����������:
                                <ul>
                                    <li>����� � ����������� � ����������� �������� � �������� "/data/promo/"</li>
                                    <li>����� ������ ���� ��������� � ������� MS Excel 97-2003 (.xls)</li>
                                    <li>����� ������ ���� ��������� � ��������� "windows-1251"</li>
                                    <li>��������� ������������� ��������� ��� ����� � ��������� �������� � ���� ������������</li>
                                    <li>������ ������ ������� ����� �������� ���������� � ������������</li>
                                    <li>� ������ ������� ������ ������ ������ ��������� ��� ������</li>
                                    <li>������� � �������� "i" ������������� �������� ����� ��� ������ �� "i-1" �����</li>
                                    <li>���� ��� ������� ����� ������� �������� "0" ��� "1", ��� ���� ����� ����������� ���������������� ��������</li>
                                    <li>���� ��� ������� ����� ������� �������� "" (������ ������) �������� ����� ��� ������� ����� �������� �� �����</li>
                                </ul>
                                ��������� ������:
                                <ul>
                                    <li>Item named <i>"foo"</i> not found! - ����� � ������ ������ �� ������</li>
                                    <li>Item named <i>"foo"</i> is ambiguous! - ��� ������ �� ���������</li>
                                    <li>Invalid sale value: <i>"foo"</i> - �������� �������� �����</li>
                                    <li>Invalid site id: <i>"foo"</i> - �������� ������������� �����</li>
                                    <li>Couldn`t set sale status of <i>"foo"</i> to <i>"bar"</i> on site <i>"baz"</i> - ������ ���������� �����</li>
                                </ul>
                                <br>
                            </li>
                            <li>
                                <a href="?action=item-display-analyzer"><b>������������� ���������� ������ �� �����</b></a><br><br>
                            </li>
                        </ul>
                    ';

            }

        ?>
    </body>
</html>