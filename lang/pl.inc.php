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
* translation into: Polish language
*
* translated by: Radoslaw Sliwinski
*
* date: 2008-12-10
*
* streber version: 0.08094
* streber revision: 448
*
* comments: Places marked as XX - I'm not shure translation.
*
*/

global $g_lang_table;
$g_lang_table= array(



### ../lists/list_projectchanges.inc.php   ###
'new'                         =>'nowy',  # line 211

### ../_docs/changes.inc.php   ###
'to'                          =>'dla',  # line 90
'you'                         =>'ty',  # line 90
'assign to'                   =>'przypisz do',  # line 93

### ../lists/list_changes.inc.php   ###
'deleted'                     =>'skasowany',  # line 339

### ../_files/prj932/1326.index.php   ###
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter you name and use the <b>forgot password link</b> below.'=>'Niestety ten kod aktywacyjny nie jest już ważny. Jeśli posiadasz konto, możesz wpisać swój login i użyć poniższego linku: <b>zapomniałem hasła</b>.',  # line 226

### ../pages/company.inc.php   ###
'Summary'                     =>'Temat',  # line 161

### ../db/class_comment.inc.php   ###
'Details'                     =>'Szczegóły',  # line 61

### ../lists/list_projects.inc.php   ###
'Name'                        =>'Nazwa',  # line 86

### ../db/class_company.inc.php   ###
'Required. (e.g. pixtur ag)'  =>'Wymagane (np. Firma S.A.)',  # line 34
'Short|form field for company'=>'Skrócone',  # line 39
'Optional: Short name shown in lists (eg. pixtur)'=>'Opcjonalne: skrócona nazwa wyświetlana na listach (np. firma)',  # line 40
'Tag line|form field for company'=>'Adres/Informacje dodatkowe',  # line 45

### ../db/class_person.inc.php   ###
'Optional: Additional tagline (eg. multimedia concepts)'=>'Opcjonalne: adres/informacje dodatkowe (np. Z nami będziesz zawsze zadowolony)',  # line 52

### ../db/class_company.inc.php   ###
'Phone|form field for company'=>'Telefon',  # line 51
'Optional: Phone (eg. +49-30-12345678)'=>'Opcjonalne: Telefon (np. +48 58 12345678)',  # line 52
'Fax|form field for company'  =>'Faks',  # line 57
'Optional: Fax (eg. +49-30-12345678)'=>'Opcjonalne: Faks (np. +48 58 12345678)',  # line 58
'Street'                      =>'Ulica',  # line 63
'Optional: (eg. Poststreet 28)'=>'Opcjonalne: (ul. Pocztowa 28)',  # line 64
'Zipcode'                     =>'Kod pocztowy',  # line 69
'Optional: (eg. 12345 Berlin)'=>'Opcjonalne: (np. 00-760 Warszawa)',  # line 70
'Website'                     =>'Strona WWW',  # line 75
'Optional: (eg. http://www.pixtur.de)'=>'Opcjonalne: (np. http://www.pixtur.de)',  # line 76
'Intranet'                    =>'Intranet',  # line 81
'Optional: (eg. http://www.pixtur.de/login.php?name=someone)'=>'Opcjonalne: (eg. http://www.pixtur.de/login.php?name=someone)',  # line 88
'E-Mail'                      =>'E-mail',  # line 87
'Comments|form label for company'=>'Komentarze',  # line 93

### ../db/class_person.inc.php   ###
'Optional'                    =>'Opcjonalne',  # line 113

### ../db/class_company.inc.php   ###
'more than expected'          =>'więcej, niż spodziewane',  # line 458
'not available'               =>'niedostępne',  # line 461

### ../db/class_effort.inc.php   ###
'optional if tasks linked to this effort'=>'opcjonalne, jeśli zadania są związane z tym wysiłkiem',  # line 39
'Time Start'                  =>'Czas - start',  # line 46
'Time End'                    =>'Czas - koniec',  # line 48

### ../pages/task.inc.php   ###
'Description'                 =>'Opis',  # line 323

### ../db/class_issue.inc.php   ###
'Production build'            =>'Wersja produkcyjna',  # line 53
'Steps to reproduce'          =>'Kroki do zreprodukowania',  # line 57
'Expected result'             =>'Oczekiwane rezultaty',  # line 60
'Suggested Solution'          =>'Sugerowane rozwiązanie',  # line 63


### ../lists/list_milestones.inc.php   ###
'Planned for'                 =>'Planowane na',  # line 284

### ../db/class_person.inc.php   ###
'Full name'                   =>'Nazwisko i imię',  # line 42
'Required. Full name like (e.g. Thomas Mann)'=>'Wymagane. Pełne nazwisko (np. Tomasz Mann)',  # line 43
'Nickname'                    =>'Nick',  # line 47
'only required if user can login (e.g. pixtur)'=>'wymagane jedynie, gdy użytkownik może się zalogować (np. pixtur)',  # line 48

### ../lists/list_persons.inc.php   ###
'Tagline'                     =>'Adres/Informacje dodatkowe',  # line 59

### ../db/class_person.inc.php   ###
'Mobile Phone'                =>'Telefon komórkowy',  # line 55
'Optional: Mobile phone (eg. +49-172-12345678)'=>'Opcjonalne: Telefon komórkowy (np. +48 602 123456)',  # line 56
'Office Phone'                =>'Biuro: telefon',  # line 61
'Optional: Office Phone (eg. +49-30-12345678)'=>'Opcjonalne: Telefon biurowy (np. +48 58 1234567)',  # line 62
'Office Fax'                  =>'Biuro: faks',  # line 65
'Optional: Office Fax (eg. +49-30-12345678)'=>'Opcjonalne: Faks biurowy (np. +48 58 1234567)',  # line 66
'Office Street'               =>'Biuro: ulica',  # line 69
'Optional: Official Street and Number (eg. Poststreet 28)'=>'Opcjonalne: Ulica i numer adresu biura (np. ul. Pocztowa 12/3)',  # line 70
'Office Zipcode'              =>'Biuro: kod pocztowy i miasto',  # line 73
'Optional: Official Zip-Code and City (eg. 12345 Berlin)'=>'Opcjonalne: Kod pocztowy i miasto adresu biura (np. 00-760 Warszawa)',  # line 74
'Office Page'                 =>'Biuro: strona WWW',  # line 77
'Optional: (eg. www.pixtur.de)'=>'Opcjonalne: (np. www.pixtur.de)',  # line 105
'Office E-Mail'               =>'Biuro: e-mail',  # line 81
'Optional: (eg. thomas@pixtur.de)'=>'Opcjonalne: (np. thomas@pixtur.de)',  # line 109
'Personal Phone'              =>'Prywatne: telefon',  # line 88
'Optional: Private Phone (eg. +49-30-12345678)'=>'Opcjonalne: Telefon prywatny (np. +48 58 1234567)',  # line 89
'Personal Fax'                =>'Prywatne: faks',  # line 92
'Optional: Private Fax (eg. +49-30-12345678)'=>'Opcjonalne: Telefon prywatny (np. +48 58 1234567)',  # line 93
'Personal Street'             =>'Prywatne: ulica',  # line 96
'Optional:  Private (eg. Poststreet 28)'=>'Opcjonalne: Ulica i numer adresu prywatnego (np. ul. Pocztowa 12/3)',  # line 97
'Personal Zipcode'            =>'Prywatne: kod pocztowy',  # line 100
'Optional: Private (eg. 12345 Berlin)'=>'Opcjonalne: Kod pocztowy i miasto adresu biura (np. 00-760 Warszawa)',  # line 101
'Personal Page'               =>'Prywatne: strona WWW',  # line 104
'Personal E-Mail'             =>'Prywatne: e-mail',  # line 108
'Birthdate'                   =>'Data urodzenia',  # line 112

### ../db/class_project.inc.php   ###
'Status summary'              =>'Podsumowanie statusu',  # line 40
'Color'                       =>'Kolor',  # line 43
'Project page'                =>'Strona projektu',  # line 58
'Wiki page'                   =>'Strona wiki',  # line 61
'show tasks in home'          =>'wyświetl zadania na stronie startowej',  # line 75
'only team members can create items'=>'tylko członkowie zespołu mogą tworzyć pozycje',  # line 1178
'validating invalid item'     =>'sprawdzanie nieprawidłowej pozycji',  # line 1191
'insufficient rights (not in project)'=>'niewystarczające uprawnienia (nie w projekcie)',  # line 1203
'Released versions'           =>'Wydane wersje',  # line 1456
'Milestones (closed)'         =>'Kamienie milowe (zamknięte)',  # line 1461


### ../db/class_person.inc.php   ###
'Optional: Color for graphical overviews (e.g. #FFFF00)'=>'Opcjonalne: Kolor dla graficznych podsumowań (np. #FFFF00)',  # line 118

### ../pages/task.inc.php   ###
'Comments'                    =>'Komentarze',  # line 411

### ../db/class_person.inc.php   ###
'Password'                    =>'Hasło',  # line 128
'Only required if user can login|tooltip'=>'Wymagane jedynie, gdy użytkownik może się zalogować',  # line 129

### ../db/class_person.inc.php   ###
'Theme|Formlabel'             =>'Temat',  # line 161

### ../render/render_list_column_special.inc.php   ###
'Status'                      =>'Status',  # line 274

### ../pages/proj.inc.php   ###
'Active'                      =>'Aktywne',  # line 34
'Closed'                      =>'Zamknięte',  # line 38
'Templates'                   =>'Szablony',  # line 42
'Your Active Projects'        =>'Twoje aktywne projekty',  # line 67
'List|page type'              =>'Lista',  # line 74
'<b>NOTE</b>: Some projects are hidden from your view. Please ask an administrator to adjust you rights to avoid double-creation of projects'=>'<b>UWAGA</b>: Niektóre projekty są niewidoczne dla ciebie. Zapytaj administratora o inne projekty i poproś o ew. zmianę towich uprawnień w celu uniknięcia zdublowania projektów.',  # line 109
'create new project'          =>'utworzenie nowego projektu',  # line 112
'not assigned to a project'   =>'nie przypisany do projektu',  # line 115
'Your Closed Projects'        =>'Twoje zamknięte projekty',  # line 142
'not assigned to a closed project'=>'nie przypisane do zamkniętego projektu',  # line 173
'Project Templates'           =>'Szablon projektu',  # line 192
'relating to %s'              =>'powiązane z %s',  # line 194
'admin view'                  =>'Widok administratora',  # line 197
'List'                        =>'Lista',  # line 199
'no project templates'        =>'brak szablonów projektów',  # line 229
'Overview'                    =>'Streszczenie',  # line 262
'Edit this project'           =>'Edytuj projekt',  # line 279
'Add person as team-member to project'=>'Dodanie osoby jako członka zespołu projektu',  # line 291
'Team member'                 =>'Członek zespołu',  # line 292
'Create task'                 =>'Utworzenie zadania',  # line 298
'Book effort for this project'=>'Rejestracja wysiłków dla tego projektu',  # line 312
'Details|block title'         =>'Szczegóły',  # line 326
'Client|label'                =>'Klient',  # line 340
'Phone|label'                 =>'Telefon',  # line 342
'E-Mail|label'                =>'E-mail',  # line 345
'Status|Label in summary'     =>'Status',  # line 358
'Wikipage|Label in summary'   =>'Strona Wiki',  # line 363
'Projectpage|Label in summary'=>'Strona projektu',  # line 367
'Opened|Label in summary'     =>'Otwarte',  # line 372
'Closed|Label in summary'     =>'Zamknięte',  # line 377
'Created by|Label in summary' =>'Twórca',  # line 381
'Last modified by|Label in summary'=>'Ostatnio zmienione',  # line 386
'Logged effort'               =>'Zarejestrowane wysiłki',  # line 393
'hours'                       =>'godziny',  # line 395
'Team members'                =>'Członkowie zespołu',  # line 440
'Folders'                     =>'Katalogi',  # line 453
'Your tasks'                  =>'Twoje zadania',  # line 552
'No tasks assigned to you.'   =>'Brak zadań przypisanych do ciebie.',  # line 553
'All project tasks'           =>'Wszystkie zadania projektu',  # line 553
'Comments on project'         =>'Komentarze do projektu',  # line 587
'Closed Tasks'                =>'Zadania zamknięte',  # line 637
'No tasks have been closed yet'=>'Żadne zadania nie zostały jeszcze zamknięte',  # line 668
'invalid project-id'          =>'nieprawidłowe ID projektu',  # line 699
'all'                         =>'wszystkie',  # line 724
'open'                        =>'otwarte',  # line 746
'my open'                     =>'moje otwarte',  # line 768
'for milestone'               =>'do kamienia milowego',  # line 804
'needs approval'              =>'wymagające akceptacji',  # line 863
'without milestone'           =>'bez kamienia milowego',  # line 887
'Changes'                     =>'Zmiany',  # line 714
'changed project-items'       =>'zmienione pozycje projektu',  # line 754
'no changes yet'              =>'brak zmian',  # line 755
'all open'                    =>'wszystkie otwarte',  # line 802
'all my open'                 =>'moje wszystkie otwarte',  # line 803
'my open for next milestone'  =>'moje otwarte do następnego kamienia milowego',  # line 804
'not assigned'                =>'nie przypisane',  # line 805
'blocked'                     =>'zablokowane',  # line 806
'open bugs'                   =>'otwarte błędy',  # line 807
'to be approved'              =>'do zaakceptowania',  # line 808
'open tasks'                  =>'zadania otwarte',  # line 819
'my open tasks'               =>'moje zadania otwarte',  # line 841
'next milestone'              =>'następny kamień milowy',  # line 875
'Closed tasks'                =>'Zamknięte zadania',  # line 908
'Tasks'                       =>'Zadania',  # line 1013
'Create a new folder for tasks and files'=>'Utworzenie nowego folderu dla zadań i plików',  # line 1039
'Folder'                      =>'Folder',  # line 1040
'Create task with issue-report'=>'Utworzenie zadania z raportem wydarzeń',  # line 1164
'Filter-Preset:'              =>'Zestaw predefiniowanych filtrów:',  # line 1071
'No tasks'                    =>'Brak zadań',  # line 1100
'Project Issues'              =>'Zdarzenia projektu',  # line 1146
'Add Bugreport'               =>'Dodanie raportu błędu',  # line 1165
'Report Bug'                  =>'Zgłoszenie błędu',  # line 1190
'Uploaded Files'              =>'Wgrane pliki',  # line 1237
'Upload file|block title'     =>'Wgranie pliku',  # line 1273
'Milestones'                  =>'Kamienie milowe',  # line 1334
'new Milestone'               =>'Nowy kamień milowy',  # line 1341
'View open milestones'        =>'Wyświetlenie otwartych kamieni milowych',  # line 1365
'View closed milestones'      =>'Wyświetlenie zamkniętych kamieni milowych',  # line 1371
'Project Efforts'             =>'Wysiłki projektu',  # line 1412
'Project Template'            =>'Szablon projektu',  # line 1416
'Inactive Project'            =>'Projekt nieaktywny',  # line 1419
'Project|Page Type'           =>'Projekt',  # line 1422
'new Effort'                  =>'Nowy wysiłek',  # line 1430
'New project'                 =>'Nowy projekt',  # line 1476
'Company|form label'          =>'Firma',  # line 1556
'Create another project after submit'=>'Utworzenie następnego projektu po zatwierdzeniu obecnego',  # line 1574
'Released Versions'           =>'Wydane wersje',  # line 1553
'New released Version'      =>'Nowe wydanie kamienia milowego',  # line 1571
'Tasks resolved in upcoming version'=>'Zadania zrealizowane w nadchodzącej wersji',  # line 1605
'Select some projects to delete'=>'Zaznacz projekty do usunięcia',  # line 1692
'WARNING: Failed to delete %s projects'=>'OSTRZEŻENIE: Usunięcie %s projektu/projektów nie powiodło się',  # line 1712
'Moved %s projects to trash'=>'Przeniesiono %s projektów do kosza',  # line 1715
'Select some projects...'     =>'Zaznacz kilka projektów...',  # line 1737
'Invalid project-id!'         =>'Nieprawidłowe ID projektu',  # line 1747
'Y-m-d'                       =>'Y-m-d',  # line 1752
'WARNING: Failed to change %s projects'=>'OSTRZEŻENIE: Modyfikacja %s projektu/projektów nie powiodła się',  # line 1762
'Closed %s projects'          =>'%s projektów zostało zamknięte',  # line 1766
'Reactivated %s projects'     =>'Reaktywacja %s projektów',  # line 1769
'Edit Project'                =>'Edytuj projekt',  # line 1801
'Select new team members'     =>'Zaznacz nowych członków zespołu',  # line 1803
'Found no persons to add. Go to `People` to create some.'=>'Nie znaleziono osób do dodania. Przejdź do `Osoby` w celu dodania kilku.',  # line 1847
'Add'                         =>'Dodanie',  # line 1859
'No persons selected...'      =>'Brak zaznaczonych osób...',  # line 1885
'Could not access person by id'=>'Brak dostępu do osoby poprzez ID',  # line 1894
'NOTE: reanimated person as team-member'=>'UWAGA: Ponowne przypisanie osoby jako członka zespołu',  # line 1932
'NOTE: person already in project'=>'UWAGA: Osoba już jest przypisana do projektu',  # line 1936
'Template|as addon to project-templates'=>'Szablon',  # line 2018
'Failed to delete %s projects'=>'Usunięcie %s projektu/projektów nie powiodło się.',  # line 1913
'Failed to change %s projects'=>'Modyfikacja %s projektu/projektów nie powiodło się',  # line 1963
'Failed to insert new project person. Data structure might have been corrupted'=>'Dodanie nowej osoby nie powiodło się. Struktura danych może być uszkodzona.',  # line 2126
'Failed to insert new issue. DB structure might have been corrupted.'=>'Dodanie nowego zdarzenia nie powiodło się. Struktura bazy danych może być uszkodzona.',  # line 2145
'Failed to update new task. DB structure might have been corrupted.'=>'Dodanie nowego zadania nie powiodło się. Struktura bazy danych może być uszkodzona.',  # line 2200
'Failed to insert new comment. DB structure might have been corrupted.'=>'Dodanie nowego komentarza nie powiodło się. Struktura bazy danych może być uszkodzona.',  # line 2297
'Project duplicated (including %s items)'=>'Projekt zduplikowany (włączając %s pozycji)',  # line 2318
'Select a project to edit description'=>'Zaznacz projekt do edycji opisu',  # line 2341
'Reanimated person as team-member'=>'Ponowne powiązanie osoby jako członka zespołu',  # line 2138
'Person already in project'   =>'Osoba jest już przypsana do projektu',  # line 2142


### ../db/class_projectperson.inc.php   ###
'job'                         =>'Praca',  # line 28
'role'                        =>'Rola',  # line 57

### ../pages/task.inc.php   ###
'For Milestone'               =>'Do kamienia milowego',  # line 849

### ../db/class_task.inc.php   ###
'Short'                       =>'Skrócone',  # line 21
'Date start'                  =>'Data startu',  # line 25
'Date closed'                 =>'Data zamknięcia',  # line 31
'resolved_version'            =>'zrealizowane w wersji',  # line 53
'show as folder (may contain other tasks)'=>'wyświetl jako folder (może zawierać inne zadania)',  # line 63
'is a milestone / version'    =>'jest kamieniem milowym / wersją',  # line 68
'resolved in version'         =>'zrealizowane w wersji',  # line 69
'milestones are shown in a different list'=>'kamienie milowe są wyświetlane na innej liście',  # line 69
'Completion'                  =>'Procent ukończenia',  # line 75
'is a milestone'              =>'jest kamieniem milowym',  # line 89
'released'                    =>'wydane',  # line 96
'release time'                =>'czas wydania',  # line 101
'Planned Start'               =>'Planowany start',  # line 105
'Planned End'                 =>'Planowany koniec',  # line 110
'Order Id'                    =>'ID porządkowe',  # line 165
'Calculation'                 =>'Kalkulacja',  # line 184
'Display in project news'     =>'Wyświetlaj w aktualnościach projektu',  # line 190
'List title and description in project overview'=>'Wyświetlaj tytuł i opis w streszczeniu projektu',  # line 191
'Display folder as topic'     =>'Wyświetlaj folder jako temat',  # line 197

### ../pages/task.inc.php   ###
'Estimated time'              =>'Przewidywany czas',  # line 1000
'Estimated worst case'        =>'Przewidywany czas, najgorszy przypadek',  # line 1001
'Label'                       =>'Etykieta',  # line 1041

### ../pages/task.inc.php   ###
'task without project?'       =>'zadanie bez projektu?',  # line 2060

### ../db/db.inc.php   ###
'Database exception'          =>'Błąd bazy danych',  # line 38

### ../db/db_item.inc.php   ###
'WARNING <b>%s</b> isn`t a known format for date.'=>'UWAGA <b>%s</b> nie jest znanym formatem dla daty.',  # line 233
'unnamed'                     =>'nie nazwany',  # line 590

### ../lists/list_changes.inc.php   ###
'to|very short for assigned tasks TO...'=>'do',  # line 325
'in|very short for IN folder...'=>'w',  # line 334

### ../lists/list_projectchanges.inc.php   ###
'modified'                    =>'zmienione',  # line 48

### ../lists/list_changes.inc.php   ###
'read more...'                =>'czytaj więcej...',  # line 208
'%s comments:'                =>'%s komentarzy:',  # line 211
'comment:'                    =>'komentarz:',  # line 214
'completed'                   =>'zakończone',  # line 234
'approved'                    =>'zaakceptowane',  # line 238
'closed'                      =>'zamknięte',  # line 242
'reopened'                    =>'otwarte ponownie',  # line 246
'is blocked'                  =>'zablokowane',  # line 250
'moved'                       =>'przeniesione',  # line 256
'changed:'                    =>'zmienione:',  # line 261
'commented'                   =>'skomentowane',  # line 273
'reassigned'                  =>'przypisane ponownie',  # line 288

### ../lists/list_projectchanges.inc.php   ###
'restore'                     =>'odzyskanie',  # line 331

### ../lists/list_projectchanges.inc.php   ###
'Other team members changed nothing since last logout (%s)'=>'Pozostali członkowie zespołu nie zmienili nic od czasu ostatniego wylogowania się (%s)',  # line 30

### ../lists/list_changes.inc.php   ###
'Date'                        =>'Data',  # line 470
'Who changed what when...'    =>'Kto, co kiedy zmienił...',  # line 602
'what|column header in change list'=>'co',  # line 504
'Date / by'                   =>'Data / przez',  # line 601

### ../lists/list_taskfolders.inc.php   ###
'New'                         =>'Nowy',  # line 102

### ../pages/task.inc.php   ###
'Delete'                      =>'Usuń',  # line 95

### ../lists/list_comments.inc.php   ###
'Move to Folder'              =>'Przenieś do folderu',  # line 61
'Shrink View'                 =>'Zwiń widok',  # line 67
'Expand View'                 =>'Rozwiń widok',  # line 73
'Topic'                       =>'Temat',  # line 93
'Date|column header'          =>'Data',  # line 145
'By|column header'            =>'Przez',  # line 190

### ../lists/list_companies.inc.php   ###
'related companies'           =>'powiązane firmy',  # line 22

### ../lists/list_persons.inc.php   ###
'Name Short'                  =>'Nazwa skrócona',  # line 27
'Shortnames used in other lists'=>'Skrócone nazwy używane w innych listach',  # line 28

### ../pages/company.inc.php   ###
'Phone'                       =>'Telefon',  # line 175

### ../lists/list_companies.inc.php   ###
'Phone-Number'                =>'Numer telefonu',  # line 36
'Proj'                        =>'Proj',  # line 44
'Number of open Projects'     =>'Liczba otwartych projektów',  # line 45

### ../lists/list_companies.inc.php   ###
'People working for this person'=>'Osoby pracujące dla tego człowieka',  # line 52
'Edit company'                =>'Edycja firmy',  # line 85
'Delete company'              =>'Usunięcie firmy',  # line 92
'Create new company'          =>'Utworzenie nowej firmy',  # line 98

### ../lists/list_efforts.inc.php   ###
'no efforts booked yet'       =>'nie zarejestrowano jeszcze żadnych wysiłków',  # line 24

### ../lists/list_efforts.inc.php   ###
'person'                      =>'osoba',  # line 38

### ../lists/list_projects.inc.php   ###
'Task name. More Details as tooltips'=>'Nazwa zadania. Więcej szczegółów w tooltipie',  # line 87

### ../lists/list_efforts.inc.php   ###
'Edit effort'                 =>'Edycja wysiłku',  # line 58
'New effort'                  =>'Nowy wysiłek',  # line 65
'booked'                      =>'zarejestrowany',  # line 111
'estimated'                   =>'przewidywany',  # line 111
'Task|column header'          =>'Zadanie',  # line 124
'Start|column header'         =>'Start',  # line 149
'D, d.m.Y'                    =>'D, d-m-Y',  # line 160
'End|column header'           =>'Koniec',  # line 176
'len|column header of length of effort'=>'Długość',  # line 200
'Daygraph|columnheader'       =>'Wykres dzienny',  # line 220

### ../pages/task.inc.php   ###
'Version'                     =>'Wersja',  # line 368

### ../pages/task.inc.php   ###
'New folder'                  =>'Nowy folder',  # line 511

### ../pages/company.inc.php   ###
'or'                          =>'lub',  # line 236

### ../lists/list_milestones.inc.php   ###
'Due Today'                   =>'mija termin',  # line 308
'%s days late'                =>'opóźn. %s dni',  # line 313
'%s days left'                =>'zostało %s dni',  # line 317
'Tasks open|columnheader'     =>'Zadania otwarte',  # line 345
'Open|columnheader'           =>'Otwarte',  # line 407
'%s open'                     =>'%s otwarte',  # line 429
'Completed|columnheader'      =>'Zakończone',  # line 441
'Completed tasks: %s'         =>'Zadania zakończone: %s',  # line 459
'date not set'                =>'brak terminu',

### ../lists/list_persons.inc.php   ###
'Private'                     =>'Prywatne',  # line 44
'Mobil'                       =>'Telefon komórkowy',  # line 49
'Office'                      =>'Biuro',  # line 54

### ../lists/list_persons.inc.php   ###
'last login'                  =>'ostatni login',  # line 69
'Edit person'                 =>'Edycja osoby',  # line 100

### ../lists/list_persons.inc.php   ###
'Delete person'               =>'Usunięcie osoby',  # line 113
'Create new person'           =>'Utworzenie nowej osoby',  # line 119
'Profile|column header'       =>'Profil',  # line 141
'Account settings for user (do not confuse with project rights)'=>'Ustawienia konta użytkownika (nie mylić z uprawnieniami projektu)',  # line 143
'(adjusted)'                  =>'(zmieniony)',  # line 160
'Active Projects|column header'=>'Projekty aktywne',  # line 180

### ../render/render_list_column_special.inc.php   ###
'Priority is %s'              =>'Priorytet jest %s',  # line 255

### ../lists/list_persons.inc.php   ###
'recent changes|column header'=>'ostatnie zmiany',  # line 225
'changes since YOUR last logout'=>'zmiany od TWOJEGO ostatniego wylogowania się',  # line 227

### ../lists/list_project_team.inc.php   ###
'Your related persons'        =>'Osoby powiązane z tobą',  # line 25
'Rights'                      =>'Uprawnienia',  # line 40
'Persons rights in this project'=>'Uprawnienia osób w tym projekcie',  # line 41
'Edit team member'            =>'Edycja członka zespołu',  # line 98
'Add team member'             =>'Dodanie członka zespołu',  # line 105
'Remove person from team'     =>'Usunięcie osoby z zespołu',  # line 112
'Member'                      =>'Członek',  # line 141
'Role'                        =>'Rola',  # line 162
'last Login|column header'    =>'Ostatni login',  # line 179

### ../render/render_list_column_special.inc.php   ###
'Created by'                  =>'Utworzone przez',  # line 386

### ../lists/list_projectchanges.inc.php   ###
'Item was originally created by'=>'Pozycja została oryginalnie utworzona przez',  # line 42
'C'                           =>'N,Z,U',  # line 191
'Created,Modified or Deleted' =>'Utworzone (Nowe),Zmienione lub Usunięte',  # line 192
'Deleted'                     =>'Usunięte',  # line 205

### ../render/render_list_column_special.inc.php   ###
'Modified'                    =>'Zmienione',  # line 197

### ../lists/list_projectchanges.inc.php   ###
'by Person'                   =>'przez osobę',  # line 229
'Person who did the last change'=>'Osoba która dokonała ostatniej zmiany',  # line 230
'Type|Column header'          =>'Typ',  # line 288
'Item of item: [T]ask, [C]omment, [E]ffort, etc '=>'Kolumna składająca się z pozycji: [Z]adanie, [K]omentarz, [W]ysiłek, itd.',  # line 289
'item %s has undefined type'  =>'pozycja %s posiada nie zdefiniowany typ',  # line 297
'Del'                         =>'Usunięte',  # line 318
'shows if item is deleted'    =>'wyświetlane, gdy pozycja jest usunięta',  # line 319
'(on comment)'                =>'(do komentarza)',  # line 375
'(on task)'                   =>'(do zadania)',  # line 380
'(on project)'                =>'(do projektu)',  # line 386

### ../lists/list_projects.inc.php   ###
'Project priority (the icons have tooltips, too)'=>'Priorytet projektu (ikony posiadają tooltipy)',  # line 61

### ../lists/list_projects.inc.php   ###
'Status Summary'              =>'Podsumowanie statusu',  # line 95
'Short discription of the current status'=>'Krótki opis bieżącego statusu',  # line 96

### ../lists/list_projects.inc.php   ###
'Number of open Tasks'        =>'Liczba otwartych zadań',  # line 106
'Opened'                      =>'Otwarty',  # line 114
'Day the Project opened'      =>'Dzień otwarcia projektu',  # line 115

### ../lists/list_projects.inc.php   ###
'Day the Project state changed to closed'=>'Dzień, w którym status projektu został zmieniony na zamknięty',  # line 121
'Edit project'                =>'Edytuj projekt',  # line 129
'Delete project'              =>'Usunięcie projektu',  # line 136
'Log hours for a project'     =>'Rejestruj czas w h do projektu',  # line 143
'Open / Close'                =>'Otwarcie / Zamknięcie',  # line 151

### ../pages/company.inc.php   ###
'Create new project'          =>'Utworzenie nowego projektu',  # line 306

### ../lists/list_projects.inc.php   ###
'... working in project'      =>'... pracujące nad projektem',  # line 299

### ../lists/list_taskfolders.inc.php   ###
'Number of subtasks'          =>'Liczba podzadań',  # line 84
'Create new folder under selected task'=>'Utworzenie nowego folderu dla zazanczonego zadania',  # line 105
'Move selected to folder'     =>'Przeniesienie zaznaczonych pozycji do folderu',  # line 110

### ../lists/list_tasks.inc.php   ###
'Priority of task'            =>'Priorytet zadania',  # line 95
'Status|Columnheader'         =>'Status',  # line 106
'Started'                     =>'Wystartował',  # line 125
'Modified|Column header'      =>'Zmienione',  # line 129
'Est.'                        =>'Przew.',  # line 140
'Add new Task'                =>'Dodanie nowego zadania',  # line 160
'Report new Bug'              =>'Zgłoszenie nowego błędu',  # line 167
'Add comment'                 =>'Komentarz',  # line 175
'Status->Completed'           =>'Status->Zakończone?',  # line 188
'Status->Approved'            =>'Status->Zaakceptowane',  # line 195
'Move tasks'                  =>'Przeniesienie zadań',  # line 202
'Status->Closed'              =>'Status->Zamknięte',  # line 208
'Log hours for select tasks'  =>'Rejestruj czas w h dla zaznaczonych zadań',  # line 209
'List|List sort mode'         =>'Lista',  # line 225
'Tree|List sort mode'         =>'Drzewo',  # line 236
'Grouped|List sort mode'      =>'Grupowane',  # line 247
'%s hidden'                   =>'%s ukryte',  # line 318
'Latest Comment'              =>'Ostatni komentarz',  # line 426
'by'                          =>'przez',  # line 428
'for'                         =>'dla',  # line 450
'%s open tasks / %s h'        =>'%s otwartych zadań / %s h',  # line 469
'Label|Columnheader'          =>'Etykieta',  # line 725
'Milestone'                   =>'Kamień milowy',  # line 764
'Name, Comments'              =>'Nazwa, Komentarz',  # line 852
'has %s comments'             =>'posiada %s komentarzy',  # line 882
'Task has %s attachments'     =>'Zadanie posiada %s załączników',  # line 895
'- no name -|in task lists'   =>'- bez nazwy -',  # line 913
'number of subtasks'          =>'liczba podzadań',  # line 935
'Task name'                   =>'Nazwa zadania',  # line 965
'Sum of all booked efforts (including subtasks)'=>'Suma wszystkich zarejestrowanych wysiłków (włączając podzadania)',  # line 966
'Effort in hours'             =>'Wysiłek w godzinach',  # line 977
'Days until planned start'    =>'Liczba dni do planowanego startu',  # line 989
'Due|column header, days until planned start'=>'Do rozp.',  # line 990
'planned for %s|a certain date'=>'planowane na %s',  # line 1019
'Est/Compl'                   =>'Przew./Zakoń.',  # line 1035
'Estimated time / completed'  =>'Czas przewidywany / zakończony',  # line 1037
'estimated %s hours'          =>'przewidywane %s godzin',  # line 1059
'estimated %s days'           =>'przewidywane %s dni',  # line 1064
'estimated %s weeks'          =>'przewidywane %s tygodni',  # line 1069
'%2.0f%% completed'           =>'%2.0f%% ukończone',  # line 1075
'Page name'                   =>'Nazwa strony',  # line 1132
'Estimated/Booked (Diff.)'    =>'Przewidywane/Faktyczne (różnica)',  # line 1203
'Relation between estimated time and booked efforts'=>'Strosunek wysiłków przewidywanych do zarejestrowanych',  # line 1239
'Completion:'                 =>'Stopień ukończenia:',  # line 1237
'Days until planned end'      =>'Dni do planowanego końca',  # line 1233
'Due|column header, days until planned end'=>'Do zak.',  # line 1234
'Review'                      =>'Inspekcja',  # line 1250
'Task status set to completed and needs approval.'=>'Status zadania zostsł ustawiony na zakończony i wymaga zaakceptowania.',  # line 1251
'Item was approved on: %s:|date a task was approved'=>'Pozycja została zaakceptowana dnia: %s|date a task was approved',  # line 1254
'done'                        =>'zrealizowane',  # line 1255
'this task is planned to be completed today.'=>'to zadanie jest zaplanowane do zakończenia dzisiaj.',  # line 1266
'Tomorrow'                    =>'Jutro',  # line 1271
'this task is planned to be completed tomorrow.'=>'to zadanie jest zaplanowane do zakończenia jutro.',  # line 1272
'Next week'                   =>'Następny tydzień',  # line 1278
'due: %s'                     =>'planowany koniec: %s',  # line 1307
'days'                        =>'dni',  # line 1284
'this task is overdue!'       =>'to zadanie ma przekroczony termin zakończenia',  # line 1288
' late'                       =>' spóźnione',  # line 1289
' remain'                     =>' pozostaje',  # line 1293
'Pending'                     =>'Nie rozpoczęte',  # line 1299
'start: %s'                   =>'start: %s',  # line 1302


### ../pages/task.inc.php   ###
'Assigned to'                 =>'Przypisane do',  # line 939

### ../pages/task.inc.php   ###
'New Milestone'               =>'Nowy kamień milowy',  # line 464

### ../pages/_handles.inc.php   ###
'Home'                        =>'Home',  # line 7
'Active Projects'             =>'Projekty aktywne',  # line 16
'Playground'                  =>'Plac zabaw ;-)',  # line 17
'View item'                   =>'Pokaż pozycję',  # line 17
'Recent changes|Page option tab'=>'Ostatnie zmiany|Page option tab',  # line 19
'Closed Projects'             =>'Projekty zamknięte',  # line 23
'Set Public Level'            =>'Ustawienie publicznego poziomu dostępu',  # line 27
'Bookmarks'                   =>'Zakładki',  # line 42
'Mark as bookmark'            =>'Dodaj do zakładek',  # line 45
'Remove bookmark'             =>'Usuń zakładkę',  # line 52
'Overall history'             =>'Zbiorcza historia',  # line 58
'Overall changes'             =>'Zbiorcze zmiany',  # line 58
'Send notification'           =>'Wyślij powiadomienia',  # line 59
'Remove notification'         =>'Usuń powiadomienia',  # line 65
'Edit bookmarks'              =>'Edytuj monitorowane pozycje',  # line 71
'View Project'                =>'Wyświetlenie projektu',  # line 79
'Edit multiple bookmarks'	  =>'Edycja wielu monitorowanych pozycji',  # line 84
'Versions'                    =>'Wersje',  # line 104
'Create Template'             =>'Utworzenie szablonu',  # line 118
'Project from Template'       =>'Utworzenie projektu z szablonu',  # line 126
'Edit Project Description'    =>'Edytuj opis projektu',  # line 134
'Delete Project'              =>'Usunięcie projektu',  # line 167
'View Project as RSS'         =>'Wyświetlenie projektu jako kanał RSS',  # line 169
'Change Project Status'       =>'Zmiana statusu projektu',  # line 175
'Add Team member'             =>'Dodanie członka zespołu',  # line 213
'Edit Team member'            =>'Edycja członka zespołu',  # line 222
'Remove from team'            =>'Usunięcie z zespołu',  # line 234
'View Task'                   =>'Wyświetlenie zadania',  # line 249
'Edit Task'                   =>'Edycja zadania',  # line 256
'Delete Task(s)'              =>'Usunięcie zadania/zadań',  # line 267
'Restore Task(s)'             =>'Odzyskanie zadania/zadań',  # line 272
'Move tasks to folder'        =>'Przeniesienie zadań do folderu',  # line 280
'Mark tasks as Complete'      =>'Zmień status zadań na Zakończone',  # line 288
'Mark tasks as Approved'      =>'Zmień status zadań na Zaakceptowane',  # line 296
'Task Test'                   =>'Test zadania',  # line 307
'New bug'                     =>'Nowy błąd',  # line 319
'Edit multiple Tasks'         =>'Edycja wielu zadań',  # line 328
'View Task As Docu'           =>'Wyświetlenie zadania jako dokumentacji',  # line 329
'New Task'                    =>'Nowe zadanie',  # line 334
'view changes'                =>'wyświetlenie zmian',  # line 337
'View Task Efforts'           =>'Wyświetlenie wysiłków zadania',  # line 350
'Mark tasks as Open'          =>'Zmień status zadań na Otwarte',  # line 399
'Add issue/bug report'        =>'Dodanie raportu zdarzenia/błędu',  # line 370
'Edit Description'            =>'Edytuj opis',  # line 379
'Log hours'                   =>'Rejestracja godzin (czasu)',  # line 396
'Edit time effort'            =>'Edycja czasu wysiłku',  # line 403
'View comment'                =>'Wyświetlenie komentarza',  # line 423
'Create comment'              =>'Utworzenie komentarza',  # line 433
'Edit comment'                =>'Edycja komentarza',  # line 443
'Mark tasks as Closed'        =>'Zmień status zadań na Zamknięte',  # line 447
'Delete comment'              =>'Usunięcie komentarza',  # line 460
'New released Version'        =>'Nowe wydanie kamienia milowego',  # line 466
'Toggle view collapsed'       =>'Zmiana widoku zwiniętego',  # line 489
'View file'                   =>'Wyświetlenie pliku',  # line 505
'Upload file'                 =>'Wprowadź plik',  # line 513
'Update file'                 =>'Aktualizacja pliku',  # line 519
'Edit file'                   =>'Edycja pliku',  # line 527
'Create Note'                 =>'Utworzenie noty',  # line 531
'Show file scaled'            =>'Wyświetlenie zeskalowanego pliku',  # line 539
'Edit Note'                   =>'Edycja noty',  # line 545
'List Companies'              =>'Lista firm',  # line 556
'View effort'                 =>'Wyświetlenie wysiłku',  # line 556
'View Company'                =>'Wyświetlenie firmy',  # line 562
'View multiple efforts'       =>'Wyświetlenie wielu wysiłków',  # line 569
'Delete Company'              =>'Usunięcie firmy',  # line 589
'List Persons'                =>'Lista osób',  # line 618
'View Person'                 =>'Wyświetlenie osoby',  # line 624
'Edit Person'                 =>'Edycja osoby',  # line 638
'Edit user rights'            =>'Edycja uprawnień osoby',  # line 653
'Delete Person'               =>'Usunięcie osoby',  # line 666
'View Efforts of Person'      =>'Wyświetlenie wysiłków osoby',  # line 671
'Send Activation E-Mail'      =>'Wysłanie e-maila aktywującego',  # line 679
'Flush Notifications'         =>'Wysłanie notyfikacji (wszystkich)',  # line 696
'Edit multiple efforts'       =>'Edycja wielu wysiłków',  # line 700
'Login'                       =>'Logowanie',  # line 713
'License'                     =>'Licencja',  # line 736
'Move files to folder'        =>'Przesunięcie plików do folderu',  # line 746
'restore Item'                =>'odzyskanie pozycji',  # line 774
'List Clients'                =>'Lista klientów',  # line 774
'List Prospective Clients'    =>'Lista potencjalnych klientów',  # line 779
'List Suppliers'              =>'Lista dostawców',  # line 785
'Activate an account'         =>'Aktywacja konta',  # line 788
'List Partners'               =>'Lista partnerów',  # line 791
'System Information'          =>'Informacje o systemie',  # line 799
'PhpInfo'                     =>'PhpInfo',  # line 809
'Search'                      =>'Wyszukiwanie',  # line 820
'Remove persons from company' =>'Usunięcie osób z firmy',  # line 845
'List Employees'              =>'Lista pracowników',  # line 872
'List Deleted Persons'        =>'Lista osób usuniętych',  # line 885
'Mark all items as viewed'    =>'Oznacz wszystko jako przeczytane',  # line 1048
'View Projects of Person'     =>'Wyświetl projekty osoby',  # line 1067
'View Task of Person'         =>'Wyświetl zadania osoby',  # line 1078
'View Changes of Person'      =>'Wyświetl zmiany osoby',  # line 1100
'Filter errors.log'           =>'Filtruj errors.log',  # line 1106
'Forgot your password?'       =>'Zapomniałeś hasło?',  # line 1108
'Delete errors.log'           =>'Usuń errors.log',  # line 1113
'Load Field'                  =>'Załadowanie pola',  # line 1296
'Save Field'                  =>'Zapisanie pola',  # line 1301
'Toggle filter own changes'   =>'Przełączenie filtru zmian danej osoby',  # line 1195

### ../pages/company.inc.php   ###
'New company'                 =>'Nowa firma',  # line 366
'Edit Company'                =>'Edycja firmy',  # line 523

### ../pages/company.inc.php   ###
'Link Persons'                =>'Asygnowanie osób',  # line 228

### ../pages/error.inc.php   ###
'Error'                       =>'Błąd',  # line 34

### ../pages/task.inc.php   ###
'(deleted %s)|page title add on with date of deletion'=>'(skasowane %s)',  # line 75

### ../pages/comment.inc.php   ###
'Comment on task|page type'   =>'Komentarz do zadania',  # line 62
'Edit this comment'           =>'Edycja tego komentarza',  # line 83
'Restore'                     =>'Odzyskaj',  # line 94
'Mark this comment as bookmark'=>'Utwórz zakładkę do tego komentarza',  # line 97
'Delete this comment'         =>'Usunięcie tego komentarza',  # line 102
'New Comment|Default name of new comment'=>'Nowy komentarz',  # line 149
'Reply to |prefix for name of new comment on another comment'=>'Odpowiedź ',  # line 213
'insufficient rights'           =>'niewystarczające uprawnienia',  # line 237
'Re: '                        =>'Odp: ',  # line 243
'Edit Comment|Page title'     =>'Edycja komentarza',  # line 290
'New Comment|Page title'      =>'Nowy komentarz',  # line 293
'On task %s|page title add on'=>'Do zadania %s',  # line 297
'Occasion|form label'         =>'Przyczyna',  # line 333
'Publish to|form labe'        =>'Opublikowane w|form labe',  # line 338
'Publish to|form label'       =>'Opublikowane w|form label',  # line 360
'Select some comments to delete'=>'Zaznacz kilka komentarzy do usunięcia',  # line 449
'WARNING: Failed to delete %s comments'=>'UWAGA: Usunięcia %s komentarza/komentarzy nie powiodło się',  # line 468
'Moved %s comments to trash'  =>'Przeniesiono %s komentarzy do kosza',  # line 471
'Failed to delete %s comments'=>'Usunięcie %s komentarza/komentarzy nie powiodło się',  # line 514
'Select some comments to restore'=>'Zaznacz komentarze do odzyskania',  # line 537
'Failed to restore %s comments'=>'Odzyskanie %s komentarza/komentarzy nie powiodło się',  # line 563
'Restored %s comments'        =>'Liczba odzyskanych komentarzy: %s',  # line 566
'Select some comments to move'=>'Zaznacz kilka komentarzy do przeniesienia',  # line 577
'Can not edit comment %s'     =>'Nie można edytować komentarza %s',  # line 618
'Select one folder to move comments into'=>'Zaznacz jeden folder, do którego zostaną przeniesione komentarze',  # line 651
'... or select nothing to move to project root'=>'... lub nie zaznaczaj niczego, aby przenieść je do folderu głównego projektu',  # line 663
'No folders in this project...'=>'Brak jakichkolwiek folderów w tym projekcie...',  # line 691

### ../pages/task.inc.php   ###
'insufficient rights'         =>'niewystarczające uprawnienia',  # line 1545

### ../pages/task.inc.php   ###
'Edit tasks'                  =>'Edycja zadań',  # line 1613
'Move items'                  =>'Przeniesienie pozycji',  # line 1668

### ../pages/company.inc.php   ###
'related projects of %s'      =>'projekty powiązane z %s',  # line 40

### ../pages/company.inc.php   ###
'no companies'                =>'brak firm',  # line 68

### ../pages/company.inc.php   ###
'Edit this company'           =>'Edycja tej firmy',  # line 125
'edit'                        =>'edycja',  # line 126
'Create new person for this company'=>'Utworzenie nowej osoby przypisanej do tej firmy',  # line 132

### ../pages/company.inc.php   ###
'Create new project for this company'=>'Utworzenie nowego projektu dla tej firmy',  # line 139
'Add existing persons to this company'=>'Dodanie istniejącej osoby do tej firmy',  # line 146
'Persons'                     =>'Osoby',  # line 147
'Adress'                      =>'Adres',  # line 169
'Fax'                         =>'Faks',  # line 178
'Web'                         =>'Web',  # line 183
'Intra'                       =>'Intranet',  # line 186
'Mail'                        =>'Mail',  # line 189
'related Persons'             =>'Osoby powiązane',  # line 204
'link existing Person'        =>'powiązanie do istniejącej osoby',  # line 235
'create new'                  =>'utworzenie nowej',  # line 237
'no persons related'          =>'brak powiązanych osób',  # line 240
'Active projects'             =>'Aktywne projekty',  # line 297
' Hint: for already existing projects please edit those and adjust company-setting.'=>'Podpowiedź: wyedytuj istniejące projekty i zmień ustawienia firmy',  # line 307
'no projects yet'             =>'nie ma jeszcze żadnych projektów',  # line 310
'Closed projects'             =>'Projekty zamknięte',  # line 335
'Create another company after submit'=>'Utworzenie następnej firmy po zatwierdzeniu obecnej',  # line 430
'Edit %s'                     =>'Edycja %s',  # line 524
'Add persons employed or related'=>'Dodanie osób zatrudnionych lub powiązanych',  # line 525
'NOTE: No persons selected...'=>'UWAGA: Brak zaznaczonych osób...',  # line 578
'NOTE person already related to company'=>'UWAGA: Osoba jest już powiązana z firmą',  # line 605
'Select some companies to delete'=>'Zaznacz firmy do skasowania',  # line 627
'WARNING: Failed to delete %s companies'=>'OSTRZEŻENIE: Usunięcie %s firmy/firm nie powiodło się',  # line 647
'Moved %s companies to trash'=>'Firmy %s zostały przeniesione do kosza',  # line 650

### ../pages/effort.inc.php   ###
'New Effort'                  =>'Nowy wysiłek',  # line 32

### ../pages/effort.inc.php   ###
'Edit Effort|page type'       =>'Edycja wysiłku',  # line 164
'Edit Effort|page title'      =>'Edycja wysiłku',  # line 178
'New Effort|page title'       =>'Nowy wysiłek',  # line 181
'Date / Duration|Field label when booking time-effort as duration'=>'Data / Czas trwania',  # line 207

### ../pages/task.inc.php   ###
'Publish to'                   =>'Opublikowane w',  # line 859

### ../pages/effort.inc.php   ###
'Could not get effort'        =>'Nie znaleziono wysiłku',  # line 278
'Could not get project of effort'=>'Nie znaleziono projektu dla wysiłku',  # line 286
'Could not get person of effort'=>'Nie znaleziono osoby dla wysiłku',  # line 292
'Name required'               =>'Wymagana nazwa',  # line 357
'Cannot start before end.'    =>'Nie może wystartować przed zakończeniem.',  # line 361
'Select some efforts to delete'=>'Zaznacz wysiłki do usunięcia',  # line 393
'WARNING: Failed to delete %s efforts'=>'OSTRZEŻENIE: Usunięcie %s wysiłku/wysiłków nie powiodło się',  # line 412
'Moved %s efforts to trash'=>'Wysiłki %s zostały przeniesione do kosza',  # line 415

### ../pages/error.inc.php   ###
'Error|top navigation tab'    =>'Błąd',  # line 24
'Unknown Page'                =>'Nieznana strona',  # line 27

### ../pages/task.inc.php   ###
'Item-ID %d'                  =>'ID pozycji: %d',  # line 73

### ../pages/file.inc.php   ###
'Could not access parent task Id:%s'=>'Brak dostęu do zadania nadrzędnego o ID: %s',  # line 52
'Could not access parent task.'=>'Brak dostępu do zadania nadrzędnego',  # line 53
'Edit this file'              =>'Edycja pliku',  # line 96
'Version #%s (current): %s'   =>'Wersja aktualna #%s: %s',  # line 109
'Move this file to another task'=>'Przeniesienie pliku do innego zadania ',  # line 121
'Move'                        =>'Przenieś',  # line 122
'For task'                    =>'Do zadania',  # line 127
'Mark this file as bookmark'  =>'Utwórz zakladkę do tego pliku',  # line 132
'Uploaded by'                 =>'Wprow. przez',  # line 133
'Download'                    =>'Pobranie',  # line 138
'Version #%s : %s'            =>'Wersja #%s: %s',  # line 165
'Filesize'                    =>'Wielkość pliku',  # line 182
'Uploaded'                    =>'Wgrany',  # line 184
'Type'                        =>'Typ',  # line 183
'Upload new version|block title'=>'Wgraj nową wersję',  # line 199
'only expected one task. Used the first one.'=>'spodziewane tylko jedno zadanie. Zostanie użyte pierwsze z nich.',  # line 322
'Could not edit task'         =>'Edycja zadania niemożliwa',  # line 331
'Edit File|page type'         =>'Edycja pliku',  # line 376
'Edit File|page title'        =>'Edycja pliku',  # line 386
'New file|page title'         =>'Nowy plik',  # line 389
'On project %s|page title add on'=>'Do projektu %s',  # line 392
'Could not get file'          =>'Nie znaleziono pliku',  # line 504
'Could not get project of file'=>'Nie znaleziono projektu dla pliku',  # line 511
'Please enter a proper filename'=>'Proszę wprowadzić prawidłową nazwę pliku',  # line 548
'Select some files to delete' =>'Zaznacz pliki do usunięcia',  # line 596
'WARNING: Failed to delete %s files'=>'OSTRZEŻENIE: Usunięcie %s pliku/plików nie powiodło się',  # line 615
'Moved %s files to trash'  =>'Przeniesiono %s plików do kosza',  # line 618
'Uploaded new version of file with Id %s'=>'Wgrano nową wersję pliku o ID %s',  # line 625
'Uploaded new file with Id %s'=>'Nowy plik wgrano z ID %s',  # line 628
'Updated file with Id %s'     =>'Zaktualizowano plik z ID %s',  # line 632
'Select some file to display' =>'Zaznacz pliki do wyświetlenia',  # line 656
'Failed to delete %s files'   =>'Usunięcie %s pliku/plików nie powiodło się',  # line 646
'Select some files to move'   =>'Zazanacz pliki do przeniesienia',  # line 727
'Can not edit file %s'        =>'Pliku %s nie można edytowa',  # line 781
'Edit files'                  =>'Edycja plików',  # line 816
'Select folder to move files into'=>'Zaznacz folder, do którego pliki zostaną przeniesione',  # line 818
'No folders available'        =>'Brak dostępnych folderów',  # line 852


### ../render/render_list_column_special.inc.php   ###
'Select lines to use functions at end of list'=>'Zaznacz linie aby użyć funkcji znajdujących się u dołu tej listy',  # line 361

### ../pages/home.inc.php   ###
'Personal Efforts'            =>'Wysiłki osobiste',  # line 69
'At Home'                     =>'Strona startowa',  # line 76
'F, jS'                       =>'d-m-Y H:i',  # line 77
'Functions'                   =>'Funkcje',  # line 86
'Edit your Profile'           =>'Edycja profilu',  # line 87
'View your efforts'           =>'Wyświetlenie twoich wysiłków',  # line 95
'Edit your profile'           =>'Edycja twojego profilu',  # line 96
'Projects'                    =>'Projekty',  # line 101
'Your projects'               =>'Twoje projekty',  # line 122
'S|Column header for status'  =>'S',  # line 126
'P|Column header for priority'=>'P',  # line 132
'Priority|Tooltip for column header'=>'Priorytet',  # line 133
'for|short for client'        =>'dla',  # line 135
'Company|column header'       =>'Firma',  # line 139
'without client'              =>'bez klienta',  # line 147
'Edit|function in context menu'=>'Edycja',  # line 153
'Log hours for a project|function in context menu'=>'Rejestracja czasu w projekcie',  # line 160
'Create new project|function in context menu'=>'Utworzenie nowego projektu',  # line 167
'You are not assigned to a project.'=>'Nie jesteś przypisany do projektu',  # line 185
'Your Bookmarks'              =>'Twoje zakładki',  # line 204
'You have no open tasks'      =>'Nie masz otwartych zadań',  # line 213
'Open tasks assigned to you'  =>'Otwarcie zadań przypisanych do ciebie',  # line 218
'Open tasks (including unassigned)'=>'Zadania otwarte (właczając nieprzypisane)',  # line 221
'All open tasks'              =>'Wszystkie otwarte zadania',  # line 224
'P|column header'             =>'P',  # line 240
'Priority'                    =>'Priorytet',  # line 241
'S|column header'             =>'S',  # line 247
'Task-Status'                 =>'Status zadania',  # line 248
'Project|column header'       =>'Projekt',  # line 255
'Folder|column header'        =>'Folder',  # line 260
'status->Closed|context menu function'=>'status->Zamknięte',  # line 264
'Modified|column header'      =>'Zmienione',  # line 277
'Est.|column header estimated time'=>'Przew.',  # line 285
'Estimated time in hours'     =>'Przewidywany czas w godzinach',  # line 286
'Edit|context menu function'  =>'Edycja',  # line 304
'status->Completed|context menu function'=>'status->Zakończone?',  # line 311
'status->Approved|context menu function'=>'status->Zaakceptowane',  # line 319
'Delete|context menu function'=>'Usunięcie',  # line 328
'Log hours for select tasks|context menu function'=>'Rejestracja czasu dla zaznaczonego zadania',  # line 336
'today'                       =>'dzisiaj',  # line 361
'%s tasks with estimated %s hours of work'=>'%s zadań o przewidywanym czasie pracy %s godzin',  # line 364
'yesterday'                   =>'wczoraj',  # line 379
'my blocked'                  =>'moje zablokowane',  # line 561
'needs feedback'              =>'wymagana reakcja',  # line 620
'Your Tasks'                  =>'Twoje zadania',  # line 756
'Your efforts'                =>'Twoje wysiłki',  # line 965

### ../render/render_page.inc.php   ###
'Your projects. Alt-P / Option-P'=>'Twoje projekty. Alt-P / Option-P',  # line 228

### ../pages/login.inc.php   ###
'Login|tab in top navigation' =>'Login',  # line 26
'License|tab in top navigation'=>'Licencja',  # line 32
'Welcome to streber|Page title'=>'Witaj w streberze',  # line 73
'please login'                =>'proszę się zalogować',  # line 74
'Nickname|label in login form'=>'Nick',  # line 93
'Password|label in login form'=>'Hasło',  # line 94
'I forgot my password.|label in login form'=>'Zapomniałem swojego hasła',  # line 95
'I forgot my password'        =>'Zapomniałem swojego hasła',  # line 96
'Continue anonymously'        =>'Kontynuuj anonimowo',  # line 106
'If you remember your name, please enter it and try again.'=>'Jeśli pamiętasz swój nick, wprowadź je proszę i spróbuj ponownie',  # line 142
'Supposed a user with this name existed a notification mail has been sent.'=>'Mail z informacją został wysłany, o ile istnieje użytkownik o takim nicku',  # line 165
'invalid login|message when login failed'=>'nieprawidłowy login',  # line 216
'Welcome to %s|Notice after login'=>'Witaj w systemie %s|Notice after login',  # line 262
'Welcome %s. Please adjust your profile and insert a good password to activate your account.'=>'Witaj %s. Proszę wyedytuj swój profil i wpisz swoje nowe, własne hasło aby aktywować swoje konto.',  # line 275
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter your name and use the <b>forgot password link</b> below.'=>'Niestety kod aktywacyjny konta nie jest juz ważny. Jeśli już posiadasz konto, możesz wprowadzić swój nick i użyć <b>Zapomniałem swojego hasła</b>.',  # line 281
'Password reminder|Page title'=>'Przypomnienie hasła',  # line 301
'License|page title'          =>'Licencja',  # line 304
'Please enter your nickname'  =>'Podaj proszę swój nick',  # line 313
'We will then sent you an E-mail with a link to adjust your password.'=>'Zostanie wysłany do Ciebie e-mail z odnośnikiem umożliwiającycm zmianę hasła.',  # line 323
'If you do not know your nickname, please contact your administrator: %s.'=>'Jeśli nie znasz swojego nick\'a skontaktuj się z administratorem: %s',  # line 325
'If you do not know your nickname, please contact your administrator: %s.'=>'Jeśli nie znasz swojego nicka, skontaktuj się proszę z administratorem: %s',  # line 334
'A notification mail has been sent.'=>'Został wysłany e-mail notyfikacyjny.',  # line 384


### ../pages/misc.inc.php   ###
'Could not find requested page `%s`'=>'Nie można znaleźć strony wysyłającej żądanie `%s`',  # line 37
'Select some items to restore'=>'Zaznacz parę pozycji adby je odzyskać',  # line 179
'Item %s does not need to be restored'=>'Nie ma potrzeby, aby pozycję %s odzyskiwać',  # line 191
'WARNING: Failed to restore %s items'=>'OSTRZEŻENIE: Nie można odzyskać %s pozycji',  # line 204
'Restored %s items'           =>'Odzyskano %s pozycji',  # line 207
'Failed to restore %s items'  =>'Odyzskanie %s pozycji nie powiodło się',  # line 231
'Admin|top navigation tab'    =>'Administrator',  # line 232
'System information'          =>'Informacja systemowa',  # line 238
'Admin'                       =>'Administrator',  # line 239
'Database Type'               =>'Typ bazy danych',  # line 279
'PHP Version'                 =>'Wersja PHP',  # line 282
'extension directory'         =>'folder rozszerzeń',  # line 285
'loaded extensions'           =>'rozszerzenia załadowane',  # line 287
'include path'                =>'ścieżka inkludowania',  # line 289
'register globals'            =>'register globals',  # line 291
'magic quotes gpc'            =>'magic quotes gpc',  # line 293
'magic quotes runtime'        =>'magic quotes runtime',  # line 295
'safe mode'                   =>'safe mode',  # line 297
'Error-Log'                   =>'Log błędów',  # line 335
'One notification sent'       =>'Wysłana została jedna notyfikacja',  # line 426
'%s notifications sent'       =>'Wysłanych zostało %s notyfikacji',  # line 429
'No notifications sent'       =>'Nie zostały wysłane żadne notyfikacje',  # line 432
'hide'                        =>'ukryj',  # line 468

### ../pages/task.inc.php   ###
'Summary|Block title'         =>'Podsumowanie',  # line 190

### ../pages/person.inc.php   ###
'Efforts'                     =>'Wysiłki',  # line 33
'Active People'               =>'Osoby aktywne',  # line 60
'relating to %s|page title add on listing pages relating to current user'=>'przypisanych do %s',  # line 62
'People/Project Overview'     =>'Osoby/Streszczenie projektu',  # line 100
'no related persons'          =>'brak powiązanych osób',  # line 189
'Persons|Pagetitle for person list'=>'Osoby',  # line 135
'relating to %s|Page title Person list title add on'=>'powiązane z %s',  # line 137
'admin view|Page title add on if admin'=>'widok administratora',  # line 140
'without account'             =>'bez konta',  # line 165
'with account'                =>'z kontem',  # line 183
'employees'                   =>'zatrudniony',  # line 201
'Employees|Pagetitle for person list'=>'Pracownicy',  # line 210
'contact persons'             =>'osoba kontaktowa',  # line 220
'Edit this person|Tooltip for page function'=>'Edycja tej osoby',  # line 234
'Profile|Page function edit person'=>'Profil',  # line 235
'Edit user rights|Tooltip for page function'=>'Edycja uprawnień użytkownika',  # line 241
'User Rights|Page function for edit user rights'=>'Uprawnienia użytkownika',  # line 242
'Contact Persons|Pagetitle for person list'=>'Osoby kontaktowe',  # line 286
'Mobile|Label mobilephone of person'=>'Telefon komórkowy',  # line 290
'Office|label for person'     =>'Biurowe',  # line 293
'Private|label for person'    =>'Prywatne',  # line 296
'Fax (office)|label for person'=>'Faks (biuro)',  # line 299
'Website|label for person'    =>'WWW',  # line 304
'Personal|label for person'   =>'Osobiste',  # line 307
'E-Mail|label for person office email'=>'E-mail',  # line 311
'E-Mail|label for person personal email'=>'E-mail',  # line 314
'Adress Personal|Label'       =>'Adres prywatny',  # line 319
'Adress Office|Label'         =>'Adres biura',  # line 326
'Birthdate|Label'             =>'Data urodzin',  # line 333
'works for|List title'        =>'pracuje dla',  # line 348
'not related to a company'    =>'nie powiązany z firmą',  # line 354
'Deleted People'              =>'Osoby usunięte',  # line 362
'works in Projects|list title for person projects'=>'zaangażowany w projektach',  # line 378
'no active projects'          =>'brak aktywnych projektów',  # line 392
'Assigned tasks'              =>'Przypisane zadania',  # line 407
'No open tasks assigned'      =>'Brak otwartych zadań przypisanych',  # line 408
'Efforts|Page title add on'   =>'Wysiłki',  # line 449
'no efforts yet'              =>'nie wprowadzono żadnych wysiłków',  # line 472
'Create Note|Tooltip for page function'=>'Utworzenie noty',  # line 474
'Note|Page function person'   =>'Nota',  # line 475
'New person'                  =>'Nowa osoba',  # line 495
'notification:'               =>'powiadomienie:',  # line 496
'Add existing companies to this person'=>'Dodanie istniejących firm do osoby',  # line 516
'Mark this person as bookmark'=>'Utwórz zakładkę do tej osoby',  # line 545
'Edit Person|Page type'       =>'Edycja osoby',  # line 570
'no company'                  =>'brak firmy',  # line 608
'Person details'              =>'Szczegóły osoby',  # line 618
'Person with account (can login)|form label'=>'Osoba z kontem (może zalogować się)',  # line 618
'Add task for this persons (optionally creating project and effort on the fly)|Tooltip for page function'=>'Dodaj zadanie dla tych osób (opcjonalnie tworząc w locie projekt i wysiłek)|Tooltip for page function',  # line 627
'Add note|Page function person'=>'Dodaj notatkę|Page function person',  # line 628
'Edit profile|Page function edit person'=>'Edytuj profil|Page function edit person',  # line 642
'Edit user rights|Page function for edit user rights'=>'Edytuj uprawnienia użytkownika|Page function for edit user rights',  # line 650
'Password|form label'         =>'Hasło',  # line 634
'confirm Password|form label' =>'Potwierdzenie hasła',  # line 640
'Link Companies'              =>'Powiąznie firmy',  # line 658
'-- reset to...--'            =>'-- przywrócenie do... --',  # line 662
'Remove companies from person'=>'Usunięcie firm powiązanych z osobą',  # line 664
'Profile|form label'          =>'Profil',  # line 667
'link existing Company'       =>'powiązanie do istniejącej firmy',  # line 672
'daily'                       =>'codziennie',  # line 676
'each 3 days'                 =>'co 3 dni',  # line 677
'no companies related'        =>'brak firm powiązanych z osobą',  # line 677
'each 7 days'                 =>'co 7 dni',  # line 678
'each 14 days'                =>'co 14 dni',  # line 679
'each 30 days'                =>'co 30 dni',  # line 680
'Never'                       =>'nigdy',  # line 681
'Send notifications|form label'=>'Wyślij potwierdzenia',  # line 687
'Send mail as html|form label'=>'Wyślij mail jako html',  # line 688
'Theme|form label'            =>'Temat',  # line 697
'Language|form label'         =>'Język',  # line 701
'Create another person after submit'=>'Utworzenie następnej osoby po zatwierdzeniu',  # line 716
'notification'                =>'notyfikacja',  # line 757
'not allowed to edit'         =>'nie można edytować',  # line 785
'Last login|Label'            =>'Ostatnio zalogwany',  # line 835
'NOTE: Nickname has been converted to lowercase'=>'UWAGA: Nick został przekonwertowany do małych liter',  # line 906
'NOTE: Nickname has to be unique'=>'UWAGA: Nick musi być unikalny',  # line 912
'Account'                     =>'Konto',  # line 912
'passwords do not match'      =>'hasła nie są jednakowe',  # line 928
'Password is too weak (please add numbers, special chars or length)'=>'Hasło jest zbyt słabe (dodaj liczby, znaki specjalne lub zwiększ długość hasła)',  # line 942
'Login-accounts require a unique nickname'=>'Konta z możliwościa zalogowania wymagają unikalnego nick\'a',  # line 957
'- no -'                      =>'- nie -',  # line 971
'Assigne to project|form label'=>'Przypisz do projektu',  # line 980
'A notification / activation  will be mailed to <b>%s</b> when you log out.'=>'Potwierdzenie / aktywacja zostanie wysłana do <b>%s</b>, gdy wylogujesz się.',  # line 983
'WARNING: could not insert object'=>'OSTRZEŻENIE: nie można wstawić obiektu',  # line 1004
'Select some persons to delete'=>'Zaznacz osoby do usunięcia',  # line 1048
'Options'                     =>'Opcje',  # line 1056
'<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'=>'<b>%s</b> został przypisany do projektów. Można jednak wyłączyć jego prawa do logowania się.',  # line 1065
'WARNING: Failed to delete %s persons'=>'OSTRZEŻENIE: Usunięcie %s osoby/osób nie powiodło się',  # line 1077
'Moved %s persons to trash'=>'Przeniesionoo %s osób do kosza',  # line 1080
'Projects|Page title add on'  =>'Projekty',  # line 1095
'Insufficient rights'         =>'Niewystarczające uprawnienia',  # line 1099
'Sending notifactions requires an email-address.'=>'Wysłanie potwierdzeń wymaga adresu e-mail',  # line 1105
'Since the user does not have the right to edit his own profile and therefore to adjust his password, sending an activation does not make sense.'=>'Ponieważ użytkownik nie ma praw do edycji swojego profilu, co umożliwa zmianę jego hasła, więc wysłanie maila aktywującego nie ma sensu.',  # line 1111
'Sending an activation mail does not make sense, until the user is allowed to login. Please adjust his profile.'=>'Wysłanie maila aktywującego nie ma sensu dopóki użytkownik nie mam możliwości do zalogowania się.',  # line 1116
'Activation mail has been sent.'=>'Mail aktywujący',  # line 1127
'Sending notification e-mail failed.'=>'Wysłanie maila z potwierdzeniem nie powiodło się.',  # line 1130
'Select some persons to notify'=>'Zaznacz kilka osób do powiadomienia',  # line 1151
'WARNING: Failed to mail %s persons'=>'OSTRZEŻENIE: Wysłanie maila do %s osoby/osób nie powiodło się',  # line 1176
'Sent notification to %s person(s)'=>'Wysłanie potwierdzeń do %s osoby/osób',  # line 1179
'The changed profile <b>does not affect existing project roles</b>! Those has to be adjusted inside the projects.'=>'Zmieniony profil <b>nie wpływa na role osoby w już istniejących projektach</b>! Takie zmiany należy dokonać również w istniejących prjektach przypisanych do osoby.',  # line 1181
'Select some persons to edit' =>'Zaznacz osoby do edycji',  # line 1205
'Could not get Person'        =>'Nie można znaleźć osoby',  # line 1209
'Edit Person|page type'       =>'Edycja osoby',  # line 1225
'Malformed activation url'    =>'Nieprawidłowy url aktywacyjny',  # line 1225
'Adjust user-rights'          =>'Zmiana uprawnień użytkownika',  # line 1227
'Please consider that activating login-accounts might trigger security-issues.'=>'Proszę rozważyć, iż wysłanie maila aktywującego może spowodować zagrożenie bezpieczeństwa.',  # line 1237
'Person can login|form label' =>'Osoba może zalogować się',  # line 1243
'Using auto detection of time zone requires this user to relogin.'=>'Uzycie autodetekcji strefy cz\asowej wymaga wylogowania i ponownego zalogowania się.',  # line 1255
'Could not get person'        =>'Nie można znaleźć osoby',  # line 1283
'Time zone|form label'        =>'Strefa czasowa',  # line 1886
'Nickname has been converted to lowercase'=>'Nick został przekonwertowany do małych liter',  # line 1300
'Nickname has to be unique'   =>'Nick musi być unikalny',  # line 1306
'User rights changed'         =>'Uprawnienia użytkownika zostały zmienione',  # line 1315
'Passwords do not match'      =>'Hasła nie zagadzają się',  # line 1321
'Tasks|Page title add on'     =>'Zadania',  # line 1348
'Login-accounts require a unique nickname'=>'Konto z loginem wymaga unikalnego nicka',  # line 1350
'no tasks yet'                =>'nie wprowadzono jeszcze zadań',  # line 1372
'Person %s created'           =>'Osoba %s została utworzona',  # line 1416
'Could not insert object'     =>'Nie można zapisać obiektu',  # line 1419
'Failed to delete %s persons' =>'Usunięcie %s osoby/osób nie powiodło się',  # line 1492
'3 weeks'                     =>'3 tygodnie',  # line 1534
'1 month'                     =>'1 miesiąc',  # line 1554
'prior'                       =>'wcześniej',  # line 1574
'Failed to mail %s persons'   =>'Wysłanie maila do %s osoby/osób nie powiodło się',  # line 1591
'Registering is not enabled'  =>'Rejestracja nie jest włączona',  # line 1755
'Please provide information, why you want to register.'=>'Proszę poinformować o powodzie rejestracji',  # line 1760
'Register as a new user'      =>'Zarejestruj się jako nowy użytkownik',  # line 1768
'Changes|Page title add on'   =>'Zmiany',  # line 1788
'Category|form label'         =>'Kategoria',  # line 1848
'Add related companies'       =>'Dodanie powiązanych firm',  # line 2054
'Authentication with|form label'=>'Autentyfikacja z|form label',  # line 2073
'Because we are afraid of spam bots, please provide some information about you and why you want to register.'=>'Ponieważ unikamy działań spam botów, proszę podaj informacje o sobie oraz dlaczego chcesz się zarejestrować.',  # line 2078
'ASAP'                        =>'ASAP',  # line 2110
'Enable efforts'              =>'Włącz wysiłki',  # line 2146
'Enable bookmarks'            =>'Włącz zakładki',  # line 2147
'No companies selected...'    =>'Żadna firma nie została zaznaczona...',  # line 2155
'Company already related to person'=>'Firma jest już powiązana z osobą',  # line 2131
'Failed to remove %s companies'=>'Usunięcie %s firmy/firm nie powiodło się',  # line 2195
'Removed %s companies'        =>'Usunięto %s firmę/firm',  # line 2198
'Marked all previous items as viewed.'=>'Oznaczono wszystkie poprzednie pozycje jako przeczytane.',  # line 2227
'Filter own changes from recent changes list'=>'Filtruj własne zmiany z listy poprzednich zmian',  # line 2232
'Login-accounts require a full name.'=>'Konta z loginem wymagają pełnej nazwy.',  # line 2357
'Please enter an e-mail address.'=>'Proszę podaj adres e-mail.',  # line 2367
'Please copy the text from the image.'=>'Proszę skopiuj tekst z obrazka.',  # line 2441
'Thank you for registration! After your request has been approved by a moderator, you will can an email.'=>'Dziękujemy za rejstrację! Po zaakceptowaniu Twojej prośby przez moderatora otrzymasz mail powiadamiający.',  # line 2470
'Updated settings for %s.'    =>'Zaktualizowane ustawienia dla %s.',  # line 2674

### ../pages/task.inc.php   ###
'new'                        =>'nowe:',  # line 134

### ../pages/task.inc.php   ###
'Bug'                         =>'Błąd',  # line 150

### ../pages/task.inc.php   ###
'new subtask for this folder' =>'nowe podzadanie dla tego folderu',  # line 118

### ../pages/task.inc.php   ###
'Edit description'            =>'Edytuj opis',  # line 2118

### ../pages/projectperson.inc.php   ###
'Edit Team Member'            =>'Edycja członka zespołu',  # line 46
'role of %s in %s|edit team-member title'=>'rola %s w %s',  # line 47
'Role in this project'        =>'Rola w tym projekcie',  # line 94
'start times and end times'   =>'czas startu i zakończenia',  # line 109
'duration'                    =>'czas trwania',  # line 110
'Log Efforts as'              =>'Rejestracja wysiłku jako',  # line 113
'Changed role of <b>%s</b> to <b>%s</b>'=>'Zmieniona rola <b>%s</b> na <b>%s</b>',  # line 193

### ../pages/search.inc.php   ###
'Jumped to the only result found.'=>'Przeskoczono do jedynego, znalezionego rezultatu.',  # line 148
'Search Results'              =>'Wyniki wyszukiwania',  # line 167
'Searching'                   =>'Trwa szukanie',  # line 168
'Found %s companies'          =>'Znaleziono %s firm',  # line 179
'Found %s projects'           =>'Znaleziono %s projektów',  # line 188
'Found %s persons'            =>'Znaleziono %s osób',  # line 198
'Found %s tasks'              =>'Znaleziono %s zadań',  # line 213
'Found %s comments'           =>'Znaleziono %s komentarzy',  # line 224
'Sorry. Could not find anything.'=>'Niestety. Nie znaleziono podanej frazy.',  # line 230
'Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters'=>'Z uwagi na ograniczenia przeszukiwania pełnotekstowego bazy danych MySQL, wyszukiwanie nie będzie działało dla:<br/>- słów zawierających 3 lub mniej znaków<br/>- list zawierających mniej, niż 3 pozycje<br/>- słów zawierających znaki specjalne',  # line 231

### ../pages/task.inc.php   ###
'Edit this task'              =>'Edycja zadania',  # line 85
'Delete this task'            =>'Usunięcie zadania',  # line 94
'Restore this task'           =>'Odzyskanie zadania',  # line 103
'Undelete'                    =>'Odkasowanie',  # line 104
'new bug for this folder'     =>'nowy błąd dla tego folderu',  # line 149
'new task for this milestone' =>'nowe zadanie dla tego kamienia milowego',  # line 141
'Append details'              =>'Dodanie detali',  # line 161
'Complete|Page function for task status complete'=>'Zakończone',  # line 168
'Approved|Page function for task status approved'=>'Zaakceptowane',  # line 174
'Description|Label in Task summary'=>'Opis',  # line 202
'Part of|Label in Task summary'=>'Znajduje się w',  # line 209
'Status|Label in Task summary'=>'Status',  # line 215
'Opened|Label in Task summary'=>'Otwarte',  # line 218
'Planned start|Label in Task summary'=>'Planowany start',  # line 221
'Planned end|Label in Task summary'=>'Plan. koniec',  # line 225
'Closed|Label in Task summary'=>'Zamknięte',  # line 230
'Created by|Label in Task summary'=>'Utworzone przez',  # line 234
'Last modified by|Label in Task summary'=>'Ostatnio zmienione przez',  # line 239
'Logged effort|Label in task-summary'=>'Zarejestrowany wysiłek',  # line 244
'Attached files'              =>'Załączone pliki',  # line 287
'attach new'                  =>'załączenie nowego',  # line 289
'Upload'                      =>'Wprowadź',  # line 292
'Issue report'                =>'Raport zdarzenia',  # line 353
'Platform'                   =>'Platforma',  # line 362
'OS'                          =>'OS',  # line 365
'Build'                       =>'Wydanie',  # line 371
'Steps to reproduce|label in issue-reports'=>'Kroki do zreprodukowania',  # line 376
'Expected result|label in issue-reports'=>'Spodziewane wyniki',  # line 380
'Suggested Solution|label in issue-reports'=>'Sugerowane rozwiązanie',  # line 384
'No project selected?'        =>'Brak zaznaczonych projektów?',  # line 485
'Please select only one item as parent'=>'Proszę zaznaczyć tylko jedną pozycję jako nadrzędną',  # line 536
'Insufficient rights for parent item.'=>'Niewystarczające uprawnienia dla pozycji nadrzędnej.',  # line 539
'could not find project'      =>'nie można znaleźć projektu',  # line 557
'I guess you wanted to create a folder...'=>'Wygląda na to, że chciałeś utworzyć folder...',  # line 591
'Assumed <b>%s</b> to be mean label <b>%s</b>'=>'Założono, że <b>%s</b> oznaczają etykiety <b>%s</b>',  # line 612
'Bug|Task-Label that causes automatically addition of issue-report'=>'Błąd',  # line 713
'Feature|Task label that added by default'=>'Cecha',  # line 724
'No task selected?'           =>'Brak zaznaczonych zadań?',  # line 768
'Edit %s|Page title'          =>'Edycja %s',  # line 795
'New task'                    =>'Nowe zadanie',  # line 801
'for %s|e.g. new task for something'=>'nowe %s',  # line 803
'-- undefined --'             =>'-- niezdefiniowane --',  # line 844
'Resolved in'                 =>'Zrealizowane w',  # line 850
'Resolve reason'              =>'Powód realizacji',  # line 708
'- select person -'           =>'-- zaznacz osobę --',  # line 921
'Assign to'                   =>'Przypisane do',  # line 942
'Assign to|Form label'        =>'Przypisane do',  # line 953
'Also assign to|Form label'   =>'Przypisz również do',  # line 954
'Prio|Form label'             =>'Priorytet',  # line 960

### ../pages/task.inc.php   ###
'30 min'                      =>'30 min',  # line 987
'1 h'                         =>'1 h',  # line 988
'2 h'                         =>'2 h',  # line 989
'4 h'                         =>'4 h',  # line 990
'1 Day'                       =>'1 dzień',  # line 991
'2 Days'                      =>'2 dni',  # line 992
'3 Days'                      =>'3 dni',  # line 993
'4 Days'                      =>'4 dni',  # line 994
'1 Week'                      =>'1 tydzień',  # line 995
'1,5 Weeks'                   =>'1,5 tygodnia',  # line 996
'2 Weeks'                     =>'2 tygodnie',  # line 997
'3 Weeks'                     =>'3 tygodnie',  # line 998
'Completed'                   =>'Zakończone',  # line 1025
'Severity|Form label, attribute of issue-reports'=>'Waga',  # line 1063
'reproducibility|Form label, attribute of issue-reports'=>'powtarzalność',  # line 1064
'unassigned to %s|task-assignment comment'=>'nie przypisane do %',  # line 1217
'formerly assigned to %s|task-assigment comment'=>'poprzednio przypisane do %s',  # line 1223
'task was already assigned to %s'=>'zadanie zostału już przypisane do %s',  # line 1241
'Failed to retrieve parent task'=>'Odzyskanie zadania nadrzędnego nie powiodło się',  # line 1300
'Task requires name'          =>'Zadanie wymaga nazwy',  # line 2176
'ERROR: Task called %s already exists'=>'BŁĄD: Zadanie o nazwie %s istnieje już',  # line 1337
'Turned parent task into a folder. Note, that folders are only listed in tree'=>'Zmieniono zadanie nadrzędna na folder. Foldery wyświetlane są tylko w trybie wyświetlania drzewa',  # line 1356
'Failed, adding to parent-task'=>'Dodanie zadania nadrzędnego nie powiodło się',  # line 1360
'NOTICE: Ungrouped %s subtasks to <b>%s</b>'=>'UWAGA: %s podzadań zostało rozgrupowaych do <b>%s</b>',  # line 1376
'HINT: You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'=>'PODPOWIEDŹ: Zadanie <b>%s</b> zostało zmienione na folder. Foldery są wyświetlane na liście zadań-folderów.',  # line 1383
'NOTE: Created task %s with ID %s'=>'UWAGA: Utworzono zadanie %s o ID %s',  # line 1472
'NOTE: Changed task %s with ID %s'=>'UWAGA: Zmodyfikowano zadanie %s o ID %s',  # line 1481
'Select some tasks to move'   =>'Zaznacz zadania do przeniesienia',  # line 1511
'Can not move task <b>%s</b> to own child.'=>'Nie można przenieść zadania <b>%s</b> do własnego podzadania',  # line 1570
'Can not edit tasks %s'       =>'Nie można edytować zadań %s',  # line 1578
'insufficient rights to edit any of the selected items'=>'niewystarczające uprawninia do edycji zaznaczonych pozycji',  # line 1589
'Select folder to move tasks into'=>'Zaznacz folder, do którego przeniesiesz zadania',  # line 1615
'(or select nothing to move to project root)'=>'(lub nie zaznaczaj niczego, aby przenieść zadania do folderu głównego)',  # line 1664
'Task <b>%s</b> deleted'      =>'Zadania <b>%s</b> zostały usunięte',  # line 1713
'Moved %s tasks to trash'  =>'Przeniesiono %s zadań do kosza',  # line 1749
' ungrouped %s subtasks to above parents.'=>' rozgrupowano %s podzadań do ich zadań nadrzędnych',  # line 1751
'No task(s) selected for deletion...'=>'Nie zaznaczono zadań do usunięcia...',  # line 1760
'ERROR: could not retrieve task'=>'BŁĄD: nie można odzyskać zadania',  # line 1782
'Task <b>%s</b> does not need to be restored'=>'Nie ma potrzeby, aby zadanie <b>%s</b> odzyskiwać',  # line 1795
'Task <b>%s</b> restored'     =>'Zadanie <b>%s</b> odzyskane',  # line 1847
'Failed to restore Task <b>%s</b>'=>'Odzyskanie zadania <b>%s</b> nie powiodło się',  # line 1850
'Task <b>%s</b> do not need to be restored'=>'Nie ma potrzeby, aby zadanie <b>%s</b> odzyskiwać',  # line 1839
'No task(s) selected for restoring...'=>'Nie zaznaczono zadań do odtworzenia...',  # line 1862
'Select some task(s) to mark as completed'=>'Zaznacz zadania do zmiany statusu na zakończony',  # line 1881
'Marked %s tasks (%s subtasks) as completed.'=>'Oznaczono %s zadań (%s podzadań) jako zakończone.',  # line 1930
'%s error(s) occured'         =>'Wystąpiły błędy. Liczba błędów: %s',  # line 2031
'Select some task(s) to mark as approved'=>'Zaznacz zadania do zmiany statusu na zaakceptowany',  # line 1951
'Marked %s tasks as approved and hidden from project-view.'=>'Oznaczono %s zadań jako zaakceptowane, które po zmianie statusu nie są wyświetlane w widoku projektu.',  # line 1977
'Select some task(s)'         =>'Zaznacz zadania',  # line 1997
'could not update task'       =>'nie można zmodyfikować zadania',  # line 2019
'No task selected to add issue-report?'=>'Nie zaznaczono zadania do dodania raportu zdarzenia?',  # line 2050
'Task already has an issue-report'=>'Zadanie posiads już raport zdarzenia',  # line 2054
'Adding issue-report to task' =>'Dodanie raportu zdarzenia do zadania',  # line 2070
'Could not get task'          =>'Nie znaleziono zadania',  # line 2076
'Select a task to edit description'=>'Zaznacz zadanie w celu edycji jego opisu',  # line 2097

### ../render/render_form.inc.php   ###
'Please use Wiki format'      =>'Używaj przoszę formatu Wiki',  # line 310
'Submit'                      =>'Zatwierdź',  # line 423
'Cancel'                      =>'Anuluj',  # line 447
'Apply'                       =>'Zastosuj',  # line 457

### ../render/render_list.inc.php   ###
'for milestone %s'            =>'do kamienia milowego %s',  # line 176
'changed today'               =>'zmiany dzisiaj',  # line 290
'changed since yesterday'     =>'zmiany od wczoraj',  # line 293
'changed since <b>%d days</b>'=>'zmiany od <b>%d dni</b>',  # line 296
'changed since <b>%d weeks</b>'=>'zmiany od <b>%d tygodni</b>',  # line 299
'created by %s'               =>'utworzone przez %s',  # line 555
'created by unknown'          =>'utworzone przez nieznanego',  # line 558
'modified by %s'              =>'zmienione przez %s',  # line 581
'modified by unknown'         =>'zmienione przez nieznanego',  # line 584
'item #%s has undefined type' =>'pozycja #%s posiada niezdefinowany typ',  # line 607
'do...'                       =>'wybierz...',  # line 833

### ../render/render_list_column_special.inc.php   ###
'Tasks|short column header'   =>'Zadania',  # line 226
'Number of open tasks is hilighted if shown home.'=>'Liczba otwartych zadań jest podświetlona, gdy wyświetlana jest strona startowa.',  # line 227
'S|Short status column header'=>'S',  # line 273
'Status is %s'                =>'Status jest %s',  # line 292
'Item is publish to'           =>'Pozycja jest opublikowana do',  # line 327
'Pub|column header for public level'=>'Pub',  # line 328
'Publish to %s'                =>'Opublikuj do %s',  # line 344

### ../render/render_page.inc.php   ###
'<span class=accesskey>H</span>ome'=>'Start (<span class=accesskey>H</span>ome)',  # line 220
'Go to your home. Alt-h / Option-h'=>'Przejdź na twoją stronę startową. Alt-h / Option-h',  # line 223
'<span class=accesskey>P</span>rojects'=>'<span class=accesskey>P</span>rojekty',  # line 227
'People'                      =>'Osoby',  # line 234
'Your related People'         =>'Osoby powiązane z tobą',  # line 235
'Companies'                   =>'Firmy',  # line 240
'Your related Companies'      =>'Firmy powiązane z tobą',  # line 241
'Calendar'                    =>'Kalendarz',  # line 246
'Home|section'                =>'Home|section',  # line 247
'<span class=accesskey>S</span>earch:&nbsp;'=>'<span class=accesskey>S</span>zukaj:&nbsp;',  # line 251
'Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`'=>'Kliknij na polu edycji w wpisz wyszukiwaną frazę* lub ID i wciśnij Enter.\nUżyj skrótu ALT-S (lewy AlT).\nWykrzyknik na końcu wyszukiwanej frazy przeskakuje do najlepszego wyniku.',  # line 254
'This page requires java-script to be enabled. Please adjust your browser-settings.'=>'Ta strona wymaga włączonej obsługi Java Script. Zmień proszę ustawienia swojej przeglądarki webowej.',  # line 549
'Add Now'                     =>'Dodatj teraz',  # line 588
'Edit'                        =>'Edytuj',  # line 589
'you are'                     =>'jesteś',  # line 635
'Profile'                     =>'Profil',  # line 639
'Logout'                      =>'Wylogowanie',  # line 641
'Return to normal view'       =>'Powrót do normalnego widoku',  # line 649
'Leave Client-View'           =>'Opuszczene widoku klienta',  # line 649
'How this page looks for clients'=>'Jak ta strona wygląda dla klienta',  # line 661
'Client view'                 =>'Widok klienta',  # line 661
'Documentation and Discussion about this page'=>'Dokumentacja i dyskusja dotyczące tej strony',  # line 881
'Help'                        =>'Pomoc',  # line 883

### ../render/render_wiki.inc.php   ###
'Update|wiki change marker'   =>'Zmiana|wiki change marker',  # line 224
'New|wiki change marker'      =>'Nowe|wiki change marker',  # line 230
'Deleted|wiki change marker'  =>'Usunięte|wiki change marker',  # line 236
'from'                        =>'od',  # line 318
'enlarge'                     =>'powiększenie',  # line 665
'Unknown File-Id:'            =>'Nieznane ID pliku',  # line 677
'Unknown project-Id:'         =>'Nieznane ID projektu',  # line 687
'Wiki-format: <b>$type</b> is not a valid link-type'=>'Format Wiki: <b>$type</b> nie jest prawidłowym typem odnośnika',  # line 734
'Read more about %s.'         =>'Przeczytaj więcej o %s',  # line 735
'No task matches this name exactly'=>'Żadne zadanie nie posiada dokładnie takiej samej nazwy',  # line 781
'This task seems to be related'=>'To zadanie wygląda na powiązane',  # line 782
'No item excactly matches this name.'=>'Żadne pozycja nie posiada dokładnie takiej samej nazwy',  # line 809
'List %s related tasks'       =>'Lista %s powiązanych zadań',  # line 810
'identical'                   =>'identyczne',  # line 818
'No item matches this name. Create new task with this name?'=>'Żadna pozycja nie odpowiada tej nazwie. Utworzyć nowe zadanie z tą nazwą?',  # line 850
'No item matches this name.'  =>'Żadna pozycja nie odpowiada tej nazwie.',  # line 828
'No item matches this name'   =>'Żadna pozycja nie odpowiada tej nazwie',  # line 875
'Image details'               =>'Szczgóły obrazka',  # line 952
'Cannot link to item of type %s'=>'Nie można utworzyć odnośnika do pozycji typu: %s',  # line 1025
'Wiki-format: <b>%s</b> is not a valid link-type'=>'Format Wiki: <b>%s</b> nie jest prawidłowym typem odnośnika',  # line 1037
'Item #%s is not an image'    =>'Pozycja #%s nie jest obrazkiem',  # line 1131
'No item matches this name...'=>'Nie znaleziono żadnej pozycji o takiej nazwie...',  # line 1204
'Unkwown item %s'             =>'Nieznana pozycja %s',  # line 1220
'Cannot link to item #%s of type %s'=>'Nie można utworzyć odnośnika do pozycji %s o typie %s',  # line 1281
'Unknown Item Id'             =>'Nieznana pozycja ID',  # line 1283
'Warning: Could not find wiki chapter'=>'Uwaga: Nie można znaleźć rozdziału wiki',  # line 1901

### ../std/class_auth.inc.php   ###
'Fresh login...'              =>'Nowy login...',  # line 45
'Cookie is no longer valid for this computer.'=>'Ciasteczko (cookie) nie jest dłużej ważne dla tego komputera.',  # line 52
'Your IP-Address changed. Please relogin.'=>'Twój adres IP zmienił się. Zaloguj się ponownie.',  # line 58
'Your account has been disabled. '=>'Twoje konto zostało wyłączone.',  # line 64
'Could not set cookie.'       =>'Nie można zapisać ciasteczka.',  # line 205

### ../std/class_pagehandler.inc.php   ###
'WARNING: operation aborted (%s)'=>'OSTRZEŻENIE: Operacja przerwana (%s).',  # line 588
'FATAL: operation aborted with an fatal error (%s).'=>'KRYTYCZNE: Operacja przerwana z błędem krytycznym (%s).',  # line 594
'Error: insufficient rights'    =>'BŁĄD: Niewystarczające uprawnienia.',  # line 597
'FATAL: operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'KRYTYCZNE: Operacja przerwana z krytycznym błędem struktury bazy danych (%s). Może to doprowadzić do utraty spójności bazy danych. Sugerujemy przywrócenie bazy danych do ostatniej wersji kopii (archiwum) bazy danych.',  # line 600
'NOTE: %s|Message when operation aborted'=>'UWAGA: %s',  # line 603
'ERROR: %s|Message when operation aborted'=>'BŁĄD: %s',  # line 606

### ../std/common.inc.php   ###
'No element selected? (could not find id)|Message if a function started without items selected'=>'Żaden element nie został zaznaczony? (nie można znaleźć ID)',  # line 294

### ../std/constant_names.inc.php   ###
'template|status name'        =>'szablon',  # line 17
'undefined|status_name'       =>'niezdefiniowane',  # line 18
'upcoming|status_name'        =>'nadchodzące',  # line 19
'new|status_name'             =>'nowe',  # line 20
'open|status_name'            =>'otwarte',  # line 21
'blocked|status_name'         =>'zablokowane',  # line 22
'done?|status_name'           =>'zakończone?',  # line 23
'approved|status_name'        =>'zaakceptowane',  # line 24
'closed|status_name'          =>'zamknięte',  # line 25
'undefined|pub_level_name'    =>'niezdefiniowane',  # line 32
'Member|profile name'         =>'Członek zespołu',  # line 32
'private|pub_level_name'      =>'prywatne',  # line 33
'Admin|profile name'          =>'Administrator',  # line 33
'Project manager|profile name'=>'Menedżer projektu',  # line 34
'suggested|pub_level_name'    =>'sugerowane',  # line 34
'Developer|profile name'      =>'Programista',  # line 35
'internal|pub_level_name'     =>'wewnętrzne',  # line 35
'Artist|profile name'         =>'Artysta',  # line 36
'open|pub_level_name'         =>'otwarte',  # line 36
'Tester|profile name'         =>'Tester',  # line 37
'client|pub_level_name'       =>'klient',  # line 37
'Client|profile name'         =>'Klient',  # line 38
'client_edit|pub_level_name'  =>'klient - edycja',  # line 38
'Client trusted|profile name' =>'Klient zaufany',  # line 39
'assigned|pub_level_name'     =>'przypisane',  # line 39
'Guest|profile name'          =>'Gość',  # line 40
'owned|pub_level_name'        =>'posiadane',  # line 40
'priv|short for public level private'=>'pryw.',  # line 47
'int|short for public level internal'=>'wewn.',  # line 49
'pub|short for public level client'=>'pub.',  # line 51
'PUB|short for public level client edit'=>'PUB.',  # line 52
'A|short for public level assigned'=>'S',  # line 53
'O|short for public level owned'=>'O',  # line 54
'Create projects|a user right'=>'Dodawanie projektów',  # line 62
'Edit projects|a user right'  =>'Edycja projektów',  # line 63
'Delete projects|a user right'=>'Usunięcie projektów',  # line 64
'Edit project teams|a user right'=>'Edycja zespołu projektu',  # line 65
'View anything|a user right'  =>'Wyświetlanie wszystkiego',  # line 66
'Edit anything|a user right'  =>'Edytowanie wszystkiego',  # line 67
'Create Persons|a user right' =>'Dodawanie osób',  # line 69
'Create & Edit Persons|a user right'=>'Tworzenie i edycja osób',  # line 70
'Delete Persons|a user right' =>'Usuwanie osób',  # line 71
'View all Persons|a user right'=>'Wyświetlanie wszystkich osób',  # line 72
'Edit user rights|a user right'=>'Edycja uprawnienia użytkownika',  # line 73
'Edit own profile|a user right'=>'Edycja własnego profilu',  # line 74
'Enable Efforts|Project setting'=>'Włącz wysiłki',  # line 74
'Enable Milestones|Project setting'=>'Włącz kamienie milowe',  # line 75
'Enable Versions|Project setting'=>'Włącz wydania',  # line 76
'Create Companies|a user right'=>'Dodawanie firm',  # line 76
'Edit Companies|a user right' =>'Edycja firm',  # line 77
'Enable Bugreports|Project setting'=>'Włącz raporty błędów',  # line 77
'Only PM may close tasks|Project setting'=>'Tylko Menedżer projektu może zamknąć zadanie',  # line 77
'Delete Companies|a user right'=>'Usuwanie firm',  # line 78
'Enable tasks|Project setting'=>'Włącz zadania|Project setting',  # line 74
'Enable files|Project setting'=>'Włącz pliki|Project setting',  # line 75
'Enable efforts|Project setting'=>'Włącz wysiłki|Project setting',  # line 76
'Enable milestones|Project setting'=>'Włącz kamienie milowe|Project setting',  # line 77
'Enable versions|Project setting'=>'Włącz wersje|Project setting',  # line 78
'Enable bugreports|Project setting'=>'Włącz raporty błędów|Project setting',  # line 79
'Enable news|Project setting' =>'Włącz aktualności|Project setting',  # line 80
'undefined|priority'          =>'niezdefiniowany',  # line 84
'urgent|priority'             =>'najwyższy',  # line 85
'high|priority'               =>'wysoki',  # line 86
'normal|priority'             =>'normalny',  # line 87
'lower|priority'              =>'niski',  # line 88
'lowest|priority'             =>'najniższy',  # line 89
'Project'                     =>'Projekt',  # line 98
'Task'                        =>'Zadanie',  # line 99
'Person'                      =>'Osoba',  # line 100
'Team Member'                 =>'Członek zaspołu',  # line 101
'Company'                     =>'Firma',  # line 102
'Employment'                  =>'Zatrudnienie',  # line 103
'Issue'                       =>'Zdarzenie',  # line 104
'View all Companies|a user right'=>'Wyświetl wszystkie firmy|a user right',  # line 104
'Effort'                      =>'Wysiłek',  # line 106
'Comment'                     =>'Komentarz',  # line 107
'File'                        =>'Plik',  # line 108
'Task assignment'             =>'Przypisanie zadania',  # line 109
'undefined'                   =>'niezdefiniowany',  # line 115
'Nitpicky|severity'           =>'Bez znaczenia',  # line 116
'Feature|severity'            =>'Cecha',  # line 117
'Trivial|severity'            =>'Trywialna',  # line 118
'Text|severity'               =>'Tekst',  # line 119
'Tweak|severity'              =>'Usprawnienie',  # line 120
'Minor|severity'              =>'Niska',  # line 121
'Major|severity'              =>'Duża',  # line 122
'Crash|severity'              =>'Krytyczna',  # line 123
'Block|severity'              =>'Blokująca',  # line 124
'Not available|reproducabilty'=>'Nie dotyczy',  # line 129
'Always|reproducabilty'       =>'Zawsze',  # line 130
'Sometimes|reproducabilty'    =>'Czasami',  # line 131
'Have not tried|reproducabilty'=>'Nie była sprawdzana',  # line 132
'Unable to reproduce|reproducabilty'=>'Nie udaje się zreprodukować',  # line 133
'done|Resolve reason'         =>'zakończone',  # line 154
'fixed|Resolve reason'        =>'poprawione',  # line 155
'works_for_me|Resolve reason' =>'działa u mnie',  # line 156
'duplicate|Resolve reason'    =>'zduplikowane',  # line 157
'bogus|Resolve reason'        =>'w założeniach błędne',  # line 158
'rejected|Resolve reason'     =>'odrzucone',  # line 159
'deferred|Resolve reason'     =>'odroczone',  # line 160
'Not defined|release type'    =>'niezdefiniowana',  # line 166
'Not planned|release type'    =>'nieplanowana',  # line 167
'upcoming|release type'      =>'nadchodząca',  # line 168
'Internal|release type'       =>'wewnętrzna',  # line 169
'Public|release type'         =>'publiczna',  # line 170
'Without support|release type'=>'bez wsparcia',  # line 171
'No longer supported|release type'=>'dalej nie wspierana',  # line 172
'undefined|company category'  =>'niezdefiniowana',  # line 178
'client|company category'     =>'klient',  # line 179
'Upcomming|release type'      =>'Nadchodzące|release type',  # line 179
'prospective client|company category'=>'klient potencjalny',  # line 180
'supplier|company category'   =>'dostawca',  # line 181
'partner|company category'    =>'partner',  # line 182
'undefined|person category'   =>'niezdefiniowana',  # line 188
'- employee -|person category'=>'- pracownicy -',  # line 189
'staff|person category'       =>'pracownik',  # line 190
'freelancer|person category'  =>'freelancer',  # line 191
'working student|person category'=>'student pracujący',  # line 192
'apprentice|person category'  =>'praktykant',  # line 193
'intern|person category'      =>'stażysta',  # line 194
'ex-employee|person category' =>'były pracownik',  # line 195
'- contact person -|person category'=>'- osoba kontaktowa -',  # line 196
'client|person category'      =>'klient',  # line 197
'prospective client|person category'=>'klient potencjalny',  # line 198
'supplier|person category'    =>'dostawca',  # line 199
'partner|person category'     =>'partner',  # line 200
'Task|Task Category'          =>'Zadanie',  # line 213
'Bug|Task Category'           =>'Błąd',  # line 214
'Documentation|Task Category' =>'Dokumentacja',  # line 214
'Folder|Task Category'        =>'Folder',  # line 215
'Event|Task Category'         =>'Wydarzenie',  # line 216
'Milestone|Task Category'     =>'Kamień milowy',  # line 218
'Version|Task Category'       =>'Wersja',  # line 219
'Topic|Task Category'         =>'Temat|Task Category',  # line 220
'ASAP|notification period'    =>'ASAP|notification period',  # line 231
'never|notification period'   =>'nigdy',  # line 225
'one day|notification period' =>'1 dzień',  # line 226
'two days|notification period'=>'2 dni',  # line 227
'three days|notification period'=>'3 dni',  # line 228
'four days|notification period'=>'4 dni',  # line 229
'five days|notification period'=>'5 dni',  # line 230
'one week|notification period'=>'1 tydzień',  # line 231
'two weeks|notification period'=>'2 tygodnie',  # line 232
'three weeks|notification period'=>'3 tygodnie',  # line 233
'one month|notification period'=>'1 miesiąc',  # line 234
'two months|notification period'=>'2 miesiące',  # line 235
'new|effort status'           =>'nowy',  # line 240
'open|effort status'          =>'otwarty',  # line 241
'discounted|effort status'    =>'upust',  # line 242
'not chargeable|effort status'=>'nie obciążający',  # line 243
'balanced|effort status'      =>'obciążający',  # line 244

### ../conf/defines.inc.php   ###
'autodetect'                  =>'autodetekcja',  # line 295

### ../pages/version.inc.php   ###
'New Version'                 =>'Nowa wersja',  # line 32

### ../std/common.inc.php   ###
'only one item expected.'     =>'spodziewana tylko jedna pozycja.',  # line 345

### ../render/render_list_column_special.inc.php   ###
'Status|Short status column header'=>'Status',  # line 273
'Item is published to'        =>'Pozycja opublikowana do',  # line 330
'Select / Deselect'           =>'Zaznacz / Odznacz',  # line 364

### ../pages/company.inc.php   ###
'Clients'                     =>'Klienci',  # line 115
'related companies of %s'     =>'firmy powiązane z %s',  # line 354
'Prospective Clients'         =>'Klienci potencjalni',  # line 195
'Suppliers'                   =>'Dostawcy',  # line 274
'Partners'                    =>'Partnerzy',  # line 352

### ../render/render_form.inc.php   ###
'Wiki format'                 =>'Format Wiki',  # line 323

### ../render/render_misc.inc.php   ###
'With Account|page option'    =>'Z kontem',  # line 180
'All Persons|page option'     =>'Wszystkie osoby',  # line 186
'Companies|page option'       =>'Firmy',  # line 239
'Issues'                      =>'Zdarzenia',  # line 260
'Tasks|Project option'        =>'Zadania',  # line 265
'Completed|Project option'    =>'Zakończone',  # line 270
'Milestones|Project option'   =>'Kamienie milowe',  # line 276
'Files|Project option'        =>'Pliki',  # line 281
'Efforts|Project option'      =>'Wysiłki',  # line 287
'History|Project option'      =>'Historia',  # line 292
'Versions|Project option'     =>'Wydania',  # line 328
'Versions|Project option'     =>'Wersje',  # line 330
'Docu|Project option'         =>'Dokumentacja',  # line 336
'Other Persons|page option'   =>'Inne osoby',  # line 365
'Employees|page option'       =>'Pracownicy',  # line 369
'Contact Persons|page option' =>'Osoby kontaktowe',  # line 373
'Deleted|page option'         =>'Usunięte',  # line 377
'All Companies|page option'   =>'Wszystkie firmy',  # line 388
'Clients|page option'         =>'Klienci',  # line 392
'Prospective Clients|page option'=>'Klienci potencjalni',  # line 396
'Suppliers|page option'       =>'Dostawcy',  # line 400
'Partners|page option'        =>'Partnerzy',  # line 404
'Today'                       =>'Dzisiaj',  # line 457
'Yesterday'                   =>'Wczoraj',  # line 460
'new since last logout'       =>'nowości od ostatniego wylogowania',  # line 490
'without client|short for client'=>'bez klienta|short for client',  # line 539
'%b %e, %Y|strftime format string'=>'%Y-%m-%d',  # line 579
'%I:%M%P|strftime format string'=>'%H:%M',  # line 592
'%a %b %e, %Y %I:%M%P|strftime format string'=>'%Y-%m-%d %H:%M',  # line 601
'Topics|Project option'       =>'Tematy|Project option',  # line 616
'Persons|page option'         =>'Osoby',  # line 619
'Calculation|Project option'  =>'Kalkulacja|Project option',  # line 657
'Changes|Project option'      =>'Zmiany|Project option',  # line 665
'%s min'                      =>'%s min',  # line 696
'%s hours'                    =>'%s godzin',  # line 711
'%s days'                     =>'%s dni',  # line 715
'%s weeks'                    =>'%s tygodni',  # line 719
'%s hours max'                =>'%s godzin maks.',  # line 749
'%s days max'                 =>'%s dni maks.',  # line 759
'%s weeks max'                =>'%s tygodni maks.',  # line 770
'%A, %B %e|strftime format string'=>'%Y-%m-%d',  # line 921
'%s min ago'                  =>'%s min temu',  # line 967
'1 hour ago'                  =>'1 h temu',  # line 970
'%s hours ago'                =>'%s h temu',  # line 973
'%s days ago'                 =>'%s dni temu',  # line 977
'%s months ago'               =>'%s miesięcy temu',  # line 980
'never'                       =>'nigdy',  # line 1015
'just now'                    =>'teraz',  # line 1019
'%smin ago'                   =>'%smin temu',  # line 1022
'%sh ago'                     =>'%sh temu',  # line 1028
'%s years ago'                =>'%s lat/lata temu',  # line 1039

### ../lists/list_versions.inc.php   ###
'Released Milestone'          =>'Wydany kamień milowy',  # line 183

### ../lists/list_comments.inc.php   ###
'New Comment'                 =>'Nowy komentarz',  # line 39

### ../lists/list_changes.inc.php   ###
'Last of %s comments:'        =>'Ostatnie %s komentarze:',  # line 218
'Approve Task'                =>'Zaakceptuj zadanie',  # line 243
'renamed'                     =>'nazwa zmieniona',  # line 273
'edit wiki'                   =>'edycja wiki',  # line 276
'assigned'                    =>'przypisane',  # line 329
'attached'                    =>'załączone',  # line 348
'attached file to'            =>'plik załączony do',  # line 358

### ../lists/list_companies.inc.php   ###
'Company|Column header'       =>'Firma',  # line 115

### ../lists/list_versions.inc.php   ###
'Release Date'                =>'Data wydania',  # line 243

### ../lists/list_versions.inc.php   ###
'%s required'                 =>'%s wymagane',  # line 265

### ../lists/list_persons.inc.php   ###
'Nickname|column header'      =>'Nick',  # line 202
'Name|column header'          =>'Nazwisko',  # line 223

### ../pages/company.inc.php   ###
'Remove person from company'  =>'Usunięcie osoby z firmy',  # line 572

### ../render/render_page.inc.php   ###
'Register'                    =>'Zarejestrowanie',  # line 648

### ../pages/version.inc.php   ###
'Edit Version|page type'      =>'Edycja wersji',  # line 79
'Edit Version|page title'     =>'Edycja wersji',  # line 88
'New Version|page title'      =>'Nowa wersja',  # line 91
'Could not get version'       =>'Nie znaleziono wersji',  # line 148
'Could not get project of version'=>'Nie znaleziono projektu dla wersji',  # line 164
'Select some versions to delete'=>'Zaznacz wersje do usunięcia',  # line 229
'Failed to delete %s versions'=>'Usunięcie %s wersji nie powiodło się',  # line 248
'Moved %s versions to dumpster'=>'Przeniesiono %s wersji do kosza',  # line 251
'Version|page type'           =>'Wersja',  # line 287
'Edit this version'           =>'Edycja wersji',  # line 308

### ../pages/task_more.inc.php   ###
'Parent task not found.'      =>'Nie znaleziono zadania nadrzędnego.',  # line 162
'New version'                 =>'Nowa wersja',  # line 331
'Select some task(s) to edit' =>'Zaznacz zadania do edycji',  # line 367
'You do not have enough rights to edit this task'=>'Nie posiadasz wystarczających uprawnień do edycji tego zadania',  # line 375
'New milestone'               =>'Nowy kamień milowy',  # line 407
'next released version' => 'najbliższa wydana wersja',  # line 457
'Display as'                  =>'Wyświetlaj jako',  # line 486
'This folder has %s subtasks. Changing category will ungroup them.'=>'Ten folder posiada %s podzadania/podzadań. Zmiana jego kategorii spowoduje rozgrupowanie ich.',  # line 490
'Release as version|Form label, attribute of issue-reports'=>'Wydanie jako wersja',  # line 605
'Bug Report'                  =>'Raport błędów',  # line 698
'Reproducibility|Form label, attribute of issue-reports'=>'Powtarzalność',  # line 719
'Internal'                    =>'Wewnętrzne',  # line 733
'Create another task after submit'=>'Utworzenie następnego zadania po zatwierdzeniu',  # line 743
'Timing'                      =>'Planowanie czasu',  # line 761
'Invalid checksum for hidden form elements'=>'Nieprawidłowa suma kontrolna ukrytych pól elementów formularza',  # line 781
'Display'                     =>'Wyświetlanie',  # line 813
'Failed to add comment'       =>'Dodanie komentarza nie powiodło się',  # line 839
'Comment has been rejected, because it looks like spam.'=>'Komentarz został odrzucony, gdyż wygląda jak spam.',  # line 844
'Not enough rights to edit task'=>'Brak wystarczających uprawnień do edycji zadania',  # line 870
'Nickname not known in this project: %s'=>'Nick nie jest znany w tym projekcie: %s',  # line 894
'Requested feedback from: %s.'=>'Wymagana reakcja ze strony: %s',  # line 899
'Task called %s already exists'=>'Task o nazwie %s istnieje już',  # line 1089
'Because task is resolved, its status has been changed completed.'=>'Ponieważ zadanie zostąło rozwiązane, jego status został zmieniony na zakończone.',  # line 1162
'Task has resolved version but is not completed?'=>'Zadanie ma oznaczenie, że jest rozwiązane w kontretnej wersji, a nie jest zakończone?',  # line 1168
'Because task is resolved, its status has been changed to completed.'=>'Ponieważ zadanie zostąło rozwiązane, jego status został zmieniony na zakończone.',  # line 1234
'Changed task %s with ID %s'  =>'Zmieniono zadanie %s o ID %s',  # line 1244
'Milestones may not have sub tasks'=>'Kamienie milowe nie mogą posiadać podzadań',  # line 1261
'Marked %s tasks to be resolved in this version.'=>'Zaznaczono %s zadań do realizacji w tej wersji',  # line 1262
'Changed %s %s with ID %s|type,link,id'=>'Zmienione %s %s z ID %s',  # line 1359
'Failed to delete task %s'    =>'Usunięcie zadania %s nie powiodło się',  # line 1538
'Select some task(s) to reopen'=>'Zaznacz zadania do ponownego otwarcia',  # line 1764
'Reopened %s tasks.'          =>'Zadania %s ponownie otwarte',  # line 1782
'Could not update task'       =>'Modyfikacja zadania nie powiodła się',  # line 1821
'Could not find task'         =>'Znalezienie zadania nie powiodło się',  # line 1872
'Select some task(s) to mark as closed'=>'Zaznacz zadania do zmiany statusu na zamknięty',  # line 1906
'Marked %s tasks as closed.'  =>'Oznaczono %s zadań jako zamknięte.',  # line 1926
'Not enough rights to close %s tasks.'=>'Brak wystarczających uprawnień do zamknięcia %s zadań.',  # line 1928
'Task Efforts'                =>'Wysiłki zadania',  # line 2027
'changes'                     =>'zmiany',  # line 2141
'View task'                   =>'Wyświetlenie zadania',  # line 2154
'date1 should be smaller than date2. Swapped'=>'data 1 powinna być mniejsza, niż data 2. Zamienione',  # line 2168
'item has not been edited history'=>'pozycja nie ma historii edycji',  # line 2178
'unknown'                     =>'niewiadome',  # line 2256
' -- '                        =>'--',  # line 2278
'prev change'                 =>'poprzednia zmiana',  # line 2290
'next'                        =>'następna',  # line 2306
'summary'                     =>'podsumowanie',  # line 2320
'Item did not exists at %s'   =>'Pozycja nie istnieje w %s',  # line 2352
'no changes between %s and %s'=>'brak zmian pomiędzy %s, a %s',  # line 2355
'ok'                          =>'ok',  # line 2449
'For editing all tasks must be of same project.'=>'Aby móc edytować zadania, wszystkie muszą należeć do tego samego projektu.',  # line 2640
'Edit multiple tasks|Page title'=>'Edycja wielu zadań',  # line 2663
'Edit %s tasks|Page title'    =>'Edycja %s zadań',  # line 2665
'-- keep different --'        =>'-- pozostaw różne --',  # line 2700
'Prio'                        =>'Priorytet',  # line 2750
'Category'                    =>'Kategoria',  # line 2768
'select person'               =>'zaznacz osobę',  # line 2878
'Also assigned to'            =>'Przypisane również do',  # line 2879
'none'                        =>'brak',  # line 2784
'resolved in Version'         =>'zrealizowane w wersji',  # line 2795
'keep different'              =>'pozostaw różne',  # line 2810
'Resolve Reason'              =>'Powód realizacji',  # line 2814
'%s tasks could not be written'=>'Zapisanie %s nie powiodło się',  # line 2975
'Updated %s tasks tasks'      =>'Zmodyfikowano %s zadania/zadań',  # line 2978
'ERROR: could not get Person' =>'BŁĄD: nie znaleziono osoby',  # line 3125
'Select a note to edit'       =>'Zaznacz notę do edycji',  # line 3116
'Note'                        =>'Nota',  # line 3143
'Create new note'             =>'Utworzenie nowej noty',  # line 3146
'New Note on %s, %s'          =>'Nowa nota do %s, %s',  # line 3152
'Publish to|Form label'       =>'Opublikowane w',  # line 3181
'Assigned Projects'           =>'Przypisane projekty',  # line 3214
'- no assigend projects'      =>'- nie przypisano projektów',  # line 3210
'Company Projects'            =>'Projekty firmy',  # line 3236
'- no company projects'       =>'- brak projektów firmy',  # line 3226
'All other Projects'          =>'Wszystkie pozostałe projekty',  # line 3254
'- no other projects'         =>'- brak innych projektów',  # line 3251
'For Project|form label'      =>'Do projektu',  # line 3260
'New project|form label'      =>'Nowy projekt',  # line 3265
'Project name|form label'     =>'Nazwa projektu',  # line 3266
'ERROR: could not get assigned persons'=>'BŁĄD: nie znaleziono przypisanych osób',  # line 3282
'Also assign to'              =>'Przypisz również do',  # line 3318
'Book effort after submit'    =>'Rejestracja wysiłków po wprowadzeniu',  # line 3322
'ERROR: could not get task'   =>'BŁĄD: nie znaleziono zadania',  # line 3362
'Note requires project'       =>'Nota wymaga projektu',  # line 3414
'Note requires assigned person(s)'=>'Nota wymaga przypisanych osób',  # line 3418
'ERROR: could not get project'=>'BŁĄD: znalezienie projektu nie powiodło się',  # line 3461
'Created task %s with ID %s'  =>'Utworzono zadanie %s o ID %s',  # line 3598

### ../pages/effort.inc.php   ###
'Select one or more efforts'  =>'Zaznacz jeden lub więcej wysiłków',  # line 197
'You do not have enough rights'=>'Twoje uprawnienia są niewystarczające',  # line 231
'Effort of task|page type'    =>'Wysiłek zadania',  # line 67
'Edit this effort'            =>'Edycja wysiłku',  # line 85
'Project|label'               =>'Projekt',  # line 332
'Task|label'                  =>'Zadanie',  # line 349
'No task related'             =>'Brak powiązanych zadań',  # line 349
'Created by|label'            =>'Utworzone przez',  # line 356
'Created at|label'            =>'Utworzone w',  # line 362
'Duration|label'              =>'Czas trwania',  # line 368
'Time start|label'            =>'Czas - start',  # line 366
'Time end|label'              =>'Czas - koniec',  # line 367
'No description available'    =>'Brak opisu ',  # line 404
'Multiple Efforts|page type'  =>'Wiele wysiłków',  # line 244
'Multiple Efforts'            =>'Wiele wysiłków',  # line 265

### ../pages/effort.inc.php   ###
'Information'                 =>'Informacja',  # line 281
'Number of efforts|label'     =>'Liczba wysiłków',  # line 290
'Sum of efforts|label'        =>'Suma wysiłków',  # line 294
'from|time label'             =>'od',  # line 301
'to|time label'               =>'do',  # line 302
'Time|label'                  =>'Czas',  # line 306
'Failed to delete %s efforts' =>'Usunięcie %s wysiłku/wysiłków nie powiodło się',  # line 833

### ../lists/list_files.inc.php   ###
'Parent item'                 =>'Pozycja nadrzędna',  # line 39
'Size'                        =>'Wielkość',  # line 88
'New file'                    =>'Nowy plik',  # line 117
'Move files'                  =>'Przeniesienie plików',  # line 119
'No files uploaded'           =>'Żaden plik nie został wgrany',  # line 198
'Download|Column header'      =>'Pobierz',  # line 241
'Name|Column header'          =>'Nazwa',  # line 264
'File|Column header'          =>'Plik',  # line 297
'in|... folder'               =>'w',  # line 334
'ID %s'                       =>'ID %s',  # line 450
'Show Details'                =>'Wyświetl szczegóły',  # line 452
'Attached to|Column header'   =>'Załączone do',  # line 376
'Summary|Column header'       =>'Podsumowanie',  # line 407
'Thumbnail|Column header'     =>'Minitura',  # line 468
'creatd on %s|date a file was created'=>'utworzony %s|date a file was created',  # line 453
'click to show details'       =>'kliknij aby wyświetlić szczegóły',  # line 458
'by %s|person who uploaded a file'=>'przez %s|person who uploaded a file',  # line 461

### ../lists/list_comments.inc.php   ###
'Add Comment'                 =>'Dodanie komentarza',  # line 41
'Shrink All Comments'         =>'Zwinięcie wszystkich komentarzy',  # line 53
'Collapse All Comments'       =>'Zwinięcie wszystkich komentarzy',  # line 55
'Expand All Comments'         =>'Rozwinięcie wszystkich komentarzy',  # line 62
'Reply'                       =>'Odpowiedz',  # line 144
'Publish'                     =>'Opublikowane',  # line 147
'1 sub comment'               =>'1 podkomentarz',  # line 204
'%s sub comments'             =>'%s podkomentarzy',  # line 207

### ../pages/task_view.inc.php   ###
'Edit this %s'                =>'Edycja %s',  # line 77
'Edit this task %s'           =>'Edycja zadania %s',  # line 79
'edit'                       =>'edycja:',  # line 89
'Wiki'                        =>'Wiki',  # line 116
'Add Details|page function'   =>'Dodanie uszczegółowienia',  # line 185
'Move|page function to move current task'=>'Przenieś',  # line 193
'Mark this task as bookmark'  =>'Utwórz zakładkę do tego zadania',  # line 197
'View history of item'        =>'Pokaż historię zmian',  # line 222
'History'                     =>'Historia',  # line 223
'Released as|Label in Task summary'=>'Wydane jako',  # line 259
'For Milestone|Label in Task summary'=>'Do kamienia milowego',  # line 276
'Estimated|Label in Task summary'=>'Szacowany czas',  # line 290
'Completed|Label in Task summary'=>'Zakończone',  # line 299
'Created|Label in Task summary'=>'Utworzone',  # line 318
'Modified|Label in Task summary'=>'Zmienione',  # line 323
'Publish to|Label in Task summary'=>'Opublikowane w',  # line 348
'Set to Open'                 =>'Ustawienie statusu na Otwarte',  # line 350
'Further Documentation'       =>'Dalsza dokumentacja',  # line 383
'This task has no description. Doubleclick to edit.'=>'To zadanie nie ma opisu. Kliknij dwukrotnie aby dokonać edycji.',  # line 416
'Severity|label in issue-reports'=>'Waga',  # line 446
'Reproducibility|label in issue-reports'=>'Powtarzalność',  # line 453
'Sub tasks'                   =>'Podzadania',  # line 509
'Open tasks for milestone'    =>'Zadania otwarte do kamienia milowego',  # line 527
'No open tasks for this milestone'=>'Nie ma otwartych zadań dla tego kamienia milowego',  # line 530
'1 Comment'                   =>'1 komentarz',  # line 570
'%s Comments'                 =>'Komentarze (%s)',  # line 573
'Resolved tasks|Block title'  =>'Zrealizowane zadania',  # line 620
'Comment / Update'            =>'Operacje',  # line 637
'quick edit'                  =>'edycja podręczna',  # line 667
'next released version'       =>'najbliższej wydanej wersji',  # line 714
'Update'                      =>'Aktualizacja',  # line 728
'Public to'                   =>'Publiczny do',  # line 736
'Page'                        =>'Strona',  # line 1028
'New topic'                   =>'Nowy temat',  # line 1044
'Book Effort'                 =>'Zarejestruj wysiłek',  # line 1109
'View previous %s versions'   =>'Wyświetl zmiany (%s)',  # line 1112
'Your feedback is requested by %s.'=>'Twoja reakcja jest wymagana przez %s.',  # line 1176
'Please edit or comment this item.'=>'Proszę wyedytować lub skomentować tę pozycję.',  # line 1177
'This topic does not have any text yet.\nDoubleclick here to add some.'=>'Ten temat nie ma jeszcze żadnego tekstu.\nKliknij dwukrotnie aby dodać tekst.',  # line 1191
'Request feedback'            =>'Zażądaj reakcji',  # line 1275

### ../db/db.inc.php   ###
'Database exception. Please read %s next steps on database errors.%s'=>'Wystąpił wyjątek (błąd) w bazie danych. Proszę przeczytaj nstępne %s kroki związane z błędami bazy danych. %s',  # line 38

### ../db/db_item.inc.php   ###
'Unknown'                     =>'Nieznane',  # line 1298
'Item has been modified during your editing by %s (%s minutes ago). Your changes can not be submitted.'=>'Pozycja została zmodyfikowana przez %s podczas twojej edycji %s minutę/minut temu. Twoje zmiany nie mogą być zapisane.',  # line 1303

### ../lists/list_efforts.inc.php   ###
'%s effort(s) with %s hours'  =>'Liczba wysiłków: %s o łącznym czasie %s h',  # line 102
'Effort name. More Details as tooltips'=>'Nazwa wysiłku. Więcej szczegółów w tooltipie',  # line 116

### ../pages/company.inc.php   ###
'Person already related to company'=>'Osoba jest już powiązana z firmą',  # line 972
'Failed to remove %s contact person(s)'=>'Usunięcie %s osoby/osób nie powiodło się',  # line 1036
'Removed %s contact person(s)'=>'Liczba usuniętych osób kontaktowych: %s',  # line 1039
'Failed to delete %s companies'=>'Usunięcie %s firmy/firm nie powiodło się',  # line 1078

### ../render/render_fields.inc.php   ###
'<b>%s</b> is not a known format for date.'=>'<b>%s</b> nie jest znanym formatem daty.',  # line 307

### ../pages/projectperson.inc.php   ###
'Failed to remove %s members from team'=>'Usunięcie %s członka/członków zespołu nie powiodło się',  # line 291
'Unassigned %s team member(s) from project'=>'Usunięto %s członka/członków zespołu z projektu',  # line 294

### ../pages/item.inc.php   ###
'Select some items(s) to change pub level'=>'Zaznacz pozycje do zmiany pozimu dostępu publicznego',  # line 59
'itemsSetPubLevel requires item_pub_level'=>'itemsSetPubLevel wymaga item_pub_level',  # line 66
'Made %s items public to %s'  =>'Ustanowiono %s pozycję/pozycji publicznych do %s',  # line 84

### ../pages/search.inc.php   ###
'in'                          =>'w',  # line 350
'on'                          =>'dla',  # line 461
'cannot jump to this item type'=>'nie można przeskoczyć do pozycji tego typu',  # line 545
'jumped to best of %s search results'=>'Przeskoczono do najlepszej pozycji spośród %s wyników wyszukiwania',  # line 580
'Add an ! to your search request to jump to the best result.'=>'Dodaj ! (wykrzyknik) na końcu frazy wyszukiwanej aby automatycznie przeskoczyć do najlepszego wyniku wyszukiwania.',  # line 587
'%s search results for `%s`'  =>'Znaleziono %s raz(y) frazę `%s`',  # line 602
'No search results for `%s`'  =>'Nie znaleziono frazy `%s`',  # line 605

### ../std/class_auth.inc.php   ###
'Invalid anonymous user'      =>'Nieprawidłowy anionimowy użytkownik',  # line 94
'Anonymous account has been disabled. '=>'Konto anonimowe zostało wyłączone.',  # line 100
'Unable to automatically detect client time zone'=>'Nie można automatycznie wykryć strefy czasowej po stronie klienta.',  # line 262

### ../std/class_pagehandler.inc.php   ###
'Operation aborted (%s)'      =>'Operacja została przerwana (%s)',  # line 733
'Operation aborted with an fatal error (%s).'=>'Operacja została przerwana z błędem fatalnym (%s).',  # line 736
'Operation aborted with an fatal error which was cause by an programming error (%s).'=>'Operacja została przerwana z błędem fatalnym spowodowanym przez błąd oprogramowania (%s).',  # line 739
'insufficient rights'           =>'Niewystarczające uprawnienia',  # line 748
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'Operacja przerwana z krytycznym błędem struktury bazy danych (%s). Może to doprowadzić do utraty spójności bazy danych. Sugerujemy przywrócenie bazy danych do ostatniej wersji kopii (archiwum) bazy danych.',  # line 752

### ../pages/proj.inc.php   ###
'Documentation'               =>'Dokumentacja',  # line 1236

### ../pages/proj.inc.php   ###
'Export as CSV'               =>'Eksport do CSV',  # line 248
'Create a new page'           =>'Utworzenie nowej strony',  # line 1256
'Main Attributes'             =>'Atrybuty główne',  # line 1772
'Additional'                  =>'Dodatkowe',  # line 1791
'Settings'                    =>'Ustawienia',  # line 1801

### ../render/render_page.inc.php   ###
'rendered in'                 =>'utworzone przez',  # line 1253
'memory used'                 =>'użyta pamięć',  # line 1254
'querrying approx.'           =>'przejrzane ok.',  # line 1255
'db-fields'                   =>'pól bazy danych',  # line 1255

### ../pages/proj.inc.php   ###
'modified by me'              =>'zmienione przeze mnie',  # line 670
'modified by others'          =>'zmienione przez innych',  # line 695
'last logout'                 =>'od ostatniego wylogowania',  # line 720
'1 week'                      =>'1 tydzień',  # line 738
'2 weeks'                     =>'2 tygodnie',  # line 757

### ../pages/search.inc.php   ###
'Due to the implementation of MySQL following words cannot be searched and have been ignored: %s'=>'Z uwagi na ograniczenia bazy danych MySQL następujące frazy nie mogą byćwyszukiwane i są ignorowane: %s',  # line 653
'Sorry, but there is nothing left to search.'=>'Niestety nie pozostało nic do wyszukiwania.',  # line 658

### ../lists/list_efforts.inc.php   ###
'View selected Efforts'       =>'Wyświetlenie zaznaczonych wysiłków',  # line 71

### ../lists/list_bookmarks.inc.php   ###
'My bookmarks'                =>'Moje zakładki',  # line 32
'You have no bookmarks'       =>'Nie masz żadnych zakładek',  # line 33

### ../lists/list_bookmarks.inc.php   ###
'Modified by'                 =>'Zmodyfikowana przez',  # line 228

### ../pages/item.inc.php   ###
'No item(s) selected.'        =>'Żadna pozycja/pozycje nie zostały zaznaczone.',  # line 127
'Select one or more bookmark(s)'=>'Zaznacz jedną lub więcej zakładek',  # line 164
'Removed %s bookmark(s).'     =>'Usunięto %s zakładkę/zakładki.',  # line 180
'ERROR: Cannot remove %s bookmark(s). Please try again.'=>'BŁĄD: Usunięcie %s zakładki/zakładek nie powiodło się. Spróbuj proszę ponownie.',  # line 184

### ../render/render_page.inc.php   ###
'Go to parent / alt-U'        =>'Przejdź poziom wyżej / alt-U',  # line 875

### ../lists/list_bookmarks.inc.php   ###
'State'                       =>'Stan',  # line 299

### ../render/render_form.inc.php   ###
'Please copy the text'        =>'Proszę skopiuj tekst',  # line 62
'Sorry. To reduce the efficiency of spam bots, guests have to copy the text'=>'Przepraszamy. Aby zredukować wpisy przez tzw. spam boty goście muszą skopiować tekst.',  # line 64

### ../std/common.inc.php   ###
'Sorry, but the entered number did not match'=>'Niestety wprowadzony numer nie zgadza się z oczekiwanym.',  # line 236

### ../db/db_itemperson.inc.php   ###
'Comment|form label for items'=>'Komentarz',  # line 45

### ../lists/list_comments.inc.php   ###
'version %s'                  =>'wersja %s',  # line 140

### ../lists/list_bookmarks.inc.php   ###
'Your bookmarks'              =>'Twoje zakładki',  # line 32

### ../pages/item.inc.php   ###
'Edit bookmark'               =>'Edycja zakładki',  # line 399
'Notify on change'            =>'Powiadom o zmianie',  # line 421

### ../lists/list_bookmarks.inc.php   ###
'Remind'                      =>'Przypomnij',  # line 415
'in %s day(s)'                =>'za %s dzień/dni',  # line 464
'since %s day(s)'             =>'od %s dnia/dni',  # line 468

### ../lists/list_projectchanges.inc.php   ###
'Nothing has changed.'        =>'Nic nie zostało zmienione.',  # line 33

### ../pages/company.inc.php   ###
'Delete this company'         =>'Usuń firmę',  # line 510

### ../pages/custom_projView.inc.php   ###
'News'                        =>'Newsy',  # line 373
'%s comments'                 =>'%s komentarzy',  # line 397

### ../pages/custom_projViewFiles.inc.php   ###
'Downloads'                   =>'Pliki do ściągnięcia',  # line 62

### ../pages/item.inc.php   ###
'An error occured'            =>'Wystąpił błąd',  # line 318
'Edit bookmark: %s|Page title'=>'Edycja zakładki: %s',  # line 401
'Bookmark: %s'               =>'Zakładka: %s',  # line 402
'Notify if unchanged in'      =>'Powiadom, jeśli nie zmieniona w',  # line 423
'Could not get bookmark'      =>'Nie znaleziono zakładki',  # line 456

### ../std/common.inc.php   ###
'en_US.utf8,en_US,enu|list of locales'=>'pl_PL.UTF8,pl_PL,pl,plk,polish_pol,Polish_Poland.28592',  # line 482

### ../pages/version.inc.php   ###
'Bookmark'                    =>'Zakładka',  # line 321
'Remove this bookmark'        =>'Usuń tę zakładkę',  # line 328
'Remove Bookmark'             =>'Usuń zakładkę',  # line 329

### ../pages/company.inc.php   ###
'Mark this company as bookmark'=>'Utwórz zakładkę do tej firmy',  # line 510

### ../pages/effort.inc.php   ###
'Mark this effort as bookmark'=>'Utwórz zakładkę do tego wysiłku',  # line 97

### ../pages/item.inc.php   ###
'Edit bookmark: "%s"|page title'=>'Edycja zakładki: "%s"',  # line 365
'Bookmark: "%s"'              =>'Zakładka: "%s"',  # line 366
'Added %s bookmark(s).'       =>'Liczba dodanych zakładek: %s',  # line 813
'Edit bookmarks'              =>'Edycja zakładek',  # line 573
'Edit multiple bookmarks|page title'=>'Edycja wielu zakładek',  # line 575
'Edit %s bookmark(s)'         =>'Edycja %s zakładki/zakładek',  # line 576
'no'                          =>'nie',  # line 674
'yes'                         =>'tak',  # line 675
'Edited %s bookmark(s).'      =>'%s zakładek zostało wyedytowanych',  # line 817
'%s bookmark(s) could not be added.'=>'Liczba zakładek, których nie można było dodać: %s',  # line 821

### ../pages/version.inc.php   ###
'Mark this version as bookmark'=>'Utwórz zakładkę do tej wersji',  # line 320

### ../render/render_page.inc.php   ###
'%s queries / %s fields '     =>'%s zapytań / %s pól',  # line 1322

### ../std/class_auth.inc.php   ###
'Sorry. Authentication failed'=>'Niestety autentyfikacja nieprawidłowa.',  # line 373

### ../lists/list_efforts.inc.php   ###
'Status|column header'        =>'Status',  # line 310

### ../pages/effort.inc.php   ###
'Select some efforts(s) to edit'=>'Zaznacz wysiłki do edycji',  # line 1057
'For editing all efforts must be of same project.'=>'Aby wyedytować wiele wysiłków, wszystkie muszą być z tego samego projektu',  # line 891
'Edit multiple efforts|Page title'=>'Edycja wielu wysiłków',  # line 914
'Edit %s efforts|Page title'  =>'Edycja %s wysiłku / wysiłków',  # line 915
'Edited %s effort(s).'        =>'Liczba wyedytowanych wysiłków: %s',  # line 1099
'Error while editing %s effort(s).'=>'Wystąpił błąd podczas edycji %s wysiłku / wysiłków',  # line 1103

### ../db/class_projectperson.inc.php   ###
'Salary per hour'             =>'Stawka godzinowa',  # line 91

### ../lists/list_effortstaskcalculation.inc.php   ###
'in Euro'                     =>'w Euro',  # line 221

### ../lists/list_effortsperson.inc.php   ###
'Efforts on team member'      =>'Wysiłki członka zespołu',  # line 28

### ../lists/list_effortstask.inc.php   ###
'Total effort sum: %s hours'  =>'Łączny wysiłek: %s h',  # line 98

### ../lists/list_effortspersoncalculation.inc.php   ###
'Role|columnheader'           =>'Rola',  # line 101

### ../lists/list_effortstaskcalculation.inc.php   ###
'Sum|columnheader'            =>'Suma',  # line 168

### ../lists/list_effortstask.inc.php   ###
'Effortgraph|columnheader'    =>'Wykres wysiłków',  # line 162

### ../lists/list_effortspersoncalculation.inc.php   ###
'Calculation on team member'  =>'Kalkulacja dla członka zespołu',  # line 28

### ../lists/list_effortstaskcalculation.inc.php   ###
'Calculation|columnheader'    =>'Kalkulacja',  # line 221
'Costgraph|columnheader'      =>'Wykres kosztów',  # line 251

### ../lists/list_effortsprojectcalculation.inc.php   ###
'Calculation for project'     =>'Kalkulacja dla projektu',  # line 28
'Project|columnheader'        =>'Projekt',  # line 90

### ../lists/list_effortstask.inc.php   ###
'Efforts on task'             =>'Wysiłki zadania',  # line 28

### ../lists/list_effortstaskcalculation.inc.php   ###
'Task|columnheader'           =>'Zadanie',  # line 116
'Calculation on task'         =>'Kalkulacja dla zadania',  # line 28

### ../lists/list_recentchanges.inc.php   ###
'Recently changes'            =>'Ostatnio zmienione',  # line 51
'Recent changes'              =>'Ostatnie zmiany',  # line 79
'No changes by others'        =>'Brak zmian dokonanych przez innych',  # line 62
'No changes yet'              =>'Nie dokonano jeszcze żadnych zmian',  # line 66
'Show more'                   =>'Pokaż więcej',  # line 90
'Also show your changes'      =>'Pokaż również Twoje zmiany',  # line 119
'Hide your changes'           =>'Ukryj Twoje zmiany',  # line 122
'Needs feedback'              =>'Wymagana reakcja',  # line 189

### ../std/class_rss.inc.php   ###
'Updated'                     =>'Zaktualizowane',  # line 105

### ../pages/company.inc.php   ###
'clients'                     =>'klienci',  # line 47
'prospective clients'         =>'kluczowi klienci',  # line 66
'supplier'                    =>'dostawca',  # line 85
'partner'                     =>'partner',  # line 104

### ../pages/item.inc.php   ###
'Edit bookmark: "%s"|page title'=>'Edycja zakładki: "%s"',  # line 390
'Bookmark: "%s"'              =>'Zakładka: "%s"',  # line 391

### ../pages/project_more.inc.php   ###
'New project from'            =>'Nowy projekt',  # line 57
'template'                    =>'z szablonu',
'scratch'                     =>'od zera',
'New Topic'                   =>'Nowy temat',  # line 1093
'Topics'                      =>'Tematy',  # line 1115
'No topics yet'               =>'Nie ma jeszcze żadnych tematów',  # line 1145
'all|Filter preset'           =>'wszystkie|Filter preset',  # line 1368
'new|Filter preset'           =>'nowe|Filter preset',  # line 1388
'open|Filter preset'          =>'otwarte|Filter preset',  # line 1408
'discounted|Filter preset'    =>'z upustem|Filter preset',  # line 1428
'discounted'                  =>'upust',  # line 1438
'not chargeable|Filter preset'=>'nie obciążające|Filter preset',  # line 1448
'not chargeable'              =>'nie obsiążający',  # line 1458
'balanced|Filter preset'      =>'zbilansowane|Filter preset',  # line 1468
'balanced'                    =>'bilansujące',  # line 1478
'last logout|Filter preset'   =>'od ostatniego logowania|Filter preset',  # line 1488
'1 week|Filter preset'        =>'1 tydzień|Filter preset',  # line 1507
'2 weeks|Filter preset'       =>'2 tygodnie|Filter preset',  # line 1527
'3 weeks|Filter preset'       =>'3 tygodnie|Filter preset',  # line 1547
'1 month|Filter preset'       =>'1 miesiąc|Filter preset',  # line 1567
'prior|Filter preset'         =>'wcześniejsze|Filter preset',  # line 1587
'View calculation'            =>'Wyświetl kalkulacje',  # line 1670
'Effort calculations'         =>'Kalkulacje wysiłków',  # line 1853
'Reanimated person %s as team-member'=>'Osoba %s została przywrócona jako członek zespołu',  # line 2388
'Person %s already in project'=>'Osoba %s jest już przypisana do projektu',  # line 2392

### ../pages/project_view.inc.php   ###
'Delete this project'         =>'Usuń projekt',  # line 96
'Mark this project as bookmark'=>'Utwórz zakładkę do tego projektu',  # line 97
'Create wiki documentation page or start discussion topic'=>'Utwórz stronę wiki z dokumentacją lub utwórz nowy temat dyskusji',  # line 163
'Book effort'                 =>'Zarejestruj wysiłek',  # line 179

### ../pages/version.inc.php   ###
'Moved %s versions to trash'  =>'Przesunięto %s wersji do kosza',  # line 253

### ../std/class_changeline.inc.php   ###
'New File'                    =>'nowy plik',  # line 197
'Latest comment:'             =>'ostatni komentarz:',  # line 261
'changed File'                =>'zmieniony plik',  # line 447
'deleted File'                =>'usunięty plik',  # line 517

### ../std/class_rss.inc.php   ###
'???'                         =>'???',  # line 93

### ../lists/list_forwardedtasks.inc.php   ###
'Your demand notes'           =>'Twoje notki',  # line 33
'You have no demand notes'    =>'Brak not',  # line 34

### ../std/mail.inc.php   ###
'Failure sending mail: %s'    =>'Nie powiodło się wysłanie maila: %s',  # line 49
'Streber Email Notification|notifcation mail from'=>'Streber Info',  # line 85
'Updates at %s|notication mail subject'=>'Powiadomienie z %s',  # line 105
'no mail for person|notification'=>'brak maila do osoby', #line 112
'Hello %s,|notification'      =>'Witaj %s,',  # line 117
'with this automatically created e-mail we want to inform you that|notification'=>'pragniemy poinformować Ciebie w tym automatycznie wygenerowanym mailu, że',  # line 119
'since %s'                    =>'od %s',  # line 123
'following happened at %s |notification'=>'wystąpiły następujące zmiany w serwisie %s ',  # line 126
'Your account has been created.|notification'=>'Twoje konto zostało utworzone.',  # line 133
'Please set password to activate it.|notification'=>'Proszę utworzyć hasło w celu aktywacji konta.',  # line 135
'Please set a password to activate it.|notification'=>'Proszę utworzyć hasło w celu aktywacji konta.',  # line 160
'You have been assigned to projects:|notification'=>'Zostałeś przypisany do następujących projektów:',  # line 144
'Project Updates'             =>'Zmiany w projekcie',  # line 174
'If you do not want to get further notifications feel free to|notification'=>'Jeśli nie chcesz otrzymywać następnych powiadomień o zmianach, możesz',  # line 221
'adjust your profile|notification'=>'zmodyfikować swój profil',  # line 223
'Thanks for your time|notication'=>'Dziękujemy za poświęcony czas.',  # line 228
'the management|notication'   =>'Zarządzający serwisem',  # line 229
'Changed monitored items:|notification'=>'Zmienione pozycje monitorowane:',  # line 229
'%s edited > %s'              =>'%s edytowanych > %s',  # line 239
'Unchanged monitored items:|notification'=>'Nie zmienione monitorowane pozycje:',  # line 267
'No news for <b>%s</b>'       =>'Brak nowych wiadomości dla <b>%s</b>',  # line 275
'If you do not want to get further notifications or you forgot your password feel free to|notification'=>'Jeśli nie chcesz otrzymywać następnych powiadomień o zmianach lub zapomniałeś swojego hasła dostępu, możesz',  # line 312
'%s (not touched since %s day(s))'=>'%s (nie modyfikowane od %s dni)',  # line 322
'Request a mail to change your account settings.|notification'=>'Zażądaj e-maila w celu zmiany ustawień Twojego konta.|notification',  # line 455
'Forgot your password or how to log in?|notification'=>'Zapomniałeś swojego hasła lub nie wiesz, jak zalogować się?|notification',  # line 464
'Click here:'                 =>'Kliknij tutaj:',  # line 465
'Your account at %s is still active.|notification'=>'Twoje konto pod adresem %s jest nadal aktywne.', #line 470
'Your login name is|notification'=>'Twój login to', #line 471
'Maybe you want to %s set your password|notification'=>'Jeśli chcesz, możesz %s zmienić swoje hasło', #line 472
'Your account at|notification'=>'Twoje konto na', #line 459
'Please use this link to'     =>'Proszę użyj tego odnośnika do',  # line 621
'update your account settings'=>'zmień ustawienia sTwojego konta',  # line 624
'Unchanged item|notifcation mail from'=>'Pozycja niezmieniona',  # line 805
'No changes since %s (%s day(s)) on: %s|notification mail subject'=>'Brak zmian od %s (%s dzień/dni) dla: %s',  # line 831
'The following item is unchanged:|notification'=>'Następująca pozycja nie została zmieniona:',  # line 847
'Notification on changed item|notification mail from'=>'Powiadomienie o zmienionej pozycji',  # line 1039
'No emails sent.'             =>'Nie zostały wysłane żadne e-maile.',  # line 1069
'Changes on: %s|notification mail subject'=>'Zmiany dla: %s',  # line 1075
'The following item was changed:|notification'=>'Następująca pozycja została zmieniona:',  # line 1091


'This task is planned to be completed today.'=>'Ukończenie tego zadanie jest zaplanowane na dzisiaj.',
'This task is planned to be completed tomorrow.'=>'Ukończenie tego zadanie jest zaplanowane na jutro.',
'late|time status of a task'  =>'opóźnione|time status of a task',
'remain|time status of a task'=>'trwa|time status of a task',
'Please select some items'    =>'Proszę zaznaczyć parę pozycji',
'Link to this chapter'        =>'Odnośnik do tego rozdziału',

'invalid Person #%s'          =>'nieprawidłowa osoba #%s',
'Reverting user changes'      =>'Przywrócenie zmian użytkownika',
'Skipped recently editted item #%s: <b>%s<b>'=>'Pominięto poprzednio wyedytowaną pozycję #%s: <b>%s<b>',
'Reverted all changes (%s) of user %s'=>'Przywrócenie wszystkich zmian (%s) użytkownika %s',
'newly created items by this user remain unaffected.'=>'pozycje nowo stworzone przez tego użytkownika pozostaną nie zmienione.',

'Note' =>'Uwaga',
'Warning'=>'Ostrzeżenie',
'Error'=>'Błąd',
'Hint' =>'Podpowiedź',

);


?>
