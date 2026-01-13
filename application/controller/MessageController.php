<?php

class MessageController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Zugriff nur für eingeloggte Nutzer
        Auth::checkAuthentication();
    }

    // Zeigt die Nachrichtenübersicht (Inbox)
    public function index()
{
    $userId = Session::get('user_id');

    $this->View->render('message/index', [
        'conversations' => MessageModel::getConversations($userId)
    ]);
}


    // Zeigt ein einzelnes Gespräch
    public function show($partnerId)
    {
        $myId = Session::get('user_id'); // eigene User-ID

        $this->View->render('message/show', [
            // Nachrichten zwischen mir und dem Gesprächspartner
            'messages'  => MessageModel::getConversation($myId, $partnerId),
            'partnerId' => $partnerId
        ]);

        // Nachrichten des Partners als gelesen markieren
        MessageModel::markAsRead($partnerId, $myId);
    }

  // Sendet eine neue Nachricht
public function send()
{
    // Prüfen, ob die nötigen POST-Daten vorhanden sind (Empfänger und Nachricht)
    if (empty($_POST['receiver_id']) || empty($_POST['message_text'])) {
        // Fehlermeldung in die Session speichern
        Session::add('feedback_negative', 'Ungültige Anfrage');
        // Benutzer zurück zur Nachrichtenübersicht weiterleiten
        Redirect::to('message');
    }

    // Nachricht über das MessageModel speichern
    MessageModel::sendMessage(
        Session::get('user_id'),     // ID des aktuellen Benutzers (Absender)
        $_POST['receiver_id'],       // ID des Empfängers
        $_POST['message_text']       // Text der Nachricht
    );

    // Nach dem Senden zur Unterhaltung des Empfängers weiterleiten
     // - Verhindert, dass die Nachricht beim Reload erneut gesendet wird
    Redirect::to('message/show/' . $_POST['receiver_id']);
}


}
