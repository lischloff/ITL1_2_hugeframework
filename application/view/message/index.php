<div class="container">
    <h1>MessageController/index</h1>

    <div class="box">

        <!-- Gibt Systemmeldungen aus (z.B. Fehler oder Erfolgsmeldungen) -->
        <?php $this->renderFeedbackMessages(); ?>

        <h3>Ihre Unterhaltungen</h3>

        <!-- Prüft, ob Unterhaltungen vorhanden sind -->
        <?php if ($this->conversations) { ?>
            <!-- Tabelle für die Anzeige der Unterhaltungen -->
            <table class="message-table">
                <thead>
                    <tr>
                        <td>Partner ID</td>
                        <td>Letzte Nachricht</td>
                        <td>Ungelesen</td>
                    </tr>
                </thead>
                <tbody>
                    <!-- Durchläuft alle Unterhaltungen -->
                    <?php foreach ($this->conversations as $chat): ?>
                        <tr>
                            <!-- Zeigt die ID des Chatpartners an -->
                            <td>User #<?= $chat->partner_id ?></td>

                            <!-- Zeigt den Zeitpunkt der letzten Nachricht -->
                            <td><?= $chat->last_time ?></td>

                            <!-- Anzeige der ungelesenen Nachrichten -->
                            <td>
                                <?php if ($chat->unread > 0): ?>
                                    <!-- Rotes Badge, wenn ungelesene Nachrichten vorhanden sind -->
                                    <span class="badge red"><?= $chat->unread ?></span>
                                <?php else: ?>
                                    <!-- 0 anzeigen, wenn keine ungelesenen Nachrichten existieren -->
                                    0
                                <?php endif; ?>
                            </td>

                            <!-- Link zum Öffnen des Chats mit dem jeweiligen Partner -->
                            <td>
                                <a href="<?= Config::get('URL') . 'message/show/' . $chat->partner_id ?>">
                                    Chat öffnen
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php } else { ?>
            <!-- Anzeige, wenn keine Unterhaltungen existieren -->
            <div>Noch keine Unterhaltungen vorhanden.</div>
        <?php } ?>

    </div>
</div>
