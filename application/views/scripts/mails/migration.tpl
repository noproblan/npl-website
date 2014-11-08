<p> Hi <?= $this->username ?>,<br />
<br />
In Vorbereitung für unsere Jubiläums-LAN haben wir die Website überarbeitet!
Um deinen alten Account direkt auf die neue Website zu übernehmen <a href="<?= $this->serverUrl() . $this->baseUrl() . $this->url(array('controller' => 'user', 
                       'action' => 'migrate', 
                       'key' => $this->token), 'default', true) ?>">klicke hier</a>.<br />
<br />
Es ist dir dabei möglich deinen Nickname sowie Passwort und Mailadresse neu zu setzen.
Sollte der Link nicht funktionieren kopiere nachstehende Webadresse in deinen Browser: <?= $this->serverUrl() . $this->baseUrl() . $this->url(array('controller' => 'user', 
                       'action' => 'migrate', 
                       'key' => $this->token), 'default', true) ?><br />
<br />
Bis bald,<br />
Das noprobLAN-Team
</p>