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
* translation into: Czech
*
*    translated by: Josef Chmel
*
*             date: 08.12.2006
*
*  streber version: 0.704
*
*         comments: translation version 1.0
*/

global $g_lang_table;
$g_lang_table= array(



### ../lists/list_projectchanges.inc.php   ###
'new'                         =>'nové',

### ../_docs/changes.inc.php   ###
'to'                          =>'',
'you'                         =>'',
'assign to'                   =>'přidělené',

### ../lists/list_changes.inc.php   ###
'deleted'                     =>'smazané',

### ../_files/prj932/1326.index.php   ###
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter you name and use the <b>forgot password link</b> below.'=>'Lituji, ale tento aktivační kód už není platný. Když už máte účet, můžete vložit svoje jméno a použít <b>Zapměl jsem svoje heslo</b>.',

### ../pages/company.inc.php   ###
'Summary'                     =>'Sumář',

### ../db/class_comment.inc.php   ###
'Details'                     =>'Detaily',

### ../lists/list_projects.inc.php   ###
'Name'                        =>'Název',

### ../db/class_company.inc.php   ###
'Required. (e.g. pixtur ag)'  =>'Vyžadované. (např. pixtur ag)',
'Short|form field for company'=>'Krátký název',
'Optional: Short name shown in lists (eg. pixtur)'=>'Volitelné: Krátký název zobrazovaný v seznamech (např. pixtur)',
'Tag line|form field for company'=>'Slogan',

### ../db/class_person.inc.php   ###
'Optional: Additional tagline (eg. multimedia concepts)'=>'Volitelné: Dodatečný slogan (např. v multimediálních konceptech)',

### ../db/class_company.inc.php   ###
'Phone|form field for company'=>'Telefón',
'Optional: Phone (eg. +49-30-12345678)'=>'Volitelné: telefónní číslo (např. +49-30-12345678)',
'Fax|form field for company'  =>'Fax',
'Optional: Fax (eg. +49-30-12345678)'=>'Volitelné: faxové číslo (např. +49-30-12345678)',
'Street'                      =>'Ulice',
'Optional: (eg. Poststreet 28)'=>'Volitelné: (např. Poštovní ulice 28)',
'Zipcode'                     =>'PSČ',
'Optional: (eg. 12345 Berlin)'=>'Volitelné: Poštové smerové číslo (např. 12345 Berlín) ',
'Website'                     =>'Web stránka ',
'Optional: (eg. http://www.pixtur.de)'=>'Volitelné: (např. http://www.pixtur.de)',
'Intranet'                    =>'Intranet',
'Optional: (eg. http://www.pixtur.de/login.php?name=someone)'=>'Volitelné: (http://www.pixtur.de/login.php?name=někdo)',
'E-Mail'                      =>'E-mail',
'Comments|form label for company'=>'Komentáře',

### ../db/class_person.inc.php   ###
'Optional'                    =>'Volitelné',

### ../db/class_company.inc.php   ###
'more than expected'          =>'více než bylo očakávané',
'not available'               =>'nedostupné',

### ../db/class_effort.inc.php   ###
'optional if tasks linked to this effort'=>'volitelné, když jsou úkoly připojené na tuto práci',
'Time Start'                  =>'Začátek',

### ../db/class_milestone.inc.php   ###
'Time End'                    =>'Konec',

### ../pages/task.inc.php   ###
'Description'                 =>'Popis',

### ../db/class_issue.inc.php   ###
'Production build'            =>'',
'Steps to reproduce'          =>'Kroky pro reprodukci',
'Expected result'             =>'Očakávaný výsledek',
'Suggested Solution'          =>'Navrhované řešení',

### ../db/class_milestone.inc.php   ###
'optional if tasks linked to this milestone'=>'volitelné, ak jsou úkoly propojené na tento milník',

### ../lists/list_milestones.inc.php   ###
'Planned for'                 =>'Plánované pro',

### ../db/class_person.inc.php   ###
'Full name'                   =>'Celé jméno',
'Required. Full name like (e.g. Thomas Mann)'=>'Vyžadované. Celé jméno jako např. Thomas Mann',
'Nickname'                    =>'Přezdívka',
'only required if user can login (e.g. pixtur)'=>'vyžadované, jen při prihlášení uživ. (např. pixtur)',
'Optional: Color for graphical overviews (e.g. #FFFF00)'=>'Volitelné: Farba pro grafický prehlad (např.  #FFFF00)',

### ../lists/list_persons.inc.php   ###
'Tagline'                     =>'Slogan',

### ../db/class_person.inc.php   ###
'Mobile Phone'                =>'Mobilný telefón',
'Optional: Mobile phone (eg. +49-172-12345678)'=>'Volitelné: Mobilné telefónne číslo (např. +49-172-12345678)',
'Office Phone'                =>'Telefón',
'Optional: Office Phone (eg. +49-30-12345678)'=>'Volitelné: Telefónne číslo do kanceláře (např. +49-30-12345678)',
'Office Fax'                  =>'Fax ',
'Optional: Office Fax (eg. +49-30-12345678)'=>'Volitelné: Telefónne číslo do kanceláře (např. +49-30-12345678)',
'Office Street'               =>'Adresa',
'Optional: Official Street and Number (eg. Poststreet 28)'=>'Volitelné: Ulice a číslo domu kanceláře (např. Poštovní 2)',
'Office Zipcode'              =>'PSČ',
'Optional: Official Zip-Code and City (eg. 12345 Berlin)'=>'Volitelné: PSČ kanceláře a Město (např. 53002 Pardubice)',
'Office Page'                 =>'Web stránka',
'Optional: (eg. www.pixtur.de)'=>'Volitelné: (např. www.pixtur.de)',
'Office E-Mail'               =>'E-mail',
'Optional: (eg. thomas@pixtur.de)'=>'Volitelné: (např. thomas@pixtur.de)',
'Personal Phone'              =>'Soukromý telefón ',
'Optional: Private Phone (eg. +49-30-12345678)'=>'Volitelné: Soukromý telefón (např. +49-30-12345678)',
'Personal Fax'                =>'Soukromý fax',
'Optional: Private Fax (eg. +49-30-12345678)'=>'Volitelné: Soukromý telefón (např. +49-30-12345678)',
'Personal Street'             =>'Soukromá adresa',
'Optional:  Private (eg. Poststreet 28)'=>'Volitelné: Ulica a číslo domu (např. Poštová 5)',
'Personal Zipcode'            =>'PSČ soukromé adresy',
'Optional: Private (eg. 12345 Berlin)'=>'Volitelné: PSČ soukromé adresy a mesto (např. 81101 Bratislava)',
'Personal Page'               =>'Osobní stránka',
'Personal E-Mail'             =>'Soukromý e-mail',
'Birthdate'                   =>'Datum narození',

### ../db/class_project.inc.php   ###
'Color'                       =>'Farba',
'Status summary'              =>'Souhrn stavu',

### ../pages/task.inc.php   ###
'Comments'                    =>'Komentáře',

### ../db/class_person.inc.php   ###
'Password'                    =>'Heslo',
'Only required if user can login|tooltip'=>'Vyžadované jen když se uživatel může přihlásit',

### ../render/render_page.inc.php   ###
'Profile'                     =>'Profil',

### ../db/class_person.inc.php   ###
'Theme|Formlabel'             =>'Téma',

### ../pages/comment.inc.php   ###
'insuffient rights'           =>'nedostatočná práva',

### ../db/class_task.inc.php   ###
'Short'                       =>'Krátký',

### ../db/class_task.inc.php   ###
'Date start'                  =>'Datum začátku',
'Date closed'                 =>'Datum uzavření',

### ../render/render_list_column_special.inc.php   ###
'Status'                      =>'Stav',

### ../db/class_project.inc.php   ###
'Project page'                =>'Stránka projektu',
'Wiki page'                   =>'Wiki stránka',

### ../pages/home.inc.php   ###
'Priority'                    =>'Priorita',

### ../std/constant_names.inc.php   ###
'Company'                     =>'Společnost',

### ../db/class_project.inc.php   ###
'show tasks in home'          =>'zobrazit úkoly "doma"',
'validating invalid item'     =>'vyhodnocení neplatné položky',
'insuffient rights (not in project)'=>'nedostatočné práva (není v projektu)',

### ../pages/proj.inc.php   ###
'Project Template'            =>'Šablona projektu',
'Inactive Project'            =>'Neaktivny projekt',
'Project|Page Type'           =>'Projekt',

### ../db/class_projectperson.inc.php   ###
'job'                         =>'pozice',
'role'                        =>'role',

### ../pages/task.inc.php   ###
'For Milestone'               =>'pro milník',

### ../pages/task_view.inc.php   ###
'edit'                       =>'upravit',

### ../db/class_task.inc.php   ###
'resolved_version'            =>'vyřešená_verze',
'show as folder (may contain other tasks)'=>'zobrazit jako složku (může obsahovat jiné úkoly)',
'is a milestone / version'    =>'je milník / verze',
'milestones are shown in a different list'=>'milníky jsou zobrazené v roznych zoznamoch',
'Completion'                  =>'Dokončení',

### ../pages/task.inc.php   ###
'Estimated time'              =>'Předpokladané trvání',
'Estimated worst case'        =>'Nejhorší varianta',
'Label'                       =>'Označení',

### ../db/class_task.inc.php   ###
'Planned Start'               =>'Plánovaný začátek',
'Planned End'                 =>'Plánovaný konec',

### ../pages/task.inc.php   ###
'task without project?'       =>'úkoly bez projektu?',

### ../pages/proj.inc.php   ###
'Folder'                      =>'Složka',

### ../lists/list_tasks.inc.php   ###
'Milestone'                   =>'Mílník',

### ../std/constant_names.inc.php   ###
'Task'                        =>'Úkol',

### ../db/db.inc.php   ###
'Database exception'          =>'Databázová výjímka',
'Database exception. Please read <a href=\'http://streber.pixtur.de/index.php?go=taskView&tsk=1272\'>next steps on database errors.</a>'=>'Databázová vyjímka. Prosím přečtěte si <a href=\'http://streber.pixtur.de/index.php?go=taskView&tsk=1272\'>, kde jsou ďalšie kroky pro databázové chyby.',

### ../db/db_item.inc.php   ###
'<b>%s</b> isn`t a known format for date.'=>'<b>%s</b> není známy formát pro dátum.',
'unnamed'                     =>'nepojménované',
'Unknown'                     =>'Neznáme',
'Item has been modified during your editing by %s (%s minutes ago). Your changes can not be submitted.'=>'Položku v čase tvé úpravy změnil %s (pred %s minutami). Tvoje změny nemohou být odeslané',

### ../lists/list_changes.inc.php   ###
'to|very short for assigned tasks TO...'=>'k',
'in|very short for IN folder...'=>'v',

### ../lists/list_projectchanges.inc.php   ###
'modified'                    =>'změněno',

### ../lists/list_changes.inc.php   ###
'New Comment'                 =>'Nový komentář',
'read more...'                =>'číst další...',
'Last of %s comments:'        =>'Posledných %s komentářů:',
'comment:'                    =>'komentář',
'completed'                   =>'dokončené',
'Approve Task'                =>'Schválit úkol',
'approved'                    =>'schválené',
'closed'                      =>'uzavřené',
'reopened'                    =>'znovu otevřené',
'is blocked'                  =>'je blokováno',
'moved'                       =>'přesunuté',
'changed:'                    =>'změněné:',
'commented'                   =>'komentované',
'reassigned'                  =>'přeřazené',
'renamed'                     =>'prejjménované',
'edit wiki'                   =>'upravit wiki',
'assigned'                    =>'přiřazené',
'attached'                    =>'přidaný',
'attached file to'            =>'přidaný soubor k',

### ../lists/list_projectchanges.inc.php   ###
'restore'                     =>'obnovit',

### ../pages/proj.inc.php   ###
'Changes'                     =>'Změny',

### ../lists/list_changes.inc.php   ###
'Date'                        =>'Datum',
'Who changed what when...'    =>'Kdo, co a kdy změnil...',
'what|column header in change list'=>'co',
'Date / by'                   =>'Datum / kdo',

### ../render/render_page.inc.php   ###
'Edit'                        =>'Upravit',

### ../lists/list_taskfolders.inc.php   ###
'New'                         =>'Nový',

### ../pages/task.inc.php   ###
'Delete'                      =>'Odstranit',

### ../lists/list_comments.inc.php   ###
'Move to Folder'              =>'Presunout do složky',
'Shrink View'                 =>'Zmenšit zobrazení',
'Expand View'                 =>'Rozvinout zobrazení',
'Topic'                       =>'Téma',
'Date|column header'          =>'Datum',
'By|column header'            =>'Od',

### ../lists/list_companies.inc.php   ###
'related companies'           =>'propojené firmy',
'Company|Column header'       =>'Firma',

### ../lists/list_persons.inc.php   ###
'Name Short'                  =>'Krátke jméno',
'Shortnames used in other lists'=>'Krátke jména použíté v jiných seznamech',

### ../pages/company.inc.php   ###
'Phone'                       =>'Telefón',

### ../lists/list_companies.inc.php   ###
'Phone-Number'                =>'Telefoní číslo',
'Proj'                        =>'Proj',
'Number of open Projects'     =>'Počet otevřených projektů',

### ../render/render_page.inc.php   ###
'People'                      =>'Lidé',

### ../lists/list_companies.inc.php   ###
'People working for this person'=>'Lidé pracující pro tuto osobu',
'Edit company'                =>'Upravit firmu',
'Delete company'              =>'Smazat firmu',
'Create new company'          =>'Vytvořit novou firmu',

### ../lists/list_files.inc.php   ###
'Name|Column header'          =>'Názů',
'Parent item'                 =>'Rodičovská položka',
'ID'                          =>'ID',
'Click on the file ids for details.'=>'Víc detailov se zobrazí po kliknutí na ID souboru',
'Move files'                  =>'Presunout soubory',
'File|Column header'          =>'Soubor',
'in|... folder'               =>'v',
'Attached to|Column header'   =>'Pripojit k',
'Thumbnail|Column header'     =>'Zmenšenina',  # line 468
'ID %s'                       =>'ID %s',  # line 450
'Show Details'                =>'Zobraz detaily',  # line 452

### ../lists/list_efforts.inc.php   ###
'no efforts booked yet'       =>'zatím bez zaznamenané práce',

### ../pages/person.inc.php   ###
'Efforts'                     =>'Práce',

### ../std/constant_names.inc.php   ###
'Project'                     =>'Projekt',

### ../lists/list_efforts.inc.php   ###
'person'                      =>'Osoba',

### ../lists/list_projects.inc.php   ###
'Task name. More Details as tooltips'=>'Název úkolu. Detaily se zobrazí jako bublina.',

### ../lists/list_efforts.inc.php   ###
'Edit effort'                 =>'Upravit práci',
'New effort'                  =>'Nová práce',
'booked'                      =>'zaznamenané',
'estimated'                   =>'očakávané',
'Task|column header'          =>'Úkol',
'Start|column header'         =>'Začátek',
'D, d.m.Y'                    =>'D, d.m.R',
'End|column header'           =>'Konec',
'len|column header of length of effort'=>'Délka',
'Daygraph|columnheader'       =>'Denní graf',

### ../pages/file.inc.php   ###
'Type'                        =>'Typ',

### ../pages/task.inc.php   ###
'Version'                     =>'Verze',

### ../lists/list_files.inc.php   ###
'Size'                        =>'Velkost',

### ../pages/_handles.inc.php   ###
'Edit file'                   =>'Upravit soubor',

### ../lists/list_files.inc.php   ###
'New file'                    =>'Nový soubor',
'No files uploaded'           =>'Bez odeslaných souborů',
'Download|Column header'      =>'Stáhnout',

### ../pages/proj.inc.php   ###
'Milestones'                  =>'Mílníky',

### ../lists/list_tasks.inc.php   ###
'Started'                     =>'Započaté',
'%s hidden'                   =>'%s krytých',
'Task name'                   =>'Název úkolu',

### ../pages/task.inc.php   ###
'New Folder'                  =>'Nová složka',

### ../pages/company.inc.php   ###
'or'                          =>'nebo',

### ../lists/list_milestones.inc.php   ###
'Due Today'                   =>'Plánované na dnes',
'%s days late'                =>'%s dní v zpoždění',
'%s days left'                =>'zbývá %s dní',
'Tasks open|columnheader'     =>'Otevřené úkoly',
'Open|columnheader'           =>'Otevřené',
'%s open'                     =>'%s otevřených',
'Completed|columnheader'      =>'Dokončeno',
'Completed tasks: %s'         =>'Dokončené úkoly: %s',
'closed'                      =>'uzavřený',
'%s required'                 =>'%s je vyžadované',

### ../lists/list_persons.inc.php   ###
'Private'                     =>'Soukromé',
'Mobil'                       =>'Mobil',
'Office'                      =>'Kancelář',

### ../render/render_page.inc.php   ###
'Companies'                   =>'Společnosti',

### ../lists/list_persons.inc.php   ###
'last login'                  =>'poslední přihlášení',
'Edit person'                 =>'Upravit osobu',

### ../pages/_handles.inc.php   ###
'Edit User Rights'            =>'Upravit používatelské prístupy',

### ../lists/list_persons.inc.php   ###
'Delete person'               =>'Smazat osobu',
'Active Projects|column header'=>'Aktivní projekty',
'Create new person'           =>'Vytvořit novou osobu',
'Profile|column header'       =>'Profil',
'Account settings for user (do not confuse with project rights)'=>'Nastavení účtu pro uživatele (nezamenit si s právami k projektu)',
'(adjusted)'                  =>'(upravené)',

### ../render/render_list_column_special.inc.php   ###
'Priority is %s'              =>'Priorita je %s',

### ../lists/list_persons.inc.php   ###
'recent changes|column header'=>'poslední změny',
'changes since YOUR last logout'=>'změny od posledního odhlášení',

### ../lists/list_project_team.inc.php   ###
'Your related persons'        =>'Prepojené osoby na tebe',
'Rights'                      =>'Práva',
'Persons rights in this project'=>'Práva osob v tomto projektu',
'Edit team member'            =>'Upravit člena týmu',
'Add team member'             =>'Přidat člena týmu',
'Remove person from team'     =>'Odstranit osobu z týmu',
'Member'                      =>'Člen',
'Role'                        =>'Role',
'last Login|column header'    =>'poslední přihlášení',

### ../render/render_list_column_special.inc.php   ###
'Created by'                  =>'Vytvořil',

### ../lists/list_projectchanges.inc.php   ###
'Item was originally created by'=>'Položka byla původně vytvořená',
'C'                           =>'V',
'Created,Modified or Deleted' =>'Vytvořené, Změněné nebo Odstraněné',
'Deleted'                     =>'Odstraněné',

### ../render/render_list_column_special.inc.php   ###
'Modified'                    =>'Změněné',

### ../lists/list_projectchanges.inc.php   ###
'by Person'                   =>'osobou',
'Person who did the last change'=>'Osoba, ktorá urobila poslednú změnu',
'Type|Column header'          =>'Typ',
'Item of item: [T]ask, [C]omment, [E]ffort, etc '=>'Položka položky: [Ú]loha, [K]omentář, Ú[s]ilie',
'item %s has undefined type'  =>'položka %s má nedefinovaný typ',
'Del'                         =>'Zma',
'shows if item is deleted'    =>'zobrazí zmazané položky',
'(on comment)'                =>'(na komentář)',
'(on task)'                   =>'(na úkol)',
'(on project)'                =>'(na projekt)',

### ../lists/list_projects.inc.php   ###
'Project priority (the icons have tooltips, too)'=>'Priority projektu',

### ../pages/home.inc.php   ###
'Task-Status'                 =>'Stav úkolu',

### ../lists/list_projects.inc.php   ###
'Status Summary'              =>'Souhrn',
'Short discription of the current status'=>'Krátký popis aktuálneho stavu',

### ../pages/proj.inc.php   ###
'Tasks'                       =>'Úkoly',

### ../lists/list_projects.inc.php   ###
'Number of open Tasks'        =>'Počet otevřených úkolů',
'Opened'                      =>'Otevřené',
'Day the Project opened'      =>'Datum vytvorení projektu',

### ../pages/proj.inc.php   ###
'Closed'                      =>'Ukončené',

### ../lists/list_projects.inc.php   ###
'Day the Project state changed to closed'=>'Den kdy stav projektu byl změněný na uzavřený',
'Edit project'                =>'Upravit projekt',
'Delete project'              =>'Smazat projekt',
'Log hours for a project'     =>'Zaznamenat hodiny pro projekt',
'Open / Close'                =>'Otvorit / Uzatvorit',

### ../pages/company.inc.php   ###
'Create new project'          =>'Vytvořit nový projekt',

### ../pages/_handles.inc.php   ###
'Create Template'             =>'Vytvořit šablonu',
'Project from Template'       =>'Projekt zo šablony',

### ../lists/list_projects.inc.php   ###
'... working in project'      =>'...pracující na projektu',

### ../pages/proj.inc.php   ###
'Folders'                     =>'Složky',

### ../lists/list_taskfolders.inc.php   ###
'Number of subtasks'          =>'Počet podúkol',
'Create new folder under selected task'=>'Vytvořit novou složku pod zvoleným úkolem',
'Move selected to folder'     =>'Presunout do zvolené složky',

### ../lists/list_tasks.inc.php   ###
'Log hours for select tasks'  =>'Zaznamenané hodiny pro označené úkoly',
'Priority of task'            =>'Priorita úkolu',
'Status|Columnheader'         =>'Stav',
'Modified|Column header'      =>'Změněné',
'Est.'                        =>'Očak.',

### ../pages/home.inc.php   ###
'Estimated time in hours'     =>'Předpokladaný čas v hodinách',

### ../lists/list_tasks.inc.php   ###
'Add new Task'                =>'Přidat nový úkol',
'Report new Bug'              =>'Oznámit novou chybu',
'Add comment'                 =>'Přidat komentář',
'Status->Completed'           =>'Stav->Ukončený',
'Status->Approved'            =>'Stav->Schválený',
'Move tasks'                  =>'Presunout úkoly',
'Latest Comment'              =>'Posledný komentář',
'by'                          =>'od',
'for'                         =>'pro',
'%s open tasks / %s h'        =>'%s otevřených úkol / %s h',
'Label|Columnheader'          =>'Označení',

### ../pages/task.inc.php   ###
'Assigned to'                 =>'Priřazené k',

### ../lists/list_tasks.inc.php   ###
'Name, Comments'              =>'Meno, komentář',
'has %s comments'             =>'má %s komentářů',
'Task has %s attachments'     =>'Úkol ma %s príloh',
'- no name -|in task lists'   =>'- bez mena -',
'number of subtasks'          =>'počet podúkolů',
'Sum of all booked efforts (including subtasks)'=>'Súčet celého zaznamenaného úsilí (včetně podúkol)',
'Effort in hours'             =>'Práce v hodinách',
'Days until planned start'    =>'Dny do plánovaného začátku',
'Due|column header, days until planned start'=>'Start',
'planned for %s|a certain date'=>'plánované na %s',
'Est/Compl'                   =>'Před./Ukon.',
'Estimated time / completed'  =>'Předpoklad času/ukončení',
'estimated %s hours'          =>'predpokladaných %s hodin',
'estimated %s days'           =>'predpokladaných %s dní',
'estimated %s weeks'          =>'predpokladaných %s týdnů',
'%2.0f%% completed'           =>'dokončené na %2.0f%%',

### ../pages/_handles.inc.php   ###
'Home'                        =>'Domů',
'View item'                   =>'Zobraz položku',  # line 17
'Set Public Level'            =>'Nastav veřejnou úroveň',  # line 27
'Active Projects'             =>'Aktivní projekty',
'Closed Projects'             =>'Uzatvorené projekty',

### ../pages/proj.inc.php   ###
'Project Templates'           =>'Šablóny projektů',

### ../pages/_handles.inc.php   ###
'View Project'                =>'Zobrazit projekt',

### ../pages/proj.inc.php   ###
'Uploaded Files'              =>'Odeslané soubory',
'Closed tasks'                =>'Uzařít úkoly',
'New Project'                 =>'Nový projekt',

### ../pages/_handles.inc.php   ###
'Edit Project Description'    =>'Upravit popis projektu',

### ../pages/proj.inc.php   ###
'Edit Project'                =>'Upravit projekt',

### ../pages/_handles.inc.php   ###
'Delete Project'              =>'Odstranit projekt',
'Change Project Status'       =>'Zmenit stav projektu',
'Add Team member'             =>'Přidat člena týmu',
'Edit Team member'            =>'Upravit člena týmu',
'Remove from team'            =>'Odstranit člena týmu',
'View Task'                   =>'Zobrazit úkol',
'Edit Task'                   =>'Upravit úkol',
'Delete Task(s)'              =>'Odstranit úkol',
'Restore Task(s)'             =>'Obnovit úkol',
'Move tasks to folder'        =>'Presunout úkoly do složky',
'Mark tasks as Complete'      =>'Označit úkoly jako vyřešené',
'Mark tasks as Approved'      =>'Označit úkoly jako schválené',
'New Task'                    =>'Nový úkol',
'New Bug'                     =>'Nová chyba',

### ../pages/task.inc.php   ###
'New Milestone'               =>'Nový milník',

### ../pages/_handles.inc.php   ###
'New released Version'      =>'',  # line 466
'Toggle view collapsed'       =>'Prepnout zobrazení',
'Add issue/bug report'        =>'Přidat hlášení problému/chyby',
'Edit Description'            =>'Upravit popis',
'Create Note'                 =>'Vytvoř Poznámku',  # line 531
'Edit Note'                   =>'Uprav poznámku',  # line 545
'View effort'                 =>'Zobraz práci',  # line 556
'View multiple efforts'       =>'Zobraz více prací',  # line 569
'Log hours'                   =>'Zaznamenat hodiny',
'Edit time effort'            =>'Upravit čas práce',
'View comment'                =>'Zobrazit komentář',
'Create comment'              =>'Vytvořit komentář',
'Edit comment'                =>'Upravit komentář',
'Delete comment'              =>'Smazat komentář',
'View file'                   =>'Zobrazit soubor',
'Upload file'                 =>'Odeslat',
'Update file'                 =>'Aktualizovat soubor',

### ../pages/file.inc.php   ###
'Download'                    =>'Stáhnout',

### ../pages/_handles.inc.php   ###
'Show file scaled'            =>'Zobrazit soubor v inej mierke',
'List Companies'              =>'Seznam firem',
'View Company'                =>'Zobrazit firmy',

### ../pages/company.inc.php   ###
'New Company'                 =>'Nová firma',
'Edit Company'                =>'Upravit firmu',

### ../pages/_handles.inc.php   ###
'Delete Company'              =>'Odstranit firmu',

### ../pages/company.inc.php   ###
'Link Persons'                =>'Propojit osoby',

### ../pages/_handles.inc.php   ###
'List Persons'                =>'Seznam osob',
'View Person'                 =>'Zobrazit osoby',

### ../pages/person.inc.php   ###
'New Person'                  =>'Nová osoba',

### ../pages/_handles.inc.php   ###
'Edit Person'                 =>'Upravit osobu',
'Delete Person'               =>'Smazat osobu',
'View Efforts of Person'      =>'Zobrazit námahu osoby',
'Send Activation E-Mail'      =>'Odeslat aktivační e-mail',
'Flush Notifications'         =>'Odeslat upozornění',
'Login'                       =>'Prihlášení',

### ../render/render_page.inc.php   ###
'Register'                    =>'Registrace',  # line 647
'Login'                       =>'Přihlášení',  # line 618
'Logout'                      =>'Odhlášení',

### ../pages/_handles.inc.php   ###
'License'                     =>'Licence',
'restore Item'                =>'obnovit položku',

### ../pages/error.inc.php   ###
'Error'                       =>'Chyba',

### ../pages/_handles.inc.php   ###
'Activate an account'         =>'Aktivovat účet',
'System Information'          =>'Systémové informácie',
'PhpInfo'                     =>'PhpInfo',
'Search'                      =>'Hladat',

### ../pages/comment.inc.php   ###
'Comment on task|page type'   =>'Komentář k úkolu',

### ../pages/task.inc.php   ###
'(deleted %s)|page title add on with date of deletion'=>'(zmazané %s)',

### ../pages/comment.inc.php   ###
'Edit this comment'           =>'Upravit tento komentář',
'New Comment|Default name of new comment'=>'Nový komentář',
'Reply to |prefix for name of new comment on another comment'=>'Odpověd: ',

### ../std/constant_names.inc.php   ###
'Comment'                     =>'Komentář',
'Warning'                     =>'Varování',

### ../pages/comment.inc.php   ###
'Edit Comment|Page title'     =>'Upravit komentář',
'New Comment|Page title'      =>'Nový komentář',
'On task %s|page title add on'=>'Na úkolu %s',

### ../pages/file.inc.php   ###
'On project %s|page title add on'=>'Na projekte %s',

### ../pages/comment.inc.php   ###
'Occasion|form label'         =>'Důvod',
'Public to|form label'        =>'Zverejnit pro',
'Select some comments to delete'=>'Označ některé komentáře na smazání',
'WARNING: Failed to delete %s comments'=>'VAROVANIE: Nepodařilo se smazat %s komentářů',
'Moved %s comments to trash'=>'%s komentářů presunutých do odpadků',
'Select some comments to move'=>'Označ některé komentáře na přesun',

### ../pages/task.inc.php   ###
'insufficient rights'         =>'nedostatočné oprávnení',

### ../pages/comment.inc.php   ###
'Can not edit comment %s'     =>'Není možné upravit komentář %s',

### ../pages/task.inc.php   ###
'Edit tasks'                  =>'Upravit úkoly',

### ../pages/comment.inc.php   ###
'Select one folder to move comments into'=>'Vyber jednu složku, do které se presunou komentáře',
'... or select nothing to move to project root'=>'... nebo neoznač nic, když chceš presun do základu projektu',
'No folders in this project...'=>'V tomto projekte není složka...',

### ../pages/task.inc.php   ###
'Move items'                  =>'Přesunout položky',

### ../pages/company.inc.php   ###
'related projects of %s'      =>'',

### ../pages/proj.inc.php   ###
'admin view'                  =>'zobrazení admina',
'List'                        =>'Seznam',

### ../pages/company.inc.php   ###
'no companies'                =>'bez firem',

### ../pages/proj.inc.php   ###
'Overview'                    =>'Přehled',

### ../pages/company.inc.php   ###
'Edit this company'           =>'Upravit túto firmu',
'edit'                        =>'upravit',
'Create new person for this company'=>'Vytvořit novou osobu pro tuto firmu',

### ../std/constant_names.inc.php   ###
'Person'                      =>'Osoba',

### ../pages/company.inc.php   ###
'Create new project for this company'=>'Vytvořit nový projekt pro tuto firmu',
'Add existing persons to this company'=>'Přidat existující osobu do této firmy',
'Persons'                     =>'Lidé',
'Adress'                      =>'Adresa',
'Fax'                         =>'Fax',
'Web'                         =>'Web',
'Intra'                       =>'Intra',
'Mail'                        =>'E-mail',
'related Persons'             =>'propojené osoby',
'link existing Person'        =>'propojit existující osobu',
'create new'                  =>'vytvořit novou',
'no persons related'          =>'bez propojenej osoby',
'Active projects'             =>'Aktivní projekty',
' Hint: for already existing projects please edit those and adjust company-setting.'=>'Tip: existující projekty prosím upravte a nastavte v nich firmu',
'no projects yet'             =>'zatí bez projektů',
'Closed projects'             =>'Ukončené projekty',
'Create another company after submit'=>'Vytvořit další firmu po odeslaní',
'Edit %s'                     =>'Upravit %s',
'Add persons employed or related'=>'Přidat osoby zaměstnané nebo napojené',
'NOTE: No persons selected...'=>'UPOZORNĚNÍ: Bez označených osob...',
'NOTE person already related to company'=>'UPOZORNĚNÍ: Osoba je už provázaná na firmu',
'Select some companies to delete'=>'Označit některé firmy na smazání',
'WARNING: Failed to delete %s companies'=>'VAROVÁNÍ: Nepodařilo se smazat %s spoločností',
'Moved %s companies to trash'=>'%s firiem presunutých do odpadků',

### ../pages/effort.inc.php   ###
'New Effort'                  =>'Nová práce',

### ../pages/file.inc.php   ###
'only expected one task. Used the first one.'=>'očakáva se jen jeden úkol. Použijte se první',

### ../pages/effort.inc.php   ###
'Edit Effort|page type'       =>'Upravit práci',
'Edit Effort|page title'      =>'Upravit práci',
'New Effort|page title'       =>'Nová práce',
'Date / Duration|Field label when booking time-effort as duration'=>'Datum / Trvaní',

### ../pages/file.inc.php   ###
'For task'                    =>'Pro úkol',

### ../pages/task.inc.php   ###
'Public to'                   =>'Zverejnit pro',

### ../pages/effort.inc.php   ###
'Could not get effort'        =>'Není možné získat info. o práci',
'Could not get project of effort'=>'Není možné získat práci projektu',
'Could not get person of effort'=>'Není možné získat práci osoby',
'Name required'               =>'Je vyžadované jméno',
'Cannot start before end.'    =>'Není možné začít před koncem',
'Select some efforts to delete'=>'Označ nějakou práci na smazání',
'WARNING: Failed to delete %s efforts'=>'VAROVÁNÍ: Nepodařilo se smazat %s práci',
'Moved %s efforts to trash'=>'%s práce presunuté do koše',

### ../pages/error.inc.php   ###
'Error|top navigation tab'    =>'Chyba',
'Unknown Page'                =>'Neznáma stránka',

### ../pages/file.inc.php   ###
'Could not access parent task.'=>'Není možné přistoupit k nadřazenému úkolu.',

### ../std/constant_names.inc.php   ###
'File'                        =>'Soubor',

### ../pages/task.inc.php   ###
'Item-ID %d'                  =>'ID položky %d',

### ../pages/file.inc.php   ###
'Edit this file'              =>'Upravit tento soubor',
'Version #%s (current): %s'   =>'Verze #%s (aktuálna): %s',
'Filesize'                    =>'Velkost souboru',
'Uploaded'                    =>'Odeslané',
'Uploaded by'                 =>'Odeslal',
'Version #%s : %s'            =>'Verze #%s : %s',
'Upload new version|block title'=>'Odeslat novou verzi',
'Could not edit task'         =>'Není možné upravit úkol',
'Edit File|page type'         =>'Upravit soubor',
'Edit File|page title'        =>'Upravit soubor',
'New File|page title'         =>'Nový soubor',
'Could not get file'          =>'Není možné získat soubor',
'Could not get project of file'=>'Není možné získat projekt souboru',
'Please enter a proper filename'=>'Vlož správny název souboru',
'Select some files to delete' =>'Označ soubory na smazaní',
'WARNING: Failed to delete %s files'=>'VAROVANIE: Nepodařilo se smazat %s souborů',
'Moved %s files to trash'  =>'%s souborov presunutých do odpadků',
'Select some file to display' =>'Označ soubory na zobrazení',

### ../render/render_misc.inc.php   ###
'Today'                       =>'Dnes',

### ../pages/home.inc.php   ###
'Personal Efforts'            =>'Osobní práce',
'At Home'                     =>'Doma',
'F, jS'                       =>'F, jS',
'Functions'                   =>'Funkce',
'View your efforts'           =>'Zobrazit tvoji práci',
'Edit your profile'           =>'Upravit tvůj profil',
'Your projects'               =>'Tvoje projekty',
'S|Column header for status'  =>'V',

### ../render/render_list_column_special.inc.php   ###
'Select lines to use functions at end of list'=>'Výběr řádků, pro funkce uvedené níže',

### ../pages/home.inc.php   ###
'P|Column header for priority'=>'P',
'Priority|Tooltip for column header'=>'Priorita',
'Company|column header'       =>'Firma',
'Project|column header'       =>'Projekt',
'Edit|function in context menu'=>'Upravit',
'Log hours for a project|function in context menu'=>'Zaznamenat hodiny pro projekt',
'Create new project|function in context menu'=>'Vytvořit nový projekt',
'You are not assigned to a project.'=>'Nie si přiřazený k projektu',
'You have no open tasks'      =>'Nemáš otevřené úkoly',
'Open tasks assigned to you'  =>'Tvoje otevřené úkoly',
'Open tasks (including unassigned)'=>'Otevřené úkoly (včetně nepřiřazených)',
'All open tasks'              =>'Všechny otevřené úkoly',
'P|column header'             =>'P',
'S|column header'             =>'S',
'Folder|column header'        =>'Priečinok',
'Modified|column header'      =>'Změněné',
'Est.|column header estimated time'=>'Očak.',
'Edit|context menu function'  =>'Upravit',
'status->Completed|context menu function'=>'stav->Ukončené',
'status->Approved|context menu function'=>'stav->Schválené',
'Delete|context menu function'=>'Odstranit',
'Log hours for select tasks|context menu function'=>'Zaznamenat hodiny pro označené úkoly',
'%s tasks with estimated %s hours of work'=>'%s úkol s predpokladanými %s hodinami práce',

### ../pages/login.inc.php   ###
'Login|tab in top navigation' =>'Prihlášení',

### ../render/render_page.inc.php   ###
'Go to your home. Alt-h / Option-h'=>'Přejít domů. Alt-h /Option-h',

### ../pages/login.inc.php   ###
'License|tab in top navigation'=>'Licence',

### ../render/render_page.inc.php   ###
'Your projects. Alt-P / Option-P'=>'Tvoje projekty. Alt-P / Option-P',

### ../pages/login.inc.php   ###
'Welcome to streber|Page title'=>'Vitejte v streberovi|',
'please login'                =>'prosím přihlašte se',
'Nickname|label in login form'=>'Přezdívka',
'Password|label in login form'=>'Heslo',
'I forgot my password.|label in login form'=>'Zapoměl jsem svoje heslo.',
'I forgot my password'        =>'Zapoměl jsem svoje heslo',

### ../pages/proj.inc.php   ###
'Create another project after submit'=>'Vytvořit další projekt po odeslaní',

### ../pages/login.inc.php   ###
'If you remember your name, please enter it and try again.'=>'Pokud si pamatujes své jméno, zadej ho a zkus akci znovu',
'Supposed a user with this name existed a notification mail has been sent.'=>'Pravděpodobně již uživatel s tím to jménem existuje a informace mu byly zaslány emailem.',
'invalid login|message when login failed'=>'neplatné přihlášení',
'Welcome %s. Please adjust your profile and insert a good password to activate your account.'=>'Výtej %s. Uprav si prosím svůj profil a vlož dobré heslo pro aktivaci účtu.',
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter your name and use the <b>forgot password link</b> below.'=>'Omlouvám se, ale tento aktivační kód už není platný. Jestli máš účet, vlož svoje jméno a použij <b>Zapoměl jsem svoje heslo</b>.',
'License|page title'          =>'Licence',

### ../pages/misc.inc.php   ###
'Select some items to restore'=>'Označ nejaké položky pro obnovu',
'Item %s does not need to be restored'=>'Položka %s nepotřebuje obnovu',
'WARNING: Failed to restore %s items'=>'VAROVANIE: Nepodařilo se obnovit %s položek',
'Restored %s items'           =>'Obnovených %s položek',
'Admin|top navigation tab'    =>'Admin',
'System information'          =>'Systémové informáce',
'Admin'                       =>'Admin',
'Database Type'               =>'Typ databáze',
'PHP Version'                 =>'PHP',
'extension directory'         =>'adresář rozšíření',
'loaded extensions'           =>'načtené rozšíření',
'include path'                =>'včetně cesty',
'register globals'            =>'',
'magic quotes gpc'            =>'',
'magic quotes runtime'        =>'',
'safe mode'                   =>'záchranný režim',

### ../pages/person.inc.php   ###
'Active People'               =>'Aktivní osoby',
'relating to %s|page title add on listing pages relating to current user'=>'vázající se k %s',
'Note|Page function person'   =>'Poznámka',  # line 475

### ../render/render_misc.inc.php   ###
'With Account|page option'    =>'S účtem',
'All Persons|page option'     =>'Všechny osoby',

### ../pages/person.inc.php   ###
'People/Project Overview'     =>'Přehled osob/projektů',
'no related persons'          =>'bez provázaných osob',
'Persons|Pagetitle for person list'=>'Osoby',
'relating to %s|Page title Person list title add on'=>'provázaný na %s',
'admin view|Page title add on if admin'=>'admin zobrazení',
'Edit this person|Tooltip for page function'=>'Upravit tuto osobu',
'Profile|Page function edit person'=>'Profil',
'Edit User Rights|Tooltip for page function'=>'Upravit uživatelská práva',
'User Rights|Page function for edit user rights'=>'Uživatelská práva',

### ../pages/task.inc.php   ###
'Summary|Block title'         =>'Souhrn',

### ../pages/person.inc.php   ###
'Mobile|Label mobilephone of person'=>'Mobil',
'Office|label for person'     =>'Kancelář',
'Private|label for person'    =>'Soukromé',
'Fax (office)|label for person'=>'Fax (do kanceláře)',
'Website|label for person'    =>'Web stránka',
'Personal|label for person'   =>'Osobní',
'E-Mail|label for person office email'=>'E-mail',
'E-Mail|label for person personal email'=>'E-mail',
'Adress Personal|Label'       =>'Soukromá adresa',
'Adress Office|Label'         =>'Adresa kanceláře',
'Birthdate|Label'             =>'Datum narození',
'works for|List title'        =>'pracuje pro',
'not related to a company'    =>'bez vazby na firmu',
'no company'                  =>'bez firmy',  # line 608
'Person details'              =>'Osobní detaily',  # line 618
'works in Projects|list title for person projects'=>'pracuje na projektech',
'no active projects'          =>'bez aktívního projektu',
'Assigned tasks'              =>'Priřazené úkoly',
'No open tasks assigned'      =>'Zatím bez přiřazené otevřené úkoly',
'Efforts|Page title add on'   =>'Práce',
'no efforts yet'              =>'momentálně bez práce',
'not allowed to edit'         =>'není možné upravovat',
'Edit Person|Page type'       =>'Upravit osobu',
'Person with account (can login)|form label'=>'Osoba s účtem (může se přihlásit)',
'Password|form label'         =>'Heslo',
'confirm Password|form label' =>'potvrdit heslo',
'-- reset to...--'            =>'-- vynulovat na... --',
'Profile|form label'          =>'Profil',
'- no -'                      =>'-- ne --',  # line 971
'Assigne to project|form label'=>'K projektu',  # line 980
'daily'                       =>'denne',
'each 3 days'                 =>'každé 3 dny',
'each 7 days'                 =>'každých 7 dní',
'each 14 days'                =>'každých 14 dní',
'each 30 days'                =>'každých 30 dní',
'Never'                       =>'Nikdy',
'Send notifications|form label'=>'Poslat upozornění',
'Send mail as html|form label'=>'Poslat e-mail jako html',
'Theme|form label'            =>'Téma',
'Language|form label'         =>'Jazyk',
'Time zone|form label'        =>'Časová zóna',  # line 1886
'Create another person after submit'=>'Po odeslaní vytvořit další osobu',
'Could not get person'        =>'Nelze načíst osobu',
'Sending notifactions requires an email-address.'=>'Odeslání upozornění vyžaduje e-mailovou adresu',
'NOTE: Nickname has been converted to lowercase'=>'UPOZORNENIE: Přezdívka byla konvertována na malá písmena',
'NOTE: Nickname has to be unique'=>'UPOZORNENIE: Přezdívka musí byt jedinečná',
'passwords do not match'      =>'heslá nesouhlasí',
'Password is too weak (please add numbers, special chars or length)'=>'Heslo je príliš slabé (přidej čísla, zvláštní znaky nebo víc znaků)',
'Login-accounts require a unique nickname'=>'Účty s možností přihlášení vyžadují jedinečné přezdívky',
'A notification / activation  will be mailed to <b>%s</b> when you log out.'=>'Upozornění / aktivace bude odeslaná na <b>%s</b>, když se odhlásíš.',

### ../render/render_wiki.inc.php   ###
'Read more about %s.'         =>'Čti další o %s',

### ../pages/person.inc.php   ###
'WARNING: could not insert object'=>'VAROVANIE: Není možné vložit objekt',
'Select some persons to delete'=>'Vyberte nejaké osoby pro smazání',
'<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'=>'<b>%s</b> je přiřazený k projektům a proto nemůže být smazan. Ale můžete deaktivovat jeho práva na přihlášení se.',
'WARNING: Failed to delete %s persons'=>'VAROBANIE: Nepodařilo se smazat %s osob.',
'Moved %s persons to trash'=>'%s osob presunutých do odpadků',
'Insufficient rights'         =>'Nedostatočné práva',
'Since the user does not have the right to edit his own profile and therefore to adjust his password, sending an activation does not make sense.'=>'Když uživatel nemá právo upravit svůj vlastní profil a tedy ani heslo, odeslání aktiváce nemá smysl.',
'Sending an activation mail does not make sense, until the user is allowed to login. Please adjust his profile.'=>'Odeslání aktivačního e-mailu nemá smysl, pokud se uživatel nemůže přihlásit. Uprav prosím jeho profil.',
'Activation mail has been sent.'=>'Aktivační e-mail byl odeslaný',
'Sending notification e-mail failed.'=>'Odeslání upozornujícího e-mailu se nepodařilo.',
'Select some persons to notify'=>'Vyberte ludí pro notifikáciu',
'WARNING: Failed to mail %s persons'=>'VAROVANIE: nepodarilo se e-mailovat pro %s osob',
'Sent notification to %s person(s)'=>'Odeslané upozornění pro %s osob',
'Select some persons to edit' =>'Vyberte nejaké osoby pro úpravy',
'Could not get Person'        =>'Nelze načíst osobu',
'Edit Person|page type'       =>'Upravit osobu',
'Adjust user-rights'          =>'Přizpůsobit oprávnení',
'Please consider that activating login-accounts might trigger security-issues.'=>'Berte do úvahy, že aktivace přihlašovacích účtů může zpusobit bezpečnostní problémy',
'Person can login|form label' =>'Osoba se může přihlásit',
'User rights changed'         =>'Oprávnení uživatele byly změněny',

### ../pages/proj.inc.php   ###
'Active'                      =>'Aktivní',
'Templates'                   =>'Šablony',
'Your Active Projects'        =>'Tvoje aktivní projekty',
'relating to %s'              =>'vážíci se k %s',
'List|page type'              =>'Seznam',
'<b>NOTE</b>: Some projects are hidden from your view. Please ask an administrator to adjust you rights to avoid double-creation of projects'=>'<b>UPOZORNĚNÍ</b>: Některé projekty jsou pro tebe skryté. Prosím požádej administrátora, aby upravil tvoje práva, aby nedošlo vícnásobnému vytvářaní projektů',
'create new project'          =>'vytvořit nový projekt',
'not assigned to a project'   =>'nepřiřazený k projektu',
'Your Closed Projects'        =>'Tvoje uzavřené projekty',
'invalid project-id'          =>'neplatné id projektu',
'Edit this project'           =>'Upravit tento projekt',

### ../pages/task.inc.php   ###
'new'                        =>'nové:',

### ../pages/proj.inc.php   ###
'Add person as team-member to project'=>'Přidat osobu jako člena týmu',
'Team member'                 =>'Člen týmu',
'Create task'                 =>'Vytvořit úkol',
'Create task with issue-report'=>'Vytvořit úkol s hlásením problému',
'open'                        =>'otevřené',


### ../pages/task.inc.php   ###
'Bug'                         =>'Chyba',

### ../pages/proj.inc.php   ###
'Book effort for this project'=>'Zaznamenat práci pro tento projekt',

### ../std/constant_names.inc.php   ###
'Effort'                      =>'Práce',

### ../pages/proj.inc.php   ###
'Details|block title'         =>'Detaily',
'Client|label'                =>'Klient',
'Phone|label'                 =>'Telefón',
'E-Mail|label'                =>'E-mail',
'Status|Label in summary'     =>'Stav',
'Wikipage|Label in summary'   =>'Wiki stránka',
'Projectpage|Label in summary'=>'Stránka projektu',
'Opened|Label in summary'     =>'Otevřené',
'Closed|Label in summary'     =>'Uzavřené',
'Created by|Label in summary' =>'Vytvořil',
'Last modified by|Label in summary'=>'Naposledy změnil',
'Logged effort'               =>'Zaznamenaná práce',
'hours'                       =>'hodiny',
'Team members'                =>'Členové týmu',
'Your tasks'                  =>'Tvoje úkoly',
'No tasks assigned to you.'   =>'Pro tebe nejsou přiřazené úkoly',
'All project tasks'           =>'Všechny úkoly projektu',
'Comments on project'         =>'Komentáře k projektu',
'Closed Tasks'                =>'Uzavřené úkoly',
'No tasks have been closed yet'=>'ještě žádný úkol nebyl uzavřen',
'changed project-items'       =>'změněné položky projektu',
'no changes yet'              =>'zatím bez změn',
'all open'                    =>'všechny otevřené',
'all my open'                 =>'všechny moje otevřené',
'my open for next milestone'  =>'moje otevřené pro další milník',
'not assigned'                =>'nepřiřazené',
'blocked'                     =>'blokované',
'open bugs'                   =>'otvořená chyba',
'to be approved'              =>'na schválení',
'open tasks'                  =>'otevřené úkoly',
'my open tasks'               =>'moje otevřené úkoly',
'next milestone'              =>'nasledující milník',
'Create a new folder for tasks and files'=>'Vytvořit novou složku pro úkoly a soubory',

### ../pages/task.inc.php   ###
'new subtask for this folder' =>'nové podúkoly pro tento složka',

### ../pages/proj.inc.php   ###
'Filter-Preset:'              =>'Přednastavení filtru:',
'No tasks'                    =>'Bez úkolů',
'Project Issues'              =>'Problémy projektu',
'Add Bugreport'               =>'Přidat hlášení chyby',

### ../render/render_misc.inc.php   ###
'Issues'                      =>'Problémy',

### ../pages/proj.inc.php   ###
'Report Bug'                  =>'Hlášení chyby',
'new Effort'                  =>'nová práce',
'Upload file|block title'     =>'Odeslat soubor',
'new Milestone'               =>'nový milník',
'View open milestones'        =>'Zobrazit otevřené milníky',
'View closed milestones'      =>'Zobrazit uzavřené milníky',
'Project Efforts'             =>'Práce projektu',
'Company|form label'          =>'Firma',
'Select some projects to delete'=>'Vybrat některé projekty na smazání',
'WARNING: Failed to delete %s projects'=>'VAROVÁNÍ: Nepodařilo se smazat %s projektů',
'Moved %s projects to trash'=>'%s projektů presunutých do odpadků',
'Select some projects...'     =>'Vyber nejaký projekt...',
'Invalid project-id!'         =>'Neplatné id projektu',
'Y-m-d'                       =>'R-m-d',
'WARNING: Failed to change %s projects'=>'VAROVÁNÍ: Nepodařilo se změnit %s projektů',
'Closed %s projects'          =>'Uzatvorených %s projektů',
'Reactivated %s projects'     =>'Reaktivovaných %s projektů',
'Select new team members'     =>'Vyber nového člena týmu',
'Found no persons to add. Go to `People` to create some.'=>'Nejsou dostupné žádné osoby. Jdi do časti `Lidé` a vytvoř nekoho.',
'Add'                         =>'Přidat',
'No persons selected...'      =>'Žádná osoba není označená',
'Could not access person by id'=>'Není možné přistoupit o osobě přez id',
'NOTE: reanimated person as team-member'=>'UPOZORNĚNÍ: osoba znovu zařazená do týmu.',
'NOTE: person already in project'=>'UPOZORNĚNÍ: osoba je už v projekte ',
'Template|as addon to project-templates'=>'Šablona',
'Failed to insert new project person. Data structure might have been corrupted'=>'Nepodařilo se vložit novou osobu. Datová struktura může být poškozená.',
'Failed to insert new issue. DB structure might have been corrupted.'=>'Nepodařilo se vložit nový problém. Datová struktura může být poškozená.',
'Failed to update new task. DB structure might have been corrupted.'=>'Nepodařilo se aktualizovat nový úkol. Datová struktura může být poškozená.',
'Failed to insert new comment. DB structure might have been corrupted.'=>'Nepodařilo se vložit komentář. Datová struktura může být poškozená.',
'Project duplicated (including %s items)'=>'Duplicitní projekt (včetně %s položek)',
'Select a project to edit description'=>'Vyber projekt, kterému chceš upravit popis',

### ../pages/task.inc.php   ###
'Edit description'            =>'Upravit popis',

### ../pages/projectperson.inc.php   ###
'Edit Team Member'            =>'Upravit člena týmu',
'role of %s in %s|edit team-member title'=>'role %s v %s',
'Role in this project'        =>'Role v projektu',
'start times and end times'   =>'počáteční a koncový čas',
'duration'                    =>'trvání',
'Log Efforts as'              =>'Zaznamenat práci jako',
'Changed role of <b>%s</b> to <b>%s</b>'=>'Změněná role z <b>%s</b> na <b>%s</b>',

### ../pages/search.inc.php   ###
'Jumped to the only result found.'=>'Přejít na jediný nálezený výsledek',
'Search Results'              =>'Výsledky hledání',
'Searching'                   =>'Hledání',
'Found %s companies'          =>'Nalezených %s firiem',
'Found %s projects'           =>'Nalezených %s projektů',
'Found %s persons'            =>'Nalezených %s osob',
'Found %s tasks'              =>'Nalezených %s úkol',
'Found %s comments'           =>'Nalezených %s komentářů',
'Sorry. Could not find anything.'=>'lituji. Nic jsem nenašel',
'Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters'=>'Kvoli limitom MySQL fulltextové hledání nebude fungovat pre...<br>- slová s 3 a menej znakmi<br>- Seznamami s menej ako 3 položkami<br>- slovami obsahujúcimi špeciálne znaky',
'Other team members changed nothing since last logout (%s)'=>'Ostatní členové týmu nic nezměnili od posledního odhlášení (%s)',

### ../pages/task.inc.php   ###
'Edit this task'              =>'Upravit túto úkol',
'Delete this task'            =>'Smazat túto úkol',
'Restore this task'           =>'Obnovit túto úkol',
'Undelete'                    =>'Obnovit',
'new bug for this folder'     =>'nová chyba pro tento složka',
'new task for this milestone' =>'nový úkol pro tento milník',
'Append details'              =>'Přidat detaily',
'Complete|Page function for task status complete'=>'Ukončit',
'Approved|Page function for task status approved'=>'Schválit',
'Description|Label in Task summary'=>'Popis',
'Part of|Label in Task summary'=>'Patří do',
'Status|Label in Task summary'=>'Stav',
'Opened|Label in Task summary'=>'Otevřené',
'Planned start|Label in Task summary'=>'Plánovaný začátek',
'Planned end|Label in Task summary'=>'Plánovaný konec',
'Closed|Label in Task summary'=>'Zavřené',
'Created by|Label in Task summary'=>'Vytvořil',
'Last modified by|Label in Task summary'=>'Naposledy upravil',
'Logged effort|Label in task-summary'=>'Zaznamenaná práce',
'Attached files'              =>'Pripojené soubory',
'attach new'                  =>'připojit úkol',
'Upload'                      =>'Odeslat',
'Issue report'                =>'Report problému',
'Plattform'                   =>'Platforma',
'OS'                          =>'OS',
'Build'                       =>'Sestavení',
'Steps to reproduce|label in issue-reports'=>'Kroky k reprodukcií',
'Expected result|label in issue-reports'=>'Očakávaný výsledek',
'Suggested Solution|label in issue-reports'=>'Navrhované řešení',
'No project selected?'        =>'Žádný projekt si neoznačil?',
'Please select only one item as parent'=>'Vyber prosím len jednu položku jako nadřazenou',
'Insufficient rights for parent item.'=>'Nedostatočné práva pro nadřazenou položku',
'could not find project'      =>'není možné nájst projekt',
'I guess you wanted to create a folder...'=>'Předpokladám, že si chcel vytvořit složka',
'Assumed <b>%s</b> to be mean label <b>%s</b>'=>'Předpokladám, že <b>%s</b> znamená označení <b>%s</b>',
'Bug|Task-Label that causes automatically addition of issue-report'=>'Chyba',
'Feature|Task label that added by default'=>'Vlastnost',
'No task selected?'           =>'Žádný úkol není označen?',
'Edit %s|Page title'          =>'Upravit %s',
'New task'                    =>'Nový úkol',
'for %s|e.g. new task for something'=>'pro %s',
'-- undefined --'             =>'--nedefinované--',
'Resolved in'                 =>'Vyřešeno v',
'- select person -'           =>'--výběr osoby--',
'Assign to'                   =>'Přiřazené k',
'Assign to|Form label'        =>'Přiradit k',
'Also assign to|Form label'   =>'Též přiradit k',
'Prio|Form label'             =>'Priorita',

### ../std/constant_names.inc.php   ###
'undefined'                   =>'nedefinované',

### ../pages/task.inc.php   ###
'30 min'                      =>'30 min',
'1 h'                         =>'1 h',
'2 h'                         =>'2 h',
'4 h'                         =>'4 h',
'1 Day'                       =>'1 den',
'2 Days'                      =>'2 dny',
'3 Days'                      =>'3 dny',
'4 Days'                      =>'4 dny',
'1 Week'                      =>'1 týden',
'1,5 Weeks'                   =>'1,5 týdenů',
'2 Weeks'                     =>'2 týdeny',
'3 Weeks'                     =>'3 týdeny',
'Completed'                   =>'Dokončeno',
'Severity|Form label, attribute of issue-reports'=>'Náročnost',
'reproducibility|Form label, attribute of issue-reports'=>'reprodukovatelnost',
'unassigned to %s|task-assignment comment'=>'nepřiřazené k %s',
'formerly assigned to %s|task-assigment comment'=>'predtým přiřazená k %s',
'task was already assigned to %s'=>'úkol už byl přiřazen k %s',
'Failed to retrieve parent task'=>'Nepodařilo se získat nadřazený úkol',
'Task requires name'          =>'Úkol vyžaduje název',
'ERROR: Task called %s already exists'=>'CHYBA: Úkol s názvom %s už existuje',
'Turned parent task into a folder. Note, that folders are only listed in tree'=>'Nadřazený úkol je preměněný na složku. Všimni si, že složky jsou zobrazené v stromové štruktúře',
'Failed, adding to parent-task'=>'Nepodařilo se přidat nadřazený úkol',
'NOTICE: Ungrouped %s subtasks to <b>%s</b>'=>'POZNÁMKA: Nezoskupených %s podúkol k %s',
'HINT: You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'=>'TIP: Zmenil si úkol <b>%s</b> na složka. Složky jsou zobrazené v samostatném sezname úkol-složek.',
'NOTE: Created task %s with ID %s'=>'POZNÁMKA: Vytvořený úkol %s s ID %s',
'NOTE: Changed task %s with ID %s'=>'POZNÁMKA: Změněný úkol %s s ID %s',
'Select some tasks to move'   =>'Vyber nejaké úkoly na přesun',
'Can not move task <b>%s</b> to own child.'=>'Není možné přesunout úkol <b>%s</b do vlastného potomka',
'Can not edit tasks %s'       =>'Není možné upravit úkol %s',
'insufficient rights to edit any of the selected items'=>'nedostatočné práva na úpravu označených položiek',
'Select folder to move tasks into'=>'Vyber složka, do ktorého se mejú presunout úkoly',
'(or select nothing to move to project root)'=>'(nebo nic neoznač, když se úkoly majú presunout do nejvyšší úrovně',
'Task <b>%s</b> deleted'      =>'Úkol <b>%s</b> byla zmazaná',
'Moved %s tasks to trash'  =>'%s úkolů presunutých do koše',
' ungrouped %s subtasks to above parents.'=> ' neseskupené %s úkoly pod nadřazenými',
'No task(s) selected for deletion...'=>'Žádné úkoly ne jsou označené na smazání...',
'ERROR: could not retrieve task'=>'CHYBA: není možné získat úkol',
'Task <b>%s</b> does not need to be restored'=>'Úkol <b>%s</b> nepotřebuje byt obnovený',
'Task <b>%s</b> restored'     =>'Úkol <b>%s</b> je obnovený',
'Failed to restore Task <b>%s</b>'=>'Nepodařilo se obnovit úkol <b>%s</b>',
'Task <b>%s</b> do not need to be restored'=>'Úkol <b>%s</b> nepotřebuje byt obnovený',
'No task(s) selected for restoring...'=>'Žádné úkoly ne jsou označené na obnovení...',
'Select some task(s) to mark as completed'=>'Vyber nejaké úkoly na označení jako ukončené',
'Marked %s tasks (%s subtasks) as completed.'=>'%s úkolů (%s podúkolů) označených ako ukončené',
'%s error(s) occured'         =>'Vyskytlo se %s chýb',
'Select some task(s) to mark as approved'=>'Vyber nejaké úkoly na schválení',
'Marked %s tasks as approved and hidden from project-view.'=>'%s označených úkol ako schválených a ukrytých z náhladu na projekt',
'Select some task(s)'         =>'Vyber nejaké úkoly',
'could not update task'       =>'není možné aktualizovat úkoly',
'No task selected to add issue-report?'=>'Žádný úkol není označená na přidaní hlášení o chybě',
'Task already has an issue-report'=>'Úkol už má hlášení o chybe',
'Adding issue-report to task' =>'Pridaní hlášení o chybe k úkole',
'Could not get task'          =>'Neviem získat úkol',
'Select a task to edit description'=>'Vyber nejaké úkoly na úpravu popisu',

### ../render/render_form.inc.php   ###
'Please use Wiki format'      =>'Prosím, použijte Wiki formát',
'Submit'                      =>'Odeslat',
'Cancel'                      =>'Zrušit',
'Apply'                       =>'Použít',

### ../render/render_list.inc.php   ###
'for milestone %s'            =>'pro mílník',
'changed today'               =>'změněné dnes',
'changed since yesterday'     =>'změněné od včera',
'changed since <b>%d days</b>'=>'změněné pro <b>%d dňami</b>',
'changed since <b>%d weeks</b>'=>'změněné pro <b>%d týždňami</b>',
'created by %s'               =>'vytvořil %s',
'created by unknown'          =>'vytvořil neznámy',
'modified by %s'              =>'změnil %s',
'modified by unknown'         =>'změnil neznámy',
'item #%s has undefined type' =>'položka #%s má nedefinovaný typ',
'do...'                       =>'udělat co ...',

### ../render/render_list_column_special.inc.php   ###
'Tasks|short column header'   =>'Úkoly',
'Number of open tasks is hilighted if shown home.'=>'',
'S|Short status column header'=>'S',
'Status is %s'                =>'Stav je %s',
'Item is public to'           =>'Položka je verejná pre',
'Pub|column header for public level'=>'Pub.',
'Public to %s'                =>'Zverejnit pro %s',

### ../render/render_misc.inc.php   ###
'Tasks|Project option'        =>'Úkoly',
'Completed|Project option'    =>'Dokončeno',
'Milestones|Project option'   =>'Milníky',
'Files|Project option'        =>'Soubory',
'Efforts|Project option'      =>'Práce',
'History|Project option'      =>'Historie',
'new since last logout'       =>'nové od posledného odhlášení',
'Yesterday'                   =>'Včera',

### ../render/render_page.inc.php   ###
'<span class=accesskey>H</span>ome'=>'Do<span class=accesskey>m</span>ů',
'<span class=accesskey>P</span>rojects'=>'<span class=accesskey>P</span>rojekty',
'Your related People'         =>'S tebou prepojení lidé',
'Your related Companies'      =>'S tebou prepojené firmy',
'Calendar'                    =>'Kalendář',
'<span class=accesskey>S</span>earch:&nbsp;'=>'<span class=accesskey>H</span>ledání:&nbsp;',
'Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`'=>'Klikni na Tab pro komplexní vyhledávání nebo zadej slovo* bouchni na return. Použij Alt-S jako zkratku. Užij Vyhledávání.',
'This page requires java-script to be enabled. Please adjust your browser-settings.'=>'Táto stránka potřebuje mat povolený java-script. Uprav si nastavení prohlížeče.',
'Add Now'                     =>'Přidat teď',
'you are'                     =>'ty jsi',
'Return to normal view'       =>'Návrat do bežného zobrazení',
'Leave Client-View'           =>'Ponechat klientské zobrazení',
'How this page looks for clients'=>'Jak vidí tuto stránku klient',
'Client view'                 =>'Klientské zobrazení',
'Documentation and Discussion about this page'=>'Dokumentace a diskuze o teto stránce',
'Help'                        =>'Nápověda',

### ../render/render_wiki.inc.php   ###
'enlarge'                     =>'Zvětšit',
'Unknown File-Id:'            =>'Neznáme ID souboru:',
'Unknown project-Id:'         =>'Neznáme ID projektu:',
'Wiki-format: <b>$type</b> is not a valid link-type'=>'Wiki-formát: <b>$type</b> není platný typ odkazu',
'No task matches this name exactly'=>'Žádný úkol nezodpovídá presne tomuto názvu',
'This task seems to be related'=>'Zdá sa, že táto úkola je vázaná',
'No item excactly matches this name.'=>'Žádná položka neodpovídá přesně tomuto názvu.',
'List %s related tasks'       =>'Seznam %s previazaných úkol',
'identical'                   =>'identické',
'No item matches this name. Create new task with this name?'=>'Žádná položka nezodpovídá tomuto názvu. Vytvořit novou úkol s tímto názvom?',
'No item matches this name.'  =>'Žádná položka nezodpovídá tomuto názvu.',
'No item matches this name'   =>'Žádná položka nezodpovídá tomuto názvu',

### ../std/class_auth.inc.php   ###
'Fresh login...'              =>'Čerstvé přihlášení...',
'Cookie is no longer valid for this computer.'=>'Cookie už není platné pro tento počítač.',
'Your IP-Address changed. Please relogin.'=>'Tvoja IP adresa se změnila. Prihlás se opät prosím.',
'Your account has been disabled. '=>'Tvoj účet byl zablokovaný.',
'Could not set cookie.'       =>'Není možné nastavit cookie.',

### ../std/class_pagehandler.inc.php   ###
'WARNING: operation aborted (%s)'=>'VAROVANIE: operácia byla prerušená (%s)',
'FATAL: operation aborted with an fatal error (%s).'=>'ZÁVAŽNÉ: operácia byla prerušená kvoli závažnej chybe (%s).',
'Error: Insuffient rights'    =>'Chyba: nedostatočné oprávnenia',
'FATAL: operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'ZÁVAŽNÉ: operácia byla prerušená kvoli závažnej databázovej chybe štruktúry (%s). K tomuto prichádza pri nekonzistentnosti databázy. Odporúčam ti vrátit se aktuálnej zálohe.',
'NOTE: %s|Message when operation aborted'=>'OZNAM: %s',
'ERROR: %s|Message when operation aborted'=>'CHYBA: %s',

### ../std/common.inc.php   ###
'No element selected? (could not find id)|Message if a function started without items selected'=>'Žiadny zvolený element (není možné nájst id)?',

### ../std/constant_names.inc.php   ###
'template|status name'        =>'šablona',
'undefined|status_name'       =>'nedefinované',
'upcoming|status_name'        =>'nastávající',
'new|status_name'             =>'nové',
'open|status_name'            =>'otevřené',
'blocked|status_name'         =>'blokované',
'done?|status_name'           =>'ukončené?',
'approved|status_name'        =>'odsouhlasené',
'closed|status_name'          =>'uzavřené',
'undefined|pub_level_name'    =>'nedefinované',
'Member|profile name'         =>'Člen',
'Admin|profile name'          =>'Správce',
'private|pub_level_name'      =>'soukromý',
'suggested|pub_level_name'    =>'navrhované',
'internal|pub_level_name'     =>'interní',
'open|pub_level_name'         =>'veřejné',
'client|pub_level_name'       =>'klient',
'cliend_edit|pub_level_name'  =>'klient_úpravy',
'assigned|pub_level_name'     =>'přiřazené',
'owned|pub_level_name'        =>'vlastněné',
'priv|short for public level private'=>'souk.',
'int|short for public level internal'=>'int.',
'pub|short for public level client'=>'veř.',
'PUB|short for public level client edit'=>'VEŘ',
'A|short for public level assigned'=>'P',
'O|short for public level owned'=>'V',
'Create projects|a user right'=>'Vytvořit projekty',
'Edit projects|a user right'  =>'Upravit projekty',
'Delete projects|a user right'=>'Smazat projekty',
'Edit project teams|a user right'=>'Upravit projektové týmy',
'View anything|a user right'  =>'Zobrazit vše',
'Edit anything|a user right'  =>'Upravit vše',
'Create Persons|a user right' =>'Vytvořit osoby',
'Create & Edit Persons|a user right'=>'Vytvořit a upravit osoby',
'Delete Persons|a user right' =>'Odstranit osoby',
'View all Persons|a user right'=>'Zobrazit všechny osoby',
'Edit User Rights|a user right'=>'Upravit práva prístupu',
'Edit Own Profil|a user right'=>'Upravit vlastný profil',
'Create Companies|a user right'=>'Vytvořit firmy',
'Edit Companies|a user right' =>'Upravit firmy',
'Delete Companies|a user right'=>'Odstranit firmy',
'undefined|priority'          =>'nedefinované',
'urgend|priority'             =>'urgentní',
'high|priority'               =>'vysoká',
'normal|priority'             =>'normální',
'lower|priority'              =>'nižší',
'lowest|priority'             =>'nízká',
'Team Member'                 =>'Člen týmu',
'Employment'                  =>'Zaměstnanost',
'Issue'                       =>'Problém',
'Task assignment'             =>'Priřazení úkolu',
'Nitpicky|severity'           =>'Snoření',
'Feature|severity'            =>'Vlastnost',
'Trivial|severity'            =>'Triviální',
'Text|severity'               =>'Text',
'Tweak|severity'              =>'Vylepšení',
'Minor|severity'              =>'Vedlejší',
'Major|severity'              =>'Hlavní',
'Crash|severity'              =>'Pád',
'Block|severity'              =>'Blok',
'Not available|reproducabilty'=>'Nedostupné',
'Always|reproducabilty'       =>'Vždy',
'Sometimes|reproducabilty'    =>'Niekedy',
'Have not tried|reproducabilty'=>'Neotestované',
'Unable to reproduce|reproducabilty'=>'Neopakovatelné',
'done|Resolve reason'         =>'hotovo',  # line 154
'fixed|Resolve reason'        =>'opraveno',  # line 155
'works_for_me|Resolve reason' =>'zdá_se_funkční',  # line 156
'duplicate|Resolve reason'    =>'duplicitní',  # line 157
'bogus|Resolve reason'        =>'falešný',  # line 158
'rejected|Resolve reason'     =>'odmítnutý',  # line 159
'deferred|Resolve reason'     =>'odložený',  # line 160

### ../std/mail.inc.php   ###
'Failure sending mail: %s'    =>'Neúspešné odeslaní e-mailu: %s',
'Streber Email Notification|notifcation mail from'=>'E-mailové Streber upozornení:',
'Updates at %s|notication mail subject'=>'Aktualizácia %s',
'Hello %s,|notification'      =>'Ahoj %s,',
'with this automatically created e-mail we want to inform you that|notification'=>'tento automaticky vytvořený e-mail tě chce upozornit, že',
'since %s'                    =>'od %s',
'following happened at %s |notification'=>'došlo k těmto udalostem na %s',
'Your account has been created.|notification'=>'Byl pro tebe vytvořený účet.',
#'Please set password to activate it.|notification'=>'Prosím nastav si pro neho heslo, aby se aktivoval.',
'You have been assigned to projects:|notification'=>'Byl si přiřazený k projektu:',
'Please set a password to activate it.|notification'=>'Prosím nastav si pro něho heslo, aby se aktivoval.',
'Project Updates'             =>'Aktualizáce projektů',
#'If you do not want to get further notifications feel free to|notification'=>'Ak nechcete dostávat ďalšie upozorenia, tak',
'adjust your profile|notification'=>'si upravte profil',
'Thanks for your time|notication'=>'Díky za tvůj čas',
'the management|notication'   =>'Menežment',
'No news for <b>%s</b>'       =>'Žádne informáce pro <b>%s</b>',
'If you do not want to get further notifications or you forgot your password feel free to|notification'=>'Pokud nechcete dostávat další upozornení, tak',

#new?
'Project manager|profile name' =>'Manažér projektu',
'Developer|profile name' =>'Vývojář',
'Artist|profile name' =>'Grafik',
'Tester|profile name' =>'Tester',
'Client|profile name' =>'Klient',
'Client trusted|profile name' =>'Důvěryhodný klient',
'Guest|profile name' =>'Návštevník',
'view changes|' =>'zobrazit změny',
'Mark tasks as Open|' =>'Označit úkoly jako otevřené',
'Move files to folder|' =>'Presunout soubory do složky',
'List Deleted Persons|' =>'Seznam zmazaných osob',
#
### ../pages/_handles.inc.php   ###
'Edit multiple Tasks'         =>'Upravit více úkol',
'view changes'                =>'zobrazit změny',
'Mark tasks as Open'          =>'Označit úkol jako otevřenú',
'Move files to folder'        =>'Přesunout soubory do složky',
'List Deleted Persons'        =>'Seznam zmazaných lidí',
'Filter errors.log'           =>'Filtrovat errors.log',
'Delete errors.log'           =>'Smazat errors.log',

### ../pages/comment.inc.php   ###
'Failed to delete %s comments'=>'Nepodařilo se smazat %s komentářů',

### ../pages/company.inc.php   ###
'related projects of %s'      =>'prepojené projekty %s',
'Person already related to company'=>'Osoba je už prepojená na firmu',
'Failed to delete %s companies'=>'Nepodařilo se smazat %s firiem',

### ../pages/effort.inc.php   ###
'Failed to delete %s efforts' =>'Nepodařilo se smazat %s práci',

### ../pages/file.inc.php   ###
'Failed to delete %s files'   =>'Nepodařilo se smazat %s souborů',
'Select some files to move'   =>'Vyber nejaké soubory na přesun',
'Can not edit file %s'        =>'Není možné upravit soubor %s',
'Edit files'                  =>'Upravit soubory',
'Select folder to move files into'=>'Vyber složku, do ktoré se soubory přesunou',
'No folders available'        =>'Žádná složka není dostupná',
'Move this file to another task'=>'Přesuň soubor do jiného úkolu',  # line 121
'Move'                        =>'Přesun',  # line 122

### ../pages/home.inc.php   ###
'Projects'                    =>'Projekty',

### ../pages/misc.inc.php   ###
'Failed to restore %s items'  =>'Nepodařilo se obnovit %s položek',
'Error-Log'                   =>'Záznam chyb',
'hide'                        =>'skryt',

### ../pages/person.inc.php   ###
'Deleted People'              =>'Smazaný lidé',
'notification:'               =>'upozornění:',
'no company'                  =>'bez firmy',
'Person details'              =>'Detaily osoby',

### ../pages/task_more.inc.php   ###
'Invalid checksum for hidden form elements'=>'Nesprávny kontrolný součet pro skryté elementy formulářa',

### ../pages/person.inc.php   ###
'The changed profile <b>does not affect existing project roles</b>! Those has to be adjusted inside the projects.'=>'Změněný profil <b>onevlivňuje existující pravidla projektů</b>! Ty je potřebné upravit v rámci projektů.',
'Nickname has been converted to lowercase'=>'Prezývka byla skonvertovaná na malé písmená',
'Nickname has to be unique'   =>'Prezývka musí byt jedinečná',
'Passwords do not match'      =>'Heslá nesouhlasia',
'Could not insert object'     =>'Není možné vložit objekt',
'Failed to delete %s persons' =>'Nepodařilo se smazat %s osob',
'Failed to mail %s persons'   =>'Nepodařilo se poslat e-mail %s osobám',

### ../pages/proj.inc.php   ###
'not assigned to a closed project'=>'nepřidělený k uzavřenému projektu',
'no project templates'        =>'projekt nemá šablonu',

### ../pages/task_view.inc.php   ###
'Wiki'                        =>'Wiki',

### ../pages/proj.inc.php   ###
'my open'                     =>'moje otevřené',
'for milestone'               =>'pro milník',
'needs approval'              =>'potřebuje schválení',
'Failed to delete %s projects'=>'Nepodařilo se smazat %s projektů',
'Failed to change %s projects'=>'Nepodařilo se změnit %s projektů',
'Reanimated person as team-member'=>'Osoba znovu zařazená do týmu',
'Person already in project'   =>'Osoba je součastou projektu',

### ../pages/projectperson.inc.php   ###
'Failed to remove %s members from team'=>'Nepodařilo se odstranit %s členov týmu',
'Unassigned %s team member(s) from project'=>'%s zrušených členov týmu z projektu',

### ../pages/search.inc.php   ###
'in'                          =>'v',
'on'                          =>'na',
'jumped to best of %s search results'=>'zobrazit nejlepší z %s výsledkov hladania',
'Add an ! to your search request to jump to the best result.'=>'Pridej ! k požadavku na hledání, aby se hned zobrazil nejlepší výsledek.',
'%s search results for `%s`'  =>'%s výsledků hladání pro `%s`',
'No search results for `%s`'  =>'Žádné výsledky hladání pro `%s`',

### ../pages/task_view.inc.php   ###
'Move|page function to move current task'=>'',  # line 193
'new bug for this folder'     =>'',  # line 173
'new task for this milestone' =>'',  # line 165
'Add Details|page function'   =>'Přidat detail',
'Move|page function to move current task'=>'Presunout',
'status:'                     =>'stav:',
'Reopen|Page function for task status reopened'=>'Znovu otevřené',
'View history of item'        =>'Zobrazit histórii položky',
'History'                     =>'Historie',
'For Milestone|Label in Task summary'=>'Pro milník',
'Estimated|Label in Task summary'=>'Předpokladané',
'Completed|Label in Task summary'=>'Dokončeno',
'Created|Label in Task summary'=>'Vytvořené',
'Modified|Label in Task summary'=>'Upravené',
'Open tasks for milestone'    =>'Otevřené úkoly pro milník',
'No open tasks for this milestone'=>'Milník nemá otevřené úkoly',

### ../pages/task_more.inc.php   ###
'Parent task not found.'      =>'Rodičovské úkoly nejsou nájdené',
'You do not have enough rights to edit this task'=>'Nemáte dost práv na úpravu této úkoly',
'New milestone'               =>'Nový milník',
'Create another task after submit'=>'Vytvořit další úkol po odeslaní',
'Task called %s already exists'=>'Úkol s názvem %s už existuje',
'You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'=>'Zmenil si úkol <b>%s</b> do složky. Složky jsou zobrazené v samostatném seznamu úkol-složek.',
'Created task %s with ID %s'  =>'Vytvořený úkol %s s ID %s',
'Changed task %s with ID %s'  =>'Změněný úkol %s s ID %s',
'Failed to delete task $task->name'=>'Nepodařilo se smazat úkol $task->name',
'Could not find task'         =>'Není možné najít úkol',
'Select some task(s) to reopen'=>'Vyber nějaké úkoly k znovu-otevření',
'Reopened %s tasks.'          =>'Znovu-otevřených %s úkol',
'Could not update task'       =>'Není možné aktualizovat úkol',
'changes'                     =>'změny',
'View task'                   =>'Zobrazit úkol',
'item has not been edited history'=>'položka nemá upravenú históriu',
'unknown'                     =>'neznáme',
' -- '                        =>' -- ',
'&lt;&lt; prev change'        =>'&lt;&lt; predch. změna',
'next &gt;&gt;'               =>'nasled. &gt;&gt;',
'summary'                     =>'sumář',
'Item did not exists at %s'   =>'Položka neexistuje v %s',
'no changes between %s and %s'=>'bez změn mezi %s a %s',
'ok'                          =>'OK',
'For editing all tasks must be of same project.'=>'Všechny upravované úkoly musí být ze stejného projektu',
'Edit multiple tasks|Page title'=>'Upravit více úkol',
'Edit %s tasks|Page title'    =>'Upravit %s úkol',
'-- keep different --'        =>'-- různé --',
'Prio'                        =>'Prio',
'- none -'                    =>'- nic -',
'%s tasks could not be written'=>'%s úkol nemůže být zapsaných',
'Updated %s tasks tasks'      =>'Aktualizovaných %s úkol',

### ../pages/task_view.inc.php   ###
'Public to|Label in Task summary'=>'Veřejné pro',

### ../render/render_fields.inc.php   ###
#'<b>%s</b> isn't a known format for date.'=>'<b>%s</b> není známy formát dátumu.',

### ../render/render_form.inc.php   ###
'Wiki format'                 =>'Wiki formát',

### ../render/render_list_column_special.inc.php   ###
'Status|Short status column header'=>'Stav',

### ../render/render_misc.inc.php   ###
'Other Persons|page option'   =>'Ostatní osoby',
'Deleted|page option'         =>'Smazané',
'%s hours'                    =>'%s hodin',
'%s days'                     =>'%s dní',
'%s weeks'                    =>'%s týdnů',
'%s hours max'                =>'max. %s hodin',
'%s days max'                 =>'max. %s dní',
'%s weeks max'                =>'max. %s týdnů',

### ../render/render_wiki.inc.php   ###
'from'                        =>'z',

### ../std/class_pagehandler.inc.php   ###
'Operation aborted (%s)'      =>'Operace je prerušena (%s)',
'Operation aborted with an fatal error (%s).'=>'Operace je prerušena kvůli závažné chybě (%s)',
'Operation aborted with an fatal error which was cause by an programming error (%s).'=>'Operace je prerušena kvůli závažné chybě, kterou způsobila programátorská chyba (%s)',
'Insuffient rights'           =>'Nedostatečná práva',
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'Operace je prerušena kvůli závažné chybě databáze (%s). K tomuto prichádza pri nekonzistentnosti databázy. Odporúčam ti vrátit se aktuálnej zálohe.',
'%s|Message when operation aborted'=>'%s',

### ../std/common.inc.php   ###
'only one item expected.'     =>'iba jedná položka byla očakávaná',

### ../std/constant_names.inc.php   ###
'client_edit|pub_level_name'  =>'klient_edit',

### ../db/class_issue.inc.php   ###
'Production build'            =>'Produkční sestavení',

### ../db/class_project.inc.php   ###
'show tasks in home'          =>'okázat úkoly na dom. str.',
'only team members can create items'=>'jen členové týmu mohou vytvářet položky',

### ../db/class_task.inc.php   ###
'resolved in version'         =>'vyriešené vo verzií',

### ../pages/task_view.inc.php   ###
'Resolve reason'              =>'Stav řešení',

### ../db/class_task.inc.php   ###
'is a milestone'              =>'je milník',
'released'                    =>'vypuštěno',
'release time'                =>'čas vypuštění',

### ../lists/list_versions.inc.php   ###
'Released Milestone'          =>'Vypuštěný milník',

### ../db/db.inc.php   ###
'Database exception. Please read %s next steps on database errors.%s'=>'',

### ../lists/list_comments.inc.php   ###
'Add Comment'                 =>'Přidat komentář',
'Shrink All Comments'         =>'Spakovat všechny koment.',
'Collapse All Comments'       =>'Zbalit všechny koment.',
'Expand All Comments'         =>'Rozbalit všechny komentáře',
'Reply'                       =>'Odpovědet',
'1 sub comment'               =>'1 pod koment.',
'%s sub comments'             =>'%s pod koment.',

### ../lists/list_efforts.inc.php   ###
'Effort description'          =>'Popis práce',
'%s effort(s) with %s hours'  =>'%s práce za %s hodin',
'Effort name. More Details as tooltips'=>'Název práce. Víc detailů jako popis nástroje',

### ../lists/list_files.inc.php   ###
'Details/Version|Column header'=>'Detaily/Verze',

### ../lists/list_versions.inc.php   ###
'Release Date'                =>'Datum vydání',

### ../pages/_handles.inc.php   ###
'Versions'                    =>'Verze',
'Task Test'                   =>'Test úkolu',
'View Task Efforts'           =>'Zobrazit vykonanou práci na úkolu',
'New released Version'      =>'Nový vypuštěný milník',
'View effort'                 =>'Zobrazit práci',
'View multiple efforts'       =>'Zobrazit výcero prácí',
'List Clients'                =>'Seznam klientů',
'List Prospective Clients'    =>'Seznam perspektívnych klientů',
'List Suppliers'              =>'Seznam dodávatelů',
'List Partners'               =>'Seznam partnerů',
'Remove persons from company' =>'Odstranit osoby zo spoločnosti',
'List Employees'              =>'Seznam zamestnanců',

### ../pages/comment.inc.php   ###
'Publish to|form label'       =>'Publikovat',

### ../pages/company.inc.php   ###
'Clients'                     =>'Klienty',
'related companies of %s'     =>'odpovídající společnosti',
'Prospective Clients'         =>'Perspektívní klienti',
'Suppliers'                   =>'Dodávatelé',
'Partners'                    =>'Partneři',
'Remove person from company'  =>'Odstranit osobu ze spoločnosti',

### ../pages/person.inc.php   ###SPS-SVH-09_2006-20061006.pdf
'Category|form label'         =>'Kategórie',

### ../pages/company.inc.php   ###
'Failed to remove %s contact person(s)'=>'Nepodařilo se odstranit %s kontaktních osob',
'Removed %s contact person(s)'=>'%s kontaktních osob ostraněných',

### ../pages/effort.inc.php   ###
'Select one or more efforts'  =>'Vyberte jednu nebo více prací',
'You do not have enough rights'=>'Nemáte dostatočné práva',
'Effort of task|page type'    =>'Práce na úkolu',
'Edit this effort'            =>'Upravit toto práci',
'Project|label'               =>'Projekt',
'Task|label'                  =>'Úkol',
'No task related'             =>'Žádná návazný úkol',
'Created by|label'            =>'Vytvořil',
'Created at|label'            =>'Vytvořené v',
'Duration|label'              =>'Trvání',
'Time start|label'            =>'Začátek',
'Time end|label'              =>'Konec',
'No description available'    =>'Popis není dostupný',
'Multiple Efforts|page type'  =>'Výcenásobná práce',
'Multiple Efforts'            =>'Výcenásobná práce',
'Information'                 =>'Informáce',
'Number of efforts|label'     =>'Počet prací',
'Sum of efforts|label'        =>'Suma prací',
'from|time label'             =>'z',
'to|time label'               =>'do',
'Time|label'                  =>'Čas',

### ../pages/version.inc.php   ###
'Publish to'                  =>'Publikovatelnost',


### ../pages/person.inc.php   ###
'Employees|Pagetitle for person list'=>'Zamestnanci',
'Contact Persons|Pagetitle for person list'=>'Kontaktní osoby',
'Person %s created'           =>'Osoba %s vytvořená',

### ../pages/proj.inc.php   ###
'all'                         =>'vše',
'without milestone'           =>'bez milníku',
'Released Versions'           =>'Vydané verze',
'New released Version'      =>'Nový vypuštěný milník',
'Tasks resolved in upcomming version'=>'Úkoly vyřešené v nadcházející verzi',

### ../pages/search.inc.php   ###
'cannot jump to this item type'=>'není možné skočit na takýto typ položky',

### ../pages/version.inc.php   ###
'New Version'                 =>'Nová verze',

### ../pages/task_more.inc.php   ###
'Select some task(s) to edit' =>'Vyberte nejaké úkoly na úpravu',
'-- next released version --' =>'',
'Release as version|Form label, attribute of issue-reports'=>'Vypustit jako verzi',
'Reproducibility|Form label, attribute of issue-reports'=>'Reprodukovatelnost',
'Marked %s tasks to be resolved in this version.'=>'Označit %s úkol za vyřešené v této verzi',
'Failed to add comment'       =>'Nepodařilo se přidat komentář',
'Failed to delete task %s'    =>'Nepodařilo se smazat úkol %s',
'Task Efforts'                =>'Práce na úkolu',
'date1 should be smaller than date2. Swapped'=>'',
'prev change'                 =>'předch. změna',
'next'                        =>'dál',
'keep different'              =>'udržet jiné',
'none'                        =>'nic',

### ../pages/task_view.inc.php   ###
'next released version'       =>'další vyp. verze',

### ../pages/task_more.inc.php   ###
'resolved in Version'         =>'vyřešeno ve verzi',
'Resolve Reason'              =>'Důvod řešení',
'-- next released version --' =>'-- další vypuštěná verze --',  # line 457
'Note'                        =>'Poznámka',  # line 3121
'Create new note'             =>'Vytvořit novou poznámku',  # line 3124

### ../pages/task_view.inc.php   ###
'Released as|Label in Task summary'=>'Vydat jako',
'Publish to|Label in Task summary'=>'Publikovatelnost',
'Severity|label in issue-reports'=>'Důležitost',
'Reproducibility|label in issue-reports'=>'Reprodukovatelnost',
'Sub tasks'                   =>'Podúkoly',
'1 Comment'                   =>'1 komentář',
'%s Comments'                 =>'%s komentářů',
'Comment / Update'            =>'Komentář/Aktualizace',
'quick edit'                  =>'Rýchla úprava',
'Set to Open'                 =>'Nastav jako veřejný',  # line 350
'new bug for this folder'     =>'nová chyba pro tuto složku',  # line 173
'Hurry up!'					  =>'Mákni na tom',
'new task for this milestone' =>'nový úkol pro milník',  # line 165

### ../pages/version.inc.php   ###
'Edit Version|page type'      =>'Upravit verzi',
'Edit Version|page title'     =>'Upravit verzi',
'New Version|page title'      =>'Nová verze',
'Could not get version'       =>'Není možné získat verzi',
'Could not get project of version'=>'Nelze získat verzi projektu',
'Select some versions to delete'=>'Vyberte které verze smazat',
'Failed to delete %s versions'=>'Nezdařilo se smazat %s verze',
'Moved %s versions to trash'=>'Verze %s přesunuté do koše',
'Version|page type'           =>'Verze',
'Edit this version'           =>'Upravit tuto verzi',

### ../render/render_fields.inc.php   ###
'<b>%s</b> is not a known format for date.'=>'',

### ../render/render_list_column_special.inc.php   ###
'Number of open tasks is hilighted if shown home.'=>'',
'Item is published to'        =>'Položka k publikaci',
'Publish to %s'               =>'publikovat do %s',
'Select / Deselect'           =>'Vybrat / Odvybrat',

### ../render/render_misc.inc.php   ###
'Clients|page option'         =>'Klienti',
'Prospective Clients|page option'=>'Potenciální klienti',
'Suppliers|page option'       =>'Dodávatelé',
'Partners|page option'        =>'Partneři',
'Companies|page option'       =>'Spoločnosti',
'Versions|Project option'     =>'Verze',
'Employees|page option'       =>'Zamestnanci',
'Contact Persons|page option' =>'Kontaktné osoby',
'All Companies|page option'   =>'Všechny společnosti',

### ../render/render_wiki.inc.php   ###
'Wiki-format: <b>%s</b> is not a valid link-type'=>'Wiki-format: <b>%s</b> není platný typ odkazu',

### ../std/class_auth.inc.php   ###
'Unable to automatically detect client time zone'=>'Není možné automaticky zjistit časovou zónu klienta',

### ../std/constant_names.inc.php   ###
'client_edit|pub_level_name'  =>'klientska_uprava',
'urgent|priority'             =>'urgentní',
'done|resolve reason'         =>'hotové',
'fixed|resolve reason'        =>'opravené',
'works_for_me|resolve reason' =>'pracuj_pro_me',
'duplicate|resolve reason'    =>'duplikované',
'bogus|resolve reason'        =>'nepravdivé',
'rejected|resolve reason'     =>'odmítnuté',
'deferred|resolve reason'     =>'odložené',
'Not defined|release type'    =>'Nedefinované',
'Not planned|release type'    =>'Neplánované',
'Upcomming|release type'      =>'Následující',
'Internal|release type'       =>'Interní',
'Public|release type'         =>'Veřejné',
'Without support|release type'=>'Bez podpory',
'No longer supported|release type'=>'Už nepodporované',
'undefined|company category'  =>'nedefinované',
'client|company category'     =>'klient',
'prospective client|company category'=>'potenciální klient',
'supplier|company category'   =>'dodavatel',
'partner|company category'    =>'partner',
'undefined|person category'   =>'nedefinované',
'- employee -|person category'=>'- zaměstanec -',
'staff|person category'       =>'zaměstnanci',
'freelancer|person category'  =>'živnostník',
'working student|person category'=>'pracující student',
'apprentice|person category'  =>'učeň',
'intern|person category'      =>'praktikant',
'ex-employee|person category' =>'ex-zamestnanec',
'- contact person -|person category'=>'- kontaktní osoba -',
'client|person category'      =>'klient',
'prospective client|person category'=>'potenciální klient',
'supplier|person category'    =>'dodavatel',
'partner|person category'     =>'partner',


);
?>
