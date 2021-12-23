<?php
    function sanitize_data($con, $string) {
        $string = trim($string);
        $string = filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
        return mysqli_real_escape_string($con, $string);
    }
?>