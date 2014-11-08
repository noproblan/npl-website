<p> Hi <?= $this->username ?>,<br />
<br />
Um Dein Passwort zurückzusetzen klicke innerhalb von 7 Tagen <a href="<?= $this->serverUrl() . $this->baseUrl() . $this->url(array('controller' => 'user', 
                       'action' => 'resetpassword', 
                       'id' => $this->id, 
                       'key' => $this->token), 'default', true) ?>">hier</a>.<br />
<br />
Sollte der Link nicht funktionieren kopiere nachstehende Webadresse in deinen Browser: <?= $this->serverUrl() . $this->baseUrl() . $this->url(array('controller' => 'user', 
                       'action' => 'resetpassword', 
                       'id' => $this->id, 
                       'key' => $this->token), 'default', true) ?><br />
<br />
Bis bald,<br />
Das noprobLAN-Team
</p>