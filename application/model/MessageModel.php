<?php

class MessageModel
{
    // Stellt die Datenbankverbindung her
    private static function db()
    {
        return DatabaseFactory::getFactory()->getConnection();
    }

    // Speichert eine neue Nachricht in der Datenbank
    public static function sendMessage($senderId, $receiverId, $text)
    {
        // Validierung: Alle Felder müssen ausgefüllt sein
        if (empty($senderId) || empty($receiverId) || empty($text)) {
            return false;
        }

        // Fügt eine neue Nachricht in die Datenbank ein (Absender, Empfänger, Nachrichtentext)
        $sql = "
            INSERT INTO messages (sender_id, empfaenger_id, message_text)
            VALUES (:sender, :receiver, :text)
        ";

        // Führt das Statement mit Platzhaltern aus (Schutz vor SQL-Injection)
        return self::db()->prepare($sql)->execute([
            ':sender'   => $senderId,
            ':receiver' => $receiverId,
            ':text'     => $text
        ]);
    }

    // Lädt den gesamten Chat-Verlauf zwischen zwei Personen (chronologisch)
public static function getConversation($userId, $partnerId)
{
    // SQL-Abfrage, um alle Nachrichten zwischen zwei Nutzern zu holen
    $sql = "
        SELECT *
        FROM messages
        WHERE 
            -- Nachrichten vom aktuellen User an den Partner
            (sender_id = :me AND empfaenger_id = :partner)

            -- ODER Nachrichten vom Partner an den aktuellen User
            OR (sender_id = :partner AND empfaenger_id = :me)

        -- Sortiere alle Nachrichten chronologisch nach Zeitstempel
        ORDER BY timestamp ASC
    ";

    // Bereitet die SQL-Abfrage vor (PDO Prepared Statement)
    $query = self::db()->prepare($sql);

    // Führt die Abfrage aus und bindet die Parameter ":me" und ":partner"
    $query->execute([
        ':me' => $userId,
        ':partner' => $partnerId
    ]);

    // Gibt alle Nachrichten als Array zurück
    return $query->fetchAll();
}

    // Setzt den Status aller Nachrichten eines Absenders auf "gelesen"
    public static function markAsRead($senderId, $receiverId)
    {
        $sql = "
            UPDATE messages
            SET gelesen = 1
            WHERE sender_id = :sender AND empfaenger_id = :receiver
        ";

        return self::db()->prepare($sql)->execute([
            ':sender'   => $senderId,
            ':receiver' => $receiverId
        ]);
    }

    // Holt eine Liste aller Chatpartner inklusive letzter Nachricht und Anzahl ungelesener Texte
   public static function getConversations($userId)
{
    // SQL-Abfrage, um alle Unterhaltungen eines bestimmten Users zu holen
    $sql = "
        SELECT 
            -- Wenn der eingeloggte User der Sender ist, dann ist Partner = Empfänger, sonst Partner = Sender
            IF(sender_id = :me, empfaenger_id, sender_id) AS partner_id,
            
            -- Zeitstempel der letzten Nachricht in diesem Chat
            MAX(timestamp) AS last_time,
            
            -- Anzahl ungelesener Nachrichten für diesen User
            SUM(
                CASE 
                    WHEN empfaenger_id = :me AND gelesen = 0 THEN 1 
                    ELSE 0 
                END
            ) AS unread
        FROM messages
        
        -- Nur Nachrichten, bei denen der User Sender oder Empfänger ist
        WHERE sender_id = :me OR empfaenger_id = :me

        -- Gruppierung nach Chatpartner
        GROUP BY partner_id

        -- Neueste Nachrichten zuerst
        ORDER BY last_time DESC
    ";

    // Bereitet die SQL-Abfrage vor (PDO Prepared Statement)
    $query = self::db()->prepare($sql);

    // Führt die Abfrage aus und bindet den Parameter ":me" an die aktuelle User-ID
    $query->execute([':me' => $userId]);

    // Gibt alle Ergebnisse als Array zurück
    return $query->fetchAll();
}

    // Gibt eine Liste mit IDs aller User zurück, mit denen man bereits geschrieben hat
    public static function getUsersForMessaging($userId)
    {
        $sql = "
            SELECT DISTINCT
                IF(sender_id = :me, empfaenger_id, sender_id) AS user_id
            FROM messages
            WHERE sender_id = :me OR empfaenger_id = :me
        ";
        // Führt ein SQL-Query mit einem Platzhalter :me aus und gibt alle Ergebnisse als eindimensionales Array zurück
        $query = self::db()->prepare($sql);
        $query->execute([':me' => $userId]);

        return $query->fetchAll(PDO::FETCH_COLUMN);
    }
}


