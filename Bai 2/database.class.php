<?php
class Dao
{
    private mysqli $con;

    public function __construct($user, $pass, $db)
    {
        $host = 'localhost';
        $this->con = new mysqli($host, $user, $pass, $db);
        if ($this->con->connect_error) {
            throw new RuntimeException('Không thể kết nối cơ sở dữ liệu.');
        }
        $this->con->set_charset('utf8mb4');
    }

    public function query($sql)
    {
        $result = $this->con->query($sql);
        if ($result === false) {
            throw new RuntimeException('Không thể truy vấn dữ liệu.');
        }
        return $result;
    }

    public function table($sql, $header)
    {
        $rs = $this->query($sql);
        $fields = $rs->fetch_fields();

        echo '<section class="result-card">';
        echo '<h2>' . htmlspecialchars($header, ENT_QUOTES, 'UTF-8') . '</h2>';
        echo '<div class="table-wrap"><table><thead><tr>';
        foreach ($fields as $field) {
            echo '<th>' . htmlspecialchars($field->name, ENT_QUOTES, 'UTF-8') . '</th>';
        }
        echo '</tr></thead><tbody>';

        if ($rs->num_rows === 0) {
            echo '<tr><td colspan="' . count($fields) . '">Không có dữ liệu.</td></tr>';
        } else {
            while ($row = $rs->fetch_assoc()) {
                echo '<tr>';
                foreach ($fields as $field) {
                    $value = $row[$field->name] ?? '';
                    echo '<td>' . htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') . '</td>';
                }
                echo '</tr>';
            }
        }

        echo '</tbody></table></div></section>';
        $rs->free();
    }
}
