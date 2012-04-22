<?php

/**
* use this file for translating streber into new languages
*
* Some hints:
*
* - This file should be edited with a utf8 capable editor.
* - Insert the translation into the '' .
* - Avoid...
*   - quotes inside strings
*   - linebreaks inside strings
* - Characters behind the pipe ('|') are just for clarifying the context. 
*   Do not translate them!
* - Rename this file into "??.inc" where as "??" being the apache-shortcut of the language (like "en").
* - Add the language definition to "conf/conf.inc" (search for $g_languages)
*
* - With each new version of streber, there will be a "??.inc.changes" file with new phrases that needs
*   to be translated. Copy and paste the contense of those files into the language-files.
* - run "perl scanLanguages.pl" from this directory to check for completeness.
*/

/**
* translation into: Italian
*
*    translated by: AlienPro www.alienpro.it
*
*             date: 29th October 2006
*
*  streber version: 0.0704
*
*         comments: `
*/

global $g_lang_table;
$g_lang_table= array(



### ../lists/list_projectchanges.inc.php   ###
'new'                         =>'nuovo',  # line 211

### ../_docs/changes.inc.php   ###
'to'                          =>'a',  # line 90
'you'                         =>'te',  # line 90
'assign to'                   =>'assegna a',  # line 93

### ../lists/list_changes.inc.php   ###
'deleted'                     =>'eliminato',  # line 339

### ../_files/prj932/1326.index.php   ###
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter you name and use the <b>forgot password link</b> below.'=>'Attenzione, questo codice di attivazione non è più valido. Se si è già in possesso di un account, si prega di inserire il proprio nome e di usare la funzione <b>password dimenticata</b> qui sotto.',  # line 226

### ../pages/company.inc.php   ###
'Summary'                     =>'Sommario',  # line 161

### ../db/class_comment.inc.php   ###
'Details'                     =>'Dettagli',  # line 61

### ../lists/list_projects.inc.php   ###
'Name'                        =>'Nome',  # line 86

### ../db/class_company.inc.php   ###
'Required. (e.g. pixtur ag)'  =>'Richiesto (es. pixtur spa)',  # line 34
'Short|form field for company'=>'Breve',  # line 39
'Optional: Short name shown in lists (eg. pixtur)'=>'Facoltativo: nome breve visualizzato negli elenci (es. pixtur)',  # line 40
'Tag line|form field for company'=>'Tag',  # line 45

### ../db/class_person.inc.php   ###
'Optional: Additional tagline (eg. multimedia concepts)'=>'Facoltativo: Tag aggiuntivo (es. multimedia concepts)',  # line 52

### ../db/class_company.inc.php   ###
'Phone|form field for company'=>'Telefono',  # line 51
'Optional: Phone (eg. +49-30-12345678)'=>'Facoltativo: Telefono (es. +39-02-12345678)',  # line 52
'Fax|form field for company'  =>'Fax',  # line 57
'Optional: Fax (eg. +49-30-12345678)'=>'Facoltativo: Fax (es. +39-02-12345678)',  # line 58
'Street'                      =>'Indirizzo',  # line 63
'Optional: (eg. Poststreet 28)'=>'Facoltativo: (es. via Verdi, 28)',  # line 64
'Zipcode'                     =>'CAP e città',  # line 69
'Optional: (eg. 12345 Berlin)'=>'Facoltativo: (es: 20121 Milano)',  # line 70
'Website'                     =>'Sito web',  # line 75
'Optional: (eg. http://www.pixtur.de)'=>'Facoltativo: (es: http://www.pixtur.de)',  # line 76
'Intranet'                    =>'Intranet',  # line 81
'Optional: (eg. http://www.pixtur.de/login.php?name=someone)'=>'Facoltativo: (es. http://www.pixtur.de/login.php?name=someone)',  # line 88
'E-Mail'                      =>'E-Mail',  # line 87
'Comments|form label for company'=>'Commenti',  # line 93

### ../db/class_person.inc.php   ###
'Optional'                    =>'Facoltativo',  # line 113

### ../db/class_company.inc.php   ###
'more than expected'          =>'oltre quelli aspettati',  # line 458
'not available'               =>'non disponibile',  # line 461

### ../db/class_effort.inc.php   ###
'optional if tasks linked to this effort'=>'facoltativo se le attività sono correlate a questo impegno',  # line 39
'Time Start'                  =>'Inizio',  # line 46

### ../db/class_milestone.inc.php   ###
'Time End'                    =>'Termine',  # line 47

### ../pages/task.inc.php   ###
'Description'                 =>'Descrizione',  # line 323

### ../db/class_issue.inc.php   ###
'Production build'            =>'Build',  # line 53
'Steps to reproduce'          =>'Passi per riprodurre il problema',  # line 57
'Expected result'             =>'Risultato atteso',  # line 60
'Suggested Solution'          =>'Soluzione suggerita',  # line 63

### ../db/class_milestone.inc.php   ###
'optional if tasks linked to this milestone'=>'facoltativo se le attività sono correlate a questo evento',  # line 36

### ../lists/list_milestones.inc.php   ###
'Planned for'                 =>'Pianificata per',  # line 284

### ../db/class_person.inc.php   ###
'Full name'                   =>'Nome e cognome',  # line 42
'Required. Full name like (e.g. Thomas Mann)'=>'Obbligatorio. Nome completo (es. Thomas Mann)',  # line 43
'Nickname'                    =>'Nickname',  # line 47
'only required if user can login (e.g. pixtur)'=>'richiesto solo se l`utente può fare login',  # line 48

### ../lists/list_people.inc.php   ###
'Tagline'                     =>'Tag',  # line 59

### ../db/class_person.inc.php   ###
'Mobile Phone'                =>'Cellulare',  # line 55
'Optional: Mobile phone (eg. +49-172-12345678)'=>'Facoltativo: Cellulare (es. +39-333-12345678)',  # line 56
'Office Phone'                =>'Ufficio',  # line 61
'Optional: Office Phone (eg. +49-30-12345678)'=>'Facoltativo: Ufficio (es. +39-02-12345678)',  # line 62
'Office Fax'                  =>'Fax',  # line 65
'Optional: Office Fax (eg. +49-30-12345678)'=>'Facoltativo: Fax (es. +39-02-12345678)',  # line 66
'Office Street'               =>'Indirizzo',  # line 69
'Optional: Official Street and Number (eg. Poststreet 28)'=>'Facoltativo: indirizzo e civico (es. via Verdi, 28)',  # line 70
'Office Zipcode'              =>'CAP - città PV',  # line 73
'Optional: Official Zip-Code and City (eg. 12345 Berlin)'=>'Facoltativo: CAP, città e provincia (es. 20121 Milano MI)',  # line 74
'Office Page'                 =>'Sito web aziendale',  # line 77
'Optional: (eg. www.pixtur.de)'=>'Facoltativo: (es. www.pixtur.de)',  # line 105
'Office E-Mail'               =>'E-mail',  # line 81
'Optional: (eg. thomas@pixtur.de)'=>'Facoltativo: (es. thomas@pixtur.de)',  # line 109
'Personal Phone'              =>'Telefono personale',  # line 88
'Optional: Private Phone (eg. +49-30-12345678)'=>'Facoltativo: telefono personale (es. +39-02-12345678)',  # line 89
'Personal Fax'                =>'Fax personale',  # line 92
'Optional: Private Fax (eg. +49-30-12345678)'=>'Facoltativo: Fax personale (es. +39-02-12345678)',  # line 93
'Personal Street'             =>'Indirizzo casa',  # line 96
'Optional:  Private (eg. Poststreet 28)'=>'Facoltativo: casa (es. via Verdi, 28)',  # line 97
'Personal Zipcode'            =>'CAP casa',  # line 100
'Optional: Private (eg. 12345 Berlin)'=>'Facoltativo: CAP, città e provincia (es: 20121 Milano MI)',  # line 101
'Personal Page'               =>'Sito web personale',  # line 104
'Personal E-Mail'             =>'E-mail personale',  # line 108
'Birthdate'                   =>'Data di nascita',  # line 112

### ../db/class_project.inc.php   ###
'Color'                       =>'Colore',  # line 43

### ../db/class_person.inc.php   ###
'Optional: Color for graphical overviews (e.g. #FFFF00)'=>'Facoltativo: colore per riepiloghi (es #FFFF00)',  # line 118

### ../pages/task.inc.php   ###
'Comments'                    =>'Commenti',  # line 411

### ../db/class_person.inc.php   ###
'Password'                    =>'Password',  # line 128
'Only required if user can login|tooltip'=>'Richiesto solo se l`utente può fare login',  # line 129

### ../render/render_page.inc.php   ###
'Profile'                     =>'Profilo',  # line 639

### ../db/class_person.inc.php   ###
'Theme|Formlabel'             =>'Tema',  # line 161

### ../pages/comment.inc.php   ###
'insufficient rights'           =>'permessi utente insufficienti',  # line 237

### ../db/class_task.inc.php   ###
'Short'                       =>'Breve',  # line 21

### ../db/class_project.inc.php   ###
'Status summary'              =>'Riepilogo stato',  # line 40

### ../db/class_task.inc.php   ###
'Date start'                  =>'Data inizio',  # line 25
'Date closed'                 =>'Data termine',  # line 31

### ../render/render_list_column_special.inc.php   ###
'Status'                      =>'Stato',  # line 274

### ../db/class_project.inc.php   ###
'Project page'                =>'Pagina del progetto',  # line 58
'Wiki page'                   =>'Wiki',  # line 61

### ../pages/home.inc.php   ###
'Priority'                    =>'Priorità',  # line 241

### ../std/constant_names.inc.php   ###
'Company'                     =>'Azienda',  # line 102

### ../db/class_project.inc.php   ###
'show tasks in home'          =>'Mostra attività in home',  # line 75
'validating invalid item'     =>'verificando elementi non validi',  # line 1191
'insufficient rights (not in project)'=>'permessi utente insufficienti (non nel progetto)',  # line 1203

### ../pages/proj.inc.php   ###
'Project Template'            =>'Template di progetto',  # line 1416
'Inactive Project'            =>'Progetto inattivo',  # line 1419
'Project|Page Type'           =>'Progetto',  # line 1422

### ../db/class_projectperson.inc.php   ###
'job'                         =>'Lavoro',  # line 28
'role'                        =>'Ruolo',  # line 57

### ../pages/task.inc.php   ###
'for Milestone'               =>'per l`evento',  # line 849

### ../db/class_task.inc.php   ###
'resolved_version'            =>'versione_risolutrice',  # line 53
'show as folder (may contain other tasks)'=>'mostra come cartella (potrebbe contenere altre attività)',  # line 63
'is a milestone / version'    =>'è un evento/versione',  # line 68
'milestones are shown in a different list'=>'gli eventi sono mostrati in un elenco separato',  # line 69
'Completion'                  =>'Completamento',  # line 75

### ../pages/task.inc.php   ###
'Estimated time'              =>'Tempo previsto',  # line 1000
'Estimated worst case'        =>'Peggior caso previsto',  # line 1001
'Label'                       =>'Etichetta',  # line 1041

### ../db/class_task.inc.php   ###
'Planned Start'               =>'Inizio pianificato',  # line 105
'Planned End'                 =>'Termine pianificato',  # line 110

### ../pages/task.inc.php   ###
'task without project?'       =>'Attività senza progetto?',  # line 2060

### ../pages/proj.inc.php   ###
'Folder'                      =>'Cartella',  # line 1040

### ../lists/list_tasks.inc.php   ###
'Milestone'                   =>'Eventi',  # line 764

### ../std/constant_names.inc.php   ###
'Task'                        =>'Attività',  # line 99

### ../db/db.inc.php   ###
'Database exception'          =>'Eccezione del database',  # line 38

### ../db/db_item.inc.php   ###
'WARNING <b>%s</b> isn`t a known format for date.'=>'ATTENZIONE <b>%s</b> non è un formato conosciuto per la data',  # line 233
'unnamed'                     =>'senza nome',  # line 590

### ../lists/list_changes.inc.php   ###
'to|very short for assigned tasks TO...'=>'a',  # line 325
'in|very short for IN folder...'=>'in',  # line 334

### ../lists/list_projectchanges.inc.php   ###
'modified'                    =>'modificato',  # line 48

### ../lists/list_changes.inc.php   ###
'read more...'                =>'segue...',  # line 208
'%s comments:'                =>'%s commenti:',  # line 211
'comment:'                    =>'commento:',  # line 214
'completed'                   =>'completato',  # line 234
'approved'                    =>'approvato',  # line 238
'closed'                      =>'chiuso',  # line 242
'reopened'                    =>'riaperto',  # line 246
'is blocked'                  =>'è bloccato',  # line 250
'moved'                       =>'spostato',  # line 256
'changed:'                    =>'cambiato',  # line 261
'commented'                   =>'commentato',  # line 273
'reassigned'                  =>'riassegnato',  # line 288

### ../lists/list_projectchanges.inc.php   ###
'restore'                     =>'ripristina',  # line 331

### ../pages/proj.inc.php   ###
'Changes'                     =>'Cambiamenti',  # line 714

### ../lists/list_projectchanges.inc.php   ###
'Other team members changed nothing since last logout (%s)'=>'Gli altri membri del team non hanno cambiato nulla dall`ultimo logout (%s)',  # line 30

### ../lists/list_changes.inc.php   ###
'Date'                        =>'Data',  # line 470
'Who changed what when...'    =>'Chi ha cambiato cosa e quando...',  # line 602
'what|column header in change list'=>'cosa',  # line 504
'Date / by'                   =>'Data / da',  # line 601

### ../render/render_page.inc.php   ###
'Edit'                        =>'Modifica',  # line 589

### ../lists/list_taskfolders.inc.php   ###
'New'                         =>'Nuova',  # line 102

### ../pages/task.inc.php   ###
'Delete'                      =>'Elimina',  # line 95

### ../lists/list_comments.inc.php   ###
'Move to Folder'              =>'Sposta nella Cartella',  # line 61
'Shrink View'                 =>'Comprimi Vista',  # line 67
'Expand View'                 =>'Espandi Vista',  # line 73
'Topic'                       =>'Argomento',  # line 93
'Date|column header'          =>'Data',  # line 145
'By|column header'            =>'Da',  # line 190

### ../lists/list_companies.inc.php   ###
'related companies'           =>'aziende correlate',  # line 22

### ../lists/list_people.inc.php   ###
'Name Short'                  =>'Nome Breve',  # line 27
'Shortnames used in other lists'=>'Nomi brevi usati in altri elenchi',  # line 28

### ../pages/company.inc.php   ###
'Phone'                       =>'Telefono',  # line 175

### ../lists/list_companies.inc.php   ###
'Phone-Number'                =>'Numero di telefono',  # line 36
'Proj'                        =>'Prog.',  # line 44
'Number of open Projects'     =>'Numero di progetti aperti',  # line 45

### ../render/render_page.inc.php   ###
'People'                      =>'Persone',  # line 234

### ../lists/list_companies.inc.php   ###
'People working for this person'=>'Persone al lavoro per questa persona',  # line 52
'Edit company'                =>'Modifica azienda',  # line 85
'Delete company'              =>'Elimina azienda',  # line 92
'Create new company'          =>'Crea nuova azienda',  # line 98

### ../lists/list_files.inc.php   ###
'Name|Column header'          =>'Nome',  # line 264

### ../lists/list_efforts.inc.php   ###
'no efforts booked yet'       =>'nessun impegno ancora pianificato',  # line 24

### ../pages/person.inc.php   ###
'Efforts'                     =>'Impegni',  # line 33

### ../std/constant_names.inc.php   ###
'Project'                     =>'Progetto',  # line 98

### ../lists/list_efforts.inc.php   ###
'person'                      =>'persona',  # line 38

### ../lists/list_projects.inc.php   ###
'Task name. More Details as tooltips'=>'Nome dell`attività. Maggiori dettagli nei tooltip',  # line 87

### ../lists/list_efforts.inc.php   ###
'Edit effort'                 =>'Modifica impegno',  # line 58
'New effort'                  =>'Nuovo impegno',  # line 65
'booked'                      =>'pianificato',  # line 111
'estimated'                   =>'previsto',  # line 111
'Task|column header'          =>'Attività',  # line 124
'Start|column header'         =>'Inizio',  # line 149
'D, d.m.Y'                    =>'G, g.m.A',  # line 160
'End|column header'           =>'Fine',  # line 176
'len|column header of length of effort'=>'h',  # line 200
'Daygraph|columnheader'       =>'Grafico (giorni)',  # line 220

### ../pages/file.inc.php   ###
'Type'                        =>'Tipo',  # line 183

### ../pages/task.inc.php   ###
'Version'                     =>'Versione',  # line 368

### ../lists/list_files.inc.php   ###
'Size'                        =>'Dimensioni',  # line 88

### ../pages/_handles.inc.php   ###
'Edit file'                   =>'Modifica file',  # line 527

### ../lists/list_files.inc.php   ###
'New file'                    =>'Nuovo file',  # line 117
'No files uploaded'           =>'Nessun file caricato',  # line 198
'Download|Column header'      =>'Download',  # line 241

### ../pages/proj.inc.php   ###
'Milestones'                  =>'Eventi',  # line 1334

### ../lists/list_tasks.inc.php   ###
'Started'                     =>'Iniziato',  # line 125
'%s hidden'                   =>'%s nascosti',  # line 318

### ../pages/task.inc.php   ###
'New folder'                  =>'Nuova Cartella',  # line 511

### ../pages/company.inc.php   ###
'or'                          =>'o',  # line 236

### ../lists/list_milestones.inc.php   ###
'Due Today'                   =>'Scade oggi',  # line 308
'%s days late'                =>'%s giorni di ritardo',  # line 313
'%s days left'                =>'%s giorni mancanti',  # line 317
'Tasks open|columnheader'     =>'Attività aperte',  # line 345
'Open|columnheader'           =>'Apri',  # line 407
'%s open'                     =>'%s aperte',  # line 429
'Completed|columnheader'      =>'Completate',  # line 441
'Completed tasks: %s'         =>'Attività completate',  # line 459

### ../lists/list_people.inc.php   ###
'Private'                     =>'Personale',  # line 44
'Mobil'                       =>'Cellulare',  # line 49
'Office'                      =>'Ufficio',  # line 54

### ../render/render_page.inc.php   ###
'Companies'                   =>'Aziende',  # line 240

### ../lists/list_people.inc.php   ###
'last login'                  =>'ultimo login',  # line 69
'Edit person'                 =>'Modifica persona',  # line 100

### ../pages/_handles.inc.php   ###
'Edit user rights'            =>'Modifica permessi utente',  # line 653

### ../lists/list_people.inc.php   ###
'Delete person'               =>'Elimina persona',  # line 113
'Create new person'           =>'Crea nuova persona',  # line 119
'Profile|column header'       =>'Profilo',  # line 141
'Account settings for user (do not confuse with project rights)'=>'Impostazioni dell`account utente (da non confondersi con i permessi utente di progetto)',  # line 143
'(adjusted)'                  =>'(aggiornato)',  # line 160
'Active Projects|column header'=>'Progetti Attivi',  # line 180

### ../render/render_list_column_special.inc.php   ###
'Priority is %s'              =>'Priorità è %s',  # line 255

### ../lists/list_people.inc.php   ###
'recent changes|column header'=>'cambiamenti recenti',  # line 225
'changes since YOUR last logout'=>'cambiamenti dal TUO ultimo logout',  # line 227

### ../lists/list_project_team.inc.php   ###
'Your related people'        =>'Persone correlate a te',  # line 25
'Rights'                      =>'Permessi',  # line 40
'People rights in this project'=>'Permessi utente delle persone in questo progetto',  # line 41
'Edit team member'            =>'Modifica membro del team',  # line 98
'Add team member'             =>'Aggiungi membro del team',  # line 105
'Remove person from team'     =>'Rimuovi persona dal team',  # line 112
'Member'                      =>'Membro',  # line 141
'Role'                        =>'Ruolo',  # line 162
'last Login|column header'    =>'ultimo Login',  # line 179

### ../render/render_list_column_special.inc.php   ###
'Created by'                  =>'Creato da',  # line 386

### ../lists/list_projectchanges.inc.php   ###
'Item was originally created by'=>'Elemento originariamente creato da',  # line 42
'C'                           =>'C',  # line 191
'Created,Modified or Deleted' =>'Creato, Modificato o Eliminato',  # line 192
'Deleted'                     =>'Eliminato',  # line 205

### ../render/render_list_column_special.inc.php   ###
'Modified'                    =>'Modificato',  # line 197

### ../lists/list_projectchanges.inc.php   ###
'by Person'                   =>'dalla persona',  # line 229
'Person who did the last change'=>'Persona che ha apportato l`ultimo cambiamento',  # line 230
'Type|Column header'          =>'Tipo',  # line 288
'Item of item: [T]ask, [C]omment, [E]ffort, etc '=>'Elemento di elemento: a[T]tività, [C]ommento, imp[E]gno, etc',  # line 289
'item %s has undefined type'  =>'elemento %s e` di tipo indefinito',  # line 297
'Del'                         =>'Elim',  # line 318
'shows if item is deleted'    =>'mostra se l`elemento è eliminato',  # line 319
'(on comment)'                =>'(sul commento)',  # line 375
'(on task)'                   =>'(sull`attività)',  # line 380
'(on project)'                =>'(sul progetto)',  # line 386

### ../lists/list_projects.inc.php   ###
'Project priority (the icons have tooltips, too)'=>'Priorità del progetto (le icone mostrano dei tooltip)',  # line 61

### ../pages/home.inc.php   ###
'Task-Status'                 =>'Stato dell`attività',  # line 248

### ../lists/list_projects.inc.php   ###
'Status Summary'              =>'Riepilogo dello stato',  # line 95
'Short discription of the current status'=>'Breve descrizione dello stato corrente',  # line 96

### ../pages/proj.inc.php   ###
'Tasks'                       =>'Attività',  # line 1013

### ../lists/list_projects.inc.php   ###
'Number of open Tasks'        =>'Numero di Attività aperte',  # line 106
'Opened'                      =>'Aperte',  # line 114
'Day the Project opened'      =>'Giorno di apertura del Progetto',  # line 115

### ../pages/proj.inc.php   ###
'Closed'                      =>'Chiuso',  # line 38

### ../lists/list_projects.inc.php   ###
'Day the Project state changed to closed'=>'Giorno in cui lo stato del Progetto è cambiato in chiuso',  # line 121
'Edit project'                =>'Modifica progetto',  # line 129
'Delete project'              =>'Elimina progetto',  # line 136
'Log hours for a project'     =>'Salvataggio ore per un progetto',  # line 143
'Open / Close'                =>'Apri / Chiudi',  # line 151

### ../pages/company.inc.php   ###
'Create new project'          =>'Crea nuovo progetto',  # line 306

### ../pages/_handles.inc.php   ###
'Create Template'             =>'Crea Template',  # line 118
'Project from Template'       =>'Progetto da Template',  # line 126

### ../lists/list_projects.inc.php   ###
'... working in project'      =>'... al lavoro nel progetto',  # line 299

### ../pages/proj.inc.php   ###
'Folders'                     =>'Cartelle',  # line 453

### ../lists/list_taskfolders.inc.php   ###
'Number of subtasks'          =>'Numero di sottoattività',  # line 84
'Create new folder under selected task'=>'Crea nuova cartella sotto l`attività selezionata',  # line 105
'Move selected to folder'     =>'Sposta selezionata nella cartella',  # line 110

### ../lists/list_tasks.inc.php   ###
'Log hours for select tasks'  =>'Salvataggio ore per le attività selezionate',  # line 209
'Priority of task'            =>'Priorità delle attività',  # line 95
'Status|Columnheader'         =>'Stato',  # line 106
'Modified|Column header'      =>'Modificato',  # line 129
'Est.'                        =>'Prev.',  # line 140

### ../pages/home.inc.php   ###
'Estimated time in hours'     =>'Tempo previsto in ore',  # line 286

### ../lists/list_tasks.inc.php   ###
'Add new Task'                =>'Aggiungi nuova attività',  # line 160
'Report new Bug'              =>'Segnala nuovo Bug',  # line 167
'Add comment'                 =>'Aggiungi commento',  # line 175
'Status->Completed'           =>'Stato->Completo',  # line 188
'Status->Approved'            =>'Stato->Approvato',  # line 195
'Move tasks'                  =>'Sposta attività',  # line 202
'Latest Comment'              =>'Ultimo commento',  # line 426
'by'                          =>'di',  # line 428
'for'                         =>'per',  # line 450
'%s open tasks / %s h'        =>'%s attività aperte / %s h',  # line 469
'Label|Columnheader'          =>'Etichetta',  # line 725

### ../pages/task.inc.php   ###
'Assigned to'                 =>'Assegnato a',  # line 939

### ../lists/list_tasks.inc.php   ###
'Name, Comments'              =>'Nome, commenti',  # line 852
'has %s comments'             =>'ha %s commenti',  # line 882
'Task has %s attachments'     =>'L`attività ha %s allegati',  # line 895
'- no name -|in task lists'   =>'- senza nome -',  # line 913
'number of subtasks'          =>'numero delle sottoattività',  # line 935
'Sum of all booked efforts (including subtasks)'=>'Somma di tutti gli impegni previsti (compreso sottoattività)',  # line 966
'Effort in hours'             =>'Impegno in ore',  # line 977
'Days until planned start'    =>'Giorni dall`inizio pianificato',  # line 989
'Due|column header, days until planned start'=>'Scad.',  # line 990
'planned for %s|a certain date'=>'pianificato per %s',  # line 1019
'Est/Compl'                   =>'Prev/Compl',  # line 1035
'Estimated time / completed'  =>'Tempo stimato / completato',  # line 1037
'estimated %s hours'          =>'previsto %s ore',  # line 1059
'estimated %s days'           =>'previsto %s giorni',  # line 1064
'estimated %s weeks'          =>'previsto %s settimane',  # line 1069
'%2.0f%% completed'           =>'%2.0f%% completato',  # line 1075

### ../pages/_handles.inc.php   ###
'Home'                        =>'Home',  # line 7
'Active Projects'             =>'Progetti attivi',  # line 16
'Closed Projects'             =>'Progetti chiusi',  # line 23

### ../pages/proj.inc.php   ###
'Project Templates'           =>'Template di Progetto',  # line 192

### ../pages/_handles.inc.php   ###
'View Project'                =>'Visualizza Progetto',  # line 79

### ../pages/proj.inc.php   ###
'Uploaded Files'              =>'File allegati',  # line 1237
'Closed tasks'                =>'Attività chiuse',  # line 908
'New project'                 =>'Nuovo progetto',  # line 1476

### ../pages/_handles.inc.php   ###
'Edit Project Description'    =>'Modifica descrizione del Progetto',  # line 134

### ../pages/proj.inc.php   ###
'Edit Project'                =>'Modifica Progetto',  # line 1801

### ../pages/_handles.inc.php   ###
'Delete Project'              =>'Elimina Progetto',  # line 167
'Change Project Status'       =>'Cambia lo Stato del Progetto',  # line 175
'Add Team member'             =>'Aggiungi membro del Team',  # line 213
'Edit Team member'            =>'Modifica membro del Team',  # line 222
'Remove from team'            =>'Rimuovi dal team',  # line 234
'View Task'                   =>'Visualizza Attività',  # line 249
'Edit Task'                   =>'Modifica Attività',  # line 256
'Delete Task(s)'              =>'Elimina Attività',  # line 267
'Restore Task(s)'             =>'Ripristina Attività',  # line 272
'Move tasks to folder'        =>'Sposta attività in una cartella',  # line 280
'Mark tasks as Complete'      =>'Segna attività come Completate',  # line 288
'Mark tasks as Approved'      =>'Segna attività come Approvate',  # line 296
'New Task'                    =>'Nuova Attività',  # line 334
'New bug'                     =>'Nuovo Bug',  # line 319

### ../pages/task.inc.php   ###
'New Milestone'               =>'Nuovo evento',  # line 464

### ../pages/_handles.inc.php   ###
'Toggle view collapsed'       =>'Espandi/Comprimi vista',  # line 489
'Add issue/bug report'        =>'Aggiungi problema/bug',  # line 370
'Edit Description'            =>'Modifica Descrizione',  # line 379
'Log hours'                   =>'Salvataggio ore',  # line 396
'Edit time effort'            =>'Modifica valori impegno',  # line 403
'View comment'                =>'Visualizza commento',  # line 423
'Create comment'              =>'Crea commento',  # line 433
'Edit comment'                =>'Modifica commento',  # line 443
'Delete comment'              =>'Elimina commento',  # line 460
'View file'                   =>'Visualizza file',  # line 505
'Upload file'                 =>'Allega file',  # line 513
'Update file'                 =>'Aggiorna file',  # line 519

### ../pages/file.inc.php   ###
'Download'                    =>'Download',  # line 138

### ../pages/_handles.inc.php   ###
'Show file scaled'            =>'Mostra file riproporzionato',  # line 539
'List Companies'              =>'Elenco Aziende',  # line 556
'View Company'                =>'Visualizza Azienda',  # line 562

### ../pages/company.inc.php   ###
'New company'                 =>'Nuova Azienda',  # line 366
'Edit Company'                =>'Modifica Azienda',  # line 523

### ../pages/_handles.inc.php   ###
'Delete Company'              =>'Elimina Azienda',  # line 589

### ../pages/company.inc.php   ###
'Link People'                =>'Collega Persone',  # line 228

### ../pages/_handles.inc.php   ###
'List People'                =>'Elenco Persone',  # line 618
'View Person'                 =>'Visualizza Persona',  # line 624

### ../pages/person.inc.php   ###
'New person'                  =>'Nuova Persona',  # line 495

### ../pages/_handles.inc.php   ###
'Edit Person'                 =>'Modifica Persona',  # line 638
'Delete Person'               =>'Elimina Persona',  # line 666
'View Efforts of Person'      =>'Visualizza Impegni della Persona',  # line 671
'Send Activation E-Mail'      =>'Invia E-Mail di Attivazione',  # line 679
'Flush Notifications'         =>'Annulla notifiche',  # line 696
'Login'                       =>'Login',  # line 713

### ../render/render_page.inc.php   ###
'Logout'                      =>'Logout',  # line 641

### ../pages/_handles.inc.php   ###
'License'                     =>'Licenza',  # line 736
'restore Item'                =>'ripristina Elemento',  # line 774

### ../pages/error.inc.php   ###
'Error'                       =>'Errore',  # line 34

### ../pages/_handles.inc.php   ###
'Activate an account'         =>'Attivazione nuovo account',  # line 788
'System Information'          =>'Informazioni di Sistema',  # line 799
'PhpInfo'                     =>'Info Php',  # line 809
'Search'                      =>'Cerca',  # line 820

### ../pages/comment.inc.php   ###
'Comment on task|page type'   =>'Commenti sull`attività',  # line 62

### ../pages/task.inc.php   ###
'(deleted %s)|page title add on with date of deletion'=>'(eliminato il %s)',  # line 75

### ../pages/comment.inc.php   ###
'Edit this comment'           =>'Modifica questo commento',  # line 83
'New Comment|Default name of new comment'=>'Nuovo commento',  # line 149
'Reply to |prefix for name of new comment on another comment'=>'Risposta a',  # line 213

### ../std/constant_names.inc.php   ###
'Comment'                     =>'Commento',  # line 107

### ../pages/comment.inc.php   ###
'Edit Comment|Page title'     =>'Modifica Commento',  # line 290
'New Comment|Page title'      =>'Nuovo Commento',  # line 293
'On task %s|page title add on'=>'Attività: %s',  # line 297

### ../pages/file.inc.php   ###
'On project %s|page title add on'=>'Progetto: %S',  # line 392

### ../pages/comment.inc.php   ###
'Occasion|form label'         =>'Occasione',  # line 333
'Public to|form label'        =>'Mostra a',  # line 338
'Select some comments to delete'=>'Seleziona i commenti da eliminare',  # line 449
'WARNING: Failed to delete %s comments'=>'ATTENZIONE: Errore durante l`eliminazione dei commenti',  # line 468
'Moved %s comments to dumpster'=>'Spostato %s commenti nel cestino',  # line 471
'Select some comments to move'=>'Seleziona i commenti da spostare',  # line 577

### ../pages/task.inc.php   ###
'insufficient rights'         =>'permessi utenti non sufficienti',  # line 1545

### ../pages/comment.inc.php   ###
'Can not edit comment %s'     =>'Non è possibile commentare %s',  # line 618

### ../pages/task.inc.php   ###
'Edit tasks'                  =>'Modifica attività',  # line 1613

### ../pages/comment.inc.php   ###
'Select one folder to move comments into'=>'Seleziona una cartella dove spostare i commenti',  # line 651
'... or select nothing to move to project root'=>'... o non selezionare niente per spostarlo nella root del progetto',  # line 663
'No folders in this project...'=>'Nessuna cartella in questo progetto',  # line 691

### ../pages/task.inc.php   ###
'Move items'                  =>'Sposta elementi',  # line 1668

### ../pages/company.inc.php   ###
'related projects of %s'      =>'progetti correlati di %s',  # line 40

### ../pages/proj.inc.php   ###
'admin view'                  =>'admin view',  # line 197
'List'                        =>'Elenco',  # line 199

### ../pages/company.inc.php   ###
'no companies'                =>'nessuna azienda',  # line 68

### ../pages/proj.inc.php   ###
'Overview'                    =>'Panoramica',  # line 262

### ../pages/company.inc.php   ###
'Edit this company'           =>'Modifica questa azienda',  # line 125
'edit'                        =>'modifica',  # line 126
'Create new person for this company'=>'Crea nuova persona per questa azienda',  # line 132

### ../std/constant_names.inc.php   ###
'Person'                      =>'Persona',  # line 100

### ../pages/company.inc.php   ###
'Create new project for this company'=>'Crea nuovo progetto per questa azienda',  # line 139
'Add existing people to this company'=>'Aggiungi persona esistente a questa azienda',  # line 146
'People'                     =>'Persone',  # line 147
'Adress'                      =>'Indirizzo',  # line 169
'Fax'                         =>'Fax',  # line 178
'Web'                         =>'Sito web',  # line 183
'Intra'                       =>'Intranet',  # line 186
'Mail'                        =>'E-Mail',  # line 189
'related People'             =>'persone correlate',  # line 204
'link existing Person'        =>'collega persone esistenti',  # line 235
'create new'                  =>'crea nuova',  # line 237
'no people related'          =>'nessuna persona correlata',  # line 240
'Active projects'             =>'Progetti attivi',  # line 297
' Hint: for already existing projects please edit those and adjust company-setting.'=>' Suggerimento: per i progetti già esistenti si prega di modificarli e aggiornare le impostazioni dell`azienda ',  # line 307
'no projects yet'             =>'ancora nessun progetto',  # line 310
'Closed projects'             =>'Progetti chiusi',  # line 335
'Create another company after submit'=>'Dopo il salvataggio crea nuova azienda',  # line 430
'Edit %s'                     =>'Modifica %s',  # line 524
'Add people employed or related'=>'Aggiungi persone impiegate o correlate',  # line 525
'NOTE: No people selected...'=>'NOTA: Nessuna persona selezionata',  # line 578
'NOTE person already related to company'=>'NOTA persona già correlata all`azienda',  # line 605
'Select some companies to delete'=>'Seleziona le aziende da eliminare',  # line 627
'WARNING: Failed to delete %s companies'=>'ATTENZIONE: Errore durante l`eliminazione di %s aziende',  # line 647
'Moved %s companies to dumpster'=>'Spostate %s aziende nel cestino',  # line 650

### ../pages/effort.inc.php   ###
'New Effort'                  =>'Nuovo Impegno',  # line 32

### ../pages/file.inc.php   ###
'only expected one task. Used the first one.'=>'atteso solo un`attività. Utilizzata la prima.',  # line 322

### ../pages/effort.inc.php   ###
'Edit Effort|page type'       =>'Modifica Impegno',  # line 164
'Edit Effort|page title'      =>'Modifica Impegno',  # line 178
'New Effort|page title'       =>'Nuovo Impegno',  # line 181
'Date / Duration|Field label when booking time-effort as duration'=>'Data / Durata',  # line 207

### ../pages/file.inc.php   ###
'For task'                    =>'Per attività',  # line 127

### ../pages/task.inc.php   ###
'Public to'                   =>'Mostra a',  # line 859

### ../pages/effort.inc.php   ###
'Could not get effort'        =>'Non è stato possibile aprire l`impegno',  # line 278
'Could not get project of effort'=>'Non è stato possibile aprire il progetto dell`impegno',  # line 286
'Could not get person of effort'=>'Non è stato possibile aprire la persona dell`impegno',  # line 292
'Name required'               =>'Nome obbligatorio',  # line 357
'Cannot start before end.'    =>'Non è possibile iniziare prima del termine',  # line 361
'Select some efforts to delete'=>'Seleziona gli impieghi da eliminare',  # line 393
'WARNING: Failed to delete %s efforts'=>'ATTENZIONE: Errore nell`eliminazione di %s impieghi',  # line 412
'Moved %s efforts to dumpster'=>'Spostato %s impieghi nel cestino',  # line 415

### ../pages/error.inc.php   ###
'Error|top navigation tab'    =>'Errore',  # line 24
'Unknown Page'                =>'Pagina sconosciuta',  # line 27

### ../pages/file.inc.php   ###
'Could not access parent task.'=>'Non è stato possibile accedere all`attività padre.',  # line 53

### ../std/constant_names.inc.php   ###
'File'                        =>'File',  # line 108

### ../pages/task.inc.php   ###
'Item-ID %d'                  =>'Elemento-ID %d',  # line 73

### ../pages/file.inc.php   ###
'Edit this file'              =>'Modifica questo file',  # line 96
'Version #%s (current): %s'   =>'Versione #%s (corrente): %s',  # line 109
'Filesize'                    =>'Dimensione del file',  # line 182
'Uploaded'                    =>'Allegato',  # line 184
'Uploaded by'                 =>'Allegato da',  # line 133
'Version #%s : %s'            =>'Versione #%s : %s',  # line 165
'Upload new version|block title'=>'Allega nuova versione',  # line 199
'Could not edit task'         =>'Non è stato possibile modificare l`attività',  # line 331
'Edit File|page type'         =>'Modifica File',  # line 376
'Edit File|page title'        =>'Modifica File',  # line 386
'New file|page title'         =>'Nuovo File',  # line 389
'Could not get file'          =>'Non è stato possibile aprire il file',  # line 504
'Could not get project of file'=>'Non è stato possibile aprire il progetto del file',  # line 511
'Please enter a proper filename'=>'Prego inserire il nome del file',  # line 548
'Select some files to delete' =>'Sezionare i file da eliminare',  # line 596
'WARNING: Failed to delete %s files'=>'ATTENZIONE: Errore nell`eleminazione di %s file',  # line 615
'Moved %s files to dumpster'  =>'Spostato %s file nel cestino',  # line 618
'Select some file to display' =>'Seleziona i file da visualizzare',  # line 656

### ../render/render_misc.inc.php   ###
'Today'                       =>'Oggi',  # line 457

### ../pages/home.inc.php   ###
'Personal Efforts'            =>'Impegni personali',  # line 69
'At Home'                     =>'At Home',  # line 76
'F, jS'                       =>'F, jS',  # line 77
'Functions'                   =>'Funzioni',  # line 86
'View your efforts'           =>'Visualizza i tuoi impegni',  # line 95
'Edit your profile'           =>'Modifica il tuo profilo',  # line 96
'Your projects'               =>'I tuoi progetti',  # line 122
'S|Column header for status'  =>'S',  # line 126

### ../render/render_list_column_special.inc.php   ###
'Select lines to use functions at end of list'=>'Seleziona le righe a cui applicare le funzioni in fondo all`elenco',  # line 361

### ../pages/home.inc.php   ###
'P|Column header for priority'=>'P',  # line 132
'Priority|Tooltip for column header'=>'Priorità',  # line 133
'Company|column header'       =>'Azienda',  # line 139
'Project|column header'       =>'Progetto',  # line 255
'Edit|function in context menu'=>'Modifica',  # line 153
'Log hours for a project|function in context menu'=>'Salvataggio ore per un progetto',  # line 160
'Create new project|function in context menu'=>'Crea nuovo progetto',  # line 167
'You are not assigned to a project.'=>'Non sei stato assegnato ad alcun progetto.',  # line 185
'You have no open tasks'      =>'Non ci sono attività aperte',  # line 213
'Open tasks assigned to you'  =>'Attività aperte assegnate a te',  # line 218
'Open tasks (including unassigned)'=>'Attività aperte (incluse quelle non assegnate)',  # line 221
'All open tasks'              =>'Tutte le attività aperte',  # line 224
'P|column header'             =>'P',  # line 240
'S|column header'             =>'S',  # line 247
'Folder|column header'        =>'Cartella',  # line 260
'Modified|column header'      =>'Modificato',  # line 277
'Est.|column header estimated time'=>'Prev.',  # line 285
'Edit|context menu function'  =>'Modifica',  # line 304
'status->Completed|context menu function'=>'stato->Completato',  # line 311
'status->Approved|context menu function'=>'stato->Approvato',  # line 319
'Delete|context menu function'=>'Elimina',  # line 328
'Log hours for select tasks|context menu function'=>'Salvataggio ore per le attività selezionate',  # line 336
'%s tasks with estimated %s hours of work'=>'%s attività con %s previste di lavoro',  # line 364

### ../pages/login.inc.php   ###
'Login|tab in top navigation' =>'Login',  # line 26

### ../render/render_page.inc.php   ###
'Go to your home. Alt-h / Option-h'=>'Vai alla home. Alt-h / Option-h',  # line 223

### ../pages/login.inc.php   ###
'License|tab in top navigation'=>'Licenza',  # line 32

### ../render/render_page.inc.php   ###
'Your projects. Alt-P / Option-P'=>'I tuoi progetti. Alt-P / Option-P',  # line 228

### ../pages/login.inc.php   ###
'Welcome to streber|Page title'=>'Benvenuto su Streber',  # line 73
'please login'                =>'fare login, per favore',  # line 74
'Nickname|label in login form'=>'Nickname',  # line 93
'Password|label in login form'=>'Password',  # line 94
'I forgot my password.|label in login form'=>'Password dimenticata.',  # line 95
'I forgot my password'        =>'Password dimenticata',  # line 96

### ../pages/proj.inc.php   ###
'Create another project after submit'=>'Dopo il salvataggio crea un altro progetto',  # line 1574

### ../pages/login.inc.php   ###
'If you remember your name, please enter it and try again.'=>'Se ricordi il tuo nome utente, inserirlo e provare nuovamente',  # line 142
'Supposed a user with this name existed a notification mail has been sent.'=>'Se questo nome utente esiste è stata inviata una mail di notifica.',  # line 165
'invalid login|message when login failed'=>'login non valida',  # line 216
'Welcome %s. Please adjust your profile and insert a good password to activate your account.'=>'Benvenuto %s. Per favore aggiorna il tuo profilo e inserisci una password valida per attivare il tuo account.',  # line 275
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter your name and use the <b>forgot password link</b> below.'=>'Spiacente, ma questo codice di attivazione non è più vlaido. Se si ha già un account, devi inserire il nome utente e utilizzare la funzione <b>Password dimenticata</b> qui sotto.',  # line 281
'License|page title'          =>'Licenza',  # line 304

### ../pages/misc.inc.php   ###
'Select some items to restore'=>'Seleziona gli elementi da ripristinare',  # line 179
'Item %s does not need to be restored'=>'L`elemento %s non necessita di essere ripristinato',  # line 191
'WARNING: Failed to restore %s items'=>'ATTENZIONE: Errore durante il ripristino di %s elementi',  # line 204
'Restored %s items'           =>'Ripristinato %s elementi',  # line 207
'Admin|top navigation tab'    =>'Admin',  # line 232
'System information'          =>'Informazione di sistema',  # line 238
'Admin'                       =>'Admin',  # line 239
'Database Type'               =>'Tipo di database',  # line 279
'PHP Version'                 =>'Versione PHP',  # line 282
'extension directory'         =>'Cartella estensioni',  # line 285
'loaded extensions'           =>'Estensioni caricate',  # line 287
'include path'                =>'Percorso inclusioni',  # line 289
'register globals'            =>'register globals',  # line 291
'magic quotes gpc'            =>'magic quotes gpc',  # line 293
'magic quotes runtime'        =>'magic quotes runtime',  # line 295
'safe mode'                   =>'modalità provvisoria',  # line 297

### ../pages/person.inc.php   ###
'Active People'               =>'Persone attive',  # line 60
'relating to %s|page title add on listing pages relating to current user'=>'relative a %s',  # line 62

### ../render/render_misc.inc.php   ###
'With Account|page option'    =>'Con l`account',  # line 180
'All People|page option'     =>'Tutte le persone',  # line 186

### ../pages/person.inc.php   ###
'People/Project Overview'     =>'Panoramica Persone/Progetto',  # line 100
'no related people'          =>'nessuna persona correlata',  # line 189
'People|Pagetitle for person list'=>'Persone',  # line 135
'relating to %s|Page title Person list title add on'=>'relative a %s',  # line 137
'admin view|Page title add on if admin'=>'Vista dell`amministratore',  # line 140
'Edit this person|Tooltip for page function'=>'Modifica questa persona',  # line 234
'Profile|Page function edit person'=>'Profilo',  # line 235
'Edit user rights|Tooltip for page function'=>'Modifica i permessi utenti',  # line 241
'User Rights|Page function for edit user rights'=>'Permessi utente',  # line 242

### ../pages/task.inc.php   ###
'Summary|Block title'         =>'Sommario',  # line 190

### ../pages/person.inc.php   ###
'Mobile|Label mobilephone of person'=>'Cellulare',  # line 290
'Office|label for person'     =>'Ufficio',  # line 293
'Private|label for person'    =>'Personale',  # line 296
'Fax (office)|label for person'=>'Fax (ufficio)',  # line 299
'Website|label for person'    =>'Sito web',  # line 304
'Personal|label for person'   =>'Personale',  # line 307
'E-Mail|label for person office email'=>'E-Mail',  # line 311
'E-Mail|label for person personal email'=>'E-Mail',  # line 314
'Adress Personal|Label'       =>'Indirizzo personale',  # line 319
'Adress Office|Label'         =>'Indirizzo ufficio',  # line 326
'Birthdate|Label'             =>'Data di nascita',  # line 333
'works for|List title'        =>'lavora per',  # line 348
'not related to a company'    =>'non correlata all`azienda',  # line 354
'works in Projects|list title for person projects'=>'lavora nei seguenti Progetti',  # line 378
'no active projects'          =>'nessun progetto attivo',  # line 392
'Assigned tasks'              =>'Attività assegnate',  # line 407
'No open tasks assigned'      =>'Nessuna attività assegnata',  # line 408
'Efforts|Page title add on'   =>'Impegno',  # line 449
'no efforts yet'              =>'ancora nessun impegno',  # line 472
'not allowed to edit'         =>'modifica non consentita',  # line 785
'Edit Person|Page type'       =>'Modifica Persona',  # line 570
'Person with account (can login)|form label'=>'Persona con account (può fare login)',  # line 618
'Password|form label'         =>'Password',  # line 634
'confirm Password|form label' =>'conferma Password',  # line 640
'-- reset to...--'            =>'-- resetta a...--',  # line 662
'Profile|form label'          =>'Profilo',  # line 667
'daily'                       =>'quotidianamente',  # line 676
'each 3 days'                 =>'ogni 3 giorni',  # line 677
'each 7 days'                 =>'ogni 7 giorni',  # line 678
'each 14 days'                =>'ogni 14 giorni',  # line 679
'each 30 days'                =>'ogni 30 giorni',  # line 680
'Never'                       =>'Mai',  # line 681
'Send notifications|form label'=>'Invia notifiche',  # line 687
'Send mail as html|form label'=>'Invia mail come html',  # line 688
'Theme|form label'            =>'Tema',  # line 697
'Language|form label'         =>'Lingua',  # line 701
'Create another person after submit'=>'Dopo il salvataggio crea un`altra persona',  # line 716
'Could not get person'        =>'Non è stato possible prendere la persona',  # line 1283
'Sending notifactions requires an email-address.'=>'L`invio della notifica richiede un indirizzo E-Mail',  # line 1105
'NOTE: Nickname has been converted to lowercase'=>'NOTA: il Nickname è stato convertito in minuscolo',  # line 906
'NOTE: Nickname has to be unique'=>'NOTA: il Nickname deve essere univoco',  # line 912
'passwords do not match'      =>'le password non coincidono',  # line 928
'Password is too weak (please add numbers, special chars or length)'=>'La Password è debole (renderla più lunga anche con numeri o caratteri speciali)',  # line 942
'Login-accounts require a unique nickname'=>'L`account per il login richiede un nickname univoco',  # line 957
'A notification / activation  will be mailed to <b>%s</b> when you log out.'=>'Una notifica / attivazione  verrà inviata a <b>%s</b> quando si fa logout.',  # line 983

### ../render/render_wiki.inc.php   ###
'Read more about %s.'         =>'Approfondimento su %s',  # line 735

### ../pages/person.inc.php   ###
'WARNING: could not insert object'=>'ATTENZIONE: non è stato possibile inserire l`oggetto',  # line 1004
'Select some people to delete'=>'Seleziona le persone da eliminare',  # line 1048
'<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'=>'',  # line 1065
'WARNING: Failed to delete %s people'=>'ATTENZIONE: Errore durante l`eliminazione di %s persone',  # line 1077
'Moved %s people to dumpster'=>'Spostato %s persone nel cestino',  # line 1080
'Insufficient rights'         =>'Permessi utente non sufficienti',  # line 1099
'Since the user does not have the right to edit his own profile and therefore to adjust his password, sending an activation does not make sense.'=>'Poichè l`utente non ha i permessi utente per modificare il proprio profilo e quindi di cambiare la password, inviare l`attivazione non ha senso',  # line 1111
'Sending an activation mail does not make sense, until the user is allowed to login. Please adjust his profile.'=>'Inviare la mail di attivazione non ha senso poichè a questo utente non è concesso di fare login. Si prega di modificare il suo profilo.',  # line 1116
'Activation mail has been sent.'=>'Mail di attivazione inviata.',  # line 1127
'Sending notification e-mail failed.'=>'Invio della e-mail di notifica fallita',  # line 1130
'Select some people to notify'=>'Seleziona le persone da notificare',  # line 1151
'WARNING: Failed to mail %s people'=>'ATTENZIONE: Invio fallito a %s persone',  # line 1176
'Sent notification to %s person(s)'=>'Inviata notifica a %s persone',  # line 1179
'Select some people to edit' =>'Seleziona le persone da modificare',  # line 1205
'Could not get Person'        =>'Non è stato possibile prendere la Persona',  # line 1209
'Edit Person|page type'       =>'Modifica Persona',  # line 1225
'Adjust user-rights'          =>'Aggiorna permessi-utente',  # line 1227
'Please consider that activating login-accounts might trigger security-issues.'=>'Si prega di valutare che l`attivazione di account utente potrebbe portare problemi di sicurezza.',  # line 1237
'Person can login|form label' =>'La persona può fare login',  # line 1243
'User rights changed'         =>'Permessi utente cambiati',  # line 1315

### ../pages/proj.inc.php   ###
'Active'                      =>'Attivo',  # line 34
'Templates'                   =>'Template',  # line 42
'Your Active Projects'        =>'I tuoi Progetti Attivi',  # line 67
'relating to %s'              =>'relativi a %s',  # line 194
'List|page type'              =>'Elenco',  # line 74
'<b>NOTE</b>: Some projects are hidden from your view. Please ask an administrator to adjust you rights to avoid double-creation of projects'=>'<b>NOTA</b>: Alcuni progetti sono nascosti alla tua vista. Chiedi all`amministratore di aggiornare il tuo profilo al fine di evitare la creazione di doppioni di progetti.',  # line 109
'create new project'          =>'crea nuovo progetto',  # line 112
'not assigned to a project'   =>'non assegnato ad alcun progetto',  # line 115
'Your Closed Projects'        =>'I tuoi progetti chiusi',  # line 142
'invalid project-id'          =>'project-id non valido',  # line 699
'Edit this project'           =>'Modifica questo progetto',  # line 279

### ../pages/task.inc.php   ###
'new'                        =>'nuova:',  # line 134

### ../pages/proj.inc.php   ###
'Add person as team-member to project'=>'Aggiungi al progetto persona come membro del team',  # line 291
'Team member'                 =>'Membro del team',  # line 292
'Create task'                 =>'Crea attività',  # line 298
'Create task with issue-report'=>'Crea attività con report di problematiche',  # line 1164

### ../pages/task.inc.php   ###
'Bug'                         =>'Bug',  # line 150

### ../pages/proj.inc.php   ###
'Book effort for this project'=>'Pianifica impegno per questo progetto',  # line 312

### ../std/constant_names.inc.php   ###
'Effort'                      =>'Impegno',  # line 106

### ../pages/proj.inc.php   ###
'Details|block title'         =>'Dettaglio',  # line 326
'Client|label'                =>'Cliente',  # line 340
'Phone|label'                 =>'Telefono',  # line 342
'E-Mail|label'                =>'E-Mail',  # line 345
'Status|Label in summary'     =>'Stato',  # line 358
'Wikipage|Label in summary'   =>'Wiki',  # line 363
'Projectpage|Label in summary'=>'Progetto',  # line 367
'Opened|Label in summary'     =>'Aperto',  # line 372
'Closed|Label in summary'     =>'Chiuso',  # line 377
'Created by|Label in summary' =>'Creato da',  # line 381
'Last modified by|Label in summary'=>'Ultima modifica di',  # line 386
'Logged effort'               =>'Impegno salvato',  # line 393
'hours'                       =>'ore',  # line 395
'Team members'                =>'Membri del team',  # line 440
'Your tasks'                  =>'Le tue attività',  # line 552
'No tasks assigned to you.'   =>'Nessun attività assegnata a te.',  # line 553
'All project tasks'           =>'Tutte le attività del progetto',  # line 553
'Comments on project'         =>'Commenti sul progetto',  # line 587
'Closed Tasks'                =>'Attività chiuse',  # line 637
'No tasks have been closed yet'=>'Nessuna attività chiusa finora',  # line 668
'changed project-items'       =>'elementi del progetto cambiati',  # line 754
'no changes yet'              =>'ancora nessun cambiamento',  # line 755
'all open'                    =>'tutte aperte',  # line 802
'all my open'                 =>'tutte le mie aperte',  # line 803
'my open for next milestone'  =>'le mie aperte per il prossimo evento',  # line 804
'not assigned'                =>'non assegnato',  # line 805
'blocked'                     =>'bloccato',  # line 806
'open bugs'                   =>'bug aperti',  # line 807
'to be approved'              =>'da approvare',  # line 808
'open tasks'                  =>'attività aperte',  # line 819
'my open tasks'               =>'le mie attività aperte',  # line 841
'next milestone'              =>'prossimo evento',  # line 875
'Create a new folder for tasks and files'=>'Crea una nuova cartella per attività e file',  # line 1039

### ../pages/task.inc.php   ###
'new subtask for this folder' =>'nuova sottoattività per questa cartella',  # line 118

### ../pages/proj.inc.php   ###
'Filter-Preset:'              =>'Imposta filtro',  # line 1071
'No tasks'                    =>'Nessuna attività',  # line 1100
'Project Issues'              =>'Problemi del progetto',  # line 1146
'Add Bugreport'               =>'Aggiungi report di un bug',  # line 1165

### ../render/render_misc.inc.php   ###
'Issues'                      =>'Problemi',  # line 260

### ../pages/proj.inc.php   ###
'Report Bug'                  =>'Aggiungi report di un bug',  # line 1190
'new Effort'                  =>'nuovo Impegno',  # line 1430
'Upload file|block title'     =>'Allega file',  # line 1273
'new Milestone'               =>'nuovo Evento',  # line 1341
'View open milestones'        =>'Mostra eventi aperti',  # line 1365
'View closed milestones'      =>'Mostra eventi chiusi',  # line 1371
'Project Efforts'             =>'Impieghi del progetto',  # line 1412
'Company|form label'          =>'Azienda',  # line 1556
'Select some projects to delete'=>'Seleziona i progetti da eliminare',  # line 1692
'WARNING: Failed to delete %s projects'=>'ATTENZIONE: Errore durante l`eliminazione di %s progetti',  # line 1712
'Moved %s projects to dumpster'=>'Spostato %s progetti nel cestino',  # line 1715
'Select some projects...'     =>'Seleziona progetti...',  # line 1737
'Invalid project-id!'         =>'Project-id non valido!',  # line 1747
'Y-m-d'                       =>'A-m-g',  # line 1752
'WARNING: Failed to change %s projects'=>'ATTENZIONE: Errore durante la modifica di %s progetti',  # line 1762
'Closed %s projects'          =>'Chiuso %s progetti',  # line 1766
'Reactivated %s projects'     =>'Riattivato %s progetti',  # line 1769
'Select new team members'     =>'Seleziona nuovi membri del team',  # line 1803
'Found no people to add. Go to `People` to create some.'=>'Non sono stati trovate persone da aggiugere. Vai in `Persone` per crearne di nuove.',  # line 1847
'Add'                         =>'Aggiungi',  # line 1859
'No people selected...'      =>'Nessuna persona selezionata',  # line 1885
'Could not access person by id'=>'Non è stato possibile accedere alla persona tramite id',  # line 1894
'NOTE: reanimated person as team-member'=>'NOTA: persona riammessa come membro del team',  # line 1932
'NOTE: person already in project'=>'NOTA: persona già nel progetto',  # line 1936
'Template|as addon to project-templates'=>'Template',  # line 2018
'Failed to insert new projectperson. Datastructure might have been corrupted'=>'Errore durante l`inserimento di una persona/progetto. La struttura del database potrebbe essere corrotta',  # line 2126
'Failed to insert new issue. DB structure might have been corrupted.'=>'Errore durante l`inserimento di un problema. La struttura del database potrebbe essere corrotta',  # line 2145
'Failed to update new task. DB structure might have been corrupted.'=>'Errore durante l`inserimento di un`attività. La struttura del database potrebbe essere corrotta',  # line 2200
'Failed to insert new comment. DB structure might have been corrupted.'=>'Errore durante l`inserimento di un
commento. La struttura del database potrebbe essere corrotta',  # line 2297
'Project duplicated (including %s items)'=>'Progetto duplicato (compreso %s elementi)',  # line 2318
'Select a project to edit description'=>'Seleziona un progetto per modificare la descrizione',  # line 2341

### ../pages/task.inc.php   ###
'Edit description'            =>'Modifica descrizione',  # line 2118

### ../pages/projectperson.inc.php   ###
'Edit Team Member'            =>'Modifica membro del team',  # line 46
'role of %s in %s|edit team-member title'=>'ruolo di %s in %s',  # line 47
'Role in this project'        =>'Ruolo in questo progetto',  # line 94
'start times and end times'   =>'Data di inizio e termine',  # line 109
'duration'                    =>'durata',  # line 110
'Log Efforts as'              =>'Salvataggio impegni come',  # line 113
'Changed role of <b>%s</b> to <b>%s</b>'=>'Cambia il ruolo di <b>%s</b> a <b>%s</b>',  # line 193

### ../pages/search.inc.php   ###
'Jumped to the only result found.'=>'Saltato all`unico risultato trovato.',  # line 148
'Search Results'              =>'Risultati della ricerca',  # line 167
'Searching'                   =>'Ricerca in corso',  # line 168
'Found %s companies'          =>'Trovato %s aziende',  # line 179
'Found %s projects'           =>'Trovato %s progetti',  # line 188
'Found %s people'            =>'Trovato %s persone',  # line 198
'Found %s tasks'              =>'Trovato %s attività',  # line 213
'Found %s comments'           =>'Trovato %s commenti',  # line 224
'sorry. Could not find anything.'=>'spiacente. Non è stato trovato alcun risultato.',  # line 230
'Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters'=>'A causa di una limitazione della ricerca testuale di MySQL, la ricerca non funziona per...<br>- parole con meno di 3 caratteri<br>- Elenchi con meno di 3 valori<br>- parole contenenti caratteri speciali',  # line 231

### ../pages/task.inc.php   ###
'Edit this task'              =>'Modifica questo attività',  # line 85
'Delete this task'            =>'Elimina questa attività',  # line 94
'Restore this task'           =>'Ripristina questa attività',  # line 103
'Undelete'                    =>'Ripristina',  # line 104
'new bug for this folder'     =>'nuovo bug per questa cartella',  # line 149
'new task for this milestone' =>'nuova attività per questo evento',  # line 141
'Append details'              =>'Aggiungi dettagli',  # line 161
'Complete|Page function for task status complete'=>'Completato',  # line 168
'Approved|Page function for task status approved'=>'Approvato',  # line 174
'Description|Label in Task summary'=>'Descrizione',  # line 202
'Part of|Label in Task summary'=>'Parte di',  # line 209
'Status|Label in Task summary'=>'Stato',  # line 215
'Opened|Label in Task summary'=>'Aperto',  # line 218
'Planned start|Label in Task summary'=>'Inizio pianificato',  # line 221
'Planned end|Label in Task summary'=>'Termine pianificato',  # line 225
'Closed|Label in Task summary'=>'Chiuso',  # line 230
'Created by|Label in Task summary'=>'Creato da',  # line 234
'Last modified by|Label in Task summary'=>'Ultima modifica di',  # line 239
'logged effort|Label in task-summary'=>'impegno salvato',  # line 244
'Attached files'              =>'File allegato',  # line 287
'attach new'                  =>'allega nuovo',  # line 289
'Upload'                      =>'Upload',  # line 292
'Issue report'                =>'Segnala problema',  # line 353
'Platform'                   =>'Piattaforma',  # line 362
'OS'                          =>'Sistema Operativo',  # line 365
'Build'                       =>'Versione',  # line 371
'Steps to reproduce|label in issue-reports'=>'Passi per riprodurre il problema',  # line 376
'Expected result|label in issue-reports'=>'Risultato atteso',  # line 380
'Suggested Solution|label in issue-reports'=>'Soluzione suggerita',  # line 384
'No project selected?'        =>'Nessun progetto selezionato?',  # line 485
'Please select only one item as parent'=>'Prego selezionare solo un elemento come padre',  # line 536
'Insufficient rights for parent item.'=>'Permessi utente insufficienti per l`elemento padre',  # line 539
'could not find project'      =>'non è stato possibile trovare il progetto',  # line 557
'I guess you wanted to create a folder...'=>'è stato intesa la volontà di creare una cartella',  # line 591
'Assumed <b>%s</b> to be mean label <b>%s</b>'=>'Presunto che <b>%s</b> significa l`etichetta <b>%s</b>',  # line 612
'Bug|Task-Label that causes automatically addition of issue-report'=>'Bug',  # line 713
'Feature|Task label that added by default'=>'Feature',  # line 724
'No task selected?'           =>'Nessuna attività selezionata?',  # line 768
'Edit %s|Page title'          =>'Modifica %s',  # line 795
'New task'                    =>'Nuova attività',  # line 801
'for %s|e.g. new task for something'=>'per %s',  # line 803
'-- undefined --'             =>'-- non definito --',  # line 844
'resolved in'                 =>'risolto in',  # line 850
'- select person -'           =>'- seleziona persona -',  # line 921
'Assign to'                   =>'Assegnato a',  # line 942
'Assign to|Form label'        =>'Assegnato a',  # line 953
'also assign to|Form label'   =>'e assegna anche a',  # line 954
'Prio|Form label'             =>'Priorità',  # line 960

### ../std/constant_names.inc.php   ###
'undefined'                   =>'non definito',  # line 115

### ../pages/task.inc.php   ###
'30 min'                      =>'30 min',  # line 987
'1 h'                         =>'1 h',  # line 988
'2 h'                         =>'2 h',  # line 989
'4 h'                         =>'4 h',  # line 990
'1 Day'                       =>'1 Giorno',  # line 991
'2 Days'                      =>'2 Giorni',  # line 992
'3 Days'                      =>'3 Giorni',  # line 993
'4 Days'                      =>'4 Giorni',  # line 994
'1 Week'                      =>'1 Settimana',  # line 995
'1,5 Weeks'                   =>'1,5 Settimane',  # line 996
'2 Weeks'                     =>'2 Settimane',  # line 997
'3 Weeks'                     =>'3 Settimane',  # line 998
'Completed'                   =>'Completata',  # line 1025
'Severity|Form label, attribute of issue-reports'=>'Gravità',  # line 1063
'reproducibility|Form label, attribute of issue-reports'=>'riproducibilità',  # line 1064
'unassigned to %s|task-assignment comment'=>'non assegnato a %s',  # line 1217
'formerly assigned to %s|task-assigment comment'=>'assegnato formalmente a %s',  # line 1223
'task was already assigned to %s'=>'attività già assegnata a %s',  # line 1241
'Failed to retrieve parent task'=>'Errore durante il recupero dell`attività padre',  # line 1300
'Task requires name'          =>'L`attività richiede un nome',  # line 2176
'ERROR: Task called %s already exists'=>'ERRORE: l`attività chiamata %s esiste già',  # line 1337
'Turned parent task into a folder. Note, that folders are only listed in tree'=>'Trasformata l`attività padre in cartella. Prego notare che le cartelle sono elencate come albero',  # line 1356
'Failed, adding to parent-task'=>'Errore, aggiunto ad attività padre',  # line 1360
'NOTICE: Ungrouped %s subtasks to <b>%s</b>'=>'NOTA: Tolte dal gruppo %s sottoattività in <b>%s</b>',  # line 1376
'HINT: You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'=>'SUGGERIMENTO: Hai trasformato l`attività <b>%s</b> in una cartella. Le cartelle sono visualizzate nell`elenco delle attività.',  # line 1383
'NOTE: Created task %s with ID %s'=>'NOTA: Creato attività %s con ID %s',  # line 1472
'NOTE: Changed task %s with ID %s'=>'NOTA: Cambiato attività %s con ID %s',  # line 1481
'Select some tasks to move'   =>'Seleziona le attività da spostare',  # line 1511
'Can not move task <b>%s</b> to own child.'=>'Non è possibile spostare l`attività <b>%s</b> sul proprio figlio',  # line 1570
'Can not edit tasks %s'       =>'Non è possibile modificare le attività %s',  # line 1578
'insufficient rights to edit any of the selected items'=>'permessi utente insufficienti per modificare alcuni degli elementi selezionati',  # line 1589
'Select folder to move tasks into'=>'Seleziona la cartella in cui spostare le attività',  # line 1615
'(or select nothing to move to project root)'=>'(o non selezionare niente per spostarla nella root del progetto)',  # line 1664
'Task <b>%s</b> deleted'      =>'Attività <b>%s</b> eliminata',  # line 1713
'Moved %s tasks to Dumpster'  =>'Spostato %s attività nel Cestino',  # line 1749
' ungrouped %s subtasks to above parents.'=>' tolte dal gruppo %s sottoattività ai relativi padri.',  # line 1751
'No task(s) selected for deletion...'=>'Nessuna attività selezionata per l`eliminazione',  # line 1760
'ERROR: could not retrieve task'=>'ERRORE: non è stato possibile recuperare l`attività',  # line 1782
'Task <b>%s</b> does not need to be restored'=>'L`attività <b>%s</b> non necessita di essere ripristinata',  # line 1795
'Task <b>%s</b> restored'     =>'Attività <b>%s</b> ripristinata',  # line 1847
'Failed to restore Task <b>%s</b>'=>'Errore durante il ripristino dell`Attività <b>%s</b>',  # line 1850
'Task <b>%s</b> do not need to be restored'=>'L`attività <b>%s</b> non richiede il ripristino',  # line 1839
'No task(s) selected for restoring...'=>'Nessuna attività selezionata per il ripristino...',  # line 1862
'Select some task(s) to mark as completed'=>'Seleziona attività da segnare come completate!',  # line 1881
'Marked %s tasks (%s subtasks) as completed.'=>'Contrassegnate %s attività (%s sottoattività) come completate.',  # line 1930
'%s error(s) occured'         =>'%s errori',  # line 2031
'Select some task(s) to mark as approved'=>'Seleziona le attività da segnare come approvate',  # line 1951
'Marked %s tasks as approved and hidden from project-view.'=>'Contrassegnato %s attività come approvate e nascoste dalla vista del progetto',  # line 1977
'Select some task(s)'         =>'Seleziona le attività',  # line 1997
'could not update task'       =>'non è stato possibile aggiornare l`attività',  # line 2019
'No task selected to add issue-report?'=>'Nessuna attività selezionata per aggiungere una segnalazione di problema?',  # line 2050
'Task already has an issue-report'=>'L`attività ha già una segnalazione di problema',  # line 2054
'Adding issue-report to task' =>'Aggiunta di una segnalazione di problema all`attività',  # line 2070
'Could not get task'          =>'Non è stato possibile recuperare l`attività',  # line 2076
'Select a task to edit description'=>'Seleziona l`attività di cui vuoi modificare la descrizione',  # line 2097

### ../render/render_form.inc.php   ###
'Please use Wiki format'      =>'Per favore usare il formato Wiki',  # line 310
'Submit'                      =>'Invia',  # line 423
'Cancel'                      =>'Annulla',  # line 447
'Apply'                       =>'Applica',  # line 457

### ../render/render_list.inc.php   ###
'for milestone %s'            =>'for l`evento %s',  # line 176
'changed today'               =>'cambiato oggi',  # line 290
'changed since yesterday'     =>'cambiato ieri',  # line 293
'changed since <b>%d days</b>'=>'cambiato da <b>%d giorni</b>',  # line 296
'changed since <b>%d weeks</b>'=>'cambiato da <b>%d settimane</b>',  # line 299
'created by %s'               =>'creato da %s',  # line 555
'created by unknown'          =>'creatore da sconosciuto',  # line 558
'modified by %s'              =>'modificato da %s',  # line 581
'modified by unknown'         =>'modificato da sconosciuto',  # line 584
'item #%s has undefined type' =>'elemento #%s è di tipo indefinito',  # line 607
'do...'                       =>'esegui...',  # line 833

### ../render/render_list_column_special.inc.php   ###
'Tasks|short column header'   =>'Attività',  # line 226
'Number of open tasks is hilighted if shown home.'=>'Il numero di attività aperte è evidenziato se mostrato in home',  # line 227
'S|Short status column header'=>'S',  # line 273
'Status is %s'                =>'Lo stato è %s',  # line 292
'Item is public to'           =>'Elemento mostrato a',  # line 327
'Pub|column header for public level'=>'Mostr',  # line 328
'Public to %s'                =>'Mostrato a %s',  # line 344

### ../render/render_misc.inc.php   ###
'Tasks|Project option'        =>'Attività',  # line 265
'Completed|Project option'    =>'Completato',  # line 270
'Milestones|Project option'   =>'Eventi',  # line 276
'Files|Project option'        =>'File',  # line 281
'Efforts|Project option'      =>'Impegno',  # line 287
'History|Project option'      =>'Storico',  # line 292
'new since last logout'       =>'novità dall`ultimo logout',  # line 490
'Yesterday'                   =>'Ieri',  # line 460

### ../render/render_page.inc.php   ###
'<span class=accesskey>H</span>ome'=>'<span class=accesskey>H</span>ome',  # line 220
'<span class=accesskey>P</span>rojects'=>'<span class=accesskey>P</span>rogetti',  # line 227
'Your related People'         =>'Persone a te correlate',  # line 235
'Your related Companies'      =>'Aziende a te correlate',  # line 241
'Calendar'                    =>'Calendario',  # line 246
'<span class=accesskey>S</span>earch:&nbsp;'=>'<span class=accesskey>[S]</span> Cerca:&nbsp;',  # line 251
'Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`'=>'Usa Tab per ricerca complessa oppure inserisci parola* o Id e premi invio. Usa ALT-S come scorciatoia. Usa `Search!` for `Mi sento fortunato`',  # line 254
'This page requires java-script to be enabled. Please adjust your browser-settings.'=>'Questa pagina richiede il supporto a java-script abilitato. Per favore aggiornare le impostazioni del proprio browser.',  # line 549
'Add Now'                     =>'Aggiungi ora',  # line 588
'you are'                     =>'tu sei',  # line 635
'Return to normal view'       =>'Torna alla vista normale',  # line 649
'Leave Client-View'           =>'Lascia la vista del Cliente',  # line 649
'How this page looks for clients'=>'Come il cliente vede questa pagina',  # line 661
'Client view'                 =>'Vista del cliente',  # line 661
'Documentation and Discussion about this page'=>'Documentazione e discussione su questa pagina',  # line 881
'Help'                        =>'Aiuto',  # line 883

### ../render/render_wiki.inc.php   ###
'enlarge'                     =>'allarga',  # line 665
'Unknown File-Id:'            =>'File-Id sconosciuto',  # line 677
'Unknown project-Id:'         =>'Project-Id sconosciuto',  # line 687
'Wiki-format: <b>$type</b> is not a valid link-type'=>'Formato Wiki: <b>$type</b> non è un formato valido di link',  # line 734
'No task matches this name exactly'=>'Nessuna attività corrisponde a questo nome esattamente',  # line 781
'This task seems to be related'=>'Questa attività sembra correlata',  # line 782
'No item excactly matches this name.'=>'Nessun elemento corrisponde a questo nome',  # line 809
'List %s related tasks'       =>'Elenca %s le attività correlate',  # line 810
'identical'                   =>'identiche',  # line 818
'No item matches this name. Create new task with this name?'=>'Nessuna elemento corrisponde a questo nome. Creo una nuova attività con questo nome?',  # line 850
'No item matches this name.'  =>'Nessun elemento corrisponde a questo nome',  # line 828
'No item matches this name'   =>'Nessun elemento corrisponde a questo nome',  # line 875

### ../std/class_auth.inc.php   ###
'Fresh login...'              =>'Fresh login...',  # line 45
'Cookie is no longer valid for this computer.'=>'Il cookie non è più valido per questo computer',  # line 52
'Your IP-Address changed. Please relogin.'=>'Il tuo indirizzo IP è cambiato. Si prega di fare login nuovamente.',  # line 58
'Your account has been disabled. '=>'Il tuo account è stato disabilitato',  # line 64
'Could not set cookie.'       =>'Non è stato possibile salvare il cookie.',  # line 205

### ../std/class_pagehandler.inc.php   ###
'WARNING: operation aborted (%s)'=>'ATTENZIONE: operazione abortita (%s)',  # line 588
'FATAL: operation aborted with an fatal error (%s).'=>'ERRORE FATALE: operazione abortita (%s)',  # line 594
'Error: insufficient rights'    =>'Errore: permessi utente insufficienti',  # line 597
'FATAL: operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'ERRORE FATALE: operazione abortita con un errore grave nella struttura del database (%s). Questo può essere causato da inconsistenza nel database. E` consigliato di ripristinare un backup recente. ',  # line 600
'NOTE: %s|Message when operation aborted'=>'NOTA: %s',  # line 603
'ERROR: %s|Message when operation aborted'=>'ERRORE: %s',  # line 606

### ../std/common.inc.php   ###
'No element selected? (could not find id)|Message if a function started without items selected'=>'Nessun elemento selezionato? (non è stato trovato alcuni id)',  # line 294

### ../std/constant_names.inc.php   ###
'template|status name'        =>'template',  # line 17
'undefined|status_name'       =>'non definito',  # line 18
'upcoming|status_name'        =>'arrivo',  # line 19
'new|status_name'             =>'nuovo',  # line 20
'open|status_name'            =>'aperto',  # line 21
'blocked|status_name'         =>'bloccato',  # line 22
'done?|status_name'           =>'fatto?',  # line 23
'approved|status_name'        =>'approvato',  # line 24
'closed|status_name'          =>'chiuso',  # line 25
'undefined|pub_level_name'    =>'non definito',  # line 32
'private|pub_level_name'      =>'personale',  # line 33
'suggested|pub_level_name'    =>'suggerito',  # line 34
'internal|pub_level_name'     =>'interno',  # line 35
'open|pub_level_name'         =>'aperto',  # line 36
'client|pub_level_name'       =>'cliente',  # line 37
'cliend_edit|pub_level_name'  =>'client_modifica',  # line 38
'assigned|pub_level_name'     =>'assegnato',  # line 39
'owned|pub_level_name'        =>'posseduto',  # line 40
'priv|short for public level private'=>'pers',  # line 47
'int|short for public level internal'=>'int',  # line 49
'pub|short for public level client'=>'pub',  # line 51
'PUB|short for public level client edit'=>'PUB',  # line 52
'A|short for public level assigned'=>'A',  # line 53
'O|short for public level owned'=>'O',  # line 54
'Create projects|a user right'=>'Crea progetti',  # line 62
'Edit projects|a user right'  =>'Modifica progetti',  # line 63
'Delete projects|a user right'=>'Elimina progetti',  # line 64
'Edit project teams|a user right'=>'Modifica team di progetti',  # line 65
'View anything|a user right'  =>'Visualizza tutto',  # line 66
'Edit anything|a user right'  =>'Modifica tutto',  # line 67
'Create People|a user right' =>'Crea Persona',  # line 69
'Create & Edit People|a user right'=>'Crea & Modifica Persone',  # line 70
'Delete People|a user right' =>'Elimina Persone',  # line 71
'View all People|a user right'=>'Mostra tutte le Persone',  # line 72
'Edit user rights|a user right'=>'Modifica Permessi Utente',  # line 73
'Edit Own Profil|a user right'=>'Modifica il proprio Profilo',  # line 74
'Create Companies|a user right'=>'Crea Aziende',  # line 76
'Edit Companies|a user right' =>'Modifica Aziende',  # line 77
'Delete Companies|a user right'=>'Elimina Aziende',  # line 78
'undefined|priority'          =>'non definito',  # line 84
'urgend|priority'             =>'urgente',  # line 85
'high|priority'               =>'alta',  # line 86
'normal|priority'             =>'normale',  # line 87
'lower|priority'              =>'bassa',  # line 88
'lowest|priority'             =>'molto bassa',  # line 89
'Team Member'                 =>'Membri del Team',  # line 101
'Employment'                  =>'Impiegato',  # line 103
'Issue'                       =>'Problema',  # line 104
'Task assignment'             =>'Assegnamento attività',  # line 109
'Nitpicky|severity'           =>'Critica',  # line 116
'Feature|severity'            =>'Feature',  # line 117
'Trivial|severity'            =>'Banale',  # line 118
'Text|severity'               =>'Testo',  # line 119
'Tweak|severity'              =>'Miglioramento',  # line 120
'Minor|severity'              =>'Minore',  # line 121
'Major|severity'              =>'Maggiore',  # line 122
'Crash|severity'              =>'Crash',  # line 123
'Block|severity'              =>'Blocco',  # line 124
'Not available|reproducabilty'=>'Non disponibile',  # line 129
'Always|reproducabilty'       =>'Sempre',  # line 130
'Sometimes|reproducabilty'    =>'A volte',  # line 131
'Have not tried|reproducabilty'=>'Non provato',  # line 132
'Unable to reproduce|reproducabilty'=>'Impossibilitato a riprodurre',  # line 133

### ../std/mail.inc.php   ###
'Failure sending mail: %s'    =>'Errore inviando mail: %s',  # line 49
'Streber Email Notification|notifcation mail from'=>'Streber - Notifica Email',  # line 85
'Updates at %s|notication mail subject'=>'Aggiornamenti su %s',  # line 105
'Hello %s,|notification'      =>'Ciao %s,',  # line 117
'with this automatically created e-mail we want to inform you that|notification'=>'questo è un messaggio automatizzato per informarti che',  # line 119
'since %s'                    =>'dal %s',  # line 123
'following happened at %s |notification'=>'è successo quanto di seguito su %s',  # line 126
'Your account has been created.|notification'=>'Il tuo account è stato creato.',  # line 133
'Please set password to activate it.|notification'=>'Per favore imposta una password per attivarlo.',  # line 135
'You have been assigned to projects:|notification'=>'Sei stato assegnato ai progetti:',  # line 144
'Project Updates'             =>'Aggiornamento dei Progetti',  # line 174
'If you do not want to get further notifications feel free to|notification'=>'Se non vuoi più ricevere queste notifiche è possibile',  # line 221
'adjust your profile|notification'=>'modifica le impostazioni del profilo',  # line 223
'Thanks for your time|notication'=>'Grazie per l`attenzione',  # line 228
'the management|notication'   =>'il management',  # line 229
'No news for <b>%s</b>'       =>'Nessuna notizia per <b>%s</b>',  # line 275

### ../db/db_item.inc.php   ###
'<b>%s</b> isn`t a known format for date.'=>'<b>%s</b> non è un formato noto per le date',  # line 237
'Unknown'                     =>'Sconosciuto',  # line 1297
'Item has been modified during your editing by %s (%s minutes ago). Your changes can not be submitted.'=>'L`elemento è stato modificando durante il editing da %s (%s minuti fa). I tuoi cambiamenti non sono stati salvati',  # line 1302

### ../lists/list_changes.inc.php   ###
'Approve Task'                =>'Approva attività',  # line 238
'renamed'                     =>'rinominato',  # line 265
'edit wiki'                   =>'modifica Wiki',  # line 268
'attached'                    =>'allegato',  # line 326
'attached file'               =>'file allegato',  # line 330

### ../lists/list_companies.inc.php   ###
'Company|Column header'       =>'Azienda',  # line 115

### ../lists/list_files.inc.php   ###
'Parent item'                 =>'Elemento padre',  # line 39
'ID'                          =>'ID',  # line 92
'Click on the file ids for details.'=>'Fai click sull`ID del file per i dettagli',  # line 95
'Move files'                  =>'Sposta file',  # line 140
'File|Column header'          =>'File',  # line 315
'in|... folder'               =>'in',  # line 348
'Attached to|Column header'   =>'Allegato a',  # line 374

### ../lists/list_milestones.inc.php   ###
'open'                        =>'apri',  # line 420

### ../lists/list_tasks.inc.php   ###
'Task name'                   =>'Nome dell`attività',  # line 906

### ../pages/_handles.inc.php   ###
'view changes'                =>'visualizza cambiamenti',  # line 254
'Mark tasks as Open'          =>'Segna attività come Aperta',  # line 308
'Move files to folder'        =>'Sposta file nella cartella',  # line 565
'List Deleted People'        =>'Elenco Persone Eliminate',  # line 652
'Filter errors.log'           =>'Filtra errors.log',  # line 853
'Delete errors.log'           =>'Elimina errors.log',  # line 860

### ../pages/comment.inc.php   ###
'Failed to delete %s comments'=>'Errore durante l`eliminazione di %s commenti',  # line 472

### ../pages/task.inc.php   ###
'edit'                       =>'modifica:',  # line 2485

### ../pages/company.inc.php   ###
'Person already related to company'=>'Persona già correlata all`azienda',  # line 617
'Failed to delete %s companies'=>'Errore durante l`eliminazione di %s aziende',  # line 659

### ../pages/effort.inc.php   ###
'Failed to delete %s efforts' =>'Errore durante l`eliminazione di %s impegni',  # line 412

### ../pages/file.inc.php   ###
'Failed to delete %s files'   =>'Errore durante l`eliminazione di %s file',  # line 615
'Select some files to move'   =>'Seleziona i file da spostare',  # line 696
'Can not edit file %s'        =>'Impossibile modificare il file %s',  # line 750
'Edit files'                  =>'Modifica i file',  # line 785
'Select folder to move files into'=>'Seleziona la cartella dove spostare i file',  # line 787
'No folders available'        =>'Nessuna cartella disponibile',  # line 821

### ../pages/misc.inc.php   ###
'Failed to restore %s items'  =>'Errore durante il ripristino di %s elementi',  # line 204
'Error-Log'                   =>'Log degli errori',  # line 293
'hide'                        =>'nascondi',  # line 429

### ../pages/person.inc.php   ###
'Deleted People'              =>'Persone eliminate',  # line 206
'notification:'               =>'notifica:',  # line 312
'no company'                  =>'nessuna azienda',  # line 425
'Nickname has been converted to lowercase'=>'Nickname è stato convertito in lettere minuscole',  # line 978
'Nickname has to be unique'   =>'Nickname deve essere univoco',  # line 984
'Passwords do not match'      =>'Le password non coincidono',  # line 1000
'Could not insert object'     =>'Non è possibile inserire oggetti',  # line 1079
'<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'=>'<b>%s</b> è stato assegnato ai progetti e non può essere eliminato. Ma è possibile disattivare i suoi permessi utente al login.',  # line 1140
'Failed to delete %s people' =>'Errore durante l`eliminazione di %s persone',  # line 1152
'Failed to mail %s people'   =>'Errore durante l`invio di e-mail a %s persone',  # line 1251

### ../pages/proj.inc.php   ###
'not assigned to a closed project'=>'not assegnato ad un progetto chiuso',  # line 171
'no project templates'        =>'nessun template di progetto',  # line 225

### ../pages/task.inc.php   ###
'Wiki'                        =>'Wiki',  # line 108

### ../pages/proj.inc.php   ###
'Failed to delete %s projects'=>'Errore durante l`eliminazione di %s progetti',  # line 1658
'Failed to change %s projects'=>'Errore durante la modifica di %s progetti',  # line 1708
'Reanimated person as team-member'=>'Riassegnata persona come membro del team',  # line 1877
'Person already in project'   =>'Persona già presente nel progetto',  # line 1881

### ../pages/projectperson.inc.php   ###
'Failed to remove %s members from team'=>'Errore durante l`eliminazione di %s membri dal team',  # line 266
'Unassigned %s team member(s) from project'=>'Rimossi %s membri del team dal progetto',  # line 269

### ../pages/task.inc.php   ###
'Add Details|page function'   =>'Aggiungi dettagli',  # line 166
'Move|page function to move current task'=>'Sposta',  # line 175
'status:'                     =>'Stato:',  # line 181
'Reopen|Page function for task status reopened'=>'Riapri',  # line 206
'View history of item'        =>'Vedi storico dell`elemento',  # line 232
'History'                     =>'Storico',  # line 233
'For Milestone|Label in Task summary'=>'Per Evento',  # line 271
'Estimated|Label in Task summary'=>'Previsto',  # line 284
'Completed|Label in Task summary'=>'Completato',  # line 293
'Created|Label in Task summary'=>'Creato',  # line 311
'Modified|Label in Task summary'=>'Modificato',  # line 316
'Open tasks for milestone'    =>'Apri attività per l`evento',  # line 438
'No open tasks for this milestone'=>'Nessuna attività aperta per questo evento',  # line 441
'Parent task not found.'      =>'Attività padre non trovata.',  # line 675
'You do not have enough rights to edit this task'=>'Non si hanno sufficienti permessi utente per modificare questa attività',  # line 881
'New milestone'               =>'Nuovo evento',  # line 911
'Create another task after submit'=>'Dopo il salvataggio crea un`altra attività',  # line 1196
'Task called %s already exists'=>'Attività con il nome %s già esiste',  # line 1463
'You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'=>'Hai convertito l`attività <b>%s</b> in una cartella. Le cartelle sono mostrate nell`elenco apposito delle attività',  # line 1520
'Created task %s with ID %s'  =>'Creata attività %s con ID %s',  # line 1609
'Changed task %s with ID %s'  =>'Cambiata attività %s con ID %s',  # line 1618
'Failed to delete task $task->name'=>'Errore durante l`eliminazione dell`attività $task->name',  # line 1905
'Could not find task'         =>'Non è stato possibile trovare l`attività',  # line 2291
'Select some task(s) to reopen'=>'Seleziona le attività da riaprire',  # line 2164
'Reopened %s tasks.'          =>'Riaperte %s attività',  # line 2189
'Could not update task'       =>'Non è stato possibile aggiornare l`attività',  # line 2234
'changes'                     =>'cambiamenti',  # line 2479
'View task'                   =>'Mostra attività',  # line 2492
'item has not been edited history'=>'l`elemento non è stato modificato storicamente',  # line 2521
'unknown'                     =>'sconosciuto',  # line 2599
' -- '                        =>' -- ',  # line 2621
'&lt;&lt; prev change'        =>'&lt;&lt; precedente cambiamento',  # line 2633
'next &gt;&gt;'               =>'prossimo &gt;&gt;',  # line 2649
'summary'                     =>'sommario',  # line 2663
'Item did not exists at %s'   =>'L`elemento non esiste a %s',  # line 2695
'no changes between %s and %s'=>'nessun cambiamento tra %s e %s',  # line 2698
'ok'                          =>'ok',  # line 2773

### ../render/render_fields.inc.php   ###
'<b>%s</b> isn`t a known format for date.'=>'<b>%s</b> non è un formato di data conosciuto.',  # line 292

### ../render/render_form.inc.php   ###
'Wiki format'                 =>'formato Wiki',  # line 310

### ../render/render_misc.inc.php   ###
'Other People|page option'   =>'Altre persone',  # line 305
'Deleted|page option'         =>'Eliminato',  # line 309

### ../render/render_wiki.inc.php   ###
'from'                        =>'da',  # line 303

### ../std/class_pagehandler.inc.php   ###
'Operation aborted (%s)'      =>'Operazione abortita (%s)',  # line 673
'Operation aborted with an fatal error (%s).'=>'Operazione abortita a causa di un errore fatale (%s)',  # line 676
'Operation aborted with an fatal error which was cause by an programming error (%s).'=>'Operazione abortita a causa di un errore fatale causato da un errore di programmazione (%s)',  # line 679
'insufficient rights'           =>'Permessi utente non sufficienti',  # line 683
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'Operazione abortita a causa di un errore fatale nella struttura del database (%s). Questo può essere causato da inconsistenza nel database. Noi consigliamo caldamente di ripristinare un backup recente.',  # line 686
'%s|Message when operation aborted'=>'%s',  # line 692

### ../std/common.inc.php   ###
'only one item expected.'     =>'atteso solo un elemento',  # line 305

### ../std/constant_names.inc.php   ###
'Member|profile name'         =>'Membro',  # line 32
'Admin|profile name'          =>'Amministratore',  # line 33
'Project manager|profile name'=>'Project Manager',  # line 34
'Developer|profile name'      =>'Sviluppatore',  # line 35
'Artist|profile name'         =>'Designer',  # line 36
'Tester|profile name'         =>'Tester',  # line 37
'Client|profile name'         =>'Cliente',  # line 38
'Client trusted|profile name' =>'Cliente certificato',  # line 39
'Guest|profile name'          =>'Ospite',  # line 40

### ../std/mail.inc.php   ###
'Please set a password to activate it.|notification'=>'Prego impostare una password per attivarlo.',  # line 152
'If you do not want to get further notifications or you forgot your password feel free to|notification'=>'Se non vuoi ricevere ulteriori notifiche oppure hai dimenticato la tua password',  # line 286


### ../db/class_project.inc.php   ###
'only team members can create items'=>'solo i membri del team posso creare elementi',  # line 1178

### ../db/class_task.inc.php   ###
'resolved in version'         =>'risolto con la versione',  # line 69

### ../pages/task_view.inc.php   ###
'resolve reason'              =>'motivo della risoluzione',  # line 708

### ../db/class_task.inc.php   ###
'is a milestone'              =>'è un evento',  # line 89
'released'                    =>'rilasciato',  # line 96
'release time'                =>'ora di rilasio',  # line 101

### ../lists/list_versions.inc.php   ###
'Released Milestone'          =>'Evento rilasciato',  # line 183

### ../db/db.inc.php   ###
'Database exception. Please read %s next steps on database errors.%s'=>'Database exception. Per favore leggere i %s passi seguenti sugli errori del database.%s',  # line 38

### ../lists/list_comments.inc.php   ###
'New Comment'                 =>'Nuovo Commento',  # line 39

### ../lists/list_changes.inc.php   ###
'Last of %s comments:'        =>'Ultimo di %s commenti:',  # line 218
'assigned'                    =>'assegnato',  # line 329
'attached file to'            =>'file allegato a',  # line 358

### ../lists/list_comments.inc.php   ###
'Add Comment'                 =>'Aggiungi Commento',  # line 41
'Shrink All Comments'         =>'Comprimi Tutti i Commenti',  # line 53
'Collapse All Comments'       =>'Comprimi Tutti i Commenti',  # line 55
'Expand All Comments'         =>'Espandi Tutti i Commenti',  # line 62
'Reply'                       =>'Rispondi',  # line 137
'1 sub comment'               =>'1 sotto-commento',  # line 192
'%s sub comments'             =>'%s sotto-commenti',  # line 195

### ../lists/list_efforts.inc.php   ###
'%s effort(s) with %s hours'  =>'%s impegni con %s ore',  # line 102
'Effort name. More Details as tooltips'=>'Nome dell`impegno',  # line 116

### ../lists/list_files.inc.php   ###
'ID %s'                       =>'ID %s',  # line 450
'Show Details'                =>'Mostra dettagli',  # line 452
'Summary|Column header'       =>'Sommario',  # line 407
'Thumbnail|Column header'     =>'Thumbnail',  # line 468

### ../lists/list_versions.inc.php   ###
'%s required'                 =>'%s richiesto',  # line 265
'Release Date'                =>'Data di rilascio',  # line 243

### ../pages/_handles.inc.php   ###
'Versions'                    =>'Versioni',  # line 59
'Task Test'                   =>'Test dell`attività',  # line 258
'Edit multiple Tasks'         =>'Modifica multiple attività',  # line 279
'View Task Efforts'           =>'Visualizza Impieghi dell`attività',  # line 301
'New released Version'      =>'Nuovo evento rilasciato',  # line 417
'Create Note'                 =>'Crea Nota',  # line 482
'Edit Note'                   =>'Modifica Nota',  # line 496
'View effort'                 =>'Mostra impegno',  # line 507
'View multiple efforts'       =>'Mostra multipli impieghi',  # line 516
'List Clients'                =>'Elenco Clienti',  # line 706
'List Prospective Clients'    =>'Elenco Prospect',  # line 711
'List Suppliers'              =>'Elenco Fornitori',  # line 717
'List Partners'               =>'Elenco Partner',  # line 723
'Remove people from company' =>'Rimuovi persone dall`azienda',  # line 774
'List Employees'              =>'Elenco Impiegati',  # line 798

### ../pages/comment.inc.php   ###
'Publish to|form label'       =>'Pubblica a',  # line 336
'Moved %s comments to trash'  =>'Spostati %s commenti nel cestino',  # line 487

### ../pages/company.inc.php   ###
'Clients'                     =>'Clienti',  # line 100
'related companies of %s'     =>'compagnie correlate di %s',  # line 295
'Prospective Clients'         =>'Clienti Prospect',  # line 165
'Suppliers'                   =>'Fornitori',  # line 229
'Partners'                    =>'Partner',  # line 293
'Remove person from company'  =>'Rimuovi persone dall`azienda',  # line 498

### ../pages/person.inc.php   ###
'Category|form label'         =>'Categoria',  # line 930

### ../pages/company.inc.php   ###
'Failed to remove %s contact person(s)'=>'Errore durante leliminazione di %s persone',  # line 954
'Removed %s contact person(s)'=>'Eliminati %s contatti',  # line 957
'Moved %s companies to trash' =>'Spostato %s aziende nel cestino',  # line 999

### ../pages/effort.inc.php   ###
'Select one or more efforts'  =>'Seleziona una o più impegni',  # line 197
'You do not have enough rights'=>'Non hai sufficienti permessi utente',  # line 231
'Effort of task|page type'    =>'Impegno dell`attività',  # line 67
'Edit this effort'            =>'Modifca questo impegno',  # line 85
'Project|label'               =>'Progetto',  # line 332
'Task|label'                  =>'Attività',  # line 349
'No task related'             =>'Nessuna attività correlata',  # line 349
'Created by|label'            =>'Creato da',  # line 356
'Created at|label'            =>'Creato a',  # line 362
'Duration|label'              =>'Durata',  # line 368
'Time start|label'            =>'Data inizio',  # line 366
'Time end|label'              =>'Data termine',  # line 367
'No description available'    =>'Nessuna descrizione disponibile',  # line 404
'Multiple Efforts|page type'  =>'Impegni multipli',  # line 244
'Multiple Efforts'            =>'Impegni multipli',  # line 265
'Information'                 =>'Informazioni',  # line 281
'Number of efforts|label'     =>'Numero di impegni',  # line 290
'Sum of efforts|label'        =>'Somma degli impegni',  # line 294
'from|time label'             =>'dal',  # line 301
'to|time label'               =>'al',  # line 302
'Time|label'                  =>'Tempo',  # line 306

### ../pages/version.inc.php   ###
'Publish to'                  =>'Pubblica a',  # line 119

### ../pages/effort.inc.php   ###
'Moved %s efforts to trash'   =>'Spostato %s attività nel cestino',  # line 836

### ../pages/file.inc.php   ###
'Move this file to another task'=>'Sposta questo file in un`altra attività',  # line 121
'Move'                        =>'Sposta',  # line 122
'Moved %s files to trash'     =>'Spostati %s file nel cestino',  # line 649

### ../pages/home.inc.php   ###
'Projects'                    =>'Progetti',  # line 104

### ../pages/person.inc.php   ###
'Employees|Pagetitle for person list'=>'Impiegati',  # line 210
'Contact People|Pagetitle for person list'=>'Contatti',  # line 286
'Create Note|Tooltip for page function'=>'Crea Nota',  # line 472
'Note|Page function person'   =>'Note',  # line 473
'Person details'              =>'Dettagli della persona',  # line 616
'- no -'                      =>'- no -',  # line 969
'Assigne to project|form label'=>'Assegna al progetto',  # line 978
'autodetect'                  =>'determina automaticamente',  # line 1019
'Time zone|form label'        =>'Fuso orario',  # line 1052

### ../pages/task_more.inc.php   ###
'Invalid checksum for hidden form elements'=>'Errore checksum per i campi nascosti della form',  # line 790

### ../pages/person.inc.php   ###
'The changed profile <b>does not affect existing project roles</b>! Those has to be adjusted inside the projects.'=>'I cambiamenti al profilo <b>non hanno effetto sulle regole dei progetti esistenti</b>! Queste devono essere aggiornate singolarmente nei progetti.',  # line 1213
'Using auto detection of time zone requires this user to relogin.'=>'La selezione automatica del fuso orario richiede un nuovo login da parte di questo utente',  # line 1287
'Person %s created'           =>'Persona %s creata',  # line 1448
'Moved %s people to trash'   =>'Spostate %s persone nel cestino',  # line 1527

### ../pages/proj.inc.php   ###
'all'                         =>'tutti',  # line 724
'my open'                     =>'i miei aperti',  # line 768
'for milestone'               =>'per evento',  # line 804
'needs approval'              =>'necessitano approvazione',  # line 863
'without milestone'           =>'senza evento',  # line 887
'Released Versions'           =>'Versioni rilasciate',  # line 1553
'New released Version'      =>'Nuovo evento rilasciato',  # line 1571
'Tasks resolved in upcoming version'=>'Attività risolte nella prossima versione',  # line 1605
'Moved %s projects to trash'  =>'Spostati %s progetti nel cestino',  # line 1916

### ../pages/search.inc.php   ###
'in'                          =>'in',  # line 350
'on'                          =>'su',  # line 461
'cannot jump to this item type'=>'non è possibile saltare a questo elemento',  # line 545
'jumped to best of %s search results'=>'saltato al primo di %s risultati della ricerca',  # line 580
'Add an ! to your search request to jump to the best result.'=>'Aggiungi un ! alla tua stringa di ricerca per saltare al primo risultato',  # line 587
'%s search results for `%s`'  =>'%s risultati per `%s`',  # line 602
'No search results for `%s`'  =>'Nessun risultato per `%s`',  # line 605

### ../pages/version.inc.php   ###
'New Version'                 =>'Nuova Versione',  # line 32

### ../pages/task_more.inc.php   ###
'Select some task(s) to edit' =>'Seleziona attività da modificare',  # line 367
'next released version' => 'prossima versione rilasciata',  # line 457
'Release as version|Form label, attribute of issue-reports'=>'Rilascia come versione',  # line 605
'Reproducibility|Form label, attribute of issue-reports'=>'Riproducibilità',  # line 719
'Marked %s tasks to be resolved in this version.'=>'Contrassegnati %s attività da risolvere con questa versione',  # line 1204
'Failed to add comment'       =>'Errore aggiungendo il commento',  # line 1264
'Failed to delete task %s'    =>'Errore eliminando l`attività %s',  # line 1514
'Moved %s tasks to Trash'     =>'Spostato %s attività nel Cestino',  # line 1520
'Task Efforts'                =>'Impegni dell`attività',  # line 2003
'date1 should be smaller than date2. Swapped'=>'data1 deve essere antecedente a data2. Scambiate',  # line 2144
'prev change'                 =>'variazione prec',  # line 2266
'next'                        =>'succ',  # line 2282
'For editing all tasks must be of same project.'=>'Per la modifica tutte le attività devono appartenere allo stesso progetto',  # line 2596
'Edit multiple tasks|Page title'=>'Modifica attività multiple',  # line 2619
'Edit %s tasks|Page title'    =>'Modifica %s attività',  # line 2621
'keep different'              =>'mantieni differente',  # line 2766
'Prio'                        =>'Priorità',  # line 2706
'none'                        =>'nessuna',  # line 2740

### ../pages/task_view.inc.php   ###
'next released version'       =>'prossima versione rilasciata',  # line 693

### ../pages/task_more.inc.php   ###
'resolved in Version'         =>'risolta nella Versione',  # line 2751
'Resolve Reason'              =>'Motivo della risoluzione',  # line 2770
'%s tasks could not be written'=>'%s attività non sono state scritte',  # line 2923
'Updated %s tasks tasks'      =>'Aggiornate %s attività',  # line 2926
'ERROR: could not get Person' =>'ERRORE: non è stato possibile prendere la Persona',  # line 3073
'Select a note to edit'       =>'Seleziona una nota da modificare',  # line 3064
'Note'                        =>'Nota',  # line 3091
'Create new note'             =>'Crea nuova nota',  # line 3094
'New Note on %s, %s'          =>'Nuova nota il %s, %s',  # line 3100
'Publish to|Form label'       =>'Mostra a',  # line 3129
'ERROR: could not get project'=>'ERRORE: non è stato possibile prendere il progetto',  # line 3401
'Assigned Projects'           =>'Progetti assegnati',  # line 3162
'- no assigend projects'      =>'- nessun progetto assegnato',  # line 3158
'Company Projects'            =>'Progetti dell`Azienda',  # line 3184
'- no company projects'       =>'- nessun progetto dell`azienda',  # line 3174
'All other Projects'          =>'Tutti gli altri Progetti',  # line 3202
'- no other projects'         =>'- nessun altro progetto',  # line 3199
'For Project|form label'      =>'Per il Progetto',  # line 3208
'New project|form label'      =>'Nuovo Progetto',  # line 3213
'Project name|form label'     =>'Nome del progetto',  # line 3214
'ERROR: could not get assigned people'=>'ERRORE: non è stato possibile prendere le persone assegnate',  # line 3230
'Assigne to'                  =>'Assegna a',  # line 3247
'Also assigne to'             =>'Assegna anche a',  # line 3264
'Book effort after submit'    =>'Dopo il salvataggio pianifica impegno',  # line 3268
'ERROR: could not get task'   =>'ERRORE: non è stato possibile prendere l`attività',  # line 3308
'Note requires project'       =>'La nota richiede un progetto',  # line 3360
'Note requires assigned person(s)'=>'La nota richiede una o più persone assegnate',  # line 3364

### ../pages/task_view.inc.php   ###
'Released as|Label in Task summary'=>'Rilasciato come',  # line 252
'Publish to|Label in Task summary'=>'Mostra a',  # line 341
'Severity|label in issue-reports'=>'Gravità',  # line 433
'Reproducibility|label in issue-reports'=>'Riproducibilità',  # line 440
'Sub tasks'                   =>'Sub attività',  # line 496
'1 Comment'                   =>'1 Commento',  # line 557
'%s Comments'                 =>'%s Commenti',  # line 560
'Comment / Update'            =>'Commento / Aggiornato',  # line 624
'quick edit'                  =>'modifica al volo',  # line 649

### ../pages/version.inc.php   ###
'Edit Version|page type'      =>'Modifica Versione',  # line 79
'Edit Version|page title'     =>'Modifica Versione',  # line 88
'New Version|page title'      =>'Nuova Versione',  # line 91
'Could not get version'       =>'Non è stato possibile prendere la versione',  # line 148
'Could not get project of version'=>'Non è stato possibile prendere il progetto della versione',  # line 164
'Select some versions to delete'=>'Seleziona alcune versioni da eliminare',  # line 229
'Failed to delete %s versions'=>'Errore eliminando %s versioni',  # line 248
'Moved %s versions to dumpster'=>'Spostato %s versioni nel cestino',  # line 251
'Version|page type'           =>'Versione',  # line 287
'Edit this version'           =>'Modifica questa versione',  # line 308

### ../render/render_fields.inc.php   ###
'<b>%s</b> is not a known format for date.'=>'<b>%s</b> non è un formato noto per la data.',  # line 307

### ../render/render_list_column_special.inc.php   ###
'Status|Short status column header'=>'Stato',  # line 273
'Item is published to'        =>'L`elemento è mostrato a',  # line 330
'Publish to %s'               =>'Mostra a %s',  # line 347
'Select / Deselect'           =>'Seleziona / Deseleziona',  # line 364

### ../render/render_misc.inc.php   ###
'Clients|page option'         =>'Clienti',  # line 392
'Prospective Clients|page option'=>'Clienti Prospect',  # line 396
'Suppliers|page option'       =>'Fornitori',  # line 400
'Partners|page option'        =>'Partner',  # line 404
'Companies|page option'       =>'Aziende',  # line 239
'Versions|Project option'     =>'Versioni',  # line 330
'Employees|page option'       =>'Impiegati',  # line 369
'Contact People|page option' =>'Contatti',  # line 373
'All Companies|page option'   =>'Tutte le Aziende',  # line 388
'%s hours'                    =>'%s ore',  # line 711
'%s days'                     =>'%s giorni',  # line 715
'%s weeks'                    =>'%s settimane',  # line 719
'%s hours max'                =>'%s ore massimo',  # line 749
'%s days max'                 =>'%s giorni massimo',  # line 759
'%s weeks max'                =>'%s settimane massimo',  # line 770

### ../render/render_wiki.inc.php   ###
'Cannot link to item of type %s'=>'Non è stato possibile aggiungere link all`elemento di tipo %s',  # line 1025
'Wiki-format: <b>%s</b> is not a valid link-type'=>'Formato Wiki: <b>%s</b> non è un tipo di formato valido',  # line 1037
'Unknown Item Id'             =>'Id dell`elemento sconosciuto',  # line 1283

### ../std/class_auth.inc.php   ###
'Unable to automatically detect client time zone'=>'Impossibile determinare automaticamente il fuso orario del client',  # line 226

### ../std/constant_names.inc.php   ###
'client_edit|pub_level_name'  =>'modifica_client',  # line 53
'urgent|priority'             =>'urgente',  # line 100
'done|resolve reason'         =>'fatto',  # line 154
'fixed|resolve reason'        =>'risolto',  # line 155
'works_for_me|resolve reason' =>'funziona_per_me',  # line 156
'duplicate|resolve reason'    =>'duplicato',  # line 157
'bogus|resolve reason'        =>'falso',  # line 158
'rejected|resolve reason'     =>'rigettato',  # line 159
'deferred|resolve reason'     =>'rimandato',  # line 160
'Not defined|release type'    =>'Non definito',  # line 166
'Not planned|release type'    =>'Non pianificato',  # line 167
'upcoming|release type'      =>'In arrivo',  # line 168
'Internal|release type'       =>'Interna',  # line 169
'Public|release type'         =>'Pubblica',  # line 170
'Without support|release type'=>'Senza supporto',  # line 171
'No longer supported|release type'=>'Non più supportata',  # line 172
'undefined|company category'  =>'sconosciuto',  # line 178
'client|company category'     =>'cliente',  # line 179
'prospective client|company category'=>'cliente prospect',  # line 180
'supplier|company category'   =>'fornitore',  # line 181
'partner|company category'    =>'partner',  # line 182
'undefined|person category'   =>'non definito',  # line 188
'- employee -|person category'=>'- impiegato -',  # line 189
'staff|person category'       =>'staff',  # line 190
'freelancer|person category'  =>'libero professionista',  # line 191
'working student|person category'=>'studente lavoratore',  # line 192
'apprentice|person category'  =>'apprendista',  # line 193
'intern|person category'      =>'interno',  # line 194
'ex-employee|person category' =>'ex-dipendente',  # line 195
'- contact person -|person category'=>'- contatto -',  # line 196
'client|person category'      =>'cliente',  # line 197
'prospective client|person category'=>'cliente prospect',  # line 198
'supplier|person category'    =>'fornitore',  # line 199
'partner|person category'     =>'partner',  # line 200

### ../pages/task_view.inc.php   ###
'For Milestone'               =>'Per Evento',  # line 723
'Resolve reason'              =>'Motivo della risoluzione',  # line 729

### ../lists/list_comments.inc.php   ###
'Publish'                     =>'Pubblica',  # line 147

### ../lists/list_people.inc.php   ###
'Nickname|column header'      =>'Nickname',  # line 202
'Name|column header'          =>'Nome',  # line 223

### ../pages/_handles.inc.php   ###
'View item'                   =>'Visualizza elemento',  # line 17
'Set Public Level'            =>'Imposta livello pubblico',  # line 27

### ../render/render_page.inc.php   ###
'Register'                    =>'Registra',  # line 648

### ../pages/comment.inc.php   ###
'Delete this comment'         =>'Elimina questo commento',  # line 102
'Restore'                     =>'Ripristina',  # line 94
'Select some comments to restore'=>'Seleziona commenti da ripristinare',  # line 537
'Failed to restore %s comments'=>'Errore durante il ripristino di %s commenti',  # line 563
'Restored %s comments'        =>'Ripristinato %s commenti',  # line 566

### ../pages/item.inc.php   ###
'Select some items(s) to change pub level'=>'Seleziona elementi a cui cambiare il livello pubblico',  # line 59
'itemsSetPubLevel requires item_pub_level'=>'itemsSetPubLevel richiede item_pub_level',  # line 66
'Made %s items public to %s'  =>'%s diventati pubblici a %s',  # line 84

### ../pages/misc.inc.php   ###
'Could not find requested page `%s`'=>'Non è stato possibile trovare la pagina richiesta',  # line 37

### ../pages/person.inc.php   ###
'Registering is not enabled'  =>'La Registrazione non è abilitata',  # line 1755
'Please provide information, why you want to register.'=>'Per favore indicare il motivo per cui viene inoltrata la richiesta di registrazione',  # line 1760
'Register as a new user'      =>'Registra come nuovo utente',  # line 1768

### ../pages/proj.inc.php   ###
'Found no people to add. Go to `People` to create some.'=>'Non è stato trovato nessuno da aggiungere. Vai in `Persone` per crearne di nuove',  # line 2048
'Failed to insert new project person. Data structure might have been corrupted'=>'Errore inserendo nuove persone al progetto. La struttura dati potrebbe essere corrotta',  # line 2338

### ../pages/search.inc.php   ###
'Sorry. Could not find anything.'=>'Spiacente. Non è stato trovato nulla.',  # line 615

### ../pages/task_view.inc.php   ###
'Resolved in'                 =>'Risolto in',  # line 726
'Also assign to|Form label'   =>'Assegnato anche a',  # line 785

### ../pages/task_more.inc.php   ###
'Not enough rights to edit task'=>'Nessun permesso per modificare l`attività',  # line 870
'Moved %s tasks to trash'     =>'Spostato %s attività nel cestino',  # line 1544
'Also assign to'              =>'Assegnato anche a',  # line 3298

### ../pages/task_view.inc.php   ###
'Logged effort|Label in task-summary'=>'Impegno salvato',  # line 329
'Set to Open'                 =>'Imposta su Aperto',  # line 350

### ../std/class_auth.inc.php   ###
'Invalid anonymous user'      =>'Utentem anonimo invalido',  # line 94
'Anonymous account has been disabled. '=>'L`account anonimo è stato disabilitato',  # line 100

### ../std/constant_names.inc.php   ###
'done|Resolve reason'         =>'fatto',  # line 154
'fixed|Resolve reason'        =>'risolto',  # line 155
'works_for_me|Resolve reason' =>'funziona_per_me',  # line 156
'duplicate|Resolve reason'    =>'duplicato',  # line 157
'bogus|Resolve reason'        =>'fasullo',  # line 158
'rejected|Resolve reason'     =>'rigettato',  # line 159
'deferred|Resolve reason'     =>'rinviato',  # line 160

);
?>
