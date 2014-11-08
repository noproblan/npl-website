<p> Hi <?= $this->username ?>,<br />
<br />
<b>Willkommen bei noprobLAN</b> und danke für Dein Interesse an einer Veranstaltung, von der wir glauben, dass es eine der gemütlichsten der Schweiz ist.<br />
<br />
Um Deinen noprobLAN-Account zu bestätigen und zu verifizieren, dass Deine E-Mail korrekt funktioniert, <a href="<?= $this->serverUrl() . $this->baseUrl() . $this->url(array('controller' => 'user', 
                       'action' => 'activate', 
                       'id' => $this->id, 
                       'key' => $this->token), 'default', true) ?>">klicke hier</a>.<br />
<br />
Sollte der Link nicht funktionieren kopiere nachstehende Webadresse in deinen Browser: <?= $this->serverUrl(). $this->baseUrl() . $this->url(array('controller' => 'user', 
                       'action' => 'activate', 
                       'id' => $this->id, 
                       'key' => $this->token), 'default', true) ?><br />
<br />
Bis bald,<br />
Das noprobLAN-Team
</p>