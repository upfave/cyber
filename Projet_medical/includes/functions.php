<?php
function calculateAge($birthdate) {
    $today = new DateTime();
    $birth = new DateTime($birthdate);
    $age = $today->diff($birth);
    return $age->y;
}

function formatDate($date, $format = 'd/m/Y') {
    return date($format, strtotime($date));
}
?>