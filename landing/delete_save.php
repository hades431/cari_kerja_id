<?php
function hapus_semua_save() {
    global $conn;
mysqli_query($conn,"DELETE FROM save_lowongan WHERE user_id = " . (int) $_SESSION["user"]["id"]);
return mysqli_affected_rows($conn); 
}

?>