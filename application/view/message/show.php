<div class="container">
    <!-- Überschrift mit der ID des Chatpartners -->
    <h1>Chat mit User #<?= $this->partnerId ?></h1>

    <!-- Box für den gesamten Chatbereich -->
    <div class="box">
        <!-- Feedback-Ausgabe (Fehler oder Erfolgsmeldungen) -->
        <?php $this->renderFeedbackMessages(); ?>

        <!-- Chatfenster mit Scrollfunktion -->
        <div class="chat-window" style="max-height:400px; overflow-y:auto; border:1px solid #ccc; padding:10px;">

            <!-- Prüft, ob Nachrichten existieren -->
            <?php if (!empty($this->messages)): ?>

                <!-- Schleife über alle Nachrichten -->
                <?php foreach ($this->messages as $msg): ?>

                    <!-- Einzelne Chat-Nachricht -->
                    <div
                        style=" padding:8px; margin:5px; border-radius:10px; max-width:70%; <?= $msg->sender_id == Session::get('user_id') ? 'background:#DCF8C6;margin-left:auto;text-align:right;' : 'background:#FFF;margin-right:auto;text-align:left;border:1px solid #ddd;' ?> ">

                        <!-- Nachrichtentext (HTML-sicher ausgegeben) -->
                        <?= htmlentities($msg->message_text) ?>

                        <!-- Zeitstempel der Nachricht -->
                        <div style="font-size:10px; color:#999;">
                            <?= $msg->timestamp ?>
                        </div>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>
                <!-- Anzeige, wenn noch keine Nachrichten vorhanden sind -->
                <p>Keine Nachrichten vorhanden.</p>
            <?php endif; ?>

        </div>

        <!-- Formular zum Senden einer neuen Nachricht -->
        <form method="post" action="<?= Config::get('URL') ?>message/send" style="margin-top:10px;">

            <!-- Verstecktes Feld mit der Empfänger-ID -->
            <input type="hidden" name="receiver_id" value="<?= $this->partnerId ?>">

            <!-- Eingabefeld für den Nachrichtentext -->
            <input type="text" name="message_text" placeholder="Schreibe eine Nachricht..." style="width:80%;" required>

            <!-- Absende-Button -->
            <button type="submit">Senden</button>
        </form>
    </div>
</div>
