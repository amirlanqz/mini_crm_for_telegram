<?php

function pretty_print_array(array $data, string $title = 'Debug Info'): void
{
    echo "<h2 style='font-family: sans-serif;'>$title</h2>";
    echo "<table border='1' cellpadding='6' cellspacing='0' style='border-collapse: collapse; font-family: monospace;'>";
    echo "<thead style='background-color: #f2f2f2;'><tr><th>Ключ</th><th>Значение</th></tr></thead>";
    echo "<tbody>";

    foreach ($data as $key => $value) {
        echo "<tr>";
        echo "<td><strong>" . htmlspecialchars((string)$key) . "</strong></td>";
        echo "<td><pre style='margin:0;'>" . htmlspecialchars(print_r($value, true)) . "</pre></td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
}
