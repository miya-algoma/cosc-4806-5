<?php

class Reminder {

public function getAllByUser($user_id) {
$db = db_connect();
$stmt = $db->prepare("SELECT * FROM notes WHERE user_id = :uid ORDER BY created_at DESC");
$stmt->bindValue(':uid', $user_id);
$stmt->execute();
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function create($user_id, $subject) {
$db = db_connect();
$stmt = $db->prepare("INSERT INTO notes (user_id, subject) VALUES (:uid, :subject)");
return $stmt->execute([
':uid' => $user_id,
':subject' => $subject
]);
}

public function delete($note_id, $user_id) {
$db = db_connect();
$stmt = $db->prepare("DELETE FROM notes WHERE id = :id AND user_id = :uid");
return $stmt->execute([':id' => $note_id, ':uid' => $user_id]);
}

public function update($note_id, $user_id, $subject) {
$db = db_connect();
$stmt = $db->prepare("UPDATE notes SET subject = :subject WHERE id = :id AND user_id = :uid");
return $stmt->execute([
':subject' => $subject,
':id' => $note_id,
':uid' => $user_id
]);
}

public function getOne($note_id, $user_id) {
$db = db_connect();
$stmt = $db->prepare("SELECT * FROM notes WHERE id = :id AND user_id = :uid");
$stmt->execute([':id' => $note_id, ':uid' => $user_id]);
return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function markCompleted($note_id, $user_id) {
$db = db_connect();
$stmt = $db->prepare("UPDATE notes SET completed = 1 WHERE id = :id AND user_id = :uid");
return $stmt->execute([
':id' => $note_id,
':uid' => $user_id
]);
}
}