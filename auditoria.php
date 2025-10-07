<?php
// auditoria.php
function auditar_login($session_id, $username, $conn) {
    $sql = "INSERT INTO log_sistema (session_id, username, inicio_sesion) 
            VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $session_id, $username);
    $stmt->execute();
    $stmt->close();
}

function auditar_logout($session_id, $conn) {
    $sql = "UPDATE log_sistema 
            SET cierre_sesion = NOW() 
            WHERE session_id = ? 
            ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $stmt->close();
}
?>
