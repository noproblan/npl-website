<p> Hi <?= $this->username ?>,<br />
<br />
Um Deine Mailadresse zu verifizieren <a href="<?= $this->serverUrl() . $this->baseUrl() . $this->url(array('controller' => 'user', 
                       'action' => 'verify', 
                       'id' => $this->id, 
                       'key' => $this->token), 'default', true) ?>">klicke hier</a>.<br />
<br />
Sollte der Link nicht funktionieren kopiere nachstehende Webadresse in deinen Browser: <?= $this->serverUrl() . $this->baseUrl() . $this->url(array('controller' => 'user', 
                       'action' => 'verify', 
                       'id' => $this->id, 
                       'key' => $this->token), 'default', true) ?><br />
<br />
Bis bald,<br />
Das noprobLAN-Team
</p>