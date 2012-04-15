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
* translation into: Slovak
*
*    translated by: Zdenko Podobný
*
*             date: 26.06.2006
*
*  streber version: 0.63
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
'assign to'                   =>'pridelené',

### ../lists/list_changes.inc.php   ###
'deleted'                     =>'zmazané',

### ../_files/prj932/1326.index.php   ###
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter you name and use the <b>forgot password link</b> below.'=>'Ľutujem, ale tento aktivačný kód už nie je platný. Ak už máte účet, môžete vložiť svoje meno a použiť <b>Zabudol som svoje heslo</b>.',

### ../pages/company.inc.php   ###
'Summary'                     =>'Sumár',

### ../db/class_comment.inc.php   ###
'Details'                     =>'Detaily',

### ../lists/list_projects.inc.php   ###
'Name'                        =>'Názov',

### ../db/class_company.inc.php   ###
'Required. (e.g. pixtur ag)'  =>'Vyžadované. (napr. pixtur ag)',
'Short|form field for company'=>'Krátky názov',
'Optional: Short name shown in lists (eg. pixtur)'=>'Voliteľné: Krátky názov zobrazovaný v zoznamoch (napr. pixtur)',
'Tag line|form field for company'=>'Slogan',

### ../db/class_person.inc.php   ###
'Optional: Additional tagline (eg. multimedia concepts)'=>'Voliteľné: Dodatočný slogan (napr. v multimediálnych konceptoch)',

### ../db/class_company.inc.php   ###
'Phone|form field for company'=>'Telefón',
'Optional: Phone (eg. +49-30-12345678)'=>'Voliteľné: telefónne číslo (napr. +49-30-12345678)',
'Fax|form field for company'  =>'Fax',
'Optional: Fax (eg. +49-30-12345678)'=>'Voliteľné: faxové číslo (napr. +49-30-12345678)',
'Street'                      =>'Ulica',
'Optional: (eg. Poststreet 28)'=>'Voliteľné: (napr. Poštová ulica 28)',
'Zipcode'                     =>'PSČ',
'Optional: (eg. 12345 Berlin)'=>'Voliteľné: Poštové smerové číslo (napr. 12345 Berlín) ',
'Website'                     =>'Web stránka ',
'Optional: (eg. http://www.pixtur.de)'=>'Voliteľné: (napr. http://www.pixtur.de)',
'Intranet'                    =>'Intranet',
'Optional: (eg. http://www.pixtur.de/login.php?name=someone)'=>'Voliteľné: (http://www.pixtur.de/login.php?name=niekto)',
'E-Mail'                      =>'E-mail',
'Comments|form label for company'=>'Komentáre',

### ../db/class_person.inc.php   ###
'Optional'                    =>'Voliteľné',

### ../db/class_company.inc.php   ###
'more than expected'          =>'viac ako bolo očakávané',
'not available'               =>'nedostupné',

### ../db/class_effort.inc.php   ###
'optional if tasks linked to this effort'=>'voliteľné, ak úlohy sú prepojené na toto úsilie',
'Time Start'                  =>'Začiatok',

### ../db/class_milestone.inc.php   ###
'Time End'                    =>'Koniec',

### ../pages/task.inc.php   ###
'Description'                 =>'Popis',

### ../db/class_issue.inc.php   ###
'Production build'            =>'',
'Steps to reproduce'          =>'Kroky na reprodukovanie',
'Expected result'             =>'Očakávaný výsledok',
'Suggested Solution'          =>'Navrhované riešenie',

### ../db/class_milestone.inc.php   ###
'optional if tasks linked to this milestone'=>'voliteľné, ak sú úlohy prepojené na tento míľnik',

### ../lists/list_milestones.inc.php   ###
'Planned for'                 =>'Plánované pre',

### ../db/class_person.inc.php   ###
'Full name'                   =>'Celé meno',
'Required. Full name like (e.g. Thomas Mann)'=>'Vyžadované. Celé meno ako napr. Thomas Mann',
'Nickname'                    =>'Prezývka',
#'only required if user can login (e.g. pixtur)'=>'vyžadované, iba ak sa má používateľ prihlasovať (napr. pixtur)',
'Optional: Color for graphical overviews (e.g. #FFFF00)'=>'Voliteľné: Farba pre grafický prehľad (napr.  #FFFF00)',

### ../lists/list_persons.inc.php   ###
'Tagline'                     =>'Slogan',

### ../db/class_person.inc.php   ###
'Mobile Phone'                =>'Mobilný telefón',
'Optional: Mobile phone (eg. +49-172-12345678)'=>'Voliteľné: Mobilné telefónne číslo (napr. +49-172-12345678)',
'Office Phone'                =>'Telefón',
'Optional: Office Phone (eg. +49-30-12345678)'=>'Voliteľné: Telefónne číslo do kancelárie (napr. +49-30-12345678)',
'Office Fax'                  =>'Fax ',
'Optional: Office Fax (eg. +49-30-12345678)'=>'Voliteľné: Telefónne číslo do kancelárie (napr. +49-30-12345678)',
'Office Street'               =>'Adresa',
'Optional: Official Street and Number (eg. Poststreet 28)'=>'Voliteľné: Ulica a číslo domu kancelárie (napr. Poštová 2)',
'Office Zipcode'              =>'PSČ',
'Optional: Official Zip-Code and City (eg. 12345 Berlin)'=>'Voliteľné: PSČ kancelárie a Mesto (napr. 81101 Bratislava)',
'Office Page'                 =>'Web stránka',
'Optional: (eg. www.pixtur.de)'=>'Voliteľné: (napr. www.pixtur.de)',
'Office E-Mail'               =>'E-mail',
'Optional: (eg. thomas@pixtur.de)'=>'Voliteľné: (napr. thomas@pixtur.de)',
'Personal Phone'              =>'Súkromný telefón ',
'Optional: Private Phone (eg. +49-30-12345678)'=>'Voliteľné: Súkromný telefón (napr. +49-30-12345678)',
'Personal Fax'                =>'Súkromný fax',
'Optional: Private Fax (eg. +49-30-12345678)'=>'Voliteľné: Súkromný telefón (napr. +49-30-12345678)',
'Personal Street'             =>'Súkromná adresa',
'Optional:  Private (eg. Poststreet 28)'=>'Voliteľné: Ulica a číslo domu (napr. Poštová 5)',
'Personal Zipcode'            =>'PSČ súkromnej adresy',
'Optional: Private (eg. 12345 Berlin)'=>'Voliteľné: PSČ súkromnej adresy a mesto (napr. 81101 Bratislava)',
'Personal Page'               =>'Osobná stránka',
'Personal E-Mail'             =>'Súkromný e-mail',
'Birthdate'                   =>'Dátum narodenia',

### ../db/class_project.inc.php   ###
'Color'                       =>'Farba',
'Status summary'              =>'Sumár stavu',

### ../pages/task.inc.php   ###
'Comments'                    =>'Komentáre',

### ../db/class_person.inc.php   ###
'Password'                    =>'Heslo',
'Only required if user can login|tooltip'=>'Vyžadované iba ak sa používateľ môže prihlásiť',

### ../render/render_page.inc.php   ###
'Profile'                     =>'Profil',

### ../db/class_person.inc.php   ###
'Theme|Formlabel'             =>'Téma',

### ../pages/comment.inc.php   ###
'insufficient rights'           =>'nedostatočné práva',

### ../db/class_task.inc.php   ###
'Short'                       =>'Krátky',

### ../db/class_task.inc.php   ###
'Date start'                  =>'Dátum začiatku',
'Date closed'                 =>'Dátum uzatvorenia',

### ../render/render_list_column_special.inc.php   ###
'Status'                      =>'Stav',

### ../db/class_project.inc.php   ###
'Project page'                =>'Stránka projektu',
'Wiki page'                   =>'Wiki stránka',

### ../pages/home.inc.php   ###
'Priority'                    =>'Priorita',

### ../std/constant_names.inc.php   ###
'Company'                     =>'Spoločnosť',

### ../db/class_project.inc.php   ###
'show tasks in home'          =>'zobraziť úlohy "doma"',
'validating invalid item'     =>'vyhodnotenie neplatnej položky',
'insufficient rights (not in project)'=>'nedostatočné práva (nie si v projekte)',

### ../pages/proj.inc.php   ###
'Project Template'            =>'Šablóna projektu',
'Inactive Project'            =>'Neaktívny projekt',
'Project|Page Type'           =>'Projekt',

### ../db/class_projectperson.inc.php   ###
'job'                         =>'úloha',
'role'                        =>'rola',

### ../pages/task.inc.php   ###
'For Milestone'               =>'pre míľnik',

### ../pages/task_view.inc.php   ###
'edit'                       =>'upraviť',

### ../db/class_task.inc.php   ###
'resolved_version'            =>'',
'show as folder (may contain other tasks)'=>'zobraziť ako priečinok (môže obsahovať iné úlohy)',
'is a milestone / version'    =>'je míľnik / verzia',
'milestones are shown in a different list'=>'míľniky sú zobrazené v rôznych zoznamoch',
'Completion'                  =>'Dokončenie',

### ../pages/task.inc.php   ###
'Estimated time'              =>'Predpokladané trvanie',
'Estimated worst case'        =>'Najhorší variant',
'Label'                       =>'Označenie',

### ../db/class_task.inc.php   ###
'Planned Start'               =>'Plánovaný začiatok',
'Planned End'                 =>'Plánovaný koniec',

### ../pages/task.inc.php   ###
'task without project?'       =>'úlohy bez projektu?',

### ../pages/proj.inc.php   ###
'Folder'                      =>'Priečinok',

### ../lists/list_tasks.inc.php   ###
'Milestone'                   =>'Míľnik',

### ../std/constant_names.inc.php   ###
'Task'                        =>'Úloha',

### ../db/db.inc.php   ###
'Database exception'          =>'Databázová výnimka',
'Database exception. Please read <a href=\'http://streber.pixtur.de/index.php?go=taskView&tsk=1272\'>next steps on database errors.</a>'=>'Databázová výnimka. Prosím prečítajte si <a href=\'http://streber.pixtur.de/index.php?go=taskView&tsk=1272\'>, kde sú ďalšie kroky pre databázové chyby.',

### ../db/db_item.inc.php   ###
'<b>%s</b> isn`t a known format for date.'=>'<b>%s</b> nie je známy formát pre dátum.',
'unnamed'                     =>'nepomenované',
'Unknown'                     =>'Neznáme',
'Item has been modified during your editing by %s (%s minutes ago). Your changes can not be submitted.'=>'Položku počas tvojej úpravy zmenil %s (pred %s minútami). Tvoje zmeny nemôžu byť odoslané',

### ../lists/list_changes.inc.php   ###
'to|very short for assigned tasks TO...'=>'k',
'in|very short for IN folder...'=>'v',

### ../lists/list_projectchanges.inc.php   ###
'modified'                    =>'zmenené',

### ../lists/list_changes.inc.php   ###
'New Comment'                 =>'Nový komentár',
'read more...'                =>'čítať viac...',
'Last of %s comments:'        =>'Posledných %s komentárov:',
'comment:'                    =>'komentár',
'completed'                   =>'dokončené',
'Approve Task'                =>'Schváliť úlohu',
'approved'                    =>'schválené',
'closed'                      =>'uzatvorené',
'reopened'                    =>'znovu otvorené',
'is blocked'                  =>'je blokované',
'moved'                       =>'presunuté',
'changed:'                    =>'zmenené:',
'commented'                   =>'komentované',
'reassigned'                  =>'preradené',
'renamed'                     =>'premenované',
'edit wiki'                   =>'upraviť wiki',
'assigned'                    =>'priradené',
'attached'                    =>'pridaný',
'attached file to'            =>'pridaný súbor k',

### ../lists/list_projectchanges.inc.php   ###
'restore'                     =>'obnoviť',

### ../pages/proj.inc.php   ###
'Changes'                     =>'Zmeny',

### ../lists/list_changes.inc.php   ###
'Date'                        =>'Dátum',
'Who changed what when...'    =>'Kto, čo a kedy zmenil...',
'what|column header in change list'=>'čo',
'Date / by'                   =>'Dátum / kto',

### ../render/render_page.inc.php   ###
'Edit'                        =>'Upraviť',

### ../lists/list_taskfolders.inc.php   ###
'New'                         =>'Nový',

### ../pages/task.inc.php   ###
'Delete'                      =>'Odstrániť',

### ../lists/list_comments.inc.php   ###
'Move to Folder'              =>'Presunúť do priečinku',
'Shrink View'                 =>'Zmenšiť zobrazenie',
'Expand View'                 =>'Rozvinúť zobrazenie',
'Topic'                       =>'Téma',
'Date|column header'          =>'Dátum',
'By|column header'            =>'Od',

### ../lists/list_companies.inc.php   ###
'related companies'           =>'prepojené firmy',
'Company|Column header'       =>'Firma',

### ../lists/list_persons.inc.php   ###
'Name Short'                  =>'Krátke meno',
'Shortnames used in other lists'=>'Krátke mená používané v iných zoznamoch',

### ../pages/company.inc.php   ###
'Phone'                       =>'Telefón',

### ../lists/list_companies.inc.php   ###
'Phone-Number'                =>'Telefónne číslo',
'Proj'                        =>'Proj',
'Number of open Projects'     =>'Počet otvorených projektov',

### ../render/render_page.inc.php   ###
'People'                      =>'Ľudia',

### ../lists/list_companies.inc.php   ###
'People working for this person'=>'Ľudia pracujúci pre túto osobu',
'Edit company'                =>'Upraviť firmu',
'Delete company'              =>'Zmazať firmu',
'Create new company'          =>'Vytvoriť novú firmu',

### ../lists/list_files.inc.php   ###
'Name|Column header'          =>'Názov',
'Parent item'                 =>'Rodičovská položka',
'ID'                          =>'ID',
'Click on the file ids for details.'=>'Viac detailov sa zobrazí po kliknutí na ID súboru',
'Move files'                  =>'Presunúť súbory',
'File|Column header'          =>'Súbor',
'in|... folder'               =>'v',
'Attached to|Column header'   =>'Pripojiť k',

### ../lists/list_efforts.inc.php   ###
'no efforts booked yet'       =>'zatiaľ bez zaznamenaného úsilia',

### ../pages/person.inc.php   ###
'Efforts'                     =>'Úsilie',

### ../std/constant_names.inc.php   ###
'Project'                     =>'Projekt',

### ../lists/list_efforts.inc.php   ###
'person'                      =>'Osoba',

### ../lists/list_projects.inc.php   ###
'Task name. More Details as tooltips'=>'Názov úlohy. Detaily sa zobrazia ako tip.',

### ../lists/list_efforts.inc.php   ###
'Edit effort'                 =>'Upraviť úsilie',
'New effort'                  =>'Nové úsilie',
'booked'                      =>'zaznamenané',
'estimated'                   =>'očakávané',
'Task|column header'          =>'Úloha',
'Start|column header'         =>'Začiatok',
'D, d.m.Y'                    =>'D, d.m.R',
'End|column header'           =>'Koniec',
'len|column header of length of effort'=>'Dĺžka',
'Daygraph|columnheader'       =>'Denný graf',

### ../pages/file.inc.php   ###
'Type'                        =>'Typ',

### ../pages/task.inc.php   ###
'Version'                     =>'Verzia',

### ../lists/list_files.inc.php   ###
'Size'                        =>'Veľkosť',

### ../pages/_handles.inc.php   ###
'Edit file'                   =>'Upraviť súbor',

### ../lists/list_files.inc.php   ###
'New file'                    =>'Nový súbor',
'No files uploaded'           =>'Bez odoslaných súborov',
'Download|Column header'      =>'Stiahnuť',

### ../pages/proj.inc.php   ###
'Milestones'                  =>'Míľniky',

### ../lists/list_tasks.inc.php   ###
'Started'                     =>'Začaté',
'%s hidden'                   =>'%s krytých',
'Task name'                   =>'Názov úlohy',

### ../pages/task.inc.php   ###
'New folder'                  =>'Nový priečinok',

### ../pages/company.inc.php   ###
'or'                          =>'alebo',

### ../lists/list_milestones.inc.php   ###
'Due Today'                   =>'Plánované na dnes',
'%s days late'                =>'%s dní v omeškaní',
'%s days left'                =>'zostáva %s dní',
'Tasks open|columnheader'     =>'Otvorené úlohy',
'Open|columnheader'           =>'Otvorené',
'%s open'                     =>'%s otvorených',
'Completed|columnheader'      =>'Ukončené',
'Completed tasks: %s'         =>'Ukončené úlohy: %s',
'closed'                      =>'uzatvorený',
'%s required'                 =>'%s je vyžadované',

### ../lists/list_persons.inc.php   ###
'Private'                     =>'Privátne',
'Mobil'                       =>'Mobil',
'Office'                      =>'Kancelária',

### ../render/render_page.inc.php   ###
'Companies'                   =>'Spoločnosti',

### ../lists/list_persons.inc.php   ###
'last login'                  =>'posledné prihlásenie',
'Edit person'                 =>'Upraviť osobu',

### ../pages/_handles.inc.php   ###
'Edit user rights'            =>'Upraviť používateľské prístupy',

### ../lists/list_persons.inc.php   ###
'Delete person'               =>'Zmazať osobu',
'Active Projects|column header'=>'Aktívne projekty',
'Create new person'           =>'Vytvoriť novú osobu',
'Profile|column header'       =>'Profil',
'Account settings for user (do not confuse with project rights)'=>'Nastavenie účtu pre používateľa (nezamieňať si právami k projektom)',
'(adjusted)'                  =>'(upravené)',

### ../render/render_list_column_special.inc.php   ###
'Priority is %s'              =>'Priorita je %s',

### ../lists/list_persons.inc.php   ###
'recent changes|column header'=>'posledné zmeny',
'changes since YOUR last logout'=>'zmeny od posledného odhlásenia',

### ../lists/list_project_team.inc.php   ###
'Your related persons'        =>'Prepojené osoby na teba',
'Rights'                      =>'Práva',
'Persons rights in this project'=>'Práva osôb v tomto projekte',
'Edit team member'            =>'Upraviť člena tímu',
'Add team member'             =>'Pridať člena tímu',
'Remove person from team'     =>'Odstrániť osobu z tímu',
'Member'                      =>'Člen',
'Role'                        =>'Rola',
'last Login|column header'    =>'posledné prihlásenie',

### ../render/render_list_column_special.inc.php   ###
'Created by'                  =>'Vytvoril',

### ../lists/list_projectchanges.inc.php   ###
'Item was originally created by'=>'Položka bola pôvodne vytvorená',
'C'                           =>'V',
'Created,Modified or Deleted' =>'Vytvorené, Zmenené alebo Odstránené',
'Deleted'                     =>'Odstránené',

### ../render/render_list_column_special.inc.php   ###
'Modified'                    =>'Zmenené',

### ../lists/list_projectchanges.inc.php   ###
'by Person'                   =>'osobou',
'Person who did the last change'=>'Osoba, ktorá urobila poslednú zmenu',
'Type|Column header'          =>'Typ',
'Item of item: [T]ask, [C]omment, [E]ffort, etc '=>'Položka položky: [Ú]loha, [K]omentár, Ú[s]ilie',
'item %s has undefined type'  =>'položka %s má nedefinovaný typ',
'Del'                         =>'Zma',
'shows if item is deleted'    =>'zobrazí zmazané položky',
'(on comment)'                =>'(na komentár)',
'(on task)'                   =>'(na úlohu)',
'(on project)'                =>'(na projekt)',

### ../lists/list_projects.inc.php   ###
'Project priority (the icons have tooltips, too)'=>'Priority projektu',

### ../pages/home.inc.php   ###
'Task-Status'                 =>'Stav úlohy',

### ../lists/list_projects.inc.php   ###
'Status Summary'              =>'Sumár',
'Short discription of the current status'=>'Krátky popis aktuálneho stavu',

### ../pages/proj.inc.php   ###
'Tasks'                       =>'Úlohy',

### ../lists/list_projects.inc.php   ###
'Number of open Tasks'        =>'Počet otvorených úloh',
'Opened'                      =>'Otvorené',
'Day the Project opened'      =>'Dátum vytvorenia projektu',

### ../pages/proj.inc.php   ###
'Closed'                      =>'Uzatvorené',

### ../lists/list_projects.inc.php   ###
'Day the Project state changed to closed'=>'Deň keď stav projektu bol zmenený na uzatvorený',
'Edit project'                =>'Upraviť projekt',
'Delete project'              =>'Zmazať projekt',
'Log hours for a project'     =>'Zaznamenať hodiny pre projekt',
'Open / Close'                =>'Otvoriť / Uzatvoriť',

### ../pages/company.inc.php   ###
'Create new project'          =>'Vytvoriť nový projekt',

### ../pages/_handles.inc.php   ###
'Create Template'             =>'Vytvoriť šablónu',
'Project from Template'       =>'Projekt zo šablóny',

### ../lists/list_projects.inc.php   ###
'... working in project'      =>'...pracujúci na projekte',

### ../pages/proj.inc.php   ###
'Folders'                     =>'Priečinky',

### ../lists/list_taskfolders.inc.php   ###
'Number of subtasks'          =>'Počet podúloh',
'Create new folder under selected task'=>'Vytvoriť nový priečinok pod zvolenou úlohou',
'Move selected to folder'     =>'Presunúť so zvoleného priečinka',

### ../lists/list_tasks.inc.php   ###
'Log hours for select tasks'  =>'Zaznamenané hodiny pre označené úlohy',
'Priority of task'            =>'Priorita úlohy',
'Status|Columnheader'         =>'Stav',
'Modified|Column header'      =>'Zmenené',
'Est.'                        =>'Očak.',

### ../pages/home.inc.php   ###
'Estimated time in hours'     =>'Predpokladaný čas v hodinách',

### ../lists/list_tasks.inc.php   ###
'Add new Task'                =>'Pridať novú úlohu',
'Report new Bug'              =>'Oznámiť novú chybu',
'Add comment'                 =>'Pridať komentár',
'Status->Completed'           =>'Stav->Ukončený',
'Status->Approved'            =>'Stav->Schválený',
'Move tasks'                  =>'Presunúť úlohy',
'Latest Comment'              =>'Posledný komentár',
'by'                          =>'od',
'for'                         =>'pre',
'%s open tasks / %s h'        =>'%s otvorených úloh / %s h',
'Label|Columnheader'          =>'Označenie',

### ../pages/task.inc.php   ###
'Assigned to'                 =>'Priradené k',

### ../lists/list_tasks.inc.php   ###
'Name, Comments'              =>'Meno, komentár',
'has %s comments'             =>'má %s komentárov',
'Task has %s attachments'     =>'Úloha ma %s príloh',
'- no name -|in task lists'   =>'- bez mena -',
'number of subtasks'          =>'počet podúloh',
'Sum of all booked efforts (including subtasks)'=>'Súčet celého zaznamenaného úsilia (vrátane podúloh)',
'Effort in hours'             =>'Úsilie v hodinách',
'Days until planned start'    =>'Dni do plánovaného začiatku',
'Due|column header, days until planned start'=>'Plán',
'planned for %s|a certain date'=>'plánované na %s',
'Est/Compl'                   =>'Pred./Ukon.',
'Estimated time / completed'  =>'Predpoklad času/ukončenia',
'estimated %s hours'          =>'predpokladaných %s hodín',
'estimated %s days'           =>'predpokladaných %s dní',
'estimated %s weeks'          =>'predpokladaných %s týždňov',
'%2.0f%% completed'           =>'dokončené na %2.0f%%',

### ../pages/_handles.inc.php   ###
'Home'                        =>'Domov',
'Active Projects'             =>'Aktívne projekty',
'Closed Projects'             =>'Uzatvorené projekty',

### ../pages/proj.inc.php   ###
'Project Templates'           =>'Šablóny projektov',

### ../pages/_handles.inc.php   ###
'View Project'                =>'Zobraziť projekt',

### ../pages/proj.inc.php   ###
'Uploaded Files'              =>'Odoslané súbory',
'Closed tasks'                =>'Uzatvoriť úlohy',
'New project'                 =>'Nový projekt',

### ../pages/_handles.inc.php   ###
'Edit Project Description'    =>'Upraviť popis projektu',

### ../pages/proj.inc.php   ###
'Edit Project'                =>'Upraviť projekt',

### ../pages/_handles.inc.php   ###
'Delete Project'              =>'Odstrániť projekt',
'Change Project Status'       =>'Zmeniť stav projektu',
'Add Team member'             =>'Pridať člena tímu',
'Edit Team member'            =>'Upraviť člena tímu',
'Remove from team'            =>'Odstrániť člena tímu',
'View Task'                   =>'Zobraziť úlohu',
'Edit Task'                   =>'Upraviť úlohu',
'Delete Task(s)'              =>'Odstrániť úlohu',
'Restore Task(s)'             =>'Obnoviť úlohu',
'Move tasks to folder'        =>'Presunúť úlohy do priečinka',
'Mark tasks as Complete'      =>'Označiť úlohy ako vyriešené',
'Mark tasks as Approved'      =>'Označiť úlohy ako schválené',
'New Task'                    =>'Nová úloha',
'New bug'                     =>'Nová chyba',

### ../pages/task.inc.php   ###
'New Milestone'               =>'Nový míľnik',

### ../pages/_handles.inc.php   ###
'Toggle view collapsed'       =>'Prepnúť zobrazenie',
'Add issue/bug report'        =>'Pridať hlásenie problému/chyby',
'Edit Description'            =>'Upraviť popis',
'Log hours'                   =>'Zaznamenať hodiny',
'Edit time effort'            =>'Upraviť čas úsilia',
'View comment'                =>'Zobraziť komentár',
'Create comment'              =>'Vytvoriť komentár',
'Edit comment'                =>'Upraviť komentár',
'Delete comment'              =>'Zmazať komentár',
'View file'                   =>'Zobraziť súbor',
'Upload file'                 =>'Odoslať',
'Update file'                 =>'Aktualizovať súbor',

### ../pages/file.inc.php   ###
'Download'                    =>'Stiahnuť',

### ../pages/_handles.inc.php   ###
'Show file scaled'            =>'Zobraziť súbor v inej mierke',
'List Companies'              =>'Zoznam firiem',
'View Company'                =>'Zobraziť firmy',

### ../pages/company.inc.php   ###
'New company'                 =>'Nová firma',
'Edit Company'                =>'Upraviť firmu',

### ../pages/_handles.inc.php   ###
'Delete Company'              =>'Odstrániť firmu',

### ../pages/company.inc.php   ###
'Link Persons'                =>'Prepojiť osoby',

### ../pages/_handles.inc.php   ###
'List Persons'                =>'Zoznam ľudí',
'View Person'                 =>'Zobraziť osoby',

### ../pages/person.inc.php   ###
'New person'                  =>'Nová osoba',

### ../pages/_handles.inc.php   ###
'Edit Person'                 =>'Upraviť osobu',
'Delete Person'               =>'Zmazať osobu',
'View Efforts of Person'      =>'Zobraziť námahu osoby',
'Send Activation E-Mail'      =>'Odoslať aktivačný e-mail',
'Flush Notifications'         =>'Odoslať notifikáciu',
'Login'                       =>'Prihlásenie',

### ../render/render_page.inc.php   ###
'Logout'                      =>'Odhlásenie',

### ../pages/_handles.inc.php   ###
'License'                     =>'Licencia',
'restore Item'                =>'obnoviť položku',

### ../pages/error.inc.php   ###
'Error'                       =>'Chyba',

### ../pages/_handles.inc.php   ###
'Activate an account'         =>'Aktivovať účet',
'System Information'          =>'Systémové informácie',
'PhpInfo'                     =>'PhpInfo',
'Search'                      =>'Hľadať',

### ../pages/comment.inc.php   ###
'Comment on task|page type'   =>'Komentár k úlohe',

### ../pages/task.inc.php   ###
'(deleted %s)|page title add on with date of deletion'=>'(zmazané %s)',

### ../pages/comment.inc.php   ###
'Edit this comment'           =>'Upraviť tento komentár',
'New Comment|Default name of new comment'=>'Nový komentár',
'Reply to |prefix for name of new comment on another comment'=>'Odpovedať',

### ../std/constant_names.inc.php   ###
'Comment'                     =>'Komentár',

### ../pages/comment.inc.php   ###
'Edit Comment|Page title'     =>'Upraviť komentár',
'New Comment|Page title'      =>'Nový komentár',
'On task %s|page title add on'=>'Na úlohe %s',

### ../pages/file.inc.php   ###
'On project %s|page title add on'=>'Na projekte %s',

### ../pages/comment.inc.php   ###
'Occasion|form label'         =>'Dôvod',
'Public to|form label'        =>'Zverejniť pre',
'Select some comments to delete'=>'Označ niektoré komentáre na zmazanie',
'WARNING: Failed to delete %s comments'=>'VAROVANIE: Nepodarilo sa zmazať %s komentárov',
'Moved %s comments to trash'=>'%s komentárov presunutých do odpadkov',
'Select some comments to move'=>'Označ niektoré komentáre na presun',

### ../pages/task.inc.php   ###
'insufficient rights'         =>'nedostatočné oprávnenia',

### ../pages/comment.inc.php   ###
'Can not edit comment %s'     =>'Nie je možné upraviť komentár %s',

### ../pages/task.inc.php   ###
'Edit tasks'                  =>'Upraviť úlohy',

### ../pages/comment.inc.php   ###
'Select one folder to move comments into'=>'Vyber jeden priečinok, do ktorého sa presunú komentáre',
'... or select nothing to move to project root'=>'... alebo neoznač nič, ak chceš presun do základu projektu',
'No folders in this project...'=>'V tomto projekte nie je priečinok...',

### ../pages/task.inc.php   ###
'Move items'                  =>'Presunúť položky',

### ../pages/company.inc.php   ###
'related projects of %s'      =>'',

### ../pages/proj.inc.php   ###
'admin view'                  =>'zobrazenie admina',
'List'                        =>'Zoznam',

### ../pages/company.inc.php   ###
'no companies'                =>'bez firiem',

### ../pages/proj.inc.php   ###
'Overview'                    =>'Prehľad',

### ../pages/company.inc.php   ###
'Edit this company'           =>'Upraviť túto firmu',
'edit'                        =>'upraviť',
'Create new person for this company'=>'Vytvoriť novú osobu pre túto firmu',

### ../std/constant_names.inc.php   ###
'Person'                      =>'Osoba',

### ../pages/company.inc.php   ###
'Create new project for this company'=>'Vytvoriť nový projekt pre túto firmu',
'Add existing persons to this company'=>'Pridať existujúcu osobu do tejto firmy',
'People'                     =>'Ľudia',
'Adress'                      =>'Adresa',
'Fax'                         =>'Fax',
'Web'                         =>'Web',
'Intra'                       =>'Intra',
'Mail'                        =>'E-mail',
'related Persons'             =>'prepojené osoby',
'link existing Person'        =>'prepojiť existujúcu osobu',
'create new'                  =>'vytvoriť novú',
'no persons related'          =>'bez prepojenej osoby',
'Active projects'             =>'Aktívne projekty',
' Hint: for already existing projects please edit those and adjust company-setting.'=>'Tip: existujúce projekty prosím upravte a nastavte v nich firmu',
'no projects yet'             =>'zatiaľ bez projektov',
'Closed projects'             =>'Uzatvorené projekty',
'Create another company after submit'=>'Vytvoriť inú firmu po odoslaní',
'Edit %s'                     =>'Upraviť %s',
'Add persons employed or related'=>'Pridať osoby zamestnané alebo previazané',
'NOTE: No persons selected...'=>'UPOZORNENIE: Bez označených osôb...',
'NOTE person already related to company'=>'UPOZORNENIE: Osoba je už previazaná na firmu',
'Select some companies to delete'=>'Označiť niektoré firmy na zmazanie',
'WARNING: Failed to delete %s companies'=>'VAROVANIE: Neporadilo sa zmazať %s spoločností',
'Moved %s companies to trash'=>'%s firiem presunutých do odpadkov',

### ../pages/effort.inc.php   ###
'New Effort'                  =>'Nové úsilie',

### ../pages/file.inc.php   ###
'only expected one task. Used the first one.'=>'očakáva sa len jedna úloha. Použije sa prvá.',

### ../pages/effort.inc.php   ###
'Edit Effort|page type'       =>'Upraviť úsilie',
'Edit Effort|page title'      =>'Upraviť úsilie',
'New Effort|page title'       =>'Nové úsilie',
'Date / Duration|Field label when booking time-effort as duration'=>'Dátum / Trvanie',

### ../pages/file.inc.php   ###
'For task'                    =>'Pre úlohu',

### ../pages/task.inc.php   ###
'Public to'                   =>'Zverejniť pre',

### ../pages/effort.inc.php   ###
'Could not get effort'        =>'Nie je možné získať úsilie',
'Could not get project of effort'=>'Nie je možné získať úsilie projektu',
'Could not get person of effort'=>'Nie je možné získať úsilie osoby',
'Name required'               =>'Je vyžadované meno',
'Cannot start before end.'    =>'Nie je možné začať pred koncom',
'Select some efforts to delete'=>'Označ nejaké úsilie na zmazanie',
'WARNING: Failed to delete %s efforts'=>'VAROVANIE: Nepodarilo sa zmazať %s úsilie',
'Moved %s efforts to trash'=>'%s úsilia presunutých do odpadkov',

### ../pages/error.inc.php   ###
'Error|top navigation tab'    =>'Chyba',
'Unknown Page'                =>'Neznáma stránka',

### ../pages/file.inc.php   ###
'Could not access parent task.'=>'Nie je možné pristúpiť k rodičovskej úlohe.',

### ../std/constant_names.inc.php   ###
'File'                        =>'Súbor',

### ../pages/task.inc.php   ###
'Item-ID %d'                  =>'ID položky %d',

### ../pages/file.inc.php   ###
'Edit this file'              =>'Upraviť tento súbor',
'Version #%s (current): %s'   =>'Verzia #%s (aktuálna): %s',
'Filesize'                    =>'Veľkosť súboru',
'Uploaded'                    =>'Odoslané',
'Uploaded by'                 =>'Odoslal',
'Version #%s : %s'            =>'Verzia #%s : %s',
'Upload new version|block title'=>'Odoslať novú verziu',
'Could not edit task'         =>'Nie je možné upraviť úlohu',
'Edit File|page type'         =>'Upraviť súbor',
'Edit File|page title'        =>'Upraviť súbor',
'New file|page title'         =>'Nový súbor',
'Could not get file'          =>'Nie je možné získať súbor',
'Could not get project of file'=>'Nie je možné získať projekt súboru',
'Please enter a proper filename'=>'Vlož správny názov súboru',
'Select some files to delete' =>'Označ súbory na zmazanie',
'WARNING: Failed to delete %s files'=>'VAROVANIE: Nepodarilo sa zmazať %s súborov',
'Moved %s files to trash'  =>'%s súborov presunutých do odpadkov',
'Select some file to display' =>'Označ súbory na zobrazenie',

### ../render/render_misc.inc.php   ###
'Today'                       =>'Dnes',

### ../pages/home.inc.php   ###
'Personal Efforts'            =>'Osobné úsilie',
'At Home'                     =>'Doma',
'F, jS'                       =>'F, jS',
'Functions'                   =>'Funkcie',
'View your efforts'           =>'Zobraziť tvoje úsilie',
'Edit your profile'           =>'Upraviť tvoj profil',
'Your projects'               =>'Tvoje projekty',
'S|Column header for status'  =>'V',

### ../render/render_list_column_special.inc.php   ###
'Select lines to use functions at end of list'=>'Výber riadkov, pre funkcie uvedené nižšie',

### ../pages/home.inc.php   ###
'P|Column header for priority'=>'P',
'Priority|Tooltip for column header'=>'Priorita',
'Company|column header'       =>'Firma',
'Project|column header'       =>'Projekt',
'Edit|function in context menu'=>'Upraviť',
'Log hours for a project|function in context menu'=>'Zaznamenať hodiny pre projekt',
'Create new project|function in context menu'=>'Vytvoriť nový projekt',
'You are not assigned to a project.'=>'Nie si priradený k projektu',
'You have no open tasks'      =>'Nemáš otvorené úlohy',
'Open tasks assigned to you'  =>'Tvoje otvorené úlohy',
'Open tasks (including unassigned)'=>'Otvorené úlohy (vrátane nepriradených)',
'All open tasks'              =>'Všetky otvorené úlohy',
'P|column header'             =>'P',
'S|column header'             =>'S',
'Folder|column header'        =>'Priečinok',
'Modified|column header'      =>'Zmenené',
'Est.|column header estimated time'=>'Očak.',
'Edit|context menu function'  =>'Upraviť',
'status->Completed|context menu function'=>'stav->Ukončené',
'status->Approved|context menu function'=>'stav->Schválené',
'Delete|context menu function'=>'Odstrániť',
'Log hours for select tasks|context menu function'=>'Zaznamenať hodiny pre označené úlohy',
'%s tasks with estimated %s hours of work'=>'%s úloh s predpokladanými %s hodinami práce',

### ../pages/login.inc.php   ###
'Login|tab in top navigation' =>'Prihlásenie',

### ../render/render_page.inc.php   ###
'Go to your home. Alt-h / Option-h'=>'Prejsť domov. Alt-h /Option-h',

### ../pages/login.inc.php   ###
'License|tab in top navigation'=>'Licencia',

### ../render/render_page.inc.php   ###
'Your projects. Alt-P / Option-P'=>'Tvoje projekty. Alt-P / Option-P',

### ../pages/login.inc.php   ###
'Welcome to streber|Page title'=>'Vitajte v streberovi|',
'please login'                =>'prosím prihláste sa',
'Nickname|label in login form'=>'Prezývka',
'Password|label in login form'=>'Heslo',
'I forgot my password.|label in login form'=>'Zabudol som svoje heslo.',
'I forgot my password'        =>'Zabudol som svoje heslo',

### ../pages/proj.inc.php   ###
'Create another project after submit'=>'Vytvoriť ďalší projekt po odoslaní',

### ../pages/login.inc.php   ###
'If you remember your name, please enter it and try again.'=>'Ak si pamätáš svoje menu, tak ho napíš a skús znova',
'Supposed a user with this name existed a notification mail has been sent.'=>'Ak predpokladaný používateľ existuje, tak mu bol odoslaný e-mail s notifikáciou.',
'invalid login|message when login failed'=>'neplatné prihlásenie',
'Welcome %s. Please adjust your profile and insert a good password to activate your account.'=>'Vitaj %s. Uprav si prosím svoj profil a vlož dobré heslo na aktiváciu svojho účtu.',
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter your name and use the <b>forgot password link</b> below.'=>'Ľutujem, ale tento aktivačný kód už nie je viac platný. Ak máš účet, vlož svoje meno a použi <b>Zabudol som svoje heslo</b>.',
'License|page title'          =>'Licencia',

### ../pages/misc.inc.php   ###
'Select some items to restore'=>'Označ nejaké položky na obnovu',
'Item %s does not need to be restored'=>'Položka %s nepotrebuje obnovu',
'WARNING: Failed to restore %s items'=>'VAROVANIE: Neporadila sa obnoviť %s položiek',
'Restored %s items'           =>'Obnovených %s položiek',
'Admin|top navigation tab'    =>'Admin',
'System information'          =>'Systémové informácie',
'Admin'                       =>'Admin',
'Database Type'               =>'Typ databázy',
'PHP Version'                 =>'PHP',
'extension directory'         =>'adresár rozšírení',
'loaded extensions'           =>'načítané rozšírenia',
'include path'                =>'vrátane cesty',
'register globals'            =>'',
'magic quotes gpc'            =>'',
'magic quotes runtime'        =>'',
'safe mode'                   =>'záchranný režim',

### ../pages/person.inc.php   ###
'Active People'               =>'Aktívne osoby',
'relating to %s|page title add on listing pages relating to current user'=>'viažuci sa k %s',

### ../render/render_misc.inc.php   ###
'With Account|page option'    =>'S účtom',
'All Persons|page option'     =>'Všetky osoby',

### ../pages/person.inc.php   ###
'People/Project Overview'     =>'Prehľad osôb/projektov',
'no related persons'          =>'bez previazaných osôb',
'Persons|Pagetitle for person list'=>'Osoby',
'relating to %s|Page title Person list title add on'=>'previazaný na %s',
'admin view|Page title add on if admin'=>'admin zobrazenie',
'Edit this person|Tooltip for page function'=>'Upraviť túto osobu',
'Profile|Page function edit person'=>'Profil',
'Edit user rights|Tooltip for page function'=>'Upraviť používateľské práva',
'User Rights|Page function for edit user rights'=>'Používateľské práva',

### ../pages/task.inc.php   ###
'Summary|Block title'         =>'Sumár',

### ../pages/person.inc.php   ###
'Mobile|Label mobilephone of person'=>'Mobil',
'Office|label for person'     =>'Kancelária',
'Private|label for person'    =>'Súkromné',
'Fax (office)|label for person'=>'Fax (do kancelárie)',
'Website|label for person'    =>'Web stránka',
'Personal|label for person'   =>'Osobné',
'E-Mail|label for person office email'=>'E-mail',
'E-Mail|label for person personal email'=>'E-mail',
'Adress Personal|Label'       =>'Súkromná adresa',
'Adress Office|Label'         =>'Adresa kancelárie',
'Birthdate|Label'             =>'Dátum narodenia',
'works for|List title'        =>'pracuje pre',
'not related to a company'    =>'bez väzby na firmu',
'works in Projects|list title for person projects'=>'pracuje na projektoch',
'no active projects'          =>'bez aktívneho projektu',
'Assigned tasks'              =>'Priradené úlohy',
'No open tasks assigned'      =>'Zatiaľ bez priradenej otvorenej úlohy',
'Efforts|Page title add on'   =>'Úsilie',
'no efforts yet'              =>'zatiaľ bez úsilia',
'not allowed to edit'         =>'nie je možné upravovať',
'Edit Person|Page type'       =>'Upraviť osobu',
'Person with account (can login)|form label'=>'Osoba s účtom (môže sa prihlásiť)',
'Password|form label'         =>'Heslo',
'confirm Password|form label' =>'potvrdiť heslo',
'-- reset to...--'            =>'-- vynulovať na... --',
'Profile|form label'          =>'Profil',
'daily'                       =>'denne',
'each 3 days'                 =>'každé 3 dni',
'each 7 days'                 =>'každých 7 dní',
'each 14 days'                =>'každých 14 dní',
'each 30 days'                =>'každých 30 dní',
'Never'                       =>'Nikdy',
'Send notifications|form label'=>'Posielať notifikácie',
'Send mail as html|form label'=>'Poslať e-mail ako html',
'Theme|form label'            =>'Téma',
'Language|form label'         =>'Jazyk',
'Create another person after submit'=>'Po odoslaní vytvoriť ďalšiu osobu',
'Could not get person'        =>'Neviem získať osobu',
'Sending notifactions requires an email-address.'=>'Odosielanie notifikácií vyžaduje e-mailovú adresu',
'NOTE: Nickname has been converted to lowercase'=>'UPOZORNENIE: Prezývka bola konvertovaná na malé písmená',
'NOTE: Nickname has to be unique'=>'UPOZORNENIE: Prezývka musí byť jedinečná',
'passwords do not match'      =>'heslá nesúhlasia',
'Password is too weak (please add numbers, special chars or length)'=>'Heslo je príliš slabé (pridaj čísla, zvláštne znaky alebo viac znakov)',
'Login-accounts require a unique nickname'=>'Účty s možnosťou prihlásenia vyžadujú jedinečné prezývky',
'A notification / activation  will be mailed to <b>%s</b> when you log out.'=>'Notifikácia / aktivácia bude odoslaná na <b>%s</b>, keď sa odhlásiš.',

### ../render/render_wiki.inc.php   ###
'Read more about %s.'         =>'Prečítaj si viac o %s',

### ../pages/person.inc.php   ###
'WARNING: could not insert object'=>'VAROVANIE: Nie je možné vložiť objekt',
'Select some persons to delete'=>'Vyberte nejaké osoby na zmazanie',
'<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'=>'<b>%s</b> je priradený k projektom a preto nemôže byť zmazaný. Ale môžete deaktivovať jeho práva na prihlásenie sa.',
'WARNING: Failed to delete %s persons'=>'VAROBANIE: Nepodarilo sa zmazať %s osôb.',
'Moved %s persons to trash'=>'%s osôb presunutých do odpadkov',
'Insufficient rights'         =>'Nedostatočné práva',
'Since the user does not have the right to edit his own profile and therefore to adjust his password, sending an activation does not make sense.'=>'Keďže používateľ nemá právo upraviť svoj vlastný profil a teda ani heslo, odoslanie aktivácie nemá zmysel.',
'Sending an activation mail does not make sense, until the user is allowed to login. Please adjust his profile.'=>'Odoslanie aktivačného e-mailu nemá zmysel, pokiaľ sa používateľ nemôže prihlásiť. Uprav prosím jeho profil.',
'Activation mail has been sent.'=>'Aktivačný e-mail bol odoslaný',
'Sending notification e-mail failed.'=>'Odoslanie notifikačného e-mailu sa nepodarilo.',
'Select some persons to notify'=>'Vyberte ľudí pre notifikáciu',
'WARNING: Failed to mail %s persons'=>'VAROVANIE: nepodarilo sa e-mailovať pre %s osôb',
'Sent notification to %s person(s)'=>'Odoslaná notifikácia pre %s osôb',
'Select some persons to edit' =>'Vyberte nejaké osoby pre úpravy',
'Could not get Person'        =>'Neviem získať osobu',
'Edit Person|page type'       =>'Upraviť osobu',
'Adjust user-rights'          =>'Prispôsobiť oprávnenia',
'Please consider that activating login-accounts might trigger security-issues.'=>'Berte do úvahy, že aktivácia prihlasovacích účtov môže spôsobiť bezpečnostné problémy',
'Person can login|form label' =>'Osoba sa môže prihlásiť',
'User rights changed'         =>'Oprávnenia používateľa boli zmenené',

### ../pages/proj.inc.php   ###
'Active'                      =>'Aktívne',
'Templates'                   =>'Šablóny',
'Your Active Projects'        =>'Tvoje aktívne projekty',
'relating to %s'              =>'viažuci sa k %s',
'List|page type'              =>'Zoznam',
'<b>NOTE</b>: Some projects are hidden from your view. Please ask an administrator to adjust you rights to avoid double-creation of projects'=>'<b>UPOZORNENIE</b>: Niektoré projekty sú pre teba skryté. Prosím požiadaj administrátora, aby upravil tvoje práva, aby nedošlo viacnásobnému vytváraniu projektov',
'create new project'          =>'vytvoriť nový projekt',
'not assigned to a project'   =>'nepriradený k projektu',
'Your Closed Projects'        =>'Tvoje uzatvorené projekty',
'invalid project-id'          =>'neplatné id projektu',
'Edit this project'           =>'Upraviť tento projekt',

### ../pages/task.inc.php   ###
'new'                        =>'nové:',

### ../pages/proj.inc.php   ###
'Add person as team-member to project'=>'Pridať osobu ako člena tímu',
'Team member'                 =>'Člen tímu',
'Create task'                 =>'Vytvoriť úlohu',
'Create task with issue-report'=>'Vytvoriť úlohu s hlásením problému',
'open'                        =>'otvorené',


### ../pages/task.inc.php   ###
'Bug'                         =>'Chyba',

### ../pages/proj.inc.php   ###
'Book effort for this project'=>'Zaznamenať úsilie pre tento projekt',

### ../std/constant_names.inc.php   ###
'Effort'                      =>'Úsilie',

### ../pages/proj.inc.php   ###
'Details|block title'         =>'Detaily',
'Client|label'                =>'Klient',
'Phone|label'                 =>'Telefón',
'E-Mail|label'                =>'E-mail',
'Status|Label in summary'     =>'Stav',
'Wikipage|Label in summary'   =>'Wiki stránka',
'Projectpage|Label in summary'=>'Stránka projektu',
'Opened|Label in summary'     =>'Otvorené',
'Closed|Label in summary'     =>'Uzatvorené',
'Created by|Label in summary' =>'Vytvoril',
'Last modified by|Label in summary'=>'Naposledy zmenil',
'Logged effort'               =>'Zaznamenané úsilie',
'hours'                       =>'hodiny',
'Team members'                =>'Členovia tímu',
'Your tasks'                  =>'Tvoje úlohy',
'No tasks assigned to you.'   =>'Pre teba nie sú priradené úlohy',
'All project tasks'           =>'Všetky úlohy projektu',
'Comments on project'         =>'Komentáre k projektu',
'Closed Tasks'                =>'Uzatvorené úlohy',
'No tasks have been closed yet'=>'Ešte žiadna úloha nebola uzatvorená',
'changed project-items'       =>'zmenené položky projektu',
'no changes yet'              =>'zatiaľ bez zmien',
'all open'                    =>'všetky otvorené',
'all my open'                 =>'všetky moje otvorené',
'my open for next milestone'  =>'moje otvorené pre ďalší míľnik',
'not assigned'                =>'nepriradené',
'blocked'                     =>'blokované',
'open bugs'                   =>'otvorená chyba',
'to be approved'              =>'na schválenie',
'open tasks'                  =>'otvorená úloha',
'my open tasks'               =>'my otvorené úlohy',
'next milestone'              =>'nasledujúci míľnik',
'Create a new folder for tasks and files'=>'Vytvoriť nový priečinok pre úlohy a súbory',

### ../pages/task.inc.php   ###
'new subtask for this folder' =>'nové podúlohy pre tento priečinok',

### ../pages/proj.inc.php   ###
'Filter-Preset:'              =>'Prednastavenie filtra:',
'No tasks'                    =>'Bez úloh',
'Project Issues'              =>'Problémy projektu',
'Add Bugreport'               =>'Pridať hlásenie chyby',

### ../render/render_misc.inc.php   ###
'Issues'                      =>'Problémy',

### ../pages/proj.inc.php   ###
'Report Bug'                  =>'Hlásenie chyby',
'new Effort'                  =>'nové úsilie',
'Upload file|block title'     =>'Odoslať súbor',
'new Milestone'               =>'nový míľnik',
'View open milestones'        =>'Zobraziť otvorené míľniky',
'View closed milestones'      =>'Zobraziť uzatvorené míľniky',
'Project Efforts'             =>'Úsilie projektu',
'Company|form label'          =>'Firma',
'Select some projects to delete'=>'Vybrať niektoré projekty na zmazanie',
'WARNING: Failed to delete %s projects'=>'VAROVANIE: Nepodarilo sa zmazať %s projektov',
'Moved %s projects to trash'=>'%s projektov presunutých do odpadkov',
'Select some projects...'     =>'Vyber nejaký projekt...',
'Invalid project-id!'         =>'Neplatné id projektu',
'Y-m-d'                       =>'R-m-d',
'WARNING: Failed to change %s projects'=>'VAROVANIE: Nepodarilo sa zmeniť %s projektov',
'Closed %s projects'          =>'Uzatvorených %s projektov',
'Reactivated %s projects'     =>'Reaktivovaných %s projektov',
'Select new team members'     =>'Vyber nového člena tímu',
'Found no persons to add. Go to `People` to create some.'=>'Nie sú dostupné žiadne osoby. Choď do časti `Ľudia` a vytvor nejakú.',
'Add'                         =>'Pridať',
'No persons selected...'      =>'Žiadna osoba nie je označená',
'Could not access person by id'=>'Nie je možné pristúpiť o osobe cez id',
'NOTE: reanimated person as team-member'=>'UPOZORNENIE: osoba znovu zaradená do tímu.',
'NOTE: person already in project'=>'UPOZORNENIE: osoba je už v projekte ',
'Template|as addon to project-templates'=>'Šablóna',
'Failed to insert new project person. Data structure might have been corrupted'=>'Nepodarilo sa vložiť novú osobu. Dátová štruktúra môže byť poškodená.',
'Failed to insert new issue. DB structure might have been corrupted.'=>'Nepodarilo sa vložiť nový problém. Dátová štruktúra môže byť poškodená.',
'Failed to update new task. DB structure might have been corrupted.'=>'Nepodarilo sa aktualizovať novú úlohu. Dátová štruktúra môže byť poškodená.',
'Failed to insert new comment. DB structure might have been corrupted.'=>'Nepodarilo sa vložiť komentár. Dátová štruktúra môže byť poškodená.',
'Project duplicated (including %s items)'=>'Duplicitný projekt (vrátane %s položiek)',
'Select a project to edit description'=>'Vyber projekt, ktorému chceš upraviť popis',

### ../pages/task.inc.php   ###
'Edit description'            =>'Upraviť popis',

### ../pages/projectperson.inc.php   ###
'Edit Team Member'            =>'Upraviť člena tímu',
'role of %s in %s|edit team-member title'=>'rola %s v %s',
'Role in this project'        =>'Rola v projekte',
'start times and end times'   =>'počiatočný a konečný čas',
'duration'                    =>'trvanie',
'Log Efforts as'              =>'Zaznamenať úsilie ako',
'Changed role of <b>%s</b> to <b>%s</b>'=>'Zmenená rola z <b>%s</b> na <b>%s</b>',

### ../pages/search.inc.php   ###
'Jumped to the only result found.'=>'Prejsť na jediný nájdený výsledok',
'Search Results'              =>'Výsledky hľadania',
'Searching'                   =>'Hľadanie',
'Found %s companies'          =>'Nájdených %s firiem',
'Found %s projects'           =>'Nájdených %s projektov',
'Found %s persons'            =>'Nájdených %s osôb',
'Found %s tasks'              =>'Nájdených %s úloh',
'Found %s comments'           =>'Nájdených %s komentárov',
'Sorry. Could not find anything.'=>'ľutujem. Nič som nenašiel',
'Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters'=>'Kvôli limitom MySQL fulltextové hľadanie nebude fungovať pre...<br>- slová s 3 a menej znakmi<br>- Zoznamami s menej ako 3 položkami<br>- slovami obsahujúcimi špeciálne znaky',
'Other team members changed nothing since last logout (%s)'=>'Ostatný členovia tímu nič nezmenili od posledného odhlásenia (%s)',

### ../pages/task.inc.php   ###
'Edit this task'              =>'Upraviť túto úlohu',
'Delete this task'            =>'Zmazať túto úlohu',
'Restore this task'           =>'Obnoviť túto úlohu',
'Undelete'                    =>'Obnoviť',
'new bug for this folder'     =>'nová chyba pre tento priečinok',
'new task for this milestone' =>'nová úloha pre tento míľnik',
'Append details'              =>'Pridať detaily',
'Complete|Page function for task status complete'=>'Ukončiť',
'Approved|Page function for task status approved'=>'Schváliť',
'Description|Label in Task summary'=>'Popis',
'Part of|Label in Task summary'=>'Patrí do',
'Status|Label in Task summary'=>'Stav',
'Opened|Label in Task summary'=>'Otvorené',
'Planned start|Label in Task summary'=>'Plánovaný začiatok',
'Planned end|Label in Task summary'=>'Plánovaný koniec',
'Closed|Label in Task summary'=>'Zatvorené',
'Created by|Label in Task summary'=>'Vytvoril',
'Last modified by|Label in Task summary'=>'Naposledy upravil',
'Logged effort|Label in task-summary'=>'Zaznamenané úsilie',
'Attached files'              =>'Pripojené súbory',
'attach new'                  =>'pripojiť nový',
'Upload'                      =>'Odoslať',
'Issue report'                =>'Report problému',
'Platform'                   =>'Platforma',
'OS'                          =>'OS',
'Build'                       =>'Zostavenie',
'Steps to reproduce|label in issue-reports'=>'Kroky k reprodukcií',
'Expected result|label in issue-reports'=>'Očakávaný výsledok',
'Suggested Solution|label in issue-reports'=>'Navrhované riešenie',
'No project selected?'        =>'Žiadny projekt si neoznačil?',
'Please select only one item as parent'=>'Vyber prosím len jednu položku ako rodičovskú',
'Insufficient rights for parent item.'=>'Nedostatočné práva pre rodičovskú položku',
'could not find project'      =>'nie je možné nájsť projekt',
'I guess you wanted to create a folder...'=>'Predpokladám, že si chcel vytvoriť priečinok',
'Assumed <b>%s</b> to be mean label <b>%s</b>'=>'Predpokladám, že <b>%s</b> znamená označenie <b>%s</b>',
'Bug|Task-Label that causes automatically addition of issue-report'=>'Chyba',
'Feature|Task label that added by default'=>'Vlastnosť',
'No task selected?'           =>'Žiadna úloha nie je označená?',
'Edit %s|Page title'          =>'Upraviť %s',
'New task'                    =>'Nová úloha',
'for %s|e.g. new task for something'=>'pre %s',
'-- undefined --'             =>'--nedefinované--',
'Resolved in'                 =>'Vyriešené v',
'- select person -'           =>'--výber osoby--',
'Assign to'                   =>'Priradené k',
'Assign to|Form label'        =>'Priradiť k',
'Also assign to|Form label'   =>'Tiež priradiť k',
'Prio|Form label'             =>'Priorita',

### ../std/constant_names.inc.php   ###
'undefined'                   =>'nedefinované',

### ../pages/task.inc.php   ###
'30 min'                      =>'30 min',
'1 h'                         =>'1 h',
'2 h'                         =>'2 h',
'4 h'                         =>'4 h',
'1 Day'                       =>'1 deň',
'2 Days'                      =>'2 dni',
'3 Days'                      =>'3 dni',
'4 Days'                      =>'4 dni',
'1 Week'                      =>'1 týždeň',
'1,5 Weeks'                   =>'1,5 týždňa',
'2 Weeks'                     =>'2 týždne',
'3 Weeks'                     =>'3 týždne',
'Completed'                   =>'Ukončené',
'Severity|Form label, attribute of issue-reports'=>'Náročnosť',
'reproducibility|Form label, attribute of issue-reports'=>'reprodukovateľnosť',
'unassigned to %s|task-assignment comment'=>'nepriradené k %s',
'formerly assigned to %s|task-assigment comment'=>'predtým priradená k %s',
'task was already assigned to %s'=>'úloha už bola priradená k %s',
'Failed to retrieve parent task'=>'Neporadilo sa získať rodičovskú úlohu',
'Task requires name'          =>'Úloha vyžaduje názov',
'ERROR: Task called %s already exists'=>'CHYBA: Úloha s názvom %s už existuje',
'Turned parent task into a folder. Note, that folders are only listed in tree'=>'Rodičovská úloha je premenená na priečinok. Všimni si, že priečinku sú zobrazené v stromovej štruktúre',
'Failed, adding to parent-task'=>'Nepodarilo sa pridať rodičovskú úlohu',
'NOTICE: Ungrouped %s subtasks to <b>%s</b>'=>'POZNÁMKA: Nezoskupených %s podúloh k %s',
'HINT: You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'=>'TIP: Zmenil si úlohu <b>%s</b> na priečinok. Priečinky sú zobrazené v osobitnom zozname úloh-priečinkov.',
'NOTE: Created task %s with ID %s'=>'POZNÁMKA: Vytvorená úloha %s s ID %s',
'NOTE: Changed task %s with ID %s'=>'POZNÁMKA: Zmenená úloha %s s ID %s',
'Select some tasks to move'   =>'Vyber nejaké úlohy na presun',
'Can not move task <b>%s</b> to own child.'=>'Nie je možné presunúť úlohu <b>%s</b do vlastného potomka',
'Can not edit tasks %s'       =>'Nie je možné upraviť úlohu %s',
'insufficient rights to edit any of the selected items'=>'nedostatočné práva na úpravu označených položiek',
'Select folder to move tasks into'=>'Vyber priečinok, do ktorého sa majú presunúť úlohy',
'(or select nothing to move to project root)'=>'(alebo nič neoznač, ak sa úlohy majú presunúť do najvyššej úrovni',
'Task <b>%s</b> deleted'      =>'Úloha <b>%s</b> bola zmazaná',
'Moved %s tasks to trash'  =>'%s úloh presunutých do koša',
' ungrouped %s subtasks to above parents.'=> ' nezoskupených %s úloha nad rodičmi',
'No task(s) selected for deletion...'=>'Žiadne úlohy nie sú označená na zmazanie...',
'ERROR: could not retrieve task'=>'CHYBA: nie je možné získať úlohu',
'Task <b>%s</b> does not need to be restored'=>'Úloha <b>%s</b> nepotrebuje byť obnovená',
'Task <b>%s</b> restored'     =>'Úloha <b>%s</b> je obnovená',
'Failed to restore Task <b>%s</b>'=>'Nepodarilo sa obnoviť úlohu <b>%s</b>',
'Task <b>%s</b> do not need to be restored'=>'Úloha <b>%s</b> nepotrebuje byť obnovená',
'No task(s) selected for restoring...'=>'Žiadne úlohy nie sú označená na obnovenie...',
'Select some task(s) to mark as completed'=>'Vyber nejaké úlohy na označenie ako ukončené',
'Marked %s tasks (%s subtasks) as completed.'=>'%s úloh (%s podúloh) označených ako ukončených',
'%s error(s) occured'         =>'Vyskytlo sa %s chýb',
'Select some task(s) to mark as approved'=>'Vyber nejaké úlohy na schválenie',
'Marked %s tasks as approved and hidden from project-view.'=>'%s označených úloh ako schválených a ukrytých z náhľadu na projekt',
'Select some task(s)'         =>'Vyber nejaké úlohy',
'could not update task'       =>'nie je možné aktualizovať úlohy',
'No task selected to add issue-report?'=>'Žiadna úloha nie je označená na pridanie hlásenia o chybe',
'Task already has an issue-report'=>'Úloha už má hlásenie o chybe',
'Adding issue-report to task' =>'Pridanie hlásenie o chybe k úlohe',
'Could not get task'          =>'Neviem získať úlohu',
'Select a task to edit description'=>'Vyber nejaké úlohy na úpravu popisu',

### ../render/render_form.inc.php   ###
'Please use Wiki format'      =>'Prosím, použite Wiki formát',
'Submit'                      =>'Odoslať',
'Cancel'                      =>'Zrušiť',
'Apply'                       =>'Použiť',

### ../render/render_list.inc.php   ###
'for milestone %s'            =>'pre míľnik',
'changed today'               =>'zmenené dnes',
'changed since yesterday'     =>'zmenené od včera',
'changed since <b>%d days</b>'=>'zmenené pre <b>%d dňami</b>',
'changed since <b>%d weeks</b>'=>'zmenené pre <b>%d týždňami</b>',
'created by %s'               =>'vytvoril %s',
'created by unknown'          =>'vytvoril neznámy',
'modified by %s'              =>'zmenil %s',
'modified by unknown'         =>'zmenil neznámy',
'item #%s has undefined type' =>'položka #%s má nedefinovaný typ',
'do...'                       =>'urobiť...',

### ../render/render_list_column_special.inc.php   ###
'Tasks|short column header'   =>'Úlohy',
'Number of open tasks is hilighted if shown home.'=>'',
'S|Short status column header'=>'S',
'Status is %s'                =>'Stav je %s',
'Item is public to'           =>'Položka je verejná pre',
'Pub|column header for public level'=>'Ver.',
'Public to %s'                =>'Zverejniť pre %s',

### ../render/render_misc.inc.php   ###
'Tasks|Project option'        =>'Úlohy',
'Completed|Project option'    =>'Ukončené',
'Milestones|Project option'   =>'Míľniky',
'Files|Project option'        =>'Súbory',
'Efforts|Project option'      =>'Úsilie',
'History|Project option'      =>'História',
'new since last logout'       =>'nové od posledného odhlásenia',
'Yesterday'                   =>'Včera',

### ../render/render_page.inc.php   ###
'<span class=accesskey>H</span>ome'=>'Do<span class=accesskey>m</span>ov',
'<span class=accesskey>P</span>rojects'=>'<span class=accesskey>P</span>rojekty',
'Your related People'         =>'S tebou prepojený ľudia',
'Your related Companies'      =>'S tebou prepojené firmy',
'Calendar'                    =>'Kalendár',
'<span class=accesskey>S</span>earch:&nbsp;'=>'<span class=accesskey>H</span>ľadanie:&nbsp;',
'Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`'=>'',
'This page requires java-script to be enabled. Please adjust your browser-settings.'=>'Táto stránka potrebuje mať povolený java-script. Uprav si nastavenie prehliadača.',
'Add Now'                     =>'Pridať teraz',
'you are'                     =>'vy ste',
'Return to normal view'       =>'Návrat do bežného zobrazenia',
'Leave Client-View'           =>'Ponechať klientske zobrazenie',
'How this page looks for clients'=>'Ako vidí túto stránku klient',
'Client view'                 =>'Klientske zobrazenie',
'Documentation and Discussion about this page'=>'Dokumentácia a diskusia o tejto stránke',
'Help'                        =>'Pomocník',

### ../render/render_wiki.inc.php   ###
'enlarge'                     =>'Zväčšiť',
'Unknown File-Id:'            =>'Neznáme ID súboru:',
'Unknown project-Id:'         =>'Neznáme ID projektu:',
'Wiki-format: <b>$type</b> is not a valid link-type'=>'Wiki-formát: <b>$type</b> nie je platný typ odkazu',
'No task matches this name exactly'=>'Žiadna úloha nezodpovedá presne tomuto názvu',
'This task seems to be related'=>'Zdá sa, že táto úloha je viazaná',
'No item excactly matches this name.'=>'Žiadna položka nezodpovedá presne tomuto názvu.',
'List %s related tasks'       =>'Zoznam %s previazaných úloh',
'identical'                   =>'identické',
'No item matches this name. Create new task with this name?'=>'Žiadna položka nezodpovedá tomuto názvu. Vytvoriť novú úlohu s týmto názvom?',
'No item matches this name.'  =>'Žiadna položka nezodpovedá tomuto názvu.',
'No item matches this name'   =>'Žiadna položka nezodpovedá tomuto názvu',

### ../std/class_auth.inc.php   ###
'Fresh login...'              =>'Čerstvé prihlásenie...',
'Cookie is no longer valid for this computer.'=>'Cookie už nie je platné pre tento počítač.',
'Your IP-Address changed. Please relogin.'=>'Tvoja IP adresa sa zmenila. Prihlás sa opäť prosím.',
'Your account has been disabled. '=>'Tvoj účet bol zablokovaný.',
'Could not set cookie.'       =>'Nie je možné nastaviť cookie.',

### ../std/class_pagehandler.inc.php   ###
'WARNING: operation aborted (%s)'=>'VAROVANIE: operácia bola prerušená (%s)',
'FATAL: operation aborted with an fatal error (%s).'=>'ZÁVAŽNÉ: operácia bola prerušená kvôli závažnej chybe (%s).',
'Error: insufficient rights'    =>'Chyba: nedostatočné oprávnenia',
'FATAL: operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'ZÁVAŽNÉ: operácia bola prerušená kvôli závažnej databázovej chybe štruktúry (%s). K tomuto prichádza pri nekonzistentnosti databázy. Odporúčam ti vrátiť sa aktuálnej zálohe.',
'NOTE: %s|Message when operation aborted'=>'OZNAM: %s',
'ERROR: %s|Message when operation aborted'=>'CHYBA: %s',

### ../std/common.inc.php   ###
'No element selected? (could not find id)|Message if a function started without items selected'=>'Žiadny zvolený element (nie je možné nájsť id)?',

### ../std/constant_names.inc.php   ###
'template|status name'        =>'šablóna',
'undefined|status_name'       =>'nedefinované',
'upcoming|status_name'        =>'nastávajúce',
'new|status_name'             =>'nové',
'open|status_name'            =>'otvorené',
'blocked|status_name'         =>'blokované',
'done?|status_name'           =>'ukončené?',
'approved|status_name'        =>'odsúhlasené',
'closed|status_name'          =>'uzatvorené',
'undefined|pub_level_name'    =>'nedefinované',
'Member|profile name'         =>'Člen',
'Admin|profile name'          =>'Správca',
'private|pub_level_name'      =>'privátne',
'suggested|pub_level_name'    =>'navrhované',
'internal|pub_level_name'     =>'interné',
'open|pub_level_name'         =>'otvorené',
'client|pub_level_name'       =>'klient',
'cliend_edit|pub_level_name'  =>'klient_úpravy',
'assigned|pub_level_name'     =>'priradené',
'owned|pub_level_name'        =>'vlastnené',
'priv|short for public level private'=>'priv',
'int|short for public level internal'=>'int',
'pub|short for public level client'=>'ver',
'PUB|short for public level client edit'=>'VER',
'A|short for public level assigned'=>'P',
'O|short for public level owned'=>'V',
'Create projects|a user right'=>'Vytvoriť projekty',
'Edit projects|a user right'  =>'Upraviť projekty',
'Delete projects|a user right'=>'Zmazať projekty',
'Edit project teams|a user right'=>'Upraviť projektové tímy',
'View anything|a user right'  =>'Zobraziť všetko',
'Edit anything|a user right'  =>'Upraviť všetko',
'Create Persons|a user right' =>'Vytvoriť osoby',
'Create & Edit Persons|a user right'=>'Vytvoriť a upraviť osoby',
'Delete Persons|a user right' =>'Odstrániť osoby',
'View all Persons|a user right'=>'Zobraziť všetky osoby',
'Edit user rights|a user right'=>'Upraviť práva prístupu',
'Edit own profile|a user right'=>'Upraviť vlastný profil',
'Create Companies|a user right'=>'Vytvoriť firmy',
'Edit Companies|a user right' =>'Upraviť firmy',
'Delete Companies|a user right'=>'Odstrániť firmy',
'undefined|priority'          =>'nedefinované',
'urgend|priority'             =>'urgentná',
'high|priority'               =>'vysoká',
'normal|priority'             =>'normálna',
'lower|priority'              =>'nižšia',
'lowest|priority'             =>'nízka',
'Team Member'                 =>'Člen tímu',
'Employment'                  =>'Zamestnanosť',
'Issue'                       =>'Problém',
'Task assignment'             =>'Priradenie úlohy',
'Nitpicky|severity'           =>'Snorenie',
'Feature|severity'            =>'Vlastnosť',
'Trivial|severity'            =>'Triviálny',
'Text|severity'               =>'Text',
'Tweak|severity'              =>'Vylepšenie',
'Minor|severity'              =>'Vedľajší',
'Major|severity'              =>'Hlavný',
'Crash|severity'              =>'Pád',
'Block|severity'              =>'Blok',
'Not available|reproducabilty'=>'Nedostupné',
'Always|reproducabilty'       =>'Vždy',
'Sometimes|reproducabilty'    =>'Niekedy',
'Have not tried|reproducabilty'=>'Neotestované',
'Unable to reproduce|reproducabilty'=>'Neopakovateľné',

### ../std/mail.inc.php   ###
'Failure sending mail: %s'    =>'Neúspešné odoslanie e-mailu: %s',
'Streber Email Notification|notifcation mail from'=>'E-mailové Streber upozornenie:',
'Updates at %s|notication mail subject'=>'Aktualizácia %s',
'Hello %s,|notification'      =>'Ahoj %s,',
'with this automatically created e-mail we want to inform you that|notification'=>'tento automaticky vytvorený e-mail ťa chce upozorniť, že',
'since %s'                    =>'od %s',
'following happened at %s |notification'=>'došlo k týmto udalostiam na %s',
'Your account has been created.|notification'=>'Bol vytvorený účet pre teba.',
#'Please set password to activate it.|notification'=>'Prosím nastav si pre neho heslo, aby sa aktivoval.',
'You have been assigned to projects:|notification'=>'Bol si priradený k projektu:',
'Please set a password to activate it.|notification'=>'Prosím nastav si pre neho heslo, aby sa aktivoval.',
'Project Updates'             =>'Aktualizácie projektov',
#'If you do not want to get further notifications feel free to|notification'=>'Ak nechcete dostávať ďalšie upozorenia, tak',
'adjust your profile|notification'=>'si upravte profil',
'Thanks for your time|notication'=>'Vďaka za tvoj čas',
'the management|notication'   =>'Manažment',
'No news for <b>%s</b>'       =>'Žiadne informácie pre <b>%s</b>',
'If you do not want to get further notifications or you forgot your password feel free to|notification'=>'Ak nechcete dostávať ďalšie upozornenia, tak',

#new?
'Project manager|profile name' =>'Manažér projektu',
'Developer|profile name' =>'Vývojár',
'Artist|profile name' =>'Umelec',
'Tester|profile name' =>'Tester',
'Client|profile name' =>'Klient',
'Client trusted|profile name' =>'Dôveryhodný klient',
'Guest|profile name' =>'Návštevník',
'view changes|' =>'zobraziť zmeny',
'Mark tasks as Open|' =>'Označiť úlohy ako Otvorené',
'Move files to folder|' =>'Presunúť súbory do priečinku',
'List Deleted Persons|' =>'Zoznam zmazaných osôb',
#
### ../pages/_handles.inc.php   ###
'Edit multiple Tasks'         =>'Upraviť viacero úloh',
'view changes'                =>'zobraziť zmeny',
'Mark tasks as Open'          =>'Označiť úlohu ako otvorenú',
'Move files to folder'        =>'Presunúť súbory do priečinka',
'List Deleted Persons'        =>'Zoznam zmazaných ľudí',
'Filter errors.log'           =>'Filtrovať errors.log',
'Delete errors.log'           =>'Zmazať errors.log',

### ../pages/comment.inc.php   ###
'Failed to delete %s comments'=>'Nepodarilo sa zmazať %s komentárov',

### ../pages/company.inc.php   ###
'related projects of %s'      =>'prepojené projekty %s',
'Person already related to company'=>'Osoba je už prepojená na firmu',
'Failed to delete %s companies'=>'Nepodarilo sa zmazať %s firiem',

### ../pages/effort.inc.php   ###
'Failed to delete %s efforts' =>'Nepodarilo sa zmazať %s úsilia',

### ../pages/file.inc.php   ###
'Failed to delete %s files'   =>'Nepodarilo sa zmazať %s súborov',
'Select some files to move'   =>'Vyber nejaké súbory na presun',
'Can not edit file %s'        =>'Nie je možné upraviť súbor %s',
'Edit files'                  =>'Upraviť súbory',
'Select folder to move files into'=>'Vyber priečinok, do ktorého sa súbory presunú',
'No folders available'        =>'Žiadny priečinok nie je dostupný',

### ../pages/home.inc.php   ###
'Projects'                    =>'Projekty',

### ../pages/misc.inc.php   ###
'Failed to restore %s items'  =>'Neporadilo sa obnoviť %s položiek',
'Error-Log'                   =>'Záznam chýb',
'hide'                        =>'skryť',

### ../pages/person.inc.php   ###
'Deleted People'              =>'Zmazaný ľudia',
'notification:'               =>'notifikácia:',
'no company'                  =>'bez firmy',
'Person details'              =>'Detaily osoby',

### ../pages/task_more.inc.php   ###
'Invalid checksum for hidden form elements'=>'Nesprávny kontrolný súčet pre skryté elementy formulára',

### ../pages/person.inc.php   ###
'The changed profile <b>does not affect existing project roles</b>! Those has to be adjusted inside the projects.'=>'Zmenený profil <b>neovplyvní existujúce pravidlá projektov</b>! Tie je potrebné upraviť v rámci projektov.',
'Nickname has been converted to lowercase'=>'Prezývka bola skonvertovaná na malé písmená',
'Nickname has to be unique'   =>'Prezývka musí byť jedinečná',
'Passwords do not match'      =>'Heslá nesúhlasia',
'Could not insert object'     =>'Nie je možné vložiť objekt',
'Failed to delete %s persons' =>'Nepodarilo sa zmazať %s osôb',
'Failed to mail %s persons'   =>'Nepodarilo sa poslať e-mail %s osobám',

### ../pages/proj.inc.php   ###
'not assigned to a closed project'=>'nepridelený k uzatvorenému projektu',
'no project templates'        =>'projekt nemá šablónu',

### ../pages/task_view.inc.php   ###
'Wiki'                        =>'Wiki',

### ../pages/proj.inc.php   ###
'my open'                     =>'moje otvorené',
'for milestone'               =>'pre míľnik',
'needs approval'              =>'potrebuje schválenie',
'Failed to delete %s projects'=>'Neporadilo sa zmazať %s projektov',
'Failed to change %s projects'=>'Neporadilo sa zmeniť %s projektov',
'Reanimated person as team-member'=>'Osoba znovu zaradená do tímu',
'Person already in project'   =>'Osoba je súčasťou projektu',

### ../pages/projectperson.inc.php   ###
'Failed to remove %s members from team'=>'Nepodarilo sa odstrániť %s členov tímu',
'Unassigned %s team member(s) from project'=>'%s zrušených členov tímu z projektu',

### ../pages/search.inc.php   ###
'in'                          =>'v',
'on'                          =>'na',
'jumped to best of %s search results'=>'zobraziť najlepší z %s výsledkov hľadania',
'Add an ! to your search request to jump to the best result.'=>'Pridaj ! k svojej požiadavke na hľadanie, aby sa hneď zobrazil najlepší výsledok.',
'%s search results for `%s`'  =>'%s výsledkov hľadania pre `%s`',
'No search results for `%s`'  =>'Žiadne výsledky hľadania pre `%s`',

### ../pages/task_view.inc.php   ###
'Add Details|page function'   =>'Pridať detail',
'Move|page function to move current task'=>'Presunúť',
'status:'                     =>'stav:',
'Reopen|Page function for task status reopened'=>'Znovu otvorené',
'View history of item'        =>'Zobraziť históriu položky',
'History'                     =>'História',
'For Milestone|Label in Task summary'=>'Pre míľnik',
'Estimated|Label in Task summary'=>'Predpokladané',
'Completed|Label in Task summary'=>'Ukončené',
'Created|Label in Task summary'=>'Vytvorené',
'Modified|Label in Task summary'=>'Upravené',
'Open tasks for milestone'    =>'Otvorené úlohy pre míľnik',
'No open tasks for this milestone'=>'Míľnik nemá otvorené úlohy',

### ../pages/task_more.inc.php   ###
'Parent task not found.'      =>'Rodičovské úlohy nie sú nájdené',
'You do not have enough rights to edit this task'=>'Nemáte dostatok práv na úpravu tejto úlohy',
'New milestone'               =>'Nový míľnik',
'Create another task after submit'=>'Vytvoriť ďalšiu úlohu po odoslaní',
'Task called %s already exists'=>'Úloha s názvom %s už existuje',
'You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'=>'Zmenil si úlohu <b>%s</b> na priečinok. Priečinky sú zobrazené v osobitnom zozname úloh-priečinkov.',
'Created task %s with ID %s'  =>'Vytvorená úloha %s s ID %s',
'Changed task %s with ID %s'  =>'Zmenená úloha %s s ID %s',
'Failed to delete task $task->name'=>'Nepodarilo sa zmazať úlohu $task->name',
'Could not find task'         =>'Nie je možné nájsť úlohu',
'Select some task(s) to reopen'=>'Vyber nejaké úlohy na znovu otvorenie',
'Reopened %s tasks.'          =>'Znovuotvorených %s úloh',
'Could not update task'       =>'Nie je možné aktualizovať úlohu',
'changes'                     =>'zmeny',
'View task'                   =>'Zobraziť úlohy',
'item has not been edited history'=>'položka nemá upravenú históriu',
'unknown'                     =>'neznáme',
' -- '                        =>' -- ',
'&lt;&lt; prev change'        =>'&lt;&lt; predch. zmena',
'next &gt;&gt;'               =>'nasled. &gt;&gt;',
'summary'                     =>'sumár',
'Item did not exists at %s'   =>'Položka neexistuje v %s',
'no changes between %s and %s'=>'bez zmien medzi %s a %s',
'ok'                          =>'OK',
'For editing all tasks must be of same project.'=>'Všetky upravované úlohy musia byť z rovnakého projektu',
'Edit multiple tasks|Page title'=>'Upraviť viacero úloh',
'Edit %s tasks|Page title'    =>'Upraviť %s úloh',
'keep different'        =>'rôzne',
'Prio'                        =>'Prio',
'- none -'                    =>'- nič -',
'%s tasks could not be written'=>'%s úloh nemôže byť zapísaných',
'Updated %s tasks tasks'      =>'Aktualizovaných %s úloh',

### ../pages/task_view.inc.php   ###
'Public to|Label in Task summary'=>'Verejné pre',

### ../render/render_fields.inc.php   ###
#'<b>%s</b> isn't a known format for date.'=>'<b>%s</b> nie je známy formát dátumu.',

### ../render/render_form.inc.php   ###
'Wiki format'                 =>'Wiki formát',

### ../render/render_list_column_special.inc.php   ###
'Status|Short status column header'=>'Stav',

### ../render/render_misc.inc.php   ###
'Other Persons|page option'   =>'Ostatné osoby',
'Deleted|page option'         =>'Zmazané',
'%s hours'                    =>'%s hodín',
'%s days'                     =>'%s dní',
'%s weeks'                    =>'%s týždňov',
'%s hours max'                =>'max. %s hodín',
'%s days max'                 =>'max. %s dní',
'%s weeks max'                =>'max. %s týždňov',

### ../render/render_page.inc.php   ###
'Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`'=>'',

### ../render/render_wiki.inc.php   ###
'from'                        =>'z',

### ../std/class_pagehandler.inc.php   ###
'Operation aborted (%s)'      =>'Operácia je prerušená (%s)',
'Operation aborted with an fatal error (%s).'=>'Operácia je prerušená kvôli závažnej chybe (%s)',
'Operation aborted with an fatal error which was cause by an programming error (%s).'=>'Operácia je prerušená kvôli závažnej chybe, ktorú spôsobila programovacia chyba (%s)',
'insufficient rights'           =>'Nedostatočné práva',
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'operácia bola prerušená kvôli závažnej databázovej chybe štruktúry (%s). K tomuto prichádza pri nekonzistentnosti databázy. Odporúčam ti vrátiť sa aktuálnej zálohe.',
'%s|Message when operation aborted'=>'%s',

### ../std/common.inc.php   ###
'only one item expected.'     =>'iba jedná položka bola očakávaná',

### ../std/constant_names.inc.php   ###
'client_edit|pub_level_name'  =>'',

### ../db/class_issue.inc.php   ###
'Production build'            =>'',

### ../db/class_project.inc.php   ###
'show tasks in home'          =>'',
'only team members can create items'=>'',

### ../db/class_task.inc.php   ###
'resolved in version'         =>'vyriešené vo verzií',

### ../pages/task_view.inc.php   ###
'Resolve reason'              =>'',

### ../db/class_task.inc.php   ###
'is a milestone'              =>'je míľnik',
'released'                    =>'',
'release time'                =>'',

### ../lists/list_versions.inc.php   ###
'Released Milestone'          =>'',

### ../db/db.inc.php   ###
'Database exception. Please read %s next steps on database errors.%s'=>'',

### ../lists/list_comments.inc.php   ###
'Add Comment'                 =>'Pridať komentár',
'Shrink All Comments'         =>'',
'Collapse All Comments'       =>'',
'Expand All Comments'         =>'Rozbaliť všetky komentáre',
'Reply'                       =>'Odpovedať',
'1 sub comment'               =>'',
'%s sub comments'             =>'',

### ../lists/list_efforts.inc.php   ###
'Effort description'          =>'Popis úsilia',
'%s effort(s) with %s hours'  =>'%s úsilia s % hodinami',
'Effort name. More Details as tooltips'=>'Názov úsilia. Viac detailov ako popis nástroja',

### ../lists/list_files.inc.php   ###
'Details/Version|Column header'=>'Detaily/Verzia',

### ../lists/list_versions.inc.php   ###
'Release Date'                =>'Dátum vydania',

### ../pages/_handles.inc.php   ###
'Versions'                    =>'Verzie',
'Task Test'                   =>'',
'View Task Efforts'           =>'Zobraziť úsilie úlohy',
'New released Version'      =>'',
'View effort'                 =>'Zobraziť úsilie',
'View multiple efforts'       =>'',
'List Clients'                =>'Zoznam klientov',
'List Prospective Clients'    =>'Zoznam perspektívnych klientov',
'List Suppliers'              =>'Zoznam dodávateľov',
'List Partners'               =>'Zoznam partnerov',
'Remove persons from company' =>'Odstrániť osoby zo spoločnosti',
'List Employees'              =>'Zoznam zamestnancov',

### ../pages/comment.inc.php   ###
'Publish to|form label'       =>'Publikovať',

### ../pages/company.inc.php   ###
'Clients'                     =>'Klienty',
'related companies of %s'     =>'',
'Prospective Clients'         =>'Perspektívny klienti',
'Suppliers'                   =>'Dodávatelia',
'Partners'                    =>'Partneri',
'Remove person from company'  =>'Odstrániť osobu zo spoločnosti',

### ../pages/person.inc.php   ###SPS-SVH-09_2006-20061006.pdf
'Category|form label'         =>'Kategória',

### ../pages/company.inc.php   ###
'Failed to remove %s contact person(s)'=>'Nepodarilo sa odstrániť %s kontaktných osôb',
'Removed %s contact person(s)'=>'%s kontaktných osôb ostránených',

### ../pages/effort.inc.php   ###
'Select one or more efforts'  =>'Vyberte jedno alebo viac úsilia',
'You do not have enough rights'=>'Nemáte dostatočné práva',
'Effort of task|page type'    =>'Úsilie úlohy',
'Edit this effort'            =>'Upraviť toto úsilie',
'Project|label'               =>'Projekt',
'Task|label'                  =>'Úloha',
'No task related'             =>'',
'Created by|label'            =>'Vytvoril',
'Created at|label'            =>'Vytvorené v',
'Duration|label'              =>'Trvanie',
'Time start|label'            =>'Začiatok',
'Time end|label'              =>'Koniec',
'No description available'    =>'Popis nie je dostupný',
'Multiple Efforts|page type'  =>'',
'Multiple Efforts'            =>'',
'Information'                 =>'Informácie',
'Number of efforts|label'     =>'Počet úsilií',
'Sum of efforts|label'        =>'Suma úsilií',
'from|time label'             =>'z',
'to|time label'               =>'do',
'Time|label'                  =>'Čas',

### ../pages/version.inc.php   ###
'Publish to'                  =>'',


### ../pages/person.inc.php   ###
'Employees|Pagetitle for person list'=>'Zamestnanci',
'Contact Persons|Pagetitle for person list'=>'Kontaktné osoby',
'Person %s created'           =>'Osoba %s vytvorená',

### ../pages/proj.inc.php   ###
'all'                         =>'všeko',
'without milestone'           =>'bez míľnika',
'Released Versions'           =>'Vydané verzie',
'New released Version'      =>'',
'Tasks resolved in upcoming version'=>'',

### ../pages/search.inc.php   ###
'cannot jump to this item type'=>'nie je možné skočiť na takýto typ položky',

### ../pages/version.inc.php   ###
'New Version'                 =>'Nová verzia',

### ../pages/task_more.inc.php   ###
'Select some task(s) to edit' =>'Vyberte nejaké úlohy na úpravu',
'Release as version|Form label, attribute of issue-reports'=>'',
'Reproducibility|Form label, attribute of issue-reports'=>'Reprodukovateľnosť',
'Marked %s tasks to be resolved in this version.'=>'Označiť %s úloh za vyriešené v tejto verzií',
'Failed to add comment'       =>'Nepodarilo sa pridať komentár',
'Failed to delete task %s'    =>'Nepodarilo sa zmazať úlohu %s',
'Task Efforts'                =>'Úsilie úlohy',
'date1 should be smaller than date2. Swapped'=>'',
'prev change'                 =>'',
'next'                        =>'ďalej',
'keep different'              =>'',
'none'                        =>'nič',

### ../pages/task_view.inc.php   ###
'next released version'       =>'',

### ../pages/task_more.inc.php   ###
'resolved in Version'         =>'',
'Resolve Reason'              =>'',

### ../pages/task_view.inc.php   ###
'Released as|Label in Task summary'=>'Vydať ako',
'Publish to|Label in Task summary'=>'',
'Severity|label in issue-reports'=>'',
'Reproducibility|label in issue-reports'=>'Reprodukovateľnosť',
'Sub tasks'                   =>'Podúlohy',
'1 Comment'                   =>'1 komentár',
'%s Comments'                 =>'%s komentárov',
'Comment / Update'            =>'Komentár/Aktualizácia',
'quick edit'                  =>'Rýchla úprava',

### ../pages/version.inc.php   ###
'Edit Version|page type'      =>'Upraviť verziu',
'Edit Version|page title'     =>'Upraviť verziu',
'New Version|page title'      =>'Nová verzia',
'Could not get version'       =>'Nie je možné získať verziu',
'Could not get project of version'=>'',
'Select some versions to delete'=>'',
'Failed to delete %s versions'=>'',
'Moved %s versions to trash'=>'',
'Version|page type'           =>'Verzia',
'Edit this version'           =>'Upraviť túto verziu',

### ../render/render_fields.inc.php   ###
'<b>%s</b> is not a known format for date.'=>'',

### ../render/render_list_column_special.inc.php   ###
'Number of open tasks is hilighted if shown home.'=>'',
'Item is published to'        =>'',
'Publish to %s'               =>'',
'Select / Deselect'           =>'',

### ../render/render_misc.inc.php   ###
'Clients|page option'         =>'Klienti',
'Prospective Clients|page option'=>'Potenciálny klienti',
'Suppliers|page option'       =>'Dodávatelia',
'Partners|page option'        =>'Partneri',
'Companies|page option'       =>'Spoločnosti',
'Versions|Project option'     =>'Verzie',
'Employees|page option'       =>'Zamestnanci',
'Contact Persons|page option' =>'Kontaktné osoby',
'All Companies|page option'   =>'Všetky spoločnosti',

### ../render/render_page.inc.php   ###
'Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`'=>'',

### ../render/render_wiki.inc.php   ###
'Wiki-format: <b>%s</b> is not a valid link-type'=>'Wiki-format: <b>%s</b> nie je platný typ odkazu',

### ../std/class_auth.inc.php   ###
'Unable to automatically detect client time zone'=>'Nie je možné automaticky zistiť časovú zónu klienta',

### ../std/constant_names.inc.php   ###
'client_edit|pub_level_name'  =>'klientska_úprava',
'urgent|priority'             =>'urgentné',
'done|resolve reason'         =>'urobené',
'fixed|resolve reason'        =>'opravené',
'works_for_me|resolve reason' =>'pracuj_pre_mňa',
'duplicate|resolve reason'    =>'duplikované',
'bogus|resolve reason'        =>'nepravdivé',
'rejected|resolve reason'     =>'odmetnuhé',
'deferred|resolve reason'     =>'odložené',
'Not defined|release type'    =>'Nedefinované',
'Not planned|release type'    =>'Neplánované',
'upcoming|release type'      =>'Prichádzajúce',
'Internal|release type'       =>'Interné',
'Public|release type'         =>'Verejné',
'Without support|release type'=>'Bez podpory',
'No longer supported|release type'=>'Už nepodporované',
'undefined|company category'  =>'nedefinované',
'client|company category'     =>'klient',
'prospective client|company category'=>'potenciálny klient',
'supplier|company category'   =>'dodávateľ',
'partner|company category'    =>'partner',
'undefined|person category'   =>'nedefinované',
'- employee -|person category'=>'- zamestanec -',
'staff|person category'       =>'zamestnanci',
'freelancer|person category'  =>'živnostník',
'working student|person category'=>'pracujúci študent',
'apprentice|person category'  =>'učeň',
'intern|person category'      =>'intern',
'ex-employee|person category' =>'ex-zamestnanec',
'- contact person -|person category'=>'- kontaktná osoba -',
'client|person category'      =>'klient',
'prospective client|person category'=>'potenciálny klient',
'supplier|person category'    =>'dodávateľ',
'partner|person category'     =>'partner',


);
?>
