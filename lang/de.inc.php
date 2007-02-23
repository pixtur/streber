<?php

# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
* language-table for German translation (C) Thomas Mann
*/

global $g_lang_table;
$g_lang_table= array(

'en_US.utf8,en_US,enu|list of locales'=>'de.utf8,deu,german',

#--- top navigation tabs -------------------------------------------------------

'<span class=accesskey>H</span>ome'
                    =>'<span class=accesskey>H</span>ome',
'Go to your home. Alt-h / Option-h'
                    =>'Persönliche Übersicht. Alt-h / Option-h',
'<span class=accesskey>P</span>rojects'
                    =>'<span class=accesskey>P</span>rojekte',
'Your projects. Alt-P / Option-P' =>'Ihre Projekte. Alt-P / Option-P',
'People'            =>'Personen',
'Your related People'
                    =>'Für Sie relevante Personen',
'Companies'         =>'Firmen',
'Your related Companies'
                    =>'Für Sie relevante Firmen',
'Calendar'          =>'Kalender',
'<span class=accesskey>S</span>earch:&nbsp;'
                    =>'<span class=accesskey>S</span>uchen:&nbsp;',
"Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`"
                    =>'Begriff eingeben und Bestätigen. Erweiterte Suche durch anklicken des Tabs.',

#--- header --------------------------------------------------------------
'Wiki+Help'         =>'Wiki+Hilfe',
'Documentation and Discussion about this page'
                    =>'Hilfe und Diskussion zu diesem Bereich von Streber',
'This page requires java-script to be enabled. Please adjust your browser-settings.'
                    =>'Bitte aktivieren Javascript, damit Sie Streber benutzen können.',
'you are'           =>'Sie sind',

'How this page looks for clients'
                    =>'So würde diese Seite für Kunden aussehen',
'Client view'       =>'Ansicht für Kunden',
'Logout'            =>'Abmelden',

#--- common texts --------------------------------------------------------------
'Task'              =>'Aufgabe',
'Effort'            =>'Aufwand',
'Comment'           =>'Kommentar',
'Add Now'           =>'hinzufügen',

#--- home -----------------------------------------------------------------------
'Today'             =>'Heute',
'Yesterday'         =>'Gestern',
'today'             =>'heute',
'yesterday'         =>'gestern',
'Discussions'       =>'Discussionen',
'At Home'           =>'Zu Hause',
'F, jS'            =>'F, jS',          # format date headline home
'Functions'         =>'Funktionen',
'View your efforts' =>'Eigene gebuchte Aufwände',
'Edit your profile' =>'Eigenes Profil editieren',
'Your projects'     =>'Eigene Projekte',
'This is a tooltip' =>'?',
'Company'           =>'Firma',
'Project'           =>'Projekt',
'Select lines to use functions at end of list'
                    =>'Markieren Sie Zeilen für die Funktionen am Ende der Liste',
'Priority'          =>'Priorität',
'Edit'              =>'Bearbeiten',
'Log hours for a project' =>'Aufwände erfassen',
'Create new project'=>'Neues Projekt erstellen',
'You have no open tasks'
                    =>'Sie haben keine offenen Aufgaben',
'Open tasks'        =>'Offene Aufgaben',
'Task-Status'       =>'Status der Aufgabe',
'Folder'            =>'Ordner',
'Started'           =>'Begonnen',
'Est.'              =>'ges.',
'Estimated time in hours'
                    =>'Geschätzter Aufwand in Stunden',
'status->Completed' =>'Status->erledigt',
'status->Approved'  =>'Status->abgenommen',
'status->Closed'   =>'Status->geschlossen',
'Delete'            =>'Löschen',
'Log hours for select tasks'
                    =>'Aufwände für Aufgabe buchen',
'%s tasks with estimated %s hours of work'
                    =>'%s Aufgaben mit mit ca. %s Stunden',

#--- pages/_handles.inc -------------
'Home'                        =>'Home',
'Active Projects'             =>'Aktive Projekte',
'Closed Projects'             =>'Geschlossene Projekte',
'Project Templates'           =>'Projekt Vorlagen',
'View Project'                =>'Projekt Überblick',
'Closed tasks'                =>'Abgeschlossene Aufgaben',
'New Project'                 =>'Neues Projekt',
'Duplicate Project'           =>'Projekt duplizieren',
'Edit Project'                =>'Projekt bearbeiten',
'Delete Project'              =>'Projekt löschen',
'Change Project Status'       =>'Projekt-Status ändern',
'Add Team member'             =>'Projektperson hinzufügen',
'Edit Team member'            =>'Projektperson bearbeiten',
'Remove from team'            =>'Projektperson abziehen',

'View Task'                   =>'Aufgabe Übersicht',
'Edit Task'                   =>'Aufgabe bearbeiten',
'Delete Task(s)'              =>'Aufgabe(n) löschen',
'Restore Task(s)'             =>'Aufgabe(n) wieder herstellen',
'Move tasks to folder'        =>'Aufgaben in Ordner verschieben',
'Mark tasks as Complete'      =>'Aufgaben als erledigt kennzeichnen',
'Mark tasks as Approved'      =>'Aufgaben als abgenommen kennzeichnen',
'New Task'                    =>'Neue Aufgabe',
'Toggle view collapsed'       =>'Block ein/aufklappen',
'Log hours'                   =>'Aufwand erfassen',
'Edit time effort'            =>'Aufwand bearbeiten',
'Create comment'              =>'Kommentar erstellen',
'Edit comment'                =>'Kommantar bearbeiten',
'Delete comment'              =>'Kommentar löschen',
'Add issue/bug report'        =>'Fehlerreport zur Aufgabe hinzufügen',
'List Companies'              =>'Firmen',
'View Company'                =>'Firma Überblick',
'New Company'                 =>'Neue Firma',
'Edit Company'                =>'Firma bearbeiten',
'Delete Company'              =>'Firma löschen',
'Link Persons'                =>'mit Personen verknüpfen',
'List Persons'                =>'Personen auflisten',
'View Person'                 =>'Person Überblick',
'New Person'                  =>'Neue Person',
'Edit Person'                 =>'Person bearbeiten',
'Edit User Rights'            =>'Rechte einer Person bearbeiten',
'Delete Person'               =>'Person entfernen',
'View Efforts of Person'      =>'Aufwände einer Person anzeigen',
'Login'                       =>'Anmelden',
'License'                     =>'Lizenz',
'Error'                       =>'Fehler',
'Remove persons from company' =>'Ansprechpartner entfernen',
'Edit Note'					  =>'Notiz bearbeiten',
'Link Companies'              =>'mit Firmen verknüpfen',
'Remove companies from person'=>'Firmen entfernen',
'Edit multiple efforts'       =>'Mehrere Aufwände bearbeiten',

### ../db/class_company.inc   ###
'Optional'                    =>'Optional',
'more than expected'          =>'mehr als erwartet',
'not available'               =>'nicht verfügbar',

### ../db/class_effort.inc   ###
'optional if tasks linked to this effort'=>'Optional, falls eine Aufgabe mit dem Aufwand verbunden ist',

### ../db/class_person.inc   ###
'Full name'                   =>'Voller Name',
'Nickname'                    =>'Nickname',

### ../lists/list_persons.inc   ###
'Tagline'                     =>'Namenszusatz',

### ../lists/list_items.inc   ###
'Your bookmarks'          =>'Ihre Lesezeichen',
'You have no bookmarks' =>'Sie haben keine Lesezeichen',
'Remove bookmark'       =>'Lesezeichen entfernen', 
'Send notification'  	=>'Benachrichtigung schicken',
'Remove notification'	=>'Benachrichtigung entfernen',
'Remind'	            =>'Erinnerung',
'in %s day(s)'          =>'in %s Tagen',
'since %s day(s)'       =>'seit %s Tagen',

### ../db/class_person.inc   ###
'Mobile Phone'                =>'Mobiltelefon',
'Office Phone'                =>'Büro Tel',
'Office Fax'                  =>'Büro Fax',
'Office Street'               =>'Büro Straße',
'Office Zipcode'              =>'Büro PLZ',
'Office Page'                 =>'Büro Webseite',
'Personal Phone'              =>'Privat Tel',
'Personal Fax'                =>'Privat Fax',
'Personal Street'             =>'Privat Straße',
'Personal Zipcode'            =>'Privat PLZ',
'Personal Page'               =>'Private Webseite',
'Personal E-Mail'             =>'Private E-Mail',
'Birthdate'                   =>'Geburtstag',

### ../db/class_project.inc   ###
'Color'                       =>'Farbe',

### ../lists/list_comments.inc   ###
'1 Comment'				 	  =>'1 Kommentar',
'%s Comments'				  =>'%s Kommentare',
'Comments'                    =>'Kommentare',

### ../db/class_person.inc   ###
'Password'                    =>'Passwort',

### ../lists/list_projects.inc   ###
'Name'                        =>'Name',

### ../db/class_task.inc   ###
'Short'                       =>'Abkürzung',
'Planned Start'               =>'geplanter Beginn',
'Planned End'                 =>'geplantes Ende',
'Date start'                  =>'Datum Begin',
'Date closed'                 =>'Datum Ende',
'Status'                      =>'Status',
'Description'                 =>'Beschreibung',
'Completion'                  =>'Geschafft',
'Estimated'                   =>'Geschätzt',
'Date due'                    =>'Datue bis',
'Date due end'                =>'Datum bis Ende',


### ../db/class_project.inc   ###
'Status summary'              =>'Status zusammenfassung',
'Project page'                =>'Projekt Webseite',
'Wiki page'                   =>'Projekt Wiki-Seite',
'show tasks in home'          =>'Aufgaben in Home zeigen',
'validating invalid item'     =>'Überprüfung auf ungültiges Element',

### ../pages/comment.inc   ###
'insuffient rights'           =>'Ungenügende Zugriffsrechte',


### ../db/class_projectperson.inc   ###
'job'                         =>'Tätigkeit',
'role'                        =>'Rolle',

### ../pages/task.inc   ###
'Label'                       =>'Etikett',

### ../pages/task.inc   ###
'task without project?'       =>'Aufgabe ohne Projekt?',

### ../db/db_item.inc   ###
'<b>%s</b> isn`t a known format for date.'=>'Warnung: <b>%s</b> ist ein unbekanntes Datumsformat',

### ../lists/list_tasks.inc   ###
'New'                         =>'Neu',
'Sum of all booked efforts (including subtasks)'=>'erfasster Gesamtaufwand',

### ../lists/list_comments.inc   ###
'Move to Folder'              =>'In Ordner verschieben',
'Shrink View'                 =>'Ansicht einklappen',
'Expand View'                 =>'Ansicht ausklappen',
'Topic'                       =>'Thema',

### ../lists/list_companies.inc   ###
'related companies'           =>'relevante Firmen',

### ../lists/list_efforts.inc   ###
'S'                           =>'S',

### ../lists/list_persons.inc   ###
'Name Short'                  =>'Abkürzung',
'Shortnames used in other lists'=>'Abkürzungen werden in Listen verwendet',

### ../pages/proj.inc   ###
'Phone'                       =>'Telefon',

### ../lists/list_companies.inc   ###
'Phone-Number'                =>'Telefon',
'Proj'                        =>'Proj',
'Number of open Projects'     =>'Anzahl der offenen Projekte',
'people'                      =>'Personen',
'People working for this person'=>'Personen dieser Firma',
'Edit company'                =>'Firma bearbeiten',
'Delete company'              =>'Firma löschen',
'Create new company'          =>'Neue Firma',

### ../lists/list_efforts.inc   ###
'person'                      =>'Person',

### ../lists/list_efforts.inc   ###
'Effort name. More Details as tooltips'=>'Name des Aufwandes. Mehr Informationen als Tooltip.',
'Select one or more efforts' => 'Einen oder mehrere Aufwände auswählen',
'Effort of task|page type'			 => 'Aufwand der Aufgabe',
'No description available'   => 'Keine Beschreibung vorhanden',
'No task related'			 => 'Keiner Aufgabe zugeordnet',

### ../lists/list_projects.inc   ###
'Task name. More Details as tooltips'=>'Name der Aufgabe. Mehr Informationen als Tooltip.',

### ../lists/list_efforts.inc   ###
'Edit effort'                 =>'Aufwand bearbeiten',
'New effort'                  =>'Neuer Aufwand',
'D, d.m.Y'                    =>'D, d.m.Y',

### ../lists/list_persons.inc   ###
'Mobil'                       =>'Mobil',

### ../pages/person.inc   ###
'Office'                      =>'Büro',
'Private'                     =>'Privat',

### ../lists/list_persons.inc   ###
'Edit person'                 =>'Person bearbeiten',
'Delete person'               =>'Person löschen',
'Create new person'           =>'Person erstellen',

### ../lists/list_project_team.inc   ###
'Your related persons'        =>'Für relevante Personen',
'Rights'                      =>'Rechte',
'Persons rights in this project'=>'Projektrechte der Person',
'Add team member'             =>'Projektperson hinzufügen',
'Remove person from team'     =>'Projektperson abziehen',
'Member'                      =>'Projektperson',
'Role'                        =>'Rolle',

### ../pages/proj.inc   ###
'Changes'                     =>'Änderungen',

### ../lists/list_tasks.inc   ###
'Created by'                  =>'Erstellt von',

### ../lists/list_projectchanges.inc   ###
'Item was originally created by'=>'Objekt wurde ursprünglich erstellt von...',
'modified'                    =>'bearbeitet',
'C'                           =>'C',
'Created,Modified or Deleted' =>'Erstellt, Bearbeitet oder Gelöscht',
'Deleted'                     =>'Gelöscht',
'Modified'                    =>'Bearbeitet',
'Created'                     =>'Erstellt',
'by Person'                   =>'von Person',
'Person who did the last change'=>'Ändernde Person',
'T'                           =>'T',
'Item of item: [T]ask, [C]omment, [E]ffort, etc '=>'Art des Objektes T-Aufgabe, C-Kommentar, E-Aufwand',
'undefined item-type'=>'unbekannter objekt-typ',
'Del'                         =>'Gel.',
'shows if item is deleted'    =>'Zeigt, ob Objekt gelöscht wurde',
'deleted'                     =>'gelöscht',

### ../lists/list_projects.inc   ###
'Status Summary'              =>'Status Zusammenfassung',
'Short discription of the current status'=>'Kurze Beschreibung des aktuellen Projektstatus',

### ../lists/list_tasks.inc   ###
'Tasks'                       =>'Aufgaben',
'Tasks|short column header'   =>'A',
'%s open tasks / %s h'        =>'%s offene Aufgaben / %s h',

### ../lists/list_projects.inc   ###
'Number of open Tasks'        =>'Anzahl der offenen Aufgaben',
'Opened'                      =>'Start',
'Day the Project opened'      =>'wann das Projekt begonnen wurde',

### ../pages/proj.inc   ###
'Closed'                      =>'Geschlossen',

### ../lists/list_projects.inc   ###
'Day the Project state changed to closed'=>'Wann das Projekt abgeschlossen wurde',
'Edit project'                =>'Projekt bearbeiten',
'Delete project'              =>'Projekt löschen',
'Open / Close'                =>'Projekt Öffnen/Schließen',
'... working in project'      =>'... arbeitet in Projekt',

### ../lists/list_taskfolders.inc   ###
'Folders'                     =>'Ordner',
'Select all, range, no row'   =>'Alle, dazwischen oder keine Zeile auswählen',
'Number of subtasks'          =>'Anzahl der Unteraufgaben',
'Create new folder under selected task'=>'Neuer Ordner unter dem ausgewählten Ordner',

### ../lists/list_tasks.inc   ###
'Move selected to folder'     =>'In Ordner verschieben',
'Priority of task'            =>'Priorität der Aufgabe',
'Status->Completed'           =>'Status->Fertig?',
'Status->Approved'            =>'Status->Abgenommen',
'Status->Closed'              =>'Status->Geschlossen',
'Name, Comments'              =>'Name, Kommentare',
'has %s comments'             =>'hat %s Kommentare',
'Notify on change'            =>'Benachrichtigung bei Änderung',

### ../pages/item.inc ###
'Mark as bookmark'   									 => 'Lesezeichen hinzufügen',
'No item(s) selected.'  								 => 'Es wurde kein(e) Element(e) ausgewählt.',
'Modified by'        									 => 'Geändert durch',
'Select one or more bookmark(s).' 						 => 'Wählen Sie bitte ein oder mehrere Lesezeichen.',
'Added %s bookmark(s).' 								 => '%s Lesezeichen wurde(n) hinzugefügt.',
'Removed %s bookmark(s).' 								 => '%s Lesezeichen wurde(n) entfernt.',
'ERROR: Cannot remove %s bookmark(s). Please try again.' => 'Fehler: %s Lesezeichen konnte nicht entfernt werden. Bitte versuchen Sie es erneut.', 
'Edit bookmark'											 => 'Lesezeichen bearbeiten',
'Edit bookmark: "%s"|page title'					     => 'Lesezeichen "%s" bearbeiten',
'Bookmark: "%s"'									     => 'Lesezeichen "%s"',
'Notify on change'										 => 'Benachrichtigung bei Änderung',
'Notify if unchanged in'								 => 'Falls keine Änderung, Benachrichtigung nach',
'no'													 => 'nein',
'yes'													 => 'ja',
'Edit %s bookmark(s)'									 => '%s Lesezeichen bearbeiten',
'%s bookmark(s) could not be added.'					 => '%s Lesezeichen konnte(n) nicht hinzugefügt werden.',
'Edited %s bookmark(s).'                                 => '%s Lesezeichen wurde(n) bearbeitet.',

### ../pages/person.inc  ###
'Bookmark'												 => 'Lesezeichen',	
'Remove Bookmark'						  			     => 'Lesezeichen entfernen',	
'Mark this person as bookmark'                           => 'Diese Person als Lesezeichen markieren',
'Remove this bookmark'                                   => 'Dieses Lesezeichen entfernen',

### ../pages/comment.inc  ###
'Mark this comment as bookmark'                          => 'Dieses Kommentar als Lesezeichen markieren',

### ../pages/company.inc  ###
'Mark this company as bookmark'                          => 'Diese Firma als Lesezeichen markieren',

### ../pages/task_view.inc  ###
'Mark this task as bookmark'                             => 'Diese Aufgabe als Lesezeichen markieren',

### ../pages/project_view.inc  ###
'Mark this project as bookmark'                          => 'Dieses Projekt als Lesezeichen markieren',

### ../pages/project_more.inc  ### 
'new|effort status'                                      => 'neu',
'open|effort status'                                     => 'offen',
'discounted|effort status'                               => 'abgerechnet',
'balanced|effort status'                                 => 'bezahlt',
'not chargeable|effort status'                           => 'nicht abrechenbar',
'new'                                                    => 'neu',
'open'                                                   => 'offen',
'discounted'                                             => 'abgerechnet',
'balanced'                                               => 'bezahlt',
'not chargeable'                                         => 'nicht abrechenbar',

### ../pages/file.inc  ###
'Mark this file as bookmark'                             => 'Diese Datei als Lesezeichen markieren',

### ../pages/version.inc  ###
'Mark this version as bookmark'                          => 'Diese Version als Lesezeichen markieren',

### ../pages/effort.inc  ###
'Mark this effort as bookmark'                           => 'Diesen Aufwand als Lesezeichen markieren',

### ../pages/person.inc   ###
'Efforts'                     =>'Aufwände',

### ../lists/list_tasks.inc   ###
'Effort in hours'             =>'Aufwand in Stunden',

### ../pages/comment.inc   ###
'New Comment'                 =>'Neuer Kommentar',
'Reply to '                   =>'Anwort auf ',
'Edit Comment'                =>'Kommentar bearbeiten',
'On task %s'                  =>'für Aufgabe %s',
'On project %s'               =>'für Projekt %s',
'Occasion'                    =>'Gelegenheit',

### ../pages/task.inc   ###
'Publish to'                   =>'Sichtbar für',
'Edit this task'              =>'Aufgabe bearbeiten',
'Append bug report'           =>'Fehlerbericht hinzufügen',
'Delete this task'            =>'Aufgabe löschen',
'Restore this task'           =>'Aufgabe wieder herstellen',

### ../pages/comment.inc   ###
'Select some comments to delete'=>'Bitte wählen Sie die zu löschenden Kommentare',
'Select some comments to move'=>'Bitte wählen Sie die zu verschiebenden Kommentare',

### ../pages/task.inc   ###
'Select excactly ONE folder to move tasks into'=>'Bitte wählen sie zusätzlich genau einen Ordner als Ziel.',

### ../pages/comment.inc   ###
'is no longer a reply'        =>'Ist nicht länger eine Antwort',

### ../pages/company.inc   ###
'related projects of %s'     =>'Relevante Projekte für %s',

### ../pages/proj.inc   ###
'admin view'                  =>'Admin-Sicht',
'List'                        =>'Liste',

### ../pages/company.inc   ###
'no companies'                =>'Keine Firmen',

### ../pages/proj.inc   ###
'Overview'                    =>'Überblick',

### ../pages/company.inc   ###
'Edit this company'           =>'Firma bearbeiten',
'Delete this company'         =>'Firma löschen',
'Create new person for this company'=>'Neue Person für Firma',

### ../pages/person.inc   ###
'Person'                      =>'Person',

### ../pages/company.inc   ###
'Create new project for this company'=>'Neues Projekt für Firma',
'Add existing persons to this company'=>'Existierende Person mit Firma verbinden',
'Persons'                     =>'Personen',

### ../pages/person.inc   ###
'Summary'                     =>'Zusammenfassung',
'Adress'                      =>'Addresse',
'Fax'                         =>'Fax',

### ../pages/company.inc   ###
'Web'                         =>'Web',
'Intra'                       =>'Intra',
'Mail'                        =>'E-Mail',
' Hint: for already existing projects please edit those and adjust company-setting.'
                                =>' Tip: Zuweisung bereits existierender Projekte müssen am Projekt vorgenommen werden..',
'no projects yet'             =>'noch keine Projekte',
'link existing Person'        =>'existieren Personen hinzufügen',
'create new'                  =>'neu erstellen',
'no persons related'          =>'keine relevanten Personen',
'Create another company after submit'=>'anschließend eine weitere Firma erstellen',
'Edit %s'                     =>'Bearbeite %s',
'Add persons employed or related'=>'in Bezug stehende Personen hinzufügen',
'No persons selected...'=>'Es waren keine Personen ausgewählt',
'Person already related to company'=>'Person arbeitet bereits für diese Firma',
'Select some companies to delete'=>'Bitte wählen Sie zu löschende Firmen',
'Select one or more companies' =>'Wählen Sie eine oder mehrere Firmen aus',
'Export companies'			  =>'Firmenliste exportieren',

### ../pages/effort.inc   ###
'New Effort'                  =>'Neuer Aufwand',
'only expected one task. Used the first one.'=>'Kann nur die erste Aufgabe verwenden.',
'For task'                    =>'Für Aufgabe',
'Could not get effort'        =>'Kann Aufwand nicht ermitteln',
'Could not get project of effort'=>'Kann Projekt für Aufwand nicht ermitteln',
'Select some efforts to delete'=>'Bitte wählen Sie zu löschende Aufwände.',
'Effort description'		   => 'Aufwandsbeschreibung',
'Time start|label'	   		   => 'Startzeit',
'Time end|label'	   		   => 'Endzeit',
'Duration|label'	   		   => 'Dauer',
'Number of efforts|label'	   => 'Gesamtanzahl',
'Sum of efforts|label'		   => 'Gesamtsumme',
'Time start (min)|label'      =>'Startzeit (min)',
'Time end (max)|label'        =>'Endzeit (max)',
'Time|label'        		  =>'Zeit',
'not available'				  =>'Nicht verfügbar',
'from|time label'			  =>'von',
'to|time label'			      =>'bis',
'len'						  =>'Dauer',
'Export efforts'			  =>'Aufwandsliste exportieren',
'Select some efforts(s) to edit' => 'Bitte wählen Sie einen oder meherer Aufwände aus.',
'Edited %s effort(s).'        =>'%s Aufwände bearbeitet.',
'Error while editing %s effort(s).' => '%s  Fehler trat(en) während der Bearbeitung auf.',
'Edit %s efforts'             =>'%s Aufwände bearbeiten',

### ../pages/error.inc   ###
'Unknown Page'                =>'Unbekannte Seite',

### ../pages/home.inc   ###
'You are not assigned to a project.'=>'Sie sind in keinem Projekt.',

### ../pages/login.inc   ###
'Welcome to streber'          =>'Willkommen bei Streber.',
'please login'                =>'Bitte anmelden',
'invalid login'               =>'Anmeldung fehlgeschlagen',

### ../pages/person.inc   ###
'Active People'               =>'Aktive Personen',

### ../pages/proj.inc   ###
'relating to %s'              =>'in Verbindung mit %s',

### ../pages/person.inc   ###
'With Account'                =>'mit Konto',
'All Persons'                 =>'Alle Personen',
'no related persons'          =>'keine relevanten Personen',
'Edit this person'            =>'Diese Person bearbeiten',
'Profile'                     =>'Profil',
'User Rights'                 =>'Benutzerrechte',
'Mobile'                      =>'Mobil',
'Website'                     =>'Webseite',
'Personal'                    =>'Persönlich',

### ../pages/proj.inc   ###
'E-Mail'                      =>'E-Mail',

### ../pages/person.inc   ###
'works for'                   =>'arbeitet für Firma',
'not related to a company'    =>'arbeitet für keine Firma',
'works in Projects'           =>'in Projekten',
'no active projects'          =>'keine aktiven Projekte',
'not allowed to edit'         =>'nicht genug Rechte zum Bearbeiten',
'Person can login'            =>'Person kann sich anmelden',
'Theme'                       =>'Style',
'Create another person after submit'=>'Anschließend eine weitere Person erstellen',
'Could not get person'        =>'Konnte Person nicht herausfinden',
'Nickname has to be unique'=>'Nicknamen müssen eindeutig sein.',
'passwords don´t match'       =>'Passwörter stimmen nicht überein',
'Login-accounts require a unique nickname'=>'Personen mit Benutzerkonten benötigen einen eindeutigen Nicknamen',
'could not insert object'=>'konnte objekt nicht einfügen',
'Select some persons to delete'=>'Bitte wählen Sie die zu löschenden Personen',
'Adjust user-rights of %s'    =>'Nutzerrechte von %s bearbeiten',
'Please consider that activating login-accounts might trigger security-issues.'
                              =>'Bitte berücksichtigen Sie, dass Benutzerkonten ein potentielles Risiko darstellen.',
'User rights changed'         =>'Benutzerrechte wurden geändert.',
'Select one or more persons' =>'Wählen Sie ein oder mehrere Personen aus',
'Export persons'			  =>'Personenliste exportieren',
'Create Note'                 =>'Notiz erstellen',
'Delete this person'          =>'Person löschen',

### ../pages/proj.inc   ###
'Active'                      =>'Aktiv',
'Templates'                   =>'Vorlagen',
'Your Active Projects'        =>'Ihre aktiven Projekte',
'<b>NOTE</b>: Some projects are hidden from your view. Please ask an administrator to adjust you rights to avoid double-creation of projects'
                                =>'Hinweis: Einige Projekte sind für Sie nicht sichtbar. Zur Vermeidung von doppelt erstellten Projekten, sollten Sie sich mit Ihren Administrator absprechen.',
'not assigned to a project'   =>'Nicht Mitglied eines Projektes',
'Your Closed Projects'        =>'Ihre abgeschlossenen Projekte',
'invalid project-id'          =>'ungültige Projekt-ID',
'Edit this project'           =>'Dieses Projekt bearbeiten',
'Delete this project'         =>'Dieses Projekt löschen',
'Add person as team-member to project'
                              =>'Person zu einem Projekt hinzufügen',
'Create task with issue-report'=>'Aufgabe mit Fehlerbeschreibung erstellen',
'Add Bugreport'               =>'neuer Fehlerbericht',
'Book effort for this project'=>'Aufwand für dieses Projekt buchen',
'Log Effort'                  =>'Aufwand buchen',
'Logged effort'               =>'gebuchte Aufwände',
'Team members'                =>'Projektmitglieder',
'All open tasks'              =>'Alle offenen Aufgaben',
'Comments on project'         =>'Projekt Kommentare',
'Project Efforts'             =>'Projekt Aufwände',
'Closed Tasks'                =>'Abgeschlossene Aufgaben',
'changed project-items'       =>'geänderte Projekt-Objekte',
'no changes yet'              =>'keine Änderungen bis jetzt',
'Project Issues'              =>'Projekt Fehler',
'Report Bug'                  =>'Fehler melden',
'Select some projects to delete'=>'Bitte wählen Sie zu löschende Projekte',
'Failed to delete %s projects'=>'Das Löschen von %s Aufgaben ist gescheitert',
'Moved %s projects to trash'=>'%s Projekte in den Papierkorb verschoben',
'Select some projects...'     =>'Bitte wählen Sie einige Projekte',
'Invalid project-id!'         =>'Ungültige Projekt-ID',
'Y-m-d'                       =>'Y-m-d',
'Failed to change %s projects'=>'WARNUNG: Das Ändern von %s schlug fehl',
'Closed %s projects'          =>'%s Projekte geschlossen',
'Select new team members'     =>'Bitte wählen Sie neue Teammitglieder',
'found no persons to add'     =>'Keine Personen zum hinzufügen gefunden',
'No persons selected...'      =>'Es waren keine Personen ausgewählt.',
'Could not access person by id'=>'Konnte nicht auf Person mit ID zugreifen',
'reanimated person as team-member'=>'Person wurde wieder aufgenommen.',
'Person already in project'=>'Person ist bereits ein Team-Mitglied',
'Failed to insert new project'=>'Das Hinzufügen des neuen Projekt ist gescheitert.',
'Failed to insert new projectproject'=>'Das Hinzufügen des neuem Team-Mitgliedes ist gescheitert.',
'Failed to insert new issue'  =>'Das Hinzufügen des neuen Fehlerberichtet ist gescheitert',
'Failed to update new task'   =>'Das Hinzufügen der neuen Aufgabe ist gescheitert',
'Failed to insert new comment'=>'Das Hinzufügen des neuen Kommentars ist gescheitert',
'Select one or more projects' =>'Wählen Sie ein oder mehrere Projekte aus',
'Export projects'			  =>'Projektliste exportieren',

### ../pages/task.inc   ###
'Issue report'                =>'Fehlerbericht',
'Plattform'                   =>'Plattform',
'OS'                          =>'OS',
'Version'                     =>'Version',
'Build'                       =>'Build',
'Steps to reproduce'          =>'Schritte zum Nachstellen',
'Expected result'             =>'erwartetes Ergebnis',
'Suggested Solution'          =>'mögliche Lösung',
'I guess you wanted to create a folder...'=>'Ich vermute, Sie wollten einen Folder erstellen...',
'Assumed <b>%s</b> to be mean label <b>%s</b>'=>'<b>%s</b> wurde als Etikett <b>%s</b> verwendet',
'No project selected?'        =>'Keine Projekte ausgwählt?',
'New Folder'                  =>'Neuer Ordner',
'No task selected?'           =>'Keine Aufgaben ausgewählt',
'Ungrouped %s subtasks to <b>%s</b>'=>'%s Unteraufgaben wurden nach %s verschoben',
'You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'              =>'Sie haben <b>%s</b> zu einem Ordner gemacht. Ordner werden nur in Baumansichten angezeigt.',
'Select some tasks to move'   =>'Bitte wählen Sie die zu verschiebenden Aufgaben.',
'Task <b>%s</b> deleted'           =>'Aufgabe <b>%s</b> wurde gelöscht.',
'Moved %s tasks to trash'=>'%s Aufgaben wurden in den Papierkorb verschoben.',
'<br> ungrouped %s subtasks to above parents.'=>'<br>%s Unteraufgaben wurde in den Ordner verschoben.',
'Could not find task'=>'Aufgabe nicht gefunden.',
'Task <b>%s</b> doesn´t need to be restored'=>'Aufgabe %s muss nicht wieder hergestellt werden.',
'Task <b>%s</b> restored'          =>'Aufgabe <b>%s</b> wurde wieder hergestellt.',
'Failed to restore Task <b>%s</b>' =>'Wiederherstellung von <b>%s</b> gescheitert.',
'Marked %s tasks as approved and hidden from project-view.'=>'%s Aufgaben nach erledigt verschoben',
'could not update task'       =>'Aufgabe konnte nicht bearbeitet werden',
'No task selected to add issue-report?'=>'Bitte wählen Sie die Aufgabe für den Fehlerbericht',
'Task already has an issue-report'=>'Aufgabe hat bereits einen Fehlerbericht',
'Adding issue-report to task' =>'Fehlerbericht zu Aufgabe hinzufügen',
'Could not get task'          =>'Konnte Aufgabe nicht ermitteln',
'Select one or more tasks' =>'Wählen Sie eine oder mehrere Aufgaben aus',

### ../render/render_page.inc   ###
'Return to normal view'       =>'Zurück zur Normalansicht',
'Leave Client-View'           =>'Kundensicht verlassen',



### tooltips ###
'Required. Full name like (e.g. Thomas Mann)' =>'Wichtig. Vollständiger Name (z.B. Thomas Mann)',
'Required. (e.g. pixtur)' =>'z.B. pixtur',
'Optional: Additional tagline (eg. multimedia concepts)' =>'Namenszusatz (z.B. multimedia solution)',
'Optional: Private Phone (eg. +49-30-12345678)' =>'Private Telefonnummer',
'Optional: Private Fax (eg. +49-30-12345678)' =>'Private Fax-nummerr',
'Optional: Private (eg. Poststreet 28)' =>'Straße und Hausnummer',
'Optional: Private (eg. 12345 Berlin)' =>'Postleitzeit und Stadt',
'Optional: (eg. http://www.pixtur.de/login.php?name=someone)' =>'z.B. http://www.pixtur.de/login.php?name=someone',
'show as folder (may contain other tasks)' =>'Ordner für Aufgaben',
'Project priority (the icons have tooltips, too)' =>'Priorität der Projekte',
'Duplicate project' =>'Projekt duplizieren',
'Required. (e.g. pixtur ag)' =>'z.B. Pixtur AG limited',
'Optional: Short name shown in lists (eg. pixtur)' =>'Kurzbeschreibung für Schmale Listenspalten',
'Optional: Phone (eg. +49-30-12345678)' =>'z.B. +49-30-1234435',
'Optional: Fax (eg. +49-30-12345678)' =>'z.B. +49-30-1234435',
'Optional: (eg. Poststreet 28)' =>'z.B. Poststraße 28',
'Optional: (eg. 12345 Berlin)' =>'z.B. 12345 Berlin',
'Optional: (eg. http://www.pixtur.de)' =>'z.B. http://www.pixtur.de',
'Optional: Private (eg. Poststreet 28)' =>'z.B. Poststraße 28',
'Optional: (eg. Poststreet 28)' =>'z.B. Poststraße 28ß',

### in listen ###
'-- do...'                      =>'-- Funktion wählen...',
"Status is %s"                  =>'Status: %s',
"Priority is %s"                =>'Priorität: %s',


### ../pages/comment.inc   ###
'Failed to delete %s comments'=>'%s Kommentare konnten nicht gelöscht werden.',
'Moved %s comments to trash'=>'%s Kommentare in den Papierkorb verschoben.',

### ../pages/company.inc   ###
'Failed to delete %s companies'=>'%s Firmen konnten nicht gelöscht werden.',
'Moved %s companies to trash'=>'%s Firmen in den Papierkorb verschoben.',
'Failed to remove %s contact person(s)' => '%s Ansprechpartner konnte(n) nicht entfernt werden.',
'Removed %s contact person(s)' => '%s Ansprechpartner wurde(n) entfernt.',

### ../pages/effort.inc   ###
'Failed to delete %s efforts'=>'%s Aufwände konnten nicht gelöscht werden.',
'Moved %s efforts to trash'=>'%s Aufwände in den Papierkorb verschoben.',

### ../pages/person.inc   ###
'passwords don´t match'       =>'Passwörter stimmen nicht überein.',
'Failed to delete %s persons'=>'Die Objekte für %s Personen konnten nicht gelöscht werden.',
'Moved %s persons to trash'=>'Die Objekte für %s Personen wurden in den Papierkorb verschoben.',
'Failed to remove %s companies' => '%s Firmen konnten nicht entfernt werden.',
'Removed %s companies' => '%s Firmen wurden entfernt.',
'No companies selected...' => 'Es wurden keine Firmen ausgewählt ...',
'Company already related to person' => 'Firma ist bereits dieser Person zugeordnet.',
'Add related companies' => 'in Bezug stehende Firmen hinzufügen',
'Add existing companies to this person' => 'Existierende Firmen mit dieser Person verbinden',


### ../pages/proj.inc   ###
'Issues'                      =>'Fehlerberichte',
'History'                     =>'Geschichte',



### ../db/db_item.inc   ###
'unnamed'                     =>'unbenannt',

### ../lists/list_tasks.inc   ###
'New / Add'                   =>'Neu / Hinzufügen',

### ../pages/task.inc   ###
'Assigned to'                 =>'Zugewiesen an',

### ../lists/list_tasks.inc   ###
'- no name -|in task lists'   =>'- unbekannt -',

### ../pages/company.inc   ###
'Active projects'             =>'Aktive Projekte',
'Closed projects'             =>'Abgeschlossene Projekte',

### ../pages/home.inc   ###
'Open tasks assigned to you'  =>'Offene, Ihnen zugewiesene Aufgaben',

### ../pages/person.inc   ###
'Language'                    =>'Sprache',
'passwords don´t match'       =>'Passwörter stimmen nicht überein',
'Select some persons to edit' =>'Bitte wählen Sie zu bearbeitende Personen',
'Could not get Person'        =>'Kann Person nicht finden',

### ../pages/proj.inc   ###
'Reactivated %s projects'     =>'%s Projekte wieder aktiviert',
'Failed to insert new projectperson'=>'Fehler beim Erstellen einer neuen Projektperson',

### ../pages/projectperson.inc   ###
'Edit Team Member'            =>'Projektrolle anpassen',
'role of %s in %s|edit team-member title'=>'Rolle von %s in Projekt %s bearbeiten',

### ../pages/task.inc   ###
'Assign to'                   =>'zuweisen für',
'Also assign to'              =>'auch zuweisen für',
'formerly assigned to %s'     =>'früher zugewiesen an %s',
'task was already assigned to %s'=>'Aufgabe war schon zugewiesen für %s',
'Task requires name'          =>'Aufgabe braucht einen Namen',
' ungrouped %s subtasks to above parents.'=>'Gruppierung von %s Unteraufgaben aufgehoben',
'Task <b>%s</b> doesn´t need to be restored'=>'Aufgabe <b>%s</b> muss nicht wiederhergestellt werden',

### ../render/render_list_column_special.inc   ###
'Days until planned start'    =>'Tage bis zum geplanten Anfang',
'Due|concerning time'         =>'Fällig',
'Number of open tasks is hilighted if shown home.'=>'Anzahl der Aufgaben wird hervorgehoben, wenn diese in der HOME-Ansicht gezeigt werden',
'Item is publish to'           =>'Objekt sichtbar für...',
'Pub|table-header, public'    =>'Sicht',
'Publish to %s'                =>'Sichtbar für %s',
'Select / Deselect'            =>'Anwählen / Abwählen',

#<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

### ../db/class_project.inc   ###
'insuffient rights (not in project)'=>'Fehlende Zugriffsrechte, da nicht im Projekt.',

### ../lists/list_persons.inc   ###
'(adjusted)'                  =>'(angepasst)',

### ../lists/list_projectchanges.inc   ###
'(on comment)'                =>'(an Kommentar)',
'(on task)'                   =>'(an Aufgabe)',
'(on project)'                =>'(an Projekt)',

### ../lists/list_changes.inc ###
'(on task: %s)'                   =>'(zu Aufgabe: %s)',
'(on comment: %s)'                =>'(zu Kommentar: %s)',
'(on project: %s)'                =>'(zu Projekt: %s)',

### ../pages/_handles.inc   ###
'Create Template'             =>'Vorlage erstellen',
'Project from Template'       =>'Projekt von Vorlage',

### ../pages/home.inc   ###
'Open tasks (including unassigned)'=>'Offene Aufgaben (inkl. nicht zugewiesene)',

### ../pages/person.inc   ###
'(resetting rights)'          =>'(Rechte zurücksetzend)',
'passwords do not match'      =>'Passwörter stimmen nicht überein',
'Password is too weak (please add numbers, special chars or length)'=>'Passwort zu kurz',

### ../pages/proj.inc   ###
'Project Template'            =>'Projekt Vorlage',
'Inactive Project'            =>'Inaktive Projekte',
'Project|Page Type'           =>'Projekt',
'Template|as addon to project-templates'=>'Vorlage',
'Project duplicated (including %s items)'=>'Projekt wurde kopiert (inklusive %s elemente)',

### ../pages/task.inc   ###
'No task(s) selected for deletion...'=>'Keine Aufgaben zu löschen ausgewählt.',
'Task <b>%s</b> do not need to be restored'=>'Aufgabe <b>%s</b> muss nicht wieder hergestellt werden.',
'No task(s) selected for restoring...'=>'Keine Aufgaben zum wiederherstellen ausgewählt.',
'Select some task(s) to mark as completed'=>'Bitte wählen Sie Aufgaben, um diese als erledigt zu kennzeichnen.',
'Marked %s tasks (%s subtasks) as completed.'=>'%s Aufgaben als erledigt gekennzeichnet.',
'Marked %s tasks as closed.'=>'%s Aufgaben als geschlossen gekennzeichnet.',
'%s error(s) occured'         =>'Es sind %s Fehler aufgetreten.',
'Not enough rights to close %s tasks.' => 'Sie haben nicht genug Rechte, um %s Aufgabe(n) zu schließen.',
'Select some task(s) to mark as approved'=>'Bitte wählen Sie Aufgaben, um diese als abgenommen zu kennzeichnen.',
'Select some task(s) to mark as closed'=>'Bitte wählen Sie Aufgaben, um diese als geschlossen zu kennzeichnen.',
'Select some task(s)'         =>'Bitte wählen Sie Aufgaben.',

### ../render/render_list_column_special.inc   ###
'Due|column header, days until planned start'=>'Bis',
'planned for %s|a certain date'=>'Geplant für %s',
'Pub|column header for public level'=>'Pub',

### ../render/render_misc.inc   ###
'No element selected? (could not find id)|Message if a function started without items selected'=>'Keine Objekte ausgewählt?',

### ../std/class_pagehandler.inc   ###
'operation aborted (%s)'=>'Operation abgebrochen (%s)',
'Insuffient rights'    =>'Fehlende Berechtigung.',


##############

### ../lists/list_project_team.inc   ###
'Edit team member'            =>'Projektrolle bearbeiten',

### ../pages/_handles.inc   ###
'Search'                      =>'Suchen',

### ../pages/effort.inc   ###
'Edit Effort'                 =>'Aufwand bearbeiten',
'Date / Duration|Field label when booking time-effort as duration'=>'Datum / Aufwand',
'Name required'               =>'Name wird benötigt.',
'Cannot start before end.'    =>'Kann nicht vor dem Anfang aufhören.',

### ../pages/proj.inc   ###
'create new project'          =>'Neues Projekt erstellen',
'no tasks closed yet'         =>'Bisher keine Aufgaben abgeschlossen',
'Create another project after submit'=>'anschließend weiteres Projekt erstellen',
'Failed to insert new project person. Data structure might have been corrupted'=>'Project person konnte nicht geschrieben werden. Datenbankstruktur eventuell beschädigt!',
'Failed to insert new project. Datastructure might have been corrupted'=>'Project konnte nicht geschrieben werden. Datenbankstruktur eventuell beschädigt!',
'Failed to insert new issue. DB structure might have been corrupted.'=>'Issue konnte nicht geschrieben werden. Datenbankstruktur eventuell beschädigt!',
'Failed to update new task. DB structure might have been corrupted.'=>'Task konnte nicht geschrieben werden. Datenbankstruktur eventuell beschädigt!',
'Failed to insert new comment. DB structure might have been corrupted.'=>'Comment konnte nicht geschrieben werden. Datenbankstruktur eventuell beschädigt!',

### ../pages/projectperson.inc   ###
'Role in this project'        =>'Rolle in diesem Projekt',
'start times and end times'   =>'Anfangs- und Endzeiten',
'duration'                    =>'nur Zeitaufwände',
'Log Efforts as'              =>'Aufwände buchen als',

### ../pages/search.inc   ###
'Jumped to the only result found.'=>'Sofort zum einzigen Suchergebnis gesprungen.',
'Search Results'              =>'Suchergebnisse',
'Searching'                   =>'Suche',
'Found %s companies'          =>'%s Firmen gefunden',
'Found %s projects'           =>'%s Projekte gefunden',
'Found %s persons'            =>'%s Personen gefunden',
'Found %s tasks'              =>'%s Aufgaben gefunden',
'Found %s comments'           =>'%s Kommentare gefunden',

### ../pages/task.inc   ###
'Summary|Block title'         =>'Übersicht',
'Description|Label in Task summary'=>'Beschreibung',
'Part of|Label in Task summary'=>'Gehört zu',
'Status|Label in Task summary'=>'Status',
'Opened|Label in Task summary'=>'Begonnen',
'Closed|Label in Task summary'=>'Abgeschlossen',
'Created by|Label in Task summary'=>'Erstellt von',
'Last modified by|Label in Task summary'=>'Bearbeitet von',
'Logged effort|Label in task-summary'=>'Gebuchter Aufwand',
'open sub tasks|Table headline'=>'Offene Unteraufgaben',
'All open tasks|Title in table'=>'All offenen Aufgaben',
'Steps to reproduce|label in issue-reports'=>'Schritten zum Nachvollziehen',
'Expected result|label in issue-reports'=>'Erwartetes Ergebnis',
'Suggested Solution|label in issue-reports'=>'Mögliche Lösung',
'Bug|Task-Label that causes automatically addition of issue-report'=>'Fehler',
'Edit Task|Page title'        =>'Aufgabe bearbeiten',
'Assign to|Form label'        =>'Zuweisen an',
'Also assign to|Form label'   =>'Auch zuweisen an',
'Prio|Form label'             =>'Prio',
'undefined'                   =>'undefiniert',
'Severity|Form label, attribute of issue-reports'=>'Schweregrad',
'reproducibility|Form label, attribute of issue-reports'=>'Wiederholbarkeit',
'unassigned to %s|task-assignment comment'=>'abgegeben an %s',
'formerly assigned to %s|task-assigment comment'=>'war davor %s zugewiesen',

### ../std/class_pagehandler.inc   ###
'Operation aborted with an fatal error (%s). Please help us by %s'=>'',
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up. Please help us by %s'=>'',



### ../lists/list_tasks.inc   ###
'Add new Task'                =>'Neue Aufgabe',

### ../pages/task.inc   ###
'Report new Bug'              =>'Neuer Fehlerbericht',

### ../pages/_handles.inc   ###
'New Bug'                     =>'Neuer Fehler',
'View comment'                =>'Kommentar zeigen',
'System Information'          =>'System Information',
'PhpInfo'                     =>'phpInfo',

### ../pages/task.inc   ###
'(deleted %s)|page title add on with date of deletion'=>'(gelöscht %s)',

### ../pages/comment.inc   ###
'Edit this comment'           =>'Kommentar bearbeiten',
'New Comment|Default name of new comment'=>'Neuer Kommentar',
'Reply to |prefix for name of new comment on another comment'=>'Antwort auf ',
'Edit Comment|Page title'     =>'Kommentar bearbeiten',
'New Comment|Page title'      =>'Neuer Kommentar',
'On task %s|page title add on'=>'zu Aufgabe %s',

### ../pages/effort.inc   ###
'On project %s|page title add on'=>'zu Projekt %s',

### ../pages/comment.inc   ###
'Occasion|form label'         =>'Gelegenheit',
'Publish to|form label'        =>'Öffentlich für',
'is no longer a reply|message'=>'Kommentar ist nicht länger eine Antwort',

### ../pages/effort.inc   ###
'Edit Effort|page type'       =>'Aufwand bearbeiten',
'Edit Effort|page title'      =>'Aufwand bearbeiten',
'New Effort|page title'       =>'Neuer Aufwand',

### ../pages/error.inc   ###
'Error|top navigation tab'    =>'Fehler',

### ../pages/home.inc   ###
'S|Column header for status'  =>'S',
'P|Column header for priority'=>'P',
'Priority|Tooltip for column header'=>'Prio',
'Company|column header'       =>'Firma',
'Project|column header'       =>'Projekt',
'Edit|function in context menu'=>'Bearbeiten',
'Log hours for a project|function in context menu'=>'Aufwand buchen',
'Create new project|function in context menu'=>'Neues Projekt erstellen',
'P|column header'             =>'P',
'S|column header'             =>'S',
'Folder|column header'        =>'Ordner',
'Started|column header'       =>'Begonnen',
'Est.|column header estimated time'=>'Geschä.',
'Edit|context menu function'  =>'Bearbeiten',
'status->Completed|context menu function'=>'Status fertig',
'status->Approved|context menu function'=>'Status abgenommen',
'status->Closed|context menu function'=>'Status geschlossen',
'Delete|context menu function'=>'Löschen',
'Log hours for select tasks|context menu function'=>'Aufwand für Aufgabe buchen',

### ../pages/login.inc   ###
'Login|tab in top navigation' =>'',
'License|tab in top navigation'=>'',
'Welcome to streber|Page title'=>'',
'Name|label in login form'    =>'',
'Password|label in login form'=>'',
'invalid login|message when login failed'=>'',
'License|page title'          =>'',

### ../pages/misc.inc   ###
'Admin|top navigation tab'    =>'Admin',
'System information'          =>'System Information',
'Admin'                       =>'Admin',
'Database Type'               =>'Datenbank Type',
'PHP Version'                 =>'PHP-Version',
'extension directory'         =>'Erweiterungs Verz.',
'loaded extensions'           =>'gelandene Erweit.',
'include path'                =>'include Verzeichnis',
'register globals'            =>'register Globals',
'magic quotes gpc'            =>'magic quotes gpc',
'magic quotes runtime'        =>'magic quotes runtime',
'safe mode'                   =>'safe mode',

### ../pages/company.inc  ###
'Companies|page option'				=> 'Firmen',
'Clients|page option'				=> 'Kunden',
'Prospective Clients|page option'	=> 'Interessenten',
'Suppliers|page option'				=> 'Lieferanten',
'Partners|page option'				=> 'Partner',

'Clients'							=> 'Kunden',
'Prospective Clients'				=> 'Interessenten',
'Suppliers'							=> 'Lieferanten',
'Partners'							=> 'Partner',

### ../pages/person.inc   ###
'relating to %s|page title add on listing pages relating to current user'=>'in bezug auf %s',
'With Account|page option'    =>'Mit Benutzerkonto',
'All Persons|page option'     =>'Alle Personen',
'Employees|page option'    	  =>'Mitarbeiter',
'Contact Persons|page option' =>'Ansprechpartner',
'People/Project Overview'     =>'Personen / Project Überblick',
'Persons|Pagetitle for person list'=>'Personen',
'relating to %s|Page title Person list title add on'=>'in Bezug auf %s',
'admin view|Page title add on if admin'=>'AdminSicht',
'Edit this person|Tooltip for page function'=>'Person bearbeiten',
'Profile|Page function edit person'=>'Profil',
'Edit User Rights|Tooltip for page function'=>'Rechte anpassen',
'User Rights|Page function for edit user rights'=>'Rechte anpassen',
'Adress|Label'                =>'Adresse',
'Mobile|Label mobilephone of person'=>'Mobil',
'Office|label for person'     =>'Büro',
'Private|label for person'    =>'Privat',
'Fax|label for person'        =>'Fax',
'Website|label for person'    =>'Webseite',
'Personal|label for person'   =>'Privat',
'E-Mail|label for person office email'=>'E-Mail',
'E-Mail|label for person personal email'=>'E-Mail',
'works for|List title'        =>'Arbeitet für',
'works in Projects|list title for person projects'=>'Arbeitet in Projekten',
'Efforts|Page title add on'   =>'Aufwände',
'Overview|Page option'        =>'Überblick',
'Efforts|Page option'         =>'Aufwände',
'Edit Person|Page type'       =>'Person bearbeiten',
'Password|form label'         =>'Passwort',
'confirm Password|form label' =>'Passwort',
'Person can login|form label' =>'kann sich anmelden',
'(resetting rights)| additional form label when changing profile'=>'Rechte zurücksetzend',
'Profile|form label'          =>'Profil',
'Theme|form label'            =>'Theme',
'Language|form label'         =>'Sprache',
'Edit Person|page type'       =>'Person bearbeiten',
'Assigne to project|form label' =>'Zuordnen zu Projekt',
'- no -'					  =>'- nein -',

### ../pages/proj.inc   ###
'List|page type'              =>'Liste',
'Summary|block title'         =>'Zusammenfassung',
'Status|Label in summary'     =>'Status',
'Opened|Label in summary'     =>'Begonnen',
'Closed|Label in summary'     =>'Abgeschl.',
'Created by|Label in summary' =>'erstellt',
'Last modified by|Label in summary'=>'zuletzt bearb.',
'hours'                       =>'Stunden',
'Client|label'                =>'Kunde',
'Phone|label'                 =>'Telefon',
'E-Mail|label'                =>'E-Mail',
'new Effort'                  =>'neuer Aufwand',
'Company|form label'          =>'Kunde',

### ../pages/projectperson.inc   ###
'Changed role of <b>%s</b> to <b>%s</b>'=>'Rolle von %s angepasst',

### ../pages/search.inc   ###
'Sorry. Could not find anything.'=>'Suche leider ergebnislos.',
'Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters'=>'Suche funktioniert nur für<br>- Wörter mit mehr als 3 Buchstaben<br>- Listen mit mehr als 3 Einträgen<br>- Wörter ohne Sonderzeichen',

### ../pages/task.inc   ###
'Task with subtasks|page type'=>'Aufgabe mit Unteraufgaben',
'Task|page type'              =>'Aufgabe',
'new subtask for this folder' =>'Neue Unteraufgabe in diesem Ordner',
'New task'                    =>'Neue Aufgabe',
'new bug for this folder'     =>'Neue Fehlermeldung',
'Turned parent task into a folder. Note, that folders are only listed in tree'=>'Aufgabe wurde in einen Ordner geändert. Diese werden nur in der Baumdarstellung gezeigt.',
'Failed, adding to parent-task'=>'Konte nicht zum Ordner hinzugefügt werden.',
'Task <b>%s</b> does not need to be restored'=>'Aufgabe %s muss nicht wieder hergestellt werden.',

### ../std/class_pagehandler.inc   ###
'Operation aborted with an fatal error (%s).'=>'Schwerwiegender Fehler: %s ',
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'Operation wurde wegen eines Fehlers in der Datenstruktur abgebrochen. Das kann ein Hinweis auf eine inkonsistente Datenbankstruktur sein. Unter Umständen sollten Sie eine Sicherung machen oder zur letzen Sicherung zurückkehren.',

### ../pages/login.inc   ###
'Login|tab in top navigation' =>'Anmelden',
'License|tab in top navigation'=>'Lizenz',
'Welcome to streber|Page title'=>'Willkommen',
'Name|label in login form'    =>'Name',
'Password|label in login form'=>'Passwort',
'invalid login|message when login failed'=>'Anmeldung fehlgeschlagen',
'License|page title'          =>'Lizenz',







### ../db/class_person.inc   ###
'only required if user can login (e.g. pixtur)'=>'Pflichtfeld, wenn sich Anwender anmelden kann.',
'Optional: Mobile phone (eg. +49-172-12345678)'=>'Mobile Telefon (z.B: +0-171-123456)',
'Optional: Office Phone (eg. +49-30-12345678)'=>'Büro Telefon (z.B: +49-30-123456)',
'Optional: Office Fax (eg. +49-30-12345678)'=>'Büro Fax (z.B: +49-30-123456)',
'Optional: Official Street and Number (eg. Poststreet 28)'=>'Büro Straße und Nummer (z.B. Poststraße 28)',
'Optional: Official Zip-Code and City (eg. 12345 Berlin)'=>'Büro Postleitzahl und Ort (z.B. 10178 Berlin)',
'Optional: (eg. www.pixtur.de)'=>'Optional (z.B. www.pixtur.de)',
'Optional: (eg. thomas@pixtur.de)'=>'Optional (z.B. thomas@pixtur.de)',
'Optional: Color for graphical overviews (e.g. #FFFF00)'=>'Farbe für grafische Darstellungen (z.B. #ff000)',
'Only required if user can login|tooltip'=>'Pflichtfeld, wenn sich Anwender anmelden kann.',

### ../pages/task.inc   ###
'Move tasks'                  =>'Aufgaben bewegen',

### ../lists/list_tasks.inc   ###
'Subtasks'                    =>'Unteraufgaben',

### ../pages/_handles.inc   ###
'Send Activation E-Mail'      =>'Aktivierungs E-Mail versenden',
'Activate an account'         =>'Konto aktivieren',

### ../pages/home.inc   ###
'Personal Efforts'            =>'Eigene Aufwände',

### ../pages/login.inc   ###
'I forgot my password.|label in login form'=>'Passwort vergessen.',
'If you remember your name, please enter it and try again.'=>'Wenn Du Dich wenigstens an Deinen Namen erinnern kannst, gib Ihn ein und versuche es noch einmal.',
'Supposed a user with this name existed a notification mail has been sent.'=>'Angenommen diese Anwender existiert, dann wurde ihm eine E-Mail geschickt.',
'Welcome %s. Please adjust your profile and insert a good password to activate your account.'=>'Willkommen %s. Bitte aktualisiere Dein Profil und vergib ein gutes Passwort.',
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter your name and use the <b>forgot password link</b> below.'=>'Fehler: dieser Aktivierungscode ist nicht mehr gültig. Eventuell wurde zwischenzeitlich das Passwort geändert...',

### ../pages/person.inc   ###
'daily'                       =>'täglich',
'each 3 days'                 =>'alle 3 Tage',
'each 7 days'                 =>'alle 7 Tage',
'each 14 days'                =>'alle 14 Tage',
'each 30 days'                =>'monatlich',
'Never'                       =>'Niemals',
'Send notifications|form label'=>'E-Mail mit Neuigkeiten',
'Send mail as html|form label'=>'E-Mail als HTML ver',
'Sending notifactions requires an email-address.'=>'E-Mail mit Neuigkeiten benötigt mindestens eine E-Mail Adresse',
'Read more about %s.'         =>'Lesen Sie mehr zu %s',
'Insufficient rights'         =>'Ungenügend Rechte',
'Notification mail has been sent.'=>'E-Mail mit Neuigkeiten wurde versendet.',
'Sending notification e-mail failed.'=>'Fehler beim versenden der E-Mail.',

### ../pages/proj.inc   ###
'Wikipage|Label in summary'   =>'Wiki Webseite',
'Projectpage|Label in summary'=>'Projekt Webseite',

### ../pages/task.inc   ###
'Comments on task'            =>'Kommentare für Aufgabe',
'insufficient rights'         =>'ungenügend Rechte',
'Can not move task <b>%s</b> to own child.'=>'Kann Aufgabe nicht an eigene Unteraufgabe hängen.',
'Can not edit tasks %s'       =>'Kann Aufgabe nicht bearbeiten.',
'Edit tasks'                  =>'Aufgaben bearbeiten',
'Select folder to move tasks into'=>'Wählen Sie einen Ordner als Ziel...',
'... or select nothing to move to project root'=>'... oder nichts für Projekt Ursprung.',

### ../render/render_list.inc   ###
'changed today'               =>'Heute geändert',
'changed since yesterday'     =>'Gestern geändert',
'changed since <b>%d days</b>'=>'seit <b>%s Tagen</b> geändert',
'changed since <b>%d weeks</b>'=>'seit <b>%s Wochen</b> geändert',
'created by %s'               =>'Erstellt von %s',
'created by unknown'          =>'Erstellt von unbekannt',

### ../std/constant_names.inc   ###
'template|status name'        =>'Vorlage',
'undefined|status_name'       =>'undefiniert',
'upcoming|status_name'        =>'kommt bald',
'new|status_name'             =>'neu',
'open|status_name'            =>'offen',
'onhold|status_name'          =>'halten',
'done?|status_name'           =>'fertig?',
'approved|status_name'        =>'abgenommen',
'closed|status_name'          =>'geschlossen',
'undefined|pub_level_name'    =>'undefiniert',
'private|pub_level_name'      =>'Privat',
'suggested|pub_level_name'    =>'Vorgeschlagen',
'internal|pub_level_name'     =>'Intern',
'open|pub_level_name'         =>'Öffentlich',
'client|pub_level_name'       =>'Kunden',
'client_edit|pub_level_name'  =>'Kundenbearbeitung',
'assigned|pub_level_name'     =>'Zugewiesen',
'owned|pub_level_name'        =>'eigenes',
'priv|short for public level private'=>'priv',
'int|short for public level internal'=>'int',
'pub|short for public level client'=>'Ku',
'PUB|short for public level client edit'=>'K!',
'A|short for public level assigned'=>'Zug',
'O|short for public level owned'=>'Eig',
'Create projects|a user right'=>'Projekte erstellen',
'Edit projects|a user right'  =>'Projekte bearbeiten',
'Delete projects|a user right'=>'Projekte löschen',
'Edit project teams|a user right'=>'Projekt Teams bearbeiten',
'View anything|a user right'  =>'Alles sehen',
'Edit anything|a user right'  =>'Alles bearbeiten',
'Create Persons|a user right' =>'Personen erstellen',
'Edit Presons|a user right'   =>'Personen bearbeiten',
'Delete Persons|a user right' =>'Personen löschen',
'View all Persons|a user right'=>'Alle Personen sehen',
'Edit User Rights|a user right'=>'Personen Rechte bearbeiten',
'Edit Own Profil|a user right'=>'Eigenes Profil bearbeiten',
'Create Companies|a user right'=>'Firmen erstellen',
'Edit Companies|a user right' =>'Firmen bearbeiten',
'Delete Companies|a user right'=>'Firmen löschen',
'undefined|priority'          =>'undefiniert',
'urgent|priority'             =>'dringend',
'high|priority'               =>'wichtig',
'normal|priority'             =>'normal',
'lower|priority'              =>'untergeordnet',
'lowest|priority'             =>'unwichtig',
'never|notification period'	  =>'niemals',
'one day|notification period' =>'einem Tag',
'two days|notification period'=>'zwei Tagen',
'three days|notification period'=>'drei Tagen',
'four days|notification period'=>'vier Tagen',
'five days|notification period'=>'fünf Tagen',
'one week|notification period'=>'einer Woche',
'two weeks|notification period'=>'zwei Wochen',
'three weeks|notification period'=>'drei Wochen',
'one month|notification period'=>'einem Monat',
'two months|notification period'=>'zwei Monaten',
'new|effort status'             =>'neu',
'open|effort status'            =>'offen',
'discounted|effort status'      =>'abgerechnet',
'balanced|effort status'        =>'bezahlt',

### ../std/mail.inc   ###
'<br>- You have been assigned to projects:<br><br>'=>'<br>- Sie wurden Projekten zugewiesen:<br><br>',
'<br>- You have been assigned to tasks:<br><br>'=>'<br>- Sie wurden Aufgaben zugewiesen:<br><br>',

'Adjust user-rights'          =>'Rechte bearbeiten',


### ../std/mail.inc   ###
'Changed monitored items:|notification'  	=> 'Geänderte Elemente:',
'Unchanged monitored items:|notification'	=> 'Unveränderte Elemente:',
'%s edited > %s'							=> '%s bearbeitete > %s',
'%s (not touched since %s day(s))'          => '%s (nicht verändert seit %s Tag(en))', 

### ../db/class_company.inc   ###
'Tag line|form field for company'=>'Namenszusatz',
'Short|form field for company'=>'Abkürzung',
'Phone|form field for company'=>'Telefon',
'Fax|form field for company'  =>'Fax',
'Street'                      =>'Straße & Nr.',
'Zipcode'                     =>'PLZ & Stadt',
'Intranet'                    =>'Firmennetz',
'Comments|form label for company'=>'Anmerkungen',

### ../db/class_person.inc   ###
'Office E-Mail'               =>'Büro E-Mail',
'Optional:  Private (eg. Poststreet 28)'=>'Optional (z.b. Poststraße 28)',
'Theme|Formlabel'             =>'Thema',

### ../pages/file.inc   ###
'Type'                        =>'Typ',

### ../lists/list_files.inc   ###
'Size'                        =>'Größe',

### ../pages/_handles.inc   ###
'Edit file'                   =>'Datei bearbeitne',

### ../lists/list_files.inc   ###
'New file'                    =>'Neue Datei',
'No files uploaded'           =>'Keine hochgeladenen Dateien',
'Download|Column header'      =>'Herunterladen',

### ../lists/list_projectchanges.inc   ###
'restore'                     =>'Wiederherstellen',

### ../lists/list_tasks.inc   ###
'Modified|Column header'      =>'Änderungsdatum',
'Add comment'                 =>'Kommentar hinzufügen',

### ../pages/proj.inc   ###
'Uploaded Files'              =>'Dateien',

### ../pages/_handles.inc   ###
'View file'                   =>'Datei zeigen',
'Upload file'                 =>'Datei hochladen',
'Update file'                 =>'Datei aktualisieren',

### ../pages/file.inc   ###
'Download'                    =>'Herunterladen',

### ../pages/_handles.inc   ###
'Show file scaled'             =>'Skaliert anzeigen',
'restore Item'                =>'Objekt wiederherstellen',

### ../pages/comment.inc   ###
'Can not edit comment %s'     =>'Kommentar %s kann nicht bearbeitet werden',
'Select one folder to move comments into'=>'Bitte einen Ordnet als Ziel wählen',
'No folders in this project...'=>'Keine Ordner in diesem Projekt',

### ../pages/task.inc   ###
'Move items'                  =>'Objekte verschieben',

### ../pages/file.inc   ###
'File'                        =>'Datei',
'Edit this file'              =>'Datei bearbeiten',
'Version #%s (current): %s'   =>'Version #%s (aktuell): %s',
'Filesize'                    =>'Dateigröße',
'Uploaded'                    =>'Hochgeladen am',
'Uploaded by'                 =>'Hochgeladen von',
'Version #%s : %s'            =>'Version %s : %s',
'Upload new version|block title'=>'Eine neuere Version hochladen',
'Edit File|page type'         =>'Datei bearbeiten',
'Edit File|page title'        =>'Datei bearbeiten',
'New File|page title'         =>'Neue Datei',
'Could not get file'          =>'Kann Datei nicht übertragen.',
'Could not get project of file'=>'Eigenschaften der Datei nicht verfügbar.',
'Please enter a proper filename'=>'Bitte geben Sie einen richtigen Namen an.',
'Select some files to delete' =>'Bitte wählen Sie Dateien zum löschen.',
'Failed to delete %s files'=>'%s Datei(en) konnten nicht gelöscht werden.',
'Moved %s files to trash'  =>'%s Datei(en) wurden in den Papierkorb verschoben.',
'Select some file to display' =>'',
'Select one or more files'    =>'Wählen Sie eine oder mehrere Dateien aus',
'Export files'			      =>'Dateienliste exportieren',

### ../pages/misc.inc   ###
'Select some items to restore'=>'Bitte wählen Sie Objekte zum wiederherstellen.',
'Item %s does not need to be restored'=>'%s Objekte brauchten nicht wiederhergestellt zu werden.',
'Failed to restore %s items'=>'%s Objekte konnten nicht wiederhergestellt werden.',
'Restored %s items'           =>'%s Objekt(e) wiederhergestellt.',

### ../pages/person.inc   ###
'Fax (office)|label for person'=>'Fax Büro',
'Adress Personal|Label'       =>'Anschrift privat',
'Adress Office|Label'         =>'Anschrift Büro',
'-- reset to...--'            =>'-- zurücksetzen --',
'Since nicknames are case sensitive using uppercase letters might confuse users at login.'=>'Da bei Nutzernahmen Groß- und Kleinschreibung unterschieden wird, wären einige Nutzer vielleicht verwirrt.',
'<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'=>'<b>%s</b> wurde bereits zu Projekten hinzugefügt und kann daher nicht gelöscht werden. Sie können jedoch das Konto für die Anmeldung deaktivieren.',

### ../pages/proj.inc   ###
'Files'                       =>'Dateien',

### ../pages/task.inc   ###
'Upload file|block title'     =>'Datei hochladen',

### ../pages/proj.inc   ###
'Add'                         =>'Hinzufügen',

### ../pages/task.inc   ###
'Undelete'                    =>'Wiederherstellen',

### ../render/render_form.inc   ###
'Submit'                      =>'OK',
'Cancel'                      =>'Abbrechen',
'Apply'                       =>'Übernehmen',

### ../render/render_list_column_special.inc   ###
'S|Short status column header'=>'S',
'Date'                        =>'Datum',
'Yesterday'                   =>'Gestern',

### ../std/constant_names.inc   ###
'Edit Persons|a user right'   =>'Personen bearbeiten',





### ../db/class_comment.inc   ###
'Details'                     =>'Details',

### ../db/class_issue.inc   ###
'Production build'            =>'Build Version',

### ../lists/list_projectchanges.inc   ###
'Nothing has changed.'=>'Keine Änderungen.',
'item %s has undefined type'=>'Item %s hat einen unbekannten Typ',

### ../lists/list_tasks.inc   ###
'Latest Comment'              =>'Letzte Kommentar',
'by'                          =>'von',
'for'                         =>'für',
'number of subtasks'          =>'Anzahl von Unteraufgaben',

### ../pages/_handles.inc   ###
'Flush Notifications'         =>'E-Mail jetzt senden',

### ../pages/company.inc   ###
'related Persons'             =>'relevante Personen',

### ../pages/file.inc   ###
'Could not access parent task.'=>'Konnte nicht auf Aufgabe zugreifen',
'Could not edit task'         =>'Konnte Aufgabe nicht bearbeiten',
'Select some file to display' =>'Wählen Sie eine zu zeigende Datei',

### ../pages/home.inc   ###
'Modified|column header'      =>'Bearbeitet',

### ../pages/person.inc   ###
'Birthdate|Label'             =>'Geburtstag',
'Assigned tasks'              =>'Zugewiesene Aufgaben',
'No open tasks assigned'      =>'Keine offenen Aufgaben zugewiesen',
'no efforts yet'              =>'Keine gebuchten Aufwände bisher',
'A notification / activation  will be mailed to <b>%s</b when you log out.'=>'Eine Benachtigung wird an %s verschickt, sobald Sie sich abmelden.',
'Since the user does not have the right to edit his own profile and therefore to adjust his password, sending an activation does not make sense.'=>'Die Person kann ihr Profil nicht bearbeiten (auch das Password nicht). Eine Aktivierungsmail zu senden, macht daher keine Sinn.',
'Sending an activation mail does not make sense, until the user is allowed to login. Please adjust his profile.'=>'Eine Aktivierungsmail macht nicht keinen Sinn, solange die Person sich nicht anmelden darf. Bitte Profil bearbeiten.',
'Activation mail has been sent.'=>'Aktivierungsmail wurde versendet',
'Select some persons to notify'=>'Wählen Sie eine Person zum benachrichtigen',
'Failed to mail %s persons'=>'Versenden der Mail an %s fehlgeschlagen.',
'Sent notification to %s person(s)'=>'Benachrichtigung wurde an %s Person(en) versendet.',

### ../pages/proj.inc   ###
'Your tasks'                  =>'Ihre Aufgaben',
'No tasks assigned to you.'   =>'Ihnen sind keine offene Aufgaben zugewiesen.',
'All project tasks'           =>'Alle Projektaufgaben',

### ../pages/task.inc   ###
'Planned start|Label in Task summary'=>'Geplanter Beginn',
'Planned end|Label in Task summary'=>'Geplantes Ende',
'Attached files'              =>'Hochgeladene Dateien',
'Send File'                   =>'Datei senden',
'Attach file to task|block title'=>'Datei an Aufgabe anhängen',
'Feature|Task label that added by default'=>'Feature',
'for %s|e.g. new task for something'=>'für %s',

### ../render/render_list.inc   ###
'modified by %s'              =>'geändert von %s',
'modified by unknown'         =>'',

### ../render/render_misc.inc   ###
'new since last logout'       =>'geändert seit letztem abmelden',

### ../std/constant_names.inc   ###
'Team Member'                 =>'Team Member',
'Employment'                  =>'Anstellung',
'Issue'                       =>'Fehlerbericht',
'Task assignment'             =>'Aufgabenzuweisung',
'Nitpicky|severity'           =>'Pedantisch',
'Feature|severity'            =>'Funktion',
'Trivial|severity'            =>'Trivial',
'Text|severity'               =>'Text',
'Tweak|severity'              =>'Verbesserung',
'Minor|severity'              =>'Unwichtig',
'Major|severity'              =>'Wichtig',
'Crash|severity'              =>'Absturz',
'Block|severity'              =>'Blockiert',
'Not available|reproducabilty'=>'Nicht verfügbar',
'Always|reproducabilty'       =>'Immer',
'Sometimes|reproducabilty'    =>'Manchmal',
'Have not tried|reproducabilty'=>'Nicht versucht',
'Unable to reproduce|reproducabilty'=>'nicht reproduzierbar',



### ../lists/list_comments.inc   ###
'Date|column header'          =>'Datum',
'By|column header'            =>'Von',

### ../lists/list_efforts.inc   ###
'no efforts booked yet'       =>'Keine Aufwände gebucht',
'booked'                      =>'gebucht',
'estimated'                   =>'geschätzt',
'Task|column header'          =>'Aufgabe',
'Start|column header'         =>'Beginn',
'End|column header'           =>'Ende',
'len|column header of length of effort'=>'Dauer',
'Daygraph|columnheader'       =>'Tagesgrafik',

### ../lists/list_projectchanges.inc   ###
'new'                         =>'neu',
'Type|Column header'          =>'Typ',


### ../render/render_list.inc   ###
'modified by unknown'         =>'Geändert von unbekannt',

### ../lists/list_persons.inc   ###
'last login'                  =>'angemeldet',
'Profile|column header'       =>'Profil',
'Account settings for user (do not confuse with project rights)'=>'Rechte für Person (Nicht zu verwechseln mit Rechten für ein bestimmtes Projekt).',
'Active Projects|column header'=>'Aktive Projekte',
'recent changes|column header'=>'Letzte Änderungen',
'changes since YOUR last logout'=>'Seit Ihrem letztem Logout',

### ../lists/list_project_team.inc   ###
'last Login|column header'    =>'Angemeldet',

### ../lists/list_tasks.inc   ###
'%s hidden'                   =>'%s ausgeblendet',

### ../pages/task.inc   ###
'Item-ID %d'                  =>'Item-Nr. %s',



### ../render/render_list.inc   ###
'item #%s has undefined type' =>'item #%s hat einen unbekannten Typ',

### ../std/mail.inc   ###
'You have been assigned to projects:'=>'Sie wurden zu folgenden Projekten hinzugezogen:',
'You have been assigned to tasks:'=>'Ihnen wurden folgende neuen Aufgaben zugewiesen:',

'Description' => 'Beschreibung',





### ../db/class_comment.inc   ###
'Title'                       =>'Titel',

### ../db/class_effort.inc   ###
'Time Start'                  =>'Startzeit',
'Time End'                    =>'Endzeit',

### ../db/db.inc   ###
'Database exception'          =>'Datenbankfehler',

### ../pages/_handles.inc   ###
'Edit Description'            =>'Beschreibung Bearbeiten',

### ../pages/comment.inc   ###
'Comment on task|page type'   =>'Kommentar an Aufgabe',


### ../pages/person.inc   ###
'Nickname has been converted to lowercase'=>'Nickname wurde in kleinbuchstaben konvertiert',

### ../pages/proj.inc   ###
'Details|block title'         =>'Details',

### ../pages/task.inc   ###
'Complete|Page function for task status complete'=>'Erledigt',
'Approved|Page function for task status approved'=>'Abgenommen',
'attach new'         =>'neue Datei',
'(or select nothing to move to project root)'=>'(oder nichts auswählen, um in die Projektwurzel zu verschieben)',
'Select a task to edit description'=>'Bitte wählen Sie eine Aufgaben, um deren Beschreibung zu bearbeiten',
'Edit description'            =>'Beschreibung bearbeiten',

### ../render/render_form.inc   ###
'Please use Wiki format'      =>'Wiki Formatierung erlaubt',

### ../render/render_wiki.inc   ###
'enlarge'                     =>'vergrößern',
'Unknown File-Id:'            =>'Unbekannte Datei-Id',
'Unknown project-Id:'         =>'Unbekannte Projekt-Id',
'No item matches this name'   =>'Kein Objekt für diesen Namen',
'No task matches this name exactly'=>'Keine Aufgabe hat diesen Namen',
'This task seems to be related'=>'',
'No item excactly matches this name.'=>'Kein Objekt hat präzise diesen Namen',
'List %s related tasks'       =>'%s relevante Aufgaben anzeigen',

### ../std/class_auth.inc   ###
'Could not set cookie.'       =>'Cookie konnte nicht gesetzt werden.',

### ../std/constant_names.inc   ###
'Create & Edit Persons|a user right'=>'Personen erstellen und bearbeiten',



### ../_docs/changes.inc   ###
'to'                          =>'für',
'you'                         =>'Sie',
'assign to'                   =>'zuweisen an',

### ../lists/list_changes.inc   ###
'to|very short for assigned tasks TO...'=>'für',
'in|very short for IN folder...'=>'in',
'read more...'                =>'weiter lesen...',
'%s comments:'                =>'%s Kommentare',
'comment:'                    =>'Kommentar:',
'completed'                   =>'Fertig?',
'approved'                    =>'Abgenommen!',
'closed'                      =>'Geschlossen',
'reopened'                    =>'Wieder offen',
'is blocked'                  =>'Blockiert',
'changed:'                    =>'bearbeitet:',
'commented'                   =>'Kommentiert',
'reassigned'                  =>'zugewiesen',
'Who changed what when...'    =>'Wer tat Was wann',
'what|column header in change list'=>'Was',
'Date / by'                   =>'Datum / Wer',

### ../lists/list_files.inc   ###
'Name|Column header'          =>'Name',
'Details/Version|Column header'          =>'Details/Version',

### ../pages/_handles.inc   ###
'Edit Project Description'    =>'Projektbeschreibung bearbeiten',

### ../pages/effort.inc   ###
'Could not get person of effort'=>'konnte person für Aufwand nicht ermitteln',

### ../pages/login.inc   ###
'I forgot my password'        =>'Passwort vergessen',

### ../pages/person.inc   ###
'A notification / activation  will be mailed to <b>%s</b> when you log out.'=>'Eine Aktivierungsmail wird and <b>%s</b> geschickt, sobald sie sich abmelden.',

### ../pages/proj.inc   ###
'No tasks have been closed yet'=>'Keine abgeschlossenen Aufgaben',
'Select a project to edit description'=>'Bitten wählen Sie ein zu bearbeitendes Projekt.',

### ../pages/task.inc   ###
'Upload'                      =>'Hochladen',
'Created task %s with ID %s'=>'Neue Aufgabe %s wurde mit ID %s erstellt.',

### ../render/render_misc.inc   ###
'Completed'                   =>'Fertig?',

### ../render/render_wiki.inc   ###
'No item matches this name. Create new task with this name?'=>'Objekt existiert nicht. Jetzt anlegen?',
'This task seems to be related'=>'Diese Aufgabe(n) könnten interessant sein.',
'No item matches this name.'  =>'Kein Objekt mit diesem Namen',

### ../std/constant_names.inc   ###
'blocked|status_name'         =>'Blockiert',

### ../std/mail.inc   ###
'Failure sending mail: %s'    =>'Fehlen beim Verschicken der Mail.',
'Hello %s,|notification'      =>'Hallo %s!',
'with this automatically created e-mail we want to inform you that|notification'=>'Diese Nachricht möchte Sie darüber informieren, dass',
'since %s'                    =>'seit %s',


### ../std/mail.inc   ###
'Streber Email Notification|notifcation mail from'=>'Streber Email Notification',
'Updates at %s|notication mail subject'=>'Neues auf %s',
'following happened at %s |notification'=>'folgendes auf %s passierte:',
'Your account has been created.|notification'=>'Ihr Konto wurde eingerichtet.',
'Please set password to activate it.|notification'=>'Setzen Sie ein Passwort zum Freischalten.',
'You have been assigned to projects:|notification'=>'Sie wurden folgenden Projekten zugewiesen.',
'Project Updates'             =>'Projekt Neuigkeiten',
'If you do not want to get further notifications or you forgot your password feel free to|notification'=>'Wenn Sie keine weiteren Mails bekommen möchten oder Ihr Passwort vergessen haben,',
'adjust your profile|notification'=>'passen Sie bitte Ihr Profil an.',
'Thanks for your time|notication'=>'Danke für Ihre Zeit,',
'the management|notication'   =>'Die Verwaltung',
'No news for <b>%s</b>'       =>'Nichts neues für %',



### ../lists/list_milestones.inc.php   ###
'Planned for'                 =>'Geplant für',

### ../pages/task.inc.php   ###
'For Milestone'               =>'für Meilenstein',

### ../db/class_task.inc.php   ###
'resolved_version'            =>'behoben in Version',
'is a milestone / version'    =>'is ein Meilenstein / eine Version',
'milestones are shown in a different list'=>'Meilensteine werden in einer separaten Liste aufgeführt',

### ../pages/task.inc.php   ###
'Estimated time'              =>'Geschätzte Zeit',
'Estimated worst case'        =>'im schlimmsten Fall',

### ../lists/list_tasks.inc.php   ###
'Milestone'                   =>'Meilenstein',

### ../lists/list_changes.inc.php   ###
'moved'                       =>'bewegt',

### ../pages/proj.inc.php   ###
'Milestones'                  =>'Meilensteine',

### ../pages/company.inc.php   ###
'or'                          =>'oder',

### ../lists/list_milestones.inc.php   ###
'Due Today'                   =>'Heute fällig',
'%s days late'                =>'%s Tage überfällig',
'%s days left'                =>'in %s Tagen',
'Tasks open|columnheader'     =>'Offene Aufgaben',
'Open|columnheader'           =>'Offen',
'%s open'                     =>'%s offen',
'Completed|columnheader'      =>'Fertig',
'Completed tasks: %s'         =>'Fertig: %s',

### ../lists/list_tasks.inc.php   ###
'Status|Columnheader'         =>'Status',
'Label|Columnheader'          =>'Etikett',
'Task has %s attachments'     =>'Aufgabe hat %s Anhänge',
'Est/Compl'                   =>'Zeit/Fertig',
'Estimated time / completed'  =>'Geschätze Zeit / Fertig',
'estimated %s hours'          =>'%s Stunden geschätzt',
'estimated %s days'           =>'%s Tage geschätzt',
'estimated %s weeks'          =>'%s Wochen geschätzt',
'%2.0f%% completed'           =>'%2.0f%% fertig',
'Estimated/Booked (Diff.)'    =>'Geschätzt/Gebucht (Diff.)',
'Completion:'                 =>'Fertigstellung:',
'Relation between estimated time and booked efforts' =>'Verhältnis zwischen geschätzter und gebuchter Arbeitszeit',

### ../pages/task.inc.php   ###
'New Milestone'               =>'Neuer Meilenstein',

### ../pages/company.inc.php   ###
'edit'                        =>'bearbeiten',

### ../pages/login.inc.php   ###
'Nickname|label in login form'=>'Nickname',

### ../pages/task.inc.php   ###
'new:'                        =>'neu:',

### ../pages/proj.inc.php   ###
'Team member'                 =>'Team Mitglied',
'Create task'                 =>'Aufgabe erstellen',

### ../pages/task.inc.php   ###
'Bug'                         =>'Fehler',

### ../pages/proj.inc.php   ###
'all open'                    =>'offene',
'all my open'                 =>'meine offenen',
'my open for next milestone'  =>'meilenstein',
'not assigned'                =>'nicht zugewiesen',
'blocked'                     =>'blockiert',
'open bugs'                   =>'offene Fehler',
'to be approved'              =>'zur Abnahme',
'open tasks'                  =>'offene Aufgaben',
'my open tasks'               =>'meine Aufgaben',
'next milestone'              =>'nächster Meilenstein',
'Create new folder for tasks and files'=>'Einen neuen Ordner für Aufgaben und Dateien erstellen',
'Filter-Preset:'              =>'Filter-Set',
'No tasks'                    =>'keine Aufgaben',
'new Milestone'               =>'neuer Meilenstein',
'View open milestones'        =>'Offene Meilensteine zeigen',
'View closed milestones'      =>'Geschlossene Meilensteine zeigen',
'modified by me'              =>'meine Änderungen',
'modified by others'		  =>'weitere Änderungen',
'last logout'                 =>'letzter Logout',
'1 week'                      =>'1 Woche',
'2 weeks'                     =>'2 Wochen',

### ../pages/task.inc.php   ###
'new task for this milestone' =>'neue Aufgabe für diesen Meilenstein',
'Append details'              =>'Details anhängen',
'Please select only one item as parent'=>'Bitte nur ein Objekt as Ziel wählen.',
'Insufficient rights for parent item.'=>'Ungenügend Rechte für Zielobjekt',
'could not find project'      =>'Konnte Projekt nicht finden',
'Edit %s|Page title'          =>'%s bearbeiten',
'-- undefined --'             =>'-- undefiniert --',
'Resolved in'                 =>'Behoben in',
'- select person -'           =>'- Person wählen -',
'30 min'                      =>'30 min',
'1 h'                         =>'1 h',
'2 h'                         =>'2 h',
'4 h'                         =>'4 h',
'1 Day'                       =>'1 Tag',
'2 Days'                      =>'2 Tage',
'3 Days'                      =>'3 Tage',
'4 Days'                      =>'4 Tage',
'1 Week'                      =>'1 Woche',
'1,5 Weeks'                   =>'1,5 Wochen',
'2 Weeks'                     =>'2 Wochen',
'3 Weeks'                     =>'3 Wochen',
'Failed to retrieve parent task'=>'Konnte Überaufgabe nicht ermitteln',
'Task called %s already exists'=>'Aufgabe mit Namen %s existiert bereits.',
'Changed task %s with ID %s'=>'Aufgabe %s (ID %s) geändert.',
'insufficient rights to edit any of the selected items'=>'Ungenügend Rechte zum Bearbeiten der Elemente',

### ../render/render_list.inc.php   ###
'for milestone %s'            =>'für Meilenstein %s',
'do...'                       =>'-- Funktion wählen--',

### ../render/render_misc.inc.php   ###
'Tasks|Project option'        =>'Aufgaben',
'Completed|Project option'    =>'Fertig',
'Milestones|Project option'   =>'Meilensteine',
'Versions|Project option'     =>'Versionen',
'Files|Project option'        =>'Dateien',
'Efforts|Project option'      =>'Aufwände',
'History|Project option'      =>'Geschichte',

### ../render/render_page.inc.php   ###
'Help'                        =>'Hilfe',

### ../render/render_wiki.inc.php   ###
'identical'                  =>'gleich benannt',

### ../std/class_auth.inc.php   ###
'Fresh login...'              =>'Neu anmelden',
'Cookie is no longer valid for this computer.'=>'Cookie ungültig für diesen Rechner',
'Your IP-Address changed. Please relogin.'=>'Ihre IP-Adresse hat sich geändert. Bitte neu anmelden.',
'Your account has been disabled. '=>'Ihr Konto wurde gesperrt.',



### ../lists/list_companies.inc.php   ###
'Company|Column header'       =>'Company',

### ../lists/list_files.inc.php   ###
'Parent item'                 =>'Übergeordnet',
'ID'                          =>'ID',
'Move files'                  =>'Dateien bewegen',
'File|Column header'          =>'Datei',
'in|... folder'               =>'in',
'Attached to|Column header'   =>'hängt an',

### ../lists/list_milestones.inc.php   ###
'open'                        =>'offen',

### ../lists/list_tasks.inc.php   ###
'Task name'                   =>'Aufgabe',

### ../pages/_handles.inc.php   ###
'Mark tasks as Open'          =>'Aufgaben als offen kennzeichnen',
'Move files to folder'        =>'Dateien in Ordner verschieben',

### ../pages/file.inc.php   ###
'Select some files to move'   =>'Bitte wählen Sie Dateien zum Verschieben.',
'Can not edit file %s'        =>'Kann Datei %s nicht bearbeiten',
'Edit files'                  =>'Datei bearbeiten',
'Select folder to move files into'=>'Wählen Sie einen Zielordner für Dateien',
'No folders available'        =>'Es existieren keine Ordner',

### ../pages/person.inc.php   ###
'no company'                  =>'keine Firma',
'Person with account (can login)|form label'=>'Person mit Konto (kann sich anmelden)',

### ../pages/task.inc.php   ###
'edit:'                       =>'bearbeiten',
'Wiki'                        =>'Wiki',

### ../pages/proj.inc.php   ###
'Create a new folder for tasks and files'=>'Neuen Ordner für Aufgaben und Dateien erstellen',
'Found no persons to add. Go to `People` to create some.'=>'Keine Personen zum hinzufügen gefunden.',

### ../pages/task.inc.php   ###
'Add Details|page function'   =>'Details hinzufügen',
'Move|page function to move current task'=>'Bewegen',
'status:'                     =>'status:',
'Reopen|Page function for task status reopened'=>'Wiedereröffnen',
'For Milestone|Label in Task summary'=>'Für Meilenstein',
'Estimated|Label in Task summary'=>'Geschätzt',
'Completed|Label in Task summary'=>'Geschafft',
'Created|Label in Task summary'=>'Erstellt',
'Modified|Label in Task summary'=>'Bearbeitet',
'Open tasks for milestone'    =>'Offene Aufgaben für Meilenstein',
'No open tasks for this milestone'=>'Keine Offenen Aufgaben für Meilenstein',
'New milestone'               =>'Neuer Meilenstein',
'Select some task(s) to reopen'=>'Bitte wählen zu wiederzueröffnende Aufgaben',
'Reopened %s tasks.'          =>'%s Aufgaben wieder eröffnet',

### ../render/render_form.inc.php   ###
'Wiki format'                 =>'Wiki-Formatierung',


### ../std/mail.inc.php   ###
'Please set a password to activate it.|notification'=>'Bitte setzen Sie ein Password zur Aktivierung.',


### ../db/db_item.inc.php   ###
'Unknown'                     =>'Unbekannt',
'Item has been modified during your editing by %s (%s minutes ago). Your changes can not be submitted.'=>'Objekt wurde während Ihrer Bearbeitung von %s geändert (vor %s Minuten). Speichern fehlgeschlagen.',

### ../lists/list_changes.inc.php   ###
'renamed'                     =>'umbenannt',
'edit wiki'                   =>'wiki bearbeitet',
'attached'                    =>'angehangen',
'attached file'               =>'Datei angehangen',

### ../lists/list_files.inc.php   ###
'Click on the file ids for details.'=>'Kicken Sie auf Datei-IDs für Detail Ansicht',

### ../pages/_handles.inc.php   ###
'List Deleted Persons'        =>'Gelöschte Personen anzeigen',


### ../pages/person.inc.php   ###
'Deleted People'              =>'Gelöschte Personen',
'notification:'               =>'Mail:',

### ../pages/task.inc.php   ###
'Parent task not found.'      =>'Überaufgabe nicht gefunden.',
'You do not have enough rights to edit this task'=>'Sie habe nicht genügend Rechte zum Bearbeiten dieser Aufgabe.',

### ../render/render_misc.inc.php   ###
'Other Persons|page option'   =>'Andere Personen',
'Deleted|page option'         =>'Gelöscht',

### ../render/render_wiki.inc.php   ###
'from'                        =>'von',

### ../std/common.inc.php   ###
'only one item expected.'     =>'Nur ein Element erwartet',

### ../std/constant_names.inc.php   ###
'Member|profile name'         =>'Mitglied',
'Admin|profile name'          =>'Admin',
'Project manager|profile name'=>'Projektleiter',
'Developer|profile name'      =>'Entwickler',
'Artist|profile name'         =>'Grafiker',
'Tester|profile name'         =>'Tester',
'Client|profile name'         =>'Kunde',
'Client trusted|profile name' =>'Kunde (vertrauen)',
'Guest|profile name'          =>'Gast',

'Warning'                     =>'Achtung',

'undefined|company category'				  => 'Undefiniert',
'client|company category'					  => 'Kunde',
'prospective client|company category'		  => 'Interessent',
'supplier|company category'					  => 'Lieferant',
'partner|company category'					  => 'Partner',

'undefined|person category'					=> 'Undefiniert',
'- employee -|person category'				=> '- Mitarbeiter -',
'staff|person category'						=> 'fester Mitarbeiter',
'freelancer|person category'				=> 'freier Mitarbeiter',
'working student|person category'			=> 'Werkstudent',
'apprentice|person category'				=> 'Auszubildender',
'intern|person category'					=> 'Praktikant',
'ex-employee|person category'				=> 'ehemaliger Mitarbeiter',
'- contact person -|person category'		=> '- Ansprechpartner -',
'client|person category'					=> 'Kunde',
'prospective client|person category'		=> 'Interessent',
'supplier|person category'					=> 'Lieferant',
'partner|person category'					=> 'Partner',

'Category|form label'		=> 'Kategorie',

### ../pages/_handles.inc.php   ###
'view changes'                =>'Änderungen',

### ../pages/person.inc.php   ###
'Passwords do not match'      =>'Passwörter stimmen nicht überein',
'Could not insert object'     =>'Objekt konnte nicht erzeugt werden.',

### ../pages/proj.inc.php   ###
'Reanimated person as team-member'=>'Person wurde wieder ins Team aufgenommen.',

### ../pages/projectperson.inc.php   ###
'Failed to remove %s members from team'=>'Das Löschen von %s Mitglied(ern) ist fehlgeschlagen.',
'Unassigned %s team member(s) from project'=>'%s Mitglieder wurden vom Team abgezogen.',

### ../pages/task.inc.php   ###
'View history of item'        =>'Änderungsgeschichte des Items zeigen',
'Create another task after submit'=>'Anschließend weitere Aufgabe erstellen',
'Could not update task'       =>'Aufgabe konnte nicht geändert werden.',
'changes'                     =>'Änderungen',
'View task'                   =>'Aufgabe zeigen',
'item has not been edited history'=>'Element wurde noch nicht bearbeitet',
'unknown'                     =>'unbekannt',
' -- '                        =>' -- ',
'&lt;&lt; prev change'        =>'',
'next &gt;&gt;'               =>'',
'summary'                     =>'Zusammenfassung',
'Item did not exists at %s'   =>'Element existierte noch nicht am %s',
'no changes between %s and %s'=>'Keine Änderungen zwischen %s und %s',
'ok'                          =>'Ok',


### ../std/class_pagehandler.inc.php   ###
'Operation aborted (%s)'      =>'Befehl abgebrochen (%s)',


### ../lists/list_changes.inc.php   ###
'Last of %s comments:'        =>'Letzer Kommentar (von %s):',
'Approve Task'                =>'Abgenommen',
'assigned'                    =>'zugewiesen',
'attached file to'            =>'Datei angehangen',

### ../lists/list_milestones.inc.php   ###
'%s required'                 =>'%s benötigt',

### ../pages/_handles.inc.php   ###
'Edit multiple Tasks'         =>'Mehrere Aufgaben bearbeiten',
'Filter errors.log'           =>'errors.log filtern',
'Delete errors.log'           =>'errors.log löschen',

### ../pages/home.inc.php   ###
'Projects'                    =>'Projekte',

### ../pages/misc.inc.php   ###
'Error-Log'                   =>'Error-Log',
'hide'                        =>'ausblenden',

### ../pages/person.inc.php   ###
'Person details'              =>'Person Details',

### ../pages/task_more.inc.php   ###
'Invalid checksum for hidden form elements'=>'Ungültige checksumme für hidden-form Felder.',

### ../pages/person.inc.php   ###
'The changed profile <b>does not affect existing project roles</b>! Those has to be adjusted inside the projects.'=>
'Das geänderte Profil hat keinen Einfluss auf aktuelle Projektrollen. Diese müssen einzeln angepasst werden.',
'Person %s created'           =>'Person %s angelegt',

### ../pages/proj.inc.php   ###
'not assigned to a closed project'=>'Keinem geschlossenem Projekt zugewiesen',
'no project templates'        =>'keine Templates',
'my open'                     =>'meine offenen',
'for milestone'               =>'für Meilenstein',
'needs approval'              =>'noch abzunehmen',

### ../pages/search.inc.php   ###
'in'                          =>'in',
'on'                          =>'an',
'jumped to best of %s search results'=>'Zum besten von %s Suchergebnissen gesprungen',
'Add an ! to your search request to jump to the best result.'=>'Fügen Sie Ihrer Suchanfrage ein ! hinzu, um direkt zum besten Ergebnis zu springen.',
'%s search results for `%s`'  =>'%s Ergebnisse für `%s`',
'No search results for `%s`'  =>'Keine Ergebnisse für `%s`',

### ../pages/task_more.inc.php   ###
'For editing all tasks must be of same project.'=>'Nur Aufgeben eines Projekte können gleichzeitig bearbeitet werden.',
'Edit multiple tasks|Page title'=>'Mehrere Aufgaben bearbeiten.',
'Edit %s tasks|Page title'    =>'%s Aufgaben bearbeiten',
'keep different'        =>'-- nicht ändern --',
'Prio'                        =>'Prio',
'none'                    =>'- nichts -',
'%s tasks could not be written'=>'%s Aufgaben konnten nich geschrieben werden',
'Updated %s tasks tasks'      =>'%s Aufgaben geändert.',
'Select a note to edit'       =>'Wählen Sie eine Notiz aus',
'ERROR: could not get Person' =>'Fehler: Konnte Person nicht ermitteln',
'ERROR: could not get project'=>'Fehler: Konnte Projekt nicht ermitteln',
'ERROR: could not get assigned persons'=>'Fehler: Konnte zugewiesene Personen nicht ermitteln',
'ERROR: could not get task'   =>'Fehler: Konnte Aufgabe nicht ermitteln',
'Note'						  =>'Notiz',
'Create new note'			  =>'Neue Notiz erstellen',
'New Note on %s, %s' 		  =>'Neue Notiz zu %s, %s',
'Assigned Projects'           =>'Zugewiesene Projekte',
'- no assigend projects'      =>'- keine zugewiesenen Projekte',
'Company Projects'            =>'Firmen-Projekte',
'- no company projects'       =>'- keine Firmen-Projekte',
'All other Projects'          =>'Alle anderen Projekte',
'- no other projects'         =>'- keine anderen Projekte',
'For Project|form label'      =>'Für Projekt',
'Project name|form label'     =>'Projektname',
'Assigne to'                  =>'Zuweisen an',
'Also assigne to'             =>'Auch zuweisen an',
'Book effort after submit'    =>'Anschließend Aufwand buchen',
'Note requires assigned person(s)'=>'Eine Person zuordnen',
'Note requires project'=>'Ein Projekt zuordnen',
'Also assigned to'			  =>'Auch zugewiesen an',
'select person'				  =>'wähle Person',

### ../pages/task_view.inc.php   ###
'Publish to|Label in Task summary'=>'Öffentlich für',
'Comment / Update'			  =>'Kommentieren / Aktualisieren',

### ../pages/version.inc.php ###
'Released Versions'			  =>'freigegebene Versionen',

### ../render/render_fields.inc.php   ###

### ../render/render_list_column_special.inc.php   ###
'Status|Short status column header'=>'Status',

### ../render/render_misc.inc.php   ###
'%s hours'                    =>'%s Stunden',
'%s days'                     =>'%s Tage',
'%s weeks'                    =>'%s Wochen',
'%s hours max'                =>'%s Stunden max',
'%s days max'                 =>'%s Tage max',
'%s weeks max'                =>'%s Wochen',

### ../render/render_wiki.inc.php   ###

### ../std/class_pagehandler.inc.php   ###
'Operation aborted with an fatal error which was cause by an programming error (%s).'=>'Anfrage aufgrund eines Programmierfehlers abgebrochen (%s).',


### ../__obsolete/class_version.inc.php   ###
'Time Released'               =>'Veröffentlicht am',

### ../db/class_project.inc.php   ###
'only team members can create items'=>'Nur Teammitglieder dürfen Elemente erstellen.',

### ../db/class_task.inc.php   ###
'resolved in version'         =>'Fertig in Version',

### ../pages/task_view.inc.php   ###
'Resolve reason'              =>'Behoben als',

### ../db/class_task.inc.php   ###
'is a milestone'              =>'Ist ein Meilenstein',
'released'                    =>'Veröffentlicht',
'release time'                =>'Veröffentlicht am',

### ../lists/list_versions.inc.php   ###
'Released Milestone'          =>'Veröffentlichter Meilenstein',

### ../lists/list_comments.inc.php   ###
'Add Comment'                 =>'Kommentar hinzufügen',
'Shrink All Comments'         =>'Alle Kommentare einklappen',
'Collapse All Comments'       =>'Alle Kommentare einklappen',
'Expand All Comments'         =>'Alle Kommentare ausklappen',
'Reply'                       =>'Antworten',
'1 sub comment'               =>'1 Antwort',
'%s sub comments'             =>'%s Antworten',

### ../lists/list_efforts.inc.php   ###
'%s effort(s) with %s hours'  =>'%s Aufwände mit %s Stunden',

### ../lists/list_versions.inc.php   ###
'Release Date'                =>'Veröffentlicht am',

### ../pages/_handles.inc.php   ###
'Versions'                    =>'Versionen',
'Task Test'                   =>'Aufgaben Testen',
'View Task Efforts'           =>'Aufwände zeigen',
'New Released Milestone'      =>'Neu veröffentlichter Meilenstein',
'View effort'                 =>'Aufwand zeigen',
'View multiple efforts'       =>'Mehrere Aufwände zeigen',
'List Clients'                =>'Kunden zeigen',
'List Prospective Clients'    =>'Potentielle Kunden zeigen',
'List Suppliers'              =>'Zulieferer zeigen',
'List Partners'               =>'Partner zeigen',
'List Employees'              =>'Angestellte zeigen',

### ../pages/company.inc.php   ###
'related companies of %s'     =>'Relevante Firmen für %s',
'Remove person from company'  =>'Person von Firma entfernen',

### ../pages/effort.inc.php   ###
'You do not have enough rights'=>'Sie haben nicht genügend Rechte',
'Edit this effort'            =>'Diesen Aufwand bearbeiten',
'Project|label'               =>'Projekt',
'Task|label'                  =>'Aufgabe',
'Created by|label'            =>'Erstellt von',
'Multiple Efforts|page type'  =>'Mehrere Aufwände',
'Multiple Efforts'            =>'Mehrere Aufwände',
'Information'                 =>'Informationen',
'Created at'				  =>'Erstellt am',

### ../pages/person.inc.php   ###
'Employees|Pagetitle for person list'=>'Angestellte',
'Contact Persons|Pagetitle for person list'=>'Ansprechpartner',

### ../pages/proj.inc.php   ###
'all'                         =>'alle',
'without milestone'           =>'ohne Meilenstein',
'New released Milestone'      =>'Neuer veröffentlichter Meilenstein',

### ../pages/search.inc.php   ###
'cannot jump to this item type'=>'Kann nicht zu diesem Elementtyp springen',

### ../pages/version.inc.php   ###
'New Version'                 =>'Neue Version',

### ../pages/task_more.inc.php   ###
'Select some task(s) to edit' =>'Bitte wählen Sie zu bearbeitende Aufgaben',

### ../pages/task_view.inc.php   ###
'next released version' =>'-- nächste veröffentlichte Version --',

### ../pages/task_more.inc.php   ###
'Release as version|Form label, attribute of issue-reports'=>'Als Version veröffentlichen',
'Reproducibility|Form label, attribute of issue-reports'=>'Wiederholbarkeit',
'NOTICE: Ungrouped %s subtasks to <b>%s</b>'=>'Hinweis: %s Unteraufgaben wurden ungruppiert.',
'Failed to add comment'       =>'Kommentar konnte nicht hinzugefügt werden.',
'Task Efforts'                =>'Aufgaben Aufwände',
'date1 should be smaller than date2. Swapped'=>'Datum 1 sollte kleiner sein als Datum 2.',
'Export tasks'			  =>'Aufgabenliste exportieren',



### ../db/db.inc.php   ###
'Database exception. Please read %s next steps on database errors.%s'=>'Datenbankfehler. Bitte lesen Sie %s nächste Schritte bei Datenbankfehlern. %s',

### ../pages/task_view.inc.php   ###
'next released version' =>'nächste Version',

### ../pages/task_more.inc.php   ###
'Failed to delete task %s'=>'Das Löschen von Aufgabe %s ist fehlgeschlagen.',
'prev change'                 =>'vorherige Änderung',
'next'                        =>'nächste Änderung',
'resolved in Version'         =>'Behoben in Version',
'Resolve Reason'              =>'Behoben als',

### ../pages/task_view.inc.php   ###
'Released as|Label in Task summary'=>'Veröffentlicht als',
'Severity|label in issue-reports'=>'Dringlichkeit',
'Reproducibility|label in issue-reports'=>'Wiederholbarkeit',
'Sub tasks'                   =>'Unteraufgaben',
'quick edit'                  =>'Schnellbearbeiten',
'Public to'                   =>'Öffentlich für',

### ../pages/version.inc.php   ###
'Edit Version|page type'      =>'Version bearbeiten',
'Edit Version|page title'     =>'Version bearbeiten',
'New Version|page title'      =>'Neue Version',
'Could not get version'       =>'Konnte Version nicht lesen.',
'Could not get project of version'=>'Konnte Projekt von Version nicht lesen.',
'Select some versions to delete'=>'Bitten wählen Sie zu löschende Versionen',
'Failed to delete %s versions'=>'Das Löschen von %s Version(en) schlug fehl.',
'Moved %s versions to trash'=>'%s Versionen gelöscht.',
'Version|page type'           =>'Version',
'Edit this version'           =>'Diese Version bearbeiten.',
'Select one or more versions' =>'Wählen Sie eine oder mehrere Versionen aus',

### ../render/render_list_column_special.inc.php   ###
'Item is published to'        =>'Element veröffentlicht für',

### ../render/render_misc.inc.php   ###
'All Companies|page option'   =>'Alle Firmen',

### ../render/render_wiki.inc.php   ###
'Wiki-format: <b>%s</b> is not a valid link-type'=>'',

### ../std/class_auth.inc.php   ###
'Unable to automatically detect client time zone'=>'Zeitzone konnte nicht automatisch bestimmt werden.',

### ../std/constant_names.inc.php   ###
'done|resolve reason'         =>'fertig',
'fixed|resolve reason'        =>'korrigiert',
'works_for_me|resolve reason' =>'funktioniert hier',
'duplicate|resolve reason'    =>'doppelt',
'bogus|resolve reason'        =>'fehlerhaft',
'rejected|resolve reason'     =>'abgelehnt',
'deferred|resolve reason'     =>'verschoben',
'Not defined|release type'    =>'undefiniert',
'Not planned|release type'    =>'nicht geplant',
'Upcomming|release type'      =>'Kommt',
'Internal|release type'       =>'Intern',
'Public|release type'         =>'Öffentlich',
'Without support|release type'=>'Ohne Service',
'No longer supported|release type'=>'Nicht länger unterstützt',



### ../render/render_fields.inc.php   ###
'<b>%s</b> is not a known format for date.'=>'<b>%s</b> ist kein unterstütztes Datumsformat.',

### ../render/render_wiki.inc.php   ###
'Wiki-format: <b>%s</b> is not a valid link-type'=>'Wiki-Format: <b>%s</a> ist kein gültiger Linktyp.',

);


?>