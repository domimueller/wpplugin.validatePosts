# Funktionaliät

Das Plugin bringt folgene Hauptfunktionalität


## Erfassung von Kontingenten
Auf der Benutzerseite gibt es neue Felder für die Aktivierung eines Kontingents für einen Benutzer. Pro Kontingent kann Dauer und Anzahl der kontingentierten Inserate festgelegt werden. 

## Weiterleitung des Benutzers auf Basis der Kontingentsituation
Das Dokument includes/businessLogicForwarding.php entscheidet, ob ein Künstler noch Kontingent für Inserate zur Verfügung hat oder nicht. Auf Basis dessen, wird der Benutzer nach der Erfassung des Inserates auf eine reine Informationsseite oder auf die Standard-Produktseite weitergeleitet (wie alle anderen Benutzer ohne Kontingent).

Dabei gibt es folgende Optionen:
a) Falls noch Kontingent vorhanden, wird der Benutzer auf das Template template-Contigency.php weitergeleitet. Das Inserat wird manuell geprüft und falls ok über das Kontingent verrechnet. Nur veröffentlichte Inserate gelten als kontingentiert.	
b) Der Künstler hat bereits mehr Bilder veröffentlicht als dies sein Kontingent erlaubt (oder gleich viel). Deshalb wird der Künstler auf die Produkteseite weitergeleitet wie alle anderen Künstler ohne Kontingent. 

Das Ablaufdatum des Kontingents wird hier nicht geprüft. siehe dazu den nächsten Abschnitt.

## Überprüfung Ablaufdatum von Inseraten und Kontingenten

Im Template template-checkAblaufdatum.php gibt es 6 Tabellen: 
a) abgelaufene Inserate
b) in den nächsten 7 Tagen ablaufende Inserate
c) noch gültige Inserate
f) Abgelaufene Kontingente
d) b) in den nächsten 7 Tagen ablaufende Kontingente
e) gültige Kontingente

Es wird jeweils das Ablaufdatum der Kontingente geprüft und nicht die Anzahl veröffentlichten Inserate vs. Anzahl erlaubte Inserate im entsprechenden Kontingent.


## Überprüfung von Inseraten und Kontingenten mittels cronjob
Es gibt 3 relevante cronjobs: wp cron event list

### vernissageContingencyExpired
Dieser Job überprüft, welche Kontingente in den nächsten 7 Tagen ablaufen werden und versendet eine Nachricht. Kommentar: Kann nur wöchtentlich laufen, weil ansonsten für denselben Eintrag mehrere Nachrichten geschickt würden. Es wird nirgends in der DB festgehalten, ob bereits eine Nachricht für diesen Eintrag versendet wurde.
cronjob-SendContigencyExpirationReminder.php und SendContigencyExpirationReminder.php realisieren diese Funktionen.	

### vernissageInsertionExpired
Dieser Job überprüft, welche Inserate in den nächsten 7 Tagen ablaufen werden und versendet eine Nachricht. Periodizät siehe Kommentar oben.
cronjob-SendInsertionExpirationReminder.php und SendInsertionExpirationReminder.php realisieren diese Funktionen.

### vernissageCheckInsertionExpired
Dieser Job überprüft täglich, welche Inserate abgelaufen sind und aktualisiert deren Bezeichnung und Status. Es wird anschliessend nur eine Infomail an vernissage4u verschickt. Übersicht der Änderung via Web.
cronjob-checkInsertionDate.php und checkInsertionDateFunction.php realisieren diese Funktionen.

# Plugin does not Provid Output
This plugin does not provide the output of the sponsoring data. This must be done via template in theme.

## Benötigte Templates
a) template-Contigency.php
b) template-checkAblaufdatum.php
