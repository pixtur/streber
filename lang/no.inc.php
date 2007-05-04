<?php

# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html
/**
* language-table for Norwegian translation (C) Arne Christian Riis / ac.riis@systemizer.no
*/

global $g_lang_table;
$g_lang_table= array(

#--- top navigation tabs -------------------------------------------------------
'<span class=accesskey>H</span>ome'
                    =>'<span class=accesskey>H</span>ome',
'Go to your home. Alt-h / Option-h'
                    =>'Personlig oversikt. Alt-h / Option-h',
'<span class=accesskey>P</span>rojects'
                    =>'<span class=accesskey>P</span>rosjekter',
'Your projects. Alt-P / Option-P' =>'Dine prosjekter. Alt-P / Option-P',
'People'            =>'Personer',
'Your related People'
                    =>'Dine relevante personer',
'Companies'         =>'Organisasjoner',
'Your related Companies'
                    =>'Dine relevante organisasjoner',
'Calendar'          =>'Kalender',
'<span class=accesskey>S</span>earch:&nbsp;'
                    =>'<span class=accesskey>S</span>øk:&nbsp;',
"Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`"
                    =>'Tast inn begrep og bekreft. Utvidet søk gjennom å klikke på flik.',

#--- header --------------------------------------------------------------
'Wiki+Help'         =>'Wiki+Hjelp',
'Documentation and Discussion about this page'
                    =>'Hjelp og diskusjon omkring dette tema i programmet',
'This page requires java-script to be enabled. Please adjust your browser-settings.'
                    =>'Vennligst aktiver Javascript for å kunne benytte programmet.',
'you are'           =>'Du er',

'How this page looks for clients'
                    =>'Slik vil siden se ut for kunden',
'Client view'       =>'Kundevisning',
'Logout'            =>'Logg ut',

#--- common texts --------------------------------------------------------------
'Task'              =>'Oppgave',
'Effort'            =>'Innsats',
'Comment'           =>'Kommentar',
'Add Now'           =>'Legg til',

#--- home -----------------------------------------------------------------------
'Today'             =>'Idag',
'Discussions'       =>'Diskusjoner',
'At Home'           =>'Hjemme',
'F, jS'            =>'F, j',          # format date headline home
'Functions'         =>'Funksjoner',
'View your efforts' =>'Vis egne innsatser',
'Edit your profile' =>'Redigere egen profil',
'Your projects'     =>'Egne prosjekter',
'This is a tooltip' =>'?',
'Company'           =>'Organisasjon',
'Project'           =>'Prosjekt',
'Select lines to use functions at end of list'
                    =>'Marker linjer for å benytte funksjoner på slutten av listen',
'Priority'          =>'Prioritet',
'Edit'              =>'Redigere',
'Log hours for a project' =>'Logge timer',
'Create new project'=>'Opprette nytt prosjekt',
'You have no open tasks'
                    =>'Du har ingen åpne oppgaver',
'Open tasks'        =>'Åpne oppgaver',
'Task-Status'       =>'Oppgave status',
'Folder'            =>'Mappe',
'Started'           =>'Påbegynt',
'Est.'              =>'Ber.',
'Estimated time in hours'
                    =>'Beregnet tidsforbruk i timer',
'status->Completed' =>'Status->Ferdig',
'status->Approved'  =>'Status->Godkjent',
'Delete'            =>'Slette',
'Log hours for select tasks'
                    =>'Logg timer for oppgave',
'%s tasks with estimated %s hours of work'
                    =>'%s oppgaver med ca. %s timers arbeid',


#--- pages/_handles.inc -------------
'Home'                        =>'Hjem',
'Active Projects'             =>'Aktive Prosjekter',
'Closed Projects'             =>'Lukkete Projekter',
'Project Templates'           =>'Prosjekt Maler',
'View Project'                =>'Prosjekt Visning',
'Closed tasks'                =>'Lukkete Oppgaver',
'New Project'                 =>'Nytt Prosjekt',
'Duplicate Project'           =>'Duplisere Prosjekt',
'Edit Project'                =>'Redigere Prosjekt',
'Delete Project'              =>'Slette Prosjekt',
'Change Project Status'       =>'Endre Prosjekt-Status',
'Add Team member'             =>'Legg til Prosjektperson',
'Edit Team member'            =>'Endre Prosjektperson',
'Remove from team'            =>'Fjerne Projektperson fra team',

'View Task'                   =>'Oppgave oversikt',
'Edit Task'                   =>'Redigere oppgave',
'Delete Task(s)'              =>'Slette Oppgave(r)',
'Restore Task(s)'             =>'Gjennopprette Oppgave(r)',
'Move tasks to folder'        =>'Flytte Opgaver til mappe',
'Mark tasks as Complete'      =>'Merke oppgaver som Utført',
'Mark tasks as Approved'      =>'Merke oppgaver som Godkjent',
'New Task'                    =>'Nye Oppgaver',
'Toggle view collapsed'       =>'Skifte mellom sammentrukket visning',
'Log hours'                   =>'Logg timer',
'Edit time effort'            =>'Redigere tids innsats',
'Create comment'              =>'Opprette Notat',
'Edit comment'                =>'Redigere Notat',
'Delete comment'              =>'Slette Notat',
'Add issue/bug report'        =>'Legg Feilrapport til oppgave',
'List Companies'              =>'Organisasjoner',
'View Company'                =>'Organisasjons Oversikt',
'New Company'                 =>'Ny Organisasjon',
'Edit Company'                =>'Redigere Organisasjon',
'Delete Company'              =>'Slette Organisasjon',
'Link Persons'                =>'Linke Personer',
'List Persons'                =>'Liste Personer',
'View Person'                 =>'Person Oversikt',
'New Person'                  =>'Ny Person',
'Edit Person'                 =>'Redigere Person',
'Edit User Rights'            =>'Redigere Bruker-rettigheter',
'Delete Person'               =>'Slette Person',
'View Efforts of Person'      =>'Vise en persons Innsats',
'Login'                       =>'Logg inn',
'License'                     =>'Lisens',
'Error'                       =>'Feil',





### ../db/class_company.inc   ###
'Optional'                    =>'Valgfri',
'more than expected'          =>'mer enn forventet',
'not available'               =>'ikke tilgjengelig',

### ../db/class_effort.inc   ###
'optional if tasks linked to this effort'=>'Valgfritt dersom oppgaver er linket til denne innsatsen',

### ../db/class_person.inc   ###
'Full name'                   =>'Fullt navn',
'Nickname'                    =>'Brukernavn',

### ../lists/list_persons.inc   ###
'Tagline'                     =>'Tag linje',

### ../db/class_person.inc   ###
'Mobile Phone'                =>'Mobiltelefon',
'Office Phone'                =>'Kontor Tlf',
'Office Fax'                  =>'Kontor Faks',
'Office Street'               =>'Kontor Gateadr',
'Office Zipcode'              =>'Kontor Postnr',
'Office Page'                 =>'Kontor Nettsted',
'Personal Phone'              =>'Privat Tlf',
'Personal Fax'                =>'Privat Faks',
'Personal Street'             =>'Privat Gateadr',
'Personal Zipcode'            =>'Privat Postnr',
'Personal Page'               =>'Privat Nettsted',
'Personal E-Mail'             =>'Privat E-post',
'Birthdate'                   =>'Fødselsdag',

### ../db/class_project.inc   ###
'Color'                       =>'Farge',

### ../lists/list_comments.inc   ###
'Comments'                    =>'Notater',

### ../db/class_person.inc   ###
'Password'                    =>'Passord',

### ../lists/list_projects.inc   ###
'Name'                        =>'Navn',

### ../db/class_task.inc   ###
'Short'                       =>'Avkortet',
'Planned Start'               =>'Planlagt Start',
'Planned End'                 =>'Planlagt Slutt',
'Date start'                  =>'Dato Start',
'Date closed'                 =>'Dato Slutt',
'Status'                      =>'Status',
'Description'                 =>'Beskrivelse',
'Completion'                  =>'Ferdig',
'Estimated'                   =>'Beregnet',
'Date due'                    =>'Forfallsdato',
'Date due end'                =>'Sluttdato',


### ../db/class_project.inc   ###
'Status summary'              =>'Status sammendrag',
'Project page'                =>'Prosjekt Nettside',
'Wiki page'                   =>'Prosjekt Wiki-Side',
'show tasks in home'          =>'Vis oppgaver i Hjemme',
'validating invalid item'     =>'Sjekker ugyldig Element',

### ../pages/comment.inc   ###
'insuffient rights'           =>'Utilstrekkelige rettigheter',


### ../db/class_projectperson.inc   ###
'job'                         =>'Jobb',
'role'                        =>'Rolle',

### ../pages/task.inc   ###
'Label'                       =>'Etikett',

### ../pages/task.inc   ###
'task without project?'       =>'Oppgave uten Prosjekt?',

### ../db/db_item.inc   ###
'<b>%s</b> isn`t a known format for date.'=>'Advarsel: <b>%s</b> er et ukjent Datoformat',

### ../lists/list_tasks.inc   ###
'New'                         =>'Ny',
'Sum of all booked efforts (including subtasks)'=>'sammendrag all registrert innsats (inkl. underoppgaver)',

### ../lists/list_comments.inc   ###
'Move to Folder'              =>'Flytt til mappe',
'Shrink View'                 =>'Klapp sammen visning',
'Expand View'                 =>'Utvid visning',
'Topic'                       =>'Tema',

### ../lists/list_companies.inc   ###
'related companies'           =>'relevante Organisasjoner',

### ../lists/list_efforts.inc   ###
'S'                           =>'S',

### ../lists/list_persons.inc   ###
'Name Short'                  =>'Kortnavn',
'Shortnames used in other lists'=>'Abkürzungen werden in Listen verwendet',

### ../pages/proj.inc   ###
'Phone'                       =>'Telefon',

### ../lists/list_companies.inc   ###
'Phone-Number'                =>'Telefon',
'Proj'                        =>'Proj',
'Number of open Projects'     =>'Antall åpne Prosjekter',
'people'                      =>'Personer',
'People working for this person'=>'Personen i denne Organisasjonen',
'Edit company'                =>'Redigere Organisasjon',
'Delete company'              =>'Slette Organisasjon',
'Create new company'          =>'Ny Organisasjon',

### ../lists/list_efforts.inc   ###
'person'                      =>'Person',

### ../lists/list_projects.inc   ###
'Task name. More Details as tooltips'=>'Oppgavenavn. Mer informasjon som Tooltip.',

### ../lists/list_efforts.inc   ###
'Edit effort'                 =>'Redigere Innsats',
'New effort'                  =>'Ny Innsats',
'D, d.m.Y'                    =>'D, d.m.Y',

### ../lists/list_persons.inc   ###
'Mobil'                       =>'Mobil',

### ../pages/person.inc   ###
'Office'                      =>'Kontor',
'Private'                     =>'Privat',

### ../lists/list_persons.inc   ###
'Edit person'                 =>'Redigere Person',
'Delete person'               =>'Slette Person',
'Create new person'           =>'Ny Person',

### ../lists/list_project_team.inc   ###
'Your related persons'        =>'Dine relevante Personer',
'Rights'                      =>'Rettigheter',
'Persons rights in this project'=>'Personers Prosjektrettigheter',
'Add team member'             =>'Ny Prosjektperson',
'Remove person from team'     =>'Fjerne Prosjektperson fra team',
'Member'                      =>'Prosjektperson',
'Role'                        =>'Rolle',

### ../pages/proj.inc   ###
'Changes'                     =>'Endringer',

### ../lists/list_tasks.inc   ###
'Created by'                  =>'Opprettet av',

### ../lists/list_projectchanges.inc   ###
'Item was originally created by'=>'Objekt ble opprinnelig opprettet av...',
'modified'                    =>'bearbeidet',
'C'                           =>'N',
'Created,Modified or Deleted' =>'Ny, Redigert eller Slettet',
'Deleted'                     =>'Slettet',
'Modified'                    =>'Redigert',
'Created'                     =>'Opprettet',
'by Person'                   =>'av Person',
'Person who did the last change'=>'Person som gjorde siste endring',
'T'                           =>'O',
'Item of item: [T]ask, [C]omment, [E]ffort, etc '=>'Objekt type O-Oppgave, N-Notat, O-Oppgave',
'undefined item-type'=>'ukjent objekt-type',
'Del'                         =>'Slett',
'shows if item is deleted'    =>'viser om objekt er slettet',
'deleted'                     =>'slettet',

### ../lists/list_projects.inc   ###
'Status Summary'              =>'Status sammendrag',
'Short discription of the current status'=>'Kort beskrivelse av aktuell Prosjektstatus',

### ../lists/list_tasks.inc   ###
'Tasks'                       =>'Oppgaver',
'Tasks|short column header'   =>'Oppg',
'%s open tasks / %s h'        =>'%s åpne oppgaver / %s t',

### ../lists/list_projects.inc   ###
'Number of open Tasks'        =>'Antall åpne oppgaver',
'Opened'                      =>'Start',
'Day the Project opened'      =>'når Prosjektet ble påbegynt',

### ../pages/proj.inc   ###
'Closed'                      =>'Lukkete',

### ../lists/list_projects.inc   ###
'Day the Project state changed to closed'=>'Når prosjektet ble avsluttet',
'Edit project'                =>'Redigere Prosjekt',
'Delete project'              =>'Slette Prosjekt',
'Open / Close'                =>'Åpne/Lukke Prosjekt',
'... working in project'      =>'... arbeider i Prosjektet',

### ../lists/list_taskfolders.inc   ###
'Folders'                     =>'Mapper',
'Select all, range, no row'   =>'Velg Alle, utvalg eller ingen linjer',
'Number of subtasks'          =>'Antall underoppgaver',
'Create new folder under selected task'=>'Ny mappe under valgte oppgave',

### ../lists/list_tasks.inc   ###
'Move selected to folder'     =>'Flytt til mappe',
'Priority of task'            =>'Oppgave Prioritet',
'Status->Completed'           =>'Status->Ferdig?',
'Status->Approved'            =>'Status->Godkjent',
'Name, Comments'              =>'Navn, Notater',
'has %s comments'             =>'har %s Notater',

### ../pages/person.inc   ###
'Efforts'                     =>'Innsatser',

### ../lists/list_tasks.inc   ###
'Effort in hours'             =>'Innsats i timer',

### ../pages/comment.inc   ###
'New Comment'                 =>'Ny Notat',
'Reply to '                   =>'Svar til ',
'Edit Comment'                =>'Redigere Notat',
'On task %s'                  =>'for oppgave %s',
'On project %s'               =>'for Prosjekt %s',
'Occasion'                    =>'Anledning',

### ../pages/task.inc   ###
'Public to'                   =>'Kan ses av',
'Edit this task'              =>'Redigere denne oppgaven',
'Append bug report'           =>'Legg til feilrapport',
'Delete this task'            =>'Slette denne oppgaven',
'Restore this task'           =>'Gjennopprette denne oppgaven',

### ../pages/comment.inc   ###
'Select some comments to delete'=>'Velg noen notater å slette',
'Select some comments to move'=>'Velg noen notater å flytte',

### ../pages/task.inc   ###
'Select excactly ONE folder to move tasks into'=>'Velg nøyaktig EN mappe å flytte oppgaven til.',

### ../pages/comment.inc   ###
'is no longer a reply'        =>'er ikke lenger et svar',

### ../pages/company.inc   ###
'related projects of %s'     =>'Relevante Projekter for %s',

### ../pages/proj.inc   ###
'admin view'                  =>'Admin-Visning',
'List'                        =>'Liste',

### ../pages/company.inc   ###
'no companies'                =>'Ingen organisasjoner',

### ../pages/proj.inc   ###
'Overview'                    =>'Oversikt',

### ../pages/company.inc   ###
'Edit this company'           =>'Redigere organisasjon',
'Create new person for this company'=>'Ny Person for organisasjonen',

### ../pages/person.inc   ###
'Person'                      =>'Person',

### ../pages/company.inc   ###
'Create new project for this company'=>'Nytt Prosjekt for organisasjonen',
'Add existing persons to this company'=>'Legg til eksisterende Personer til organisasjonen',
'Persons'                     =>'Personer',

### ../pages/person.inc   ###
'Summary'                     =>'Sammendrag',
'Adress'                      =>'Addresse',
'Fax'                         =>'Faks',

### ../pages/company.inc   ###
'Web'                         =>'Web',
'Intra'                       =>'Intra',
'Mail'                        =>'E-Post',
' Hint: for already existing projects please edit those and adjust company-setting.'
                                =>' Tips: For allerede eksisterende projekter foretas endringer der..',
'no projects yet'             =>'ennå ingen Projekter',
'link existing Person'        =>'linke eksisterende Personer',
'create new'                  =>'opprette ny',
'no persons related'          =>'ingen relevante Personer',
'Create another company after submit'=>'opprette ennå en organisasjon etter lagring',
'Edit %s'                     =>'Redigere %s',
'Add persons employed or related'=>'Legg til ansatte eller relaterte Personer',
'No persons selected...'=>'Ingen Personer valgt...',
'Person already related to company'=>'Personen arbeiteder allerede for denne organisasjonen',
'Select some companies to delete'=>'Velg organisasjoner som skal slettes',

### ../pages/effort.inc   ###
'New Effort'                  =>'Ny Innsats',
'only expected one task. Used the first one.'=>'Kan kun benytte den første oppgaven.',
'For task'                    =>'For oppgave',
'Could not get effort'        =>'Kunne ikke hente innsatsen',
'Could not get project of effort'=>'Kunne ikke hente Prosjekt for Innsatsen',
'Select some efforts to delete'=>'Vennligst velg noen innsatser å slette.',

### ../pages/error.inc   ###
'Unknown Page'                =>'Ukjent side',

### ../pages/home.inc   ###
'You are not assigned to a project.'=>'Du er ikke med i noen prosjekter.',

### ../pages/login.inc   ###
'Welcome to streber'          =>'Velkommen til Systemizer prosjektoppfølging.',
'please login'                =>'Vennligst logg inn',
'invalid login'               =>'Feil ved innlogging',

### ../pages/person.inc   ###
'Active People'               =>'Aktive Personer',

### ../pages/proj.inc   ###
'relating to %s'              =>'i forbindelse med %s',

### ../pages/person.inc   ###
'With Account'                =>'med Konto',
'All Persons'                 =>'Alle Personer',
'no related persons'          =>'ingen relevante Personer',
'Edit this person'            =>'Redigere denne Personen',
'Profile'                     =>'Profil',
'User Rights'                 =>'Bruker-rettigheter',
'Mobile'                      =>'Mobil',
'Website'                     =>'Webside',
'Personal'                    =>'Personlig',

### ../pages/proj.inc   ###
'E-Mail'                      =>'E-Post',

### ../pages/person.inc   ###
'works for'                   =>'arbeider for Organisasjon',
'not related to a company'    =>'ikke relatert til noen organisasjon',
'works in Projects'           =>'i Projekter',
'no active projects'          =>'ingen aktive Projekter',
'not allowed to edit'         =>'ikke tilstrekkelige rettigheter for å redigere',
'Person can login'            =>'Person kan logge inn',
'Theme'                       =>'Stil',
'Create another person after submit'=>'Legge inn ennå en person etter lagring',
'Could not get person'        =>'Kunne ikke hente Person',
'Nickname has to be unique'=>'Brukernavn må være unike.',
'passwords don´t match'       =>'Passordene stemmer ikke overens',
'Login-accounts require a unique nickname'=>'Personer med bruker konti må ha entydige brukernavn',
'could not insert object'=>'kunne ikke legge til objekt',
'Select some persons to delete'=>'Velg personer som skal slettes',
'Adjust user-rights of %s'    =>'Redigere bruker rettigheter for %s',
'Please consider that activating login-accounts might trigger security-issues.'
                              =>'Vær oppmerksom på at bruker konti representerer potensiell sikkerhets risiko.',
'User rights changed'         =>'Bruker rettigheter ble endret.',

### ../pages/proj.inc   ###
'Active'                      =>'Aktive',
'Templates'                   =>'Maler',
'Your Active Projects'        =>'Dine aktive Projekter',
'<b>NOTE</b>: Some projects are hidden from your view. Please ask an administrator to adjust you rights to avoid double-creation of projects'
                                =>'Bem: Noen prosjekter er ikke synlig for deg. For å unngå dobbelregistrering av prosjekter burde du snakke med administrator.',
'not assigned to a project'   =>'Ikke medlem av dette prosjektet',
'Your Closed Projects'        =>'Dine avsluttete prosjekter',
'invalid project-id'          =>'ugyldig Prosjekt-ID',
'Edit this project'           =>'Redigere dette Prosjektet',
'Add person as team-member to project'
                              =>'Legg Person til Prosjekt',
'Create task with issue-report'=>'Opprette oppgave med feilbeskrivelse',
'Add Bugreport'               =>'ny feilrapport',
'Book effort for this project'=>'Registrere innsats for dette Prosjektet',
'Log Effort'                  =>'Logg Innsats',
'Logged effort'               =>'Logget Innsats',
'Team members'                =>'Prosjektmedlemmer',
'All open tasks'              =>'Alle åpne oppgaver',
'Comments on project'         =>'Prosjekt Notater',
'Project Efforts'             =>'Prosjekt Innsatser',
'Closed Tasks'                =>'Avsluttete Oppgaver',
'changed project-items'       =>'endrete Prosjekt-Objekter',
'no changes yet'              =>'ingen endringer hittil',
'Project Issues'              =>'Prosjekt Feil',
'Report Bug'                  =>'Rapportere feil',
'Select some projects to delete'=>'Vennligst velg prosjekter som skal slettes',
'Failed to delete %s projects'=>'Klarte ikke å slette %s oppgaver',
'Moved %s projects to trash'=>'%s Projekter flyttet til Søppelbøtten',
'Select some projects...'     =>'Velg noen prosjekter...',
'Invalid project-id!'         =>'Ugyldig Prosjekt-ID',
'Y-m-d'                       =>'Y-m-d',
'Failed to change %s projects'=>'ADVARSEL: Endringen av %s slo feil',
'Closed %s projects'          =>'%s Projekter lukket',
'Select new team members'     =>'Velg nye team medlemmer',
'found no persons to add'     =>'fant ingen personer å legge til',
'No persons selected...'      =>'Ingen personer ble valgt ut.',
'Could not access person by id'=>'Kunne ikke aksessere Person med ID',
'reanimated person as team-member'=>'Person ble gjenopptatt som team medlem.',
'Person already in project'=>'Person er allerede Team-Medlem',
'Failed to insert new project'=>'Feil ved innlegging av nytt Prosjekt.',
'Failed to insert new projectproject'=>'Feil ved innlegging av nytt Team-Medlem.',
'Failed to insert new issue'  =>'Feil ved innlegging av ny feilrapport',
'Failed to update new task'   =>'Feil ved innlegging av ny oppgave',
'Failed to insert new comment'=>'Feil ved innlegging av nytt notat',

### ../pages/task.inc   ###
'Issue report'                =>'Feilrapport',
'Plattform'                   =>'Plattform',
'OS'                          =>'OS',
'Version'                     =>'Versjon',
'Build'                       =>'Build',
'Steps to reproduce'          =>'Skritt for å reprodusere',
'Expected result'             =>'forventet resultat',
'Suggested Solution'          =>'mulig løsning',
'I guess you wanted to create a folder...'=>'Jeg antar at det var en mappe du ville opprette...',
'Assumed <b>%s</b> to be mean label <b>%s</b>'=>'<b>%s</b> ble anvendt som etikett <b>%s</b>',
'No project selected?'        =>'Ingen Prosjekter valgt?',
'New folder'                  =>'Ny mappe',
'No task selected?'           =>'Ingen Oppgaver valgt',
'NOTICE: Ungrouped %s subtasks to <b>%s</b>'=>'%s underoppgaver ble forskjøvet til %s',
'HINT: You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'
              =>'Du har gjort <b>%s</b> om til en mappe. Mapper vises kun i oppgave treet.',
'Select some tasks to move'   =>'Velg noen oppgaver å flytte.',
'Task <b>%s</b> deleted'           =>'Oppgaven <b>%s</b> ble slettet.',
'Moved %s tasks to trash'=>'%s oppgaver ble flyttet til søppelkurven.',
'<br> ungrouped %s subtasks to above parents.'=>'<br>%s underoppgaver ble forskjøvet til overliggende foreldre.',
'Could not find task'=>'Oppgave ikke funnet.',
'Task <b>%s</b> doesn´t need to be restored'=>'Oppgave %s trenger ikke å bli gjenopprettet.',
'Task <b>%s</b> restored'          =>'Oppgave <b>%s</b> ble gjenopprettet.',
'Failed to restore Task <b>%s</b>' =>'Feil ved gjennoppretting av <b>%s</b>.',
'Marked %s tasks as approved and hidden from project-view.'=>'%s oppgaver merket som godkjent og skjult fra prosjekt visning',
'could not update task'       =>'Kunne ikke oppdatere oppgave',
'No task selected to add issue-report?'=>'Vennligst velg en oppgave for feilrapporten',
'Task already has an issue-report'=>'Oppgaven har allerede en feilrapport',
'Adding issue-report to task' =>'Legge feil-rapport til oppgaven',
'Could not get task'          =>'Kunne ikke få tak i oppgaven',

### ../render/render_page.inc   ###
'Return to normal view'       =>'Tilbake til normalvisning',
'Leave Client-View'           =>'Forlate klient visning',



### tooltips ###
'Required. Full name like (e.g. Thomas Mann)' =>'Må være med. Fullstendig navn (f.eks. Thomas Mann)',
'Required. (e.g. pixtur)' =>'f.eks. pixtur',
'Optional: Additional tagline (eg. multimedia concepts)' =>'Tilleggstag (f.eks.multimedia løsning)',
'Optional: Private Phone (eg. +49-30-12345678)' =>'Privat Telefonnummer',
'Optional: Private Fax (eg. +49-30-12345678)' =>'Privat Fax-nummer',
'Optional: Private (eg. Poststreet 28)' =>'Gate og Husnummer',
'Optional: Private (eg. 12345 Berlin)' =>'Postnr. og sted',
'Optional: (eg. http://www.pixtur.de/login.php?name=someone)' =>'f.eks. http://www.pixtur.noe/login.php?name=someone',
'show as folder (may contain other tasks)' =>'Mappe for oppgaver',
'Project priority (the icons have tooltips, too)' =>'Prosjekt prioriteter',
'Duplicate project' =>'Duplisere prosjekt',
'Required. (e.g. pixtur ag)' =>'Må være med. f.eks.Pixtur AS limited',
'Optional: Short name shown in lists (eg. pixtur)' =>'Kortnavn for smale listekolonner',
'Optional: Phone (eg. +49-30-12345678)' =>'f.eks. +47-12344355',
'Optional: Fax (eg. +49-30-12345678)' =>'f.eks. +47-12344355',
'Optional: (eg. Poststreet 28)' =>'f.eks. Postgaten 28',
'Optional: (eg. 12345 Berlin)' =>'f.eks. 5000 Bergen',
'Optional: (eg. http://www.pixtur.de)' =>'f.eks.. http://www.pixtur.no',
'Optional: Private (eg. Poststreet 28)' =>'f.eks. Postsgaten 28',
'Optional: (eg. Poststreet 28)' =>'f.eks.Poststgaten 28',

### in listen ###
'-- do...'                      =>'-- Funktion wählen...',
"Status is %s"                  =>'Status: %s',
"Priority is %s"                =>'Prioritet: %s',


### ../pages/comment.inc   ###
'Failed to delete %s comments'=>'%s notater kunne ikke slettes.',
'Moved %s comments to trash'=>'%s notater lagt i søppelbøtten.',

### ../pages/company.inc   ###
'Failed to delete %s companies'=>'%s organisasjoner kunne ikke slettes.',
'Moved %s companies to trash'=>'%s organisasjoner flyttet til søppelbøtten.',

### ../pages/effort.inc   ###
'Failed to delete %s efforts'=>'%s innsatser kunne ikke slettes.',
'Moved %s efforts to trash'=>'%s innsatser flyttet til søppelbøtten.',

### ../pages/person.inc   ###
'passwords don´t match'       =>'Passordene stemmer ikke overens.',
'Failed to delete %s persons'=>'%s Personer kunne ikke slettes.',
'Moved %s persons to trash'=>'%s Personen ble flyttet til papirkurven.',

### ../pages/proj.inc   ###
'Issues'                      =>'Feilrapporter',
'History'                     =>'Historikk',



### ../db/db_item.inc   ###
'unnamed'                     =>'uten navn',

### ../lists/list_tasks.inc   ###
'New / Add'                   =>'Ny / Legge til',

### ../pages/task.inc   ###
'Assigned to'                 =>'Tildelt',

### ../lists/list_tasks.inc   ###
'- no name -|in task lists'   =>'- uten navn -',

### ../pages/company.inc   ###
'Active projects'             =>'Aktive Prosjekter',
'Closed projects'             =>'Avsluttete Projekter',

### ../pages/home.inc   ###
'Open tasks assigned to you'  =>'Åpne oppgaver tildelt deg',

### ../pages/person.inc   ###
'Language'                    =>'Språk',
'passwords don´t match'       =>'Passordene stemmer ikke overens',
'Select some persons to edit' =>'Vennligst velg noen personer å redigere',
'Could not get Person'        =>'Kan ikke finne Person',

### ../pages/proj.inc   ###
'Reactivated %s projects'     =>'%s Projekter ble reaktiverte',
'Failed to insert new projectperson'=>'Feil ved innlegging av ny Prosjektperson',

### ../pages/projectperson.inc   ###
'Edit Team Member'            =>'Tilpasse prosjektrolle',
'role of %s in %s|edit team-member title'=>'Redigere rolle til %s i Prosjekt %s',

### ../pages/task.inc   ###
'Assign to'                   =>'Tildeles',
'Also assign to'              =>'Tildeles også',
'formerly assigned to %s'     =>'tidligere tilegnet %s',
'task was already assigned to %s'=>'Oppgave var allerede tilegnet %s',
'Task requires name'          =>'Oppgave trenger navn',
' ungrouped %s subtasks to above parents.'=>'Opphevet gruppering av %s underoppgaver',
'Task <b>%s</b> doesn´t need to be restored'=>'Oppgave <b>%s</b> trenger ikke gjenopprettes',

### ../render/render_list_column_special.inc   ###
'Days until planned start'    =>'Dager til planlagt start',
'Due|concerning time'         =>'Forfaller',
'Number of open tasks is hilighted if shown home.'=>'Antall oppgaver blir uthevet dersom disse vises i HJEM-Visning',
'Item is public to'           =>'Objekt kan ses av...',
'Pub|table-header, public'    =>'Ses av',
'Public to %s'                =>'Ses av %s',


#<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

### ../db/class_project.inc   ###
'insuffient rights (not in project)'=>'Manglende tilgangsretter (ikke i prosjekt).',

### ../lists/list_persons.inc   ###
'(adjusted)'                  =>'(tilpasset)',

### ../lists/list_projectchanges.inc   ###
'(on comment)'                =>'(på Notat)',
'(on task)'                   =>'(på Oppgave)',
'(on project)'                =>'(på Prosjekt)',

### ../pages/_handles.inc   ###
'Create Template'             =>'Opprette Mal',
'Project from Template'       =>'Prosjekt fra Mal',

### ../pages/home.inc   ###
'Open tasks (including unassigned)'=>'Åpne oppgaver (inkl. ikke tildelte)',

### ../pages/person.inc   ###
'(resetting rights)'          =>'(Tilbakestiller rettigheter)',
'passwords do not match'      =>'Passordene stemmer ikke overens',
'Password is too weak (please add numbers, special chars or length)'=>'Passord for kort',

### ../pages/proj.inc   ###
'Project Template'            =>'Prosjekt Mal',
'Inactive Project'            =>'Inaktive Prosjekter',
'Project|Page Type'           =>'Prosjekt',
'Template|as addon to project-templates'=>'Mal',
'Project duplicated (including %s items)'=>'Prosjekt ble kopiert (inklusive %s elementer)',

### ../pages/task.inc   ###
'No task(s) selected for deletion...'=>'Ingen oppgave(r) valgt for sletting.',
'Task <b>%s</b> do not need to be restored'=>'Oppgave <b>%s</b> trenger ikke gjenoprettes.',
'No task(s) selected for restoring...'=>'Ingen oppgaver valgt for gjenoppretting.',
'Select some task(s) to mark as completed'=>'Vennligst velg oppgave(r) som skal merkes som avsluttet.',
'Marked %s tasks (%s subtasks) as completed.'=>'%s oppgaver merket som avsluttet.',
'%s error(s) occured'         =>'Det er oppstått %s feil.',
'Select some task(s) to mark as approved'=>'Vennligst veg oppgave(r) for avmerking som godkjent.',
'Select some task(s)'         =>'Vennligst velg oppgaver.',

### ../render/render_list_column_special.inc   ###
'Due|column header, days until planned start'=>'Innen',
'planned for %s|a certain date'=>'planlagt for %s',
'Pub|column header for public level'=>'Off',

### ../render/render_misc.inc   ###
'No element selected? (could not find id)|Message if a function started without items selected'=>'Ingen objekter valgt?',

### ../std/class_pagehandler.inc   ###
'operation aborted (%s)'=>'Operasjon avbrutt (%s)',
'Insuffient rights'    =>'Manglende rettigheter.',


##############

### ../lists/list_project_team.inc   ###
'Edit team member'            =>'Redigere Prosjektrolle',

### ../pages/_handles.inc   ###
'Search'                      =>'Søke',

### ../pages/effort.inc   ###
'Edit Effort'                 =>'Redigere Innsats',
'Date / Duration|Field label when booking time-effort as duration'=>'Dato / Varighet',
'Name required'               =>'Navn er nødvendig.',
'Cannot start before end.'    =>'Kan ikke slutte før start dato.',

### ../pages/proj.inc   ###
'create new project'          =>'Opprette nytt prosjekt',
'no tasks closed yet'         =>'ingen oppgaver avsluttet ennå',
'Create another project after submit'=>'Opprett ennå et prosjekt etter lagring av dette',
'Failed to insert new project person. Data structure might have been corrupted'=>'Kunne ikke lagre prosjekt person. Databankstruktur eventuelt skadet!',
'Failed to insert new project. Datastructure might have been corrupted'=>'Kunne ikke lagre Prosjekt. Databankstruktur eventuelt skadet!',
'Failed to insert new issue. DB structure might have been corrupted.'=>'Kunne ikke lagre sak. Databankstruktur eventuelt skadet!',
'Failed to update new task. DB structure might have been corrupted.'=>'Kunne ikke lagre oppgaven. Databankstruktur eventuelt skadet!',
'Failed to insert new comment. DB structure might have been corrupted.'=>'Kunne ikke lagre notat. Databankstruktur eventuelt skadet!',

### ../pages/projectperson.inc   ###
'Role in this project'        =>'Rolle i dette prosjektet',
'start times and end times'   =>'Start- og Slutt tider',
'duration'                    =>'kun varighet',
'Log Efforts as'              =>'Logg innsats som',

### ../pages/search.inc   ###
'Jumped to the only result found.'=>'Hoppet til det eneste resultatet som ble funnet.',
'Search Results'              =>'Søkeresultater',
'Searching'                   =>'Søk',
'Found %s companies'          =>'%s Firmaer funnet',
'Found %s projects'           =>'%s Projekter funnet',
'Found %s persons'            =>'%s Personer funnet',
'Found %s tasks'              =>'%s Oppgaver funnet',
'Found %s comments'           =>'%s Notater funnet',

### ../pages/task.inc   ###
'Summary|Block title'         =>'Oversikt',
'Description|Label in Task summary'=>'Beskrivelse',
'Part of|Label in Task summary'=>'Tilhører',
'Status|Label in Task summary'=>'Status',
'Opened|Label in Task summary'=>'Påbegynt',
'Closed|Label in Task summary'=>'Avsluttet',
'Created by|Label in Task summary'=>'Opprettet av',
'Last modified by|Label in Task summary'=>'Bearbeidet av',
'Logged effort|Label in task-summary'=>'Logget innsats',
'open sub tasks|Table headline'=>'Åpne underoppgaver',
'All open tasks|Title in table'=>'Alle åpne underoppgaver',
'Steps to reproduce|label in issue-reports'=>'Skritt for å reprodusere',
'Expected result|label in issue-reports'=>'Forventet resultat',
'Suggested Solution|label in issue-reports'=>'Mulig løsning',
'Bug|Task-Label that causes automatically addition of issue-report'=>'Feil',
'Edit Task|Page title'        =>'Redigere oppgave',
'Assign to|Form label'        =>'Tildelt',
'Also assign to|Form label'   =>'Tildeles også',
'Prio|Form label'             =>'Prio',
'undefined'                   =>'udefinert',
'Severity|Form label, attribute of issue-reports'=>'Alvorlighetsgrad',
'reproducibility|Form label, attribute of issue-reports'=>'Reproduserbarhet',
'unassigned to %s|task-assignment comment'=>'tildelt %s',
'formerly assigned to %s|task-assigment comment'=>'var tidligeretildelt %s',

### ../std/class_pagehandler.inc   ###
'Operation aborted with an fatal error (%s). Please help us by %s'=>'Operasjon avbrutt pga fatal feil. Vennligst hjelp oss ved %s',
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up. Please help us by %s'
	=>'Operasjon avbrutt med fatal database struktur feil (%s). Dette kan ha skjedd pga inkonsekvens i din database. Vi anbefaler sterkt å ta inn en backup. Vennligst hjelp oss ved %s',



### ../lists/list_tasks.inc   ###
'Add new Task'                =>'Ny oppgave',

### ../pages/task.inc   ###
'Report new Bug'              =>'Ny feilrapport',

### ../pages/_handles.inc   ###
'New Bug'                     =>'Ny feil',
'View comment'                =>'Vise notater',
'System Information'          =>'System Informasjon',
'PhpInfo'                     =>'phpInfo',

### ../pages/task.inc   ###
'(deleted %s)|page title add on with date of deletion'=>'(slettet %s)',

### ../pages/comment.inc   ###
'Edit this comment'           =>'Redigere Notat',
'New Comment|Default name of new comment'=>'Nytt Notat',
'Reply to |prefix for name of new comment on another comment'=>'Svar til ',
'Edit Comment|Page title'     =>'Redigere Notat',
'New Comment|Page title'      =>'Nytt Notat',
'On task %s|page title add on'=>'til Oppgave %s',

### ../pages/effort.inc   ###
'On project %s|page title add on'=>'til Prosjekt %s',

### ../pages/comment.inc   ###
'Occasion|form label'         =>'Mulighet',
'Public to|form label'        =>'Offentlig for',
'is no longer a reply|message'=>'er ikke lenger et svar',

### ../pages/effort.inc   ###
'Edit Effort|page type'       =>'Redigere innsats',
'Edit Effort|page title'      =>'Redigere innsats',
'New Effort|page title'       =>'Ny innsats',

### ../pages/error.inc   ###
'Error|top navigation tab'    =>'Feil',

### ../pages/home.inc   ###
'S|Column header for status'  =>'S',
'P|Column header for priority'=>'P',
'Priority|Tooltip for column header'=>'Prio',
'Company|column header'       =>'Org.',
'Project|column header'       =>'Prosjekt',
'Edit|function in context menu'=>'Redigere',
'Log hours for a project|function in context menu'=>'Logg innsats',
'Create new project|function in context menu'=>'Opprette nytt Prosjekt',
'P|column header'             =>'P',
'S|column header'             =>'S',
'Folder|column header'        =>'Mappe',
'Started|column header'       =>'Påbegynt',
'Est.|column header estimated time'=>'Est.',
'Edit|context menu function'  =>'Redigere',
'status->Completed|context menu function'=>'Status->ferdig',
'status->Approved|context menu function'=>'Status->godkjent',
'Delete|context menu function'=>'Slette',
'Log hours for select tasks|context menu function'=>'Logg innsats for oppgave(r)',

### ../pages/login.inc   ###
'Login|tab in top navigation' =>'Logg inn',
'License|tab in top navigation'=>'Lisens',
'Welcome to streber|Page title'=>'Velkommen til Systemizers prosjektstyring system',
'Name|label in login form'    =>'Brukernavn',
'Password|label in login form'=>'Passord',
'invalid login|message when login failed'=>'feil ved innlogging',
'License|page title'          =>'Lisens',

### ../pages/misc.inc   ###
'Admin|top navigation tab'    =>'Admin',
'System information'          =>'System Informasjon',
'Admin'                       =>'Admin',
'Database Type'               =>'Databank Type',
'PHP Version'                 =>'PHP-Version',
'extension directory'         =>'Extensions katalog',
'loaded extensions'           =>'lastete extensions.',
'include path'                =>'include sti',
'register globals'            =>'register Globals',
'magic quotes gpc'            =>'magic quotes gpc',
'magic quotes runtime'        =>'magic quotes runtime',
'safe mode'                   =>'safe mode',

### ../pages/person.inc   ###
'relating to %s|page title add on listing pages relating to current user'=>'relatert til %s',
'With Account|page option'    =>'Med Konto',
'All Persons|page option'     =>'Alle Personer',
'People/Project Overview'     =>'Personer / Prosject Overblikk',
'Persons|Pagetitle for person list'=>'Personer',
'relating to %s|Page title Person list title add on'=>'relatert til %s',
'admin view|Page title add on if admin'=>'Admin visning',
'Edit this person|Tooltip for page function'=>'Redigere denne Personen',
'Profile|Page function edit person'=>'Profil',
'Edit User Rights|Tooltip for page function'=>'Tilpasse Rettigheter',
'User Rights|Page function for edit user rights'=>'Tilpasse Rettigheter',
'Adress|Label'                =>'Adresse',
'Mobile|Label mobilephone of person'=>'Mobil',
'Office|label for person'     =>'Kontor',
'Private|label for person'    =>'Privat',
'Fax|label for person'        =>'Faks',
'Website|label for person'    =>'Webside',
'Personal|label for person'   =>'Privat',
'E-Mail|label for person office email'=>'E-Post',
'E-Mail|label for person personal email'=>'E-Post',
'works for|List title'        =>'Arbeider for',
'works in Projects|list title for person projects'=>'Arbeider i prosjekter',
'Efforts|Page title add on'   =>'Innsats',
'Overview|Page option'        =>'Overblikk',
'Efforts|Page option'         =>'Innsats',
'Edit Person|Page type'       =>'Redigere Person',
'Password|form label'         =>'Passord',
'confirm Password|form label' =>'Passord',
'Person can login|form label' =>'kan logge inn',
'(resetting rights)| additional form label when changing profile'=>'Gjennopprette rettigheter',
'Profile|form label'          =>'Profil',
'Theme|form label'            =>'Tema',
'Language|form label'         =>'Språk',
'Edit Person|page type'       =>'Redigere Person',

### ../pages/proj.inc   ###
'List|page type'              =>'Liste',
'Summary|block title'         =>'Oppsummering',
'Status|Label in summary'     =>'Status',
'Opened|Label in summary'     =>'Åpnet',
'Closed|Label in summary'     =>'Lukket',
'Created by|Label in summary' =>'Opprettet av',
'Last modified by|Label in summary'=>'Sist endret av',
'hours'                       =>'timer',
'Client|label'                =>'Kunde',
'Phone|label'                 =>'Telefon',
'E-Mail|label'                =>'E-Post',
'new Effort'                  =>'nye Innsatser',
'Company|form label'          =>'Kunde',

### ../pages/projectperson.inc   ###
'Changed role of <b>%s</b> to <b>%s</b>'=>'Endret %s sin rolle',

### ../pages/search.inc   ###
'Sorry. Could not find anything.'=>'Beklager, fant ikke noe.',
'Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters'
	=>'Søk fungerer kun for<br>- Ord med mer enn 3 bokstaver<br>- Lister med mer enn 3 registreringer<br>- Ord uten spesialtegn',

### ../pages/task.inc   ###
'Task with subtasks|page type'=>'Oppgaver med underoppgaver',
'Task|page type'              =>'Oppgave',
'new subtask for this folder' =>'Nye underoppgaver i denne mappen',
'New task'                    =>'Ny oppgave',
'new bug for this folder'     =>'Ny feilmelding for denne mappen',
'Turned parent task into a folder. Note, that folders are only listed in tree'
	=>'Endret oppgaven til en mappe. Disse blir kun vist i trevisningen.',
'Failed, adding to parent-task'=>'Kunne ikke legges til mappen.',
'Task <b>%s</b> does not need to be restored'=>'Oppgave %s trenger ikke gjenopprettes.',

### ../std/class_pagehandler.inc   ###
'Operation aborted with an fatal error (%s).'=>'Alvorlig feil: %s ',
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'
	=>'Operasjonen ble avbrutt pga feil i datastrukturen. Det kan være tegn på inkonsistent Databankstruktur. Bør vurderes å ta sikkerhetskopi eller ta inn siste backup.',

### ../pages/login.inc   ###
'Login|tab in top navigation' =>'Logg inn',
'License|tab in top navigation'=>'Lisens',
'Welcome to streber|Page title'=>'Velkommen',
'Name|label in login form'    =>'Navn',
'Password|label in login form'=>'Passord',
'invalid login|message when login failed'=>'Feil ved pålogging',
'License|page title'          =>'Lisens',







### ../db/class_person.inc   ###
'only required if user can login (e.g. pixtur)'=>'Nødvendig felt om bruker kan logge inn.',
'Optional: Mobile phone (eg. +49-172-12345678)'=>'Mobil Telefon (f.eks: +0-171-123456)',
'Optional: Office Phone (eg. +49-30-12345678)'=>'Kontor Telefon (f.eks: +49-30-123456)',
'Optional: Office Fax (eg. +49-30-12345678)'=>'Kontor Faks (f.eks: +49-30-123456)',
'Optional: Official Street and Number (eg. Poststreet 28)'=>'Kontor gateadresse og nummer (f.eks. Postgaten 28)',
'Optional: Official Zip-Code and City (eg. 12345 Berlin)'=>'Kontor Postnummer og sted (f.eks. 5000 Bergen)',
'Optional: (eg. www.pixtur.de)'=>'Valgfritt (f.eks. www.pixtur.no)',
'Optional: (eg. thomas@pixtur.de)'=>'Valgfritt (f.eks. thomas@pixtur.no)',
'Optional: Color for graphical overviews (e.g. #FFFF00)'=>'Farge for grafiske fremstillinger (f.eks. #ff000)',
'Only required if user can login|tooltip'=>'Nødvendig felt dersom bruker kan logge inn.',

### ../pages/task.inc   ###
'Move tasks'                  =>'Flytte oppgaver',

### ../lists/list_tasks.inc   ###
'Subtasks'                    =>'Underoppgaver',

### ../pages/_handles.inc   ###
'Send Activation E-Mail'      =>'Sende aktiverings E-Post',
'Activate an account'         =>'Aktivere Konto',

### ../pages/home.inc   ###
'Personal Efforts'            =>'Egen innsats',

### ../pages/login.inc   ###
'I forgot my password.|label in login form'=>'HAr glemt Passordet mitt.',
'If you remember your name, please enter it and try again.'
	=>'Om du husker brukernavnet ditt kan du taste det inn og forsøke omigjen.',
'Supposed a user with this name existed a notification mail has been sent.'
	=>'Dersom denne brukeren finnes ble det sendt en e-post.',
'Welcome %s. Please adjust your profile and insert a good password to activate your account.'
	=>'Velkommen %s. Vennligst aktualiser profilen din og tast inn et bra passord.',
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter your name and use the <b>forgot password link</b> below.'
	=>'Feil: denne aktiveringskoden er ikke lenger gyldig. Eventuelt ble passordet endret i mellomtiden...',

### ../pages/person.inc   ###
'daily'                       =>'daglig',
'each 3 days'                 =>'hver 3 dager',
'each 7 days'                 =>'hver 7 dager',
'each 14 days'                =>'hver 14 dager',
'each 30 days'                =>'månedlig',
'Never'                       =>'aldri',
'Send notifications|form label'=>'E-post med nyheter',
'Send mail as html|form label'=>'E-post som HTML',
'Sending notifactions requires an email-address.'=>'Trenger i det minste en e-post adresse for å kunne sende E-post med nyheter',
'Read more about %s.'         =>'Les mer om %s',
'Insufficient rights'         =>'Utilstrekkelige rettigheter',
'Notification mail has been sent.'=>'E-post med nyheter ble sendt.',
'Sending notification e-mail failed.'=>'Feil under forsendelse av e-post.',

### ../pages/proj.inc   ###
'Wikipage|Label in summary'   =>'Wiki nettside',
'Projectpage|Label in summary'=>'Prosjekt nettside',

### ../pages/task.inc   ###
'Comments on task'            =>'Notater for oppgave',
'insufficient rights'         =>'utilstrekkelige rettigheter',
'Can not move task <b>%s</b> to own child.'=>'Kan ikke flytte oppgave til egen underoppgave.',
'Can not edit tasks %s'       =>'Kan ikke redigere oppgaven.',
'Edit tasks'                  =>'Redigere oppgaver',
'Select folder to move tasks into'=>'Velg en mappe å flytte til...',
'... or select nothing to move to project root'=>'... eller ikke noe for å flytte til prosjekt roten.',

### ../render/render_list.inc   ###
'changed today'               =>'endret idag',
'changed since yesterday'     =>'endret igår geändert',
'changed since <b>%d days</b>'=>'endret i løpet av <b>%s dager</b>',
'changed since <b>%d weeks</b>'=>'endret i løpet av <b>%s uker</b>',
'created by %s'               =>'Opprettet av %s',
'created by unknown'          =>'Opprettet av ukjente',


### ../std/constant_names.inc   ###
'template|status name'        =>'Mal',
'undefined|status_name'       =>'undefinert',
'upcoming|status_name'        =>'kommer snart',
'new|status_name'             =>'ny',
'open|status_name'            =>'åpen',
'onhold|status_name'          =>'på vent',
'done?|status_name'           =>'ferdig?',
'approved|status_name'        =>'godkjent',
'closed|status_name'          =>'lukket',
'undefined|pub_level_name'    =>'undefinert',
'private|pub_level_name'      =>'Privat',
'suggested|pub_level_name'    =>'Foreslått',
'internal|pub_level_name'     =>'Intern',
'open|pub_level_name'         =>'Offentlig',
'client|pub_level_name'       =>'Kunder',
'client_edit|pub_level_name'  =>'Redigere Kunder',
'assigned|pub_level_name'     =>'Tildelt',
'owned|pub_level_name'        =>'egne',
'priv|short for public level private'=>'priv',
'int|short for public level internal'=>'int',
'pub|short for public level client'=>'Ku',
'PUB|short for public level client edit'=>'K!',
'A|short for public level assigned'=>'Off',
'O|short for public level owned'=>'Egne',
'Create projects|a user right'=>'Opprette Prosjekter',
'Edit projects|a user right'  =>'Redigere Prosjekter',
'Delete projects|a user right'=>'Slette Prosjekter',
'Edit project teams|a user right'=>'Redigere Prosjekt Team',
'View anything|a user right'  =>'Se alt',
'Edit anything|a user right'  =>'Redigere alt',
'Create Persons|a user right' =>'Opprette Personer',
'Edit Presons|a user right'   =>'Redigere Personer',
'Delete Persons|a user right' =>'Slette Personer',
'View all Persons|a user right'=>'Se Alle Personer',
'Edit User Rights|a user right'=>'Endre bruker rettigheter',
'Edit own profile|a user right'=>'Redigere egen profil',
'Create Companies|a user right'=>'Opprette Firmaer',
'Edit Companies|a user right' =>'Redigere Firmaer',
'Delete Companies|a user right'=>'Slette Firmaer',
'undefined|priority'          =>'undefinert',
'urgend|priority'             =>'hastesak',
'high|priority'               =>'viktig',
'normal|priority'             =>'normal',
'lower|priority'              =>'underordnet',
'lowest|priority'             =>'uviktig',

### ../std/mail.inc   ###
'<br>- You have been assigned to projects:<br><br>'=>'<br>- Du er tildelt prosjektene:<br><br>',
'<br>- You have been assigned to tasks:<br><br>'=>'<br>- Du er tildelt opgavene:<br><br>',

'Adjust user-rights'          =>'Redigere rettigheter',




### ../db/class_company.inc   ###
'Tag line|form field for company'=>'Tag linje',
'Short|form field for company'=>'Kortform',
'Phone|form field for company'=>'Telefon',
'Fax|form field for company'  =>'Faks',
'Street'                      =>'Gateadresse & Nr.',
'Zipcode'                     =>'Postnr. og sted',
'Intranet'                    =>'Intranet',
'Comments|form label for company'=>'Notater',

### ../db/class_person.inc   ###
'Office E-Mail'               =>'Kontor E-post',
'Optional:  Private (eg. Poststreet 28)'=>'Valgfritt (f.eks. Postgaten 28)',
'Theme|Formlabel'             =>'Tema',

### ../pages/file.inc   ###
'Type'                        =>'Type',

### ../lists/list_files.inc   ###
'Size'                        =>'Størrelse',

### ../pages/_handles.inc   ###
'Edit file'                   =>'Redigere fil',

### ../lists/list_files.inc   ###
'New file'                    =>'Ny fil',
'No files uploaded'           =>'Ingen filer lastet opp',
'Download|Column header'      =>'LAste ned',

### ../lists/list_projectchanges.inc   ###
'restore'                     =>'Gjenopprette',

### ../lists/list_tasks.inc   ###
'Modified|Column header'      =>'Endret',
'Add comment'                 =>'Legge til notat',

### ../pages/proj.inc   ###
'Uploaded Files'              =>'Filer',

### ../pages/_handles.inc   ###
'View file'                   =>'Se på fil',
'Upload file'                 =>'Laste opp fil',
'Update file'                 =>'Oppdatere fil',

### ../pages/file.inc   ###
'Download'                    =>'Laste ned',

### ../pages/_handles.inc   ###
'Show file scaled'             =>'Vis fil skalert',
'restore Item'                =>'gjenopprette objekt',

### ../pages/comment.inc   ###
'Can not edit comment %s'     =>'Notat %s kan ikke bearbeides',
'Select one folder to move comments into'=>'Vennligst velg en mappe å flytte notater til',
'No folders in this project...'=>'Ingen mapper i dette Prosjektet',

### ../pages/task.inc   ###
'Move items'                  =>'Flytte objekter',

### ../pages/file.inc   ###
'File'                        =>'Fil',
'Edit this file'              =>'Redigere fil',
'Version #%s (current): %s'   =>'Versjon #%s (aktuell): %s',
'Filesize'                    =>'Fil størrelse',
'Uploaded'                    =>'Opplastet',
'Uploaded by'                 =>'Opplastet av',
'Version #%s : %s'            =>'Versjon %s : %s',
'Upload new version|block title'=>'LAste opp en nyere versjon',
'Edit File|page type'         =>'Redigere fil',
'Edit File|page title'        =>'Redigere fil',
'New File|page title'         =>'Ny fil',
'Could not get file'          =>'Kunne ikke hente filen.',
'Could not get project of file'=>'Kunne ikke hente prosjekt eller fil.',
'Please enter a proper filename'=>'Vennligst tast inn et gyldig navn.',
'Select some files to delete' =>'Vennligst velg de filene du vil slette.',
'Failed to delete %s files'=>'%s fil(er) kunne ikke slettes.',
'Moved %s files to trash'  =>'%s fil(er) ble sendt til søppelbøtten.',
'Select some file to display' =>'Velg noen filer å vise',

### ../pages/misc.inc   ###
'Select some items to restore'=>'Vennligst velg objekter å gjennopprette.',
'Item %s does not need to be restored'=>'objekt %s trenger ikke gjennopprettes.',
'Failed to restore %s items'=>'%s Objekter kunne ikke gjennopprettes.',
'Restored %s items'           =>'%s Objekt(er) gjennopprettet.',

### ../pages/person.inc   ###
'Fax (office)|label for person'=>'Faks kontor',
'Adress Personal|Label'       =>'Adresse privat',
'Adress Office|Label'         =>'Adresse kontor',
'-- reset to...--'            =>'-- tilbakestille --',
'Since nicknames are case sensitive using uppercase letters might confuse users at login.'
	=>'Da det skilles mellom store og små bokstaver i brukernavn kan noen brukere bli forvirret.',
'<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'
=>'<b>%s</b> er allerede tildelt Projekter og kan defor ikke slettes. Konto for innlogging kan derimot deaktiveres.',

### ../pages/proj.inc   ###
'Files'                       =>'Filer',

### ../pages/task.inc   ###
'Upload file|block title'     =>'Laste opp fil',

### ../pages/proj.inc   ###
'Add'                         =>'Legge til',

### ../pages/task.inc   ###
'Undelete'                    =>'Gjennopprette',

### ../render/render_form.inc   ###
'Submit'                      =>'OK',
'Cancel'                      =>'Avbryte',
'Apply'                       =>'Lagre',

### ../render/render_list_column_special.inc   ###
'S|Short status column header'=>'S',
'Date'                        =>'Dato',
'Yesterday'                   =>'Igår',

### ../std/constant_names.inc   ###
'Edit Persons|a user right'   =>'Redigere Personer',





### ../db/class_comment.inc   ###
'Details'                     =>'Detaljer',

### ../db/class_issue.inc   ###
'Production build'            =>'Build Versjon',

### ../lists/list_projectchanges.inc   ###
'Other team members changed nothing since last logout (%s)'
	=>'Ingen endringer siden siste innlogging (%s)',
'item %s has undefined type'=>'Posten %s er av ukjent type',

### ../lists/list_tasks.inc   ###
'Latest Comment'              =>'Siste notat',
'by'                          =>'av',
'for'                         =>'for',
'number of subtasks'          =>'Antall underoppgaver',

### ../pages/_handles.inc   ###
'Flush Notifications'         =>'Sende e-post nå',

### ../pages/company.inc   ###
'related Persons'             =>'relevante Personer',

### ../pages/file.inc   ###
'Could not access parent task.'=>'Kommer ikke til mappen',
'Could not edit task'         =>'Kan ikke endre oppgaven',
'Select some file to display' =>'Velg en fil å vise',

### ../pages/home.inc   ###
'Modified|column header'      =>'Endret',

### ../pages/person.inc   ###
'Birthdate|Label'             =>'Fødselsdag',
'Assigned tasks'              =>'Tildelte oppgaver',
'No open tasks assigned'      =>'Ingen åpne oppgaver tildelt',
'no efforts yet'              =>'Ingen innsatser ennå',
'A notification / activation  will be mailed to <b>%s</b when you log out.'
	=>'En melding blir sendt til %s så snart du logger av.',
'Since the user does not have the right to edit his own profile and therefore to adjust his password, sending an activation does not make sense.'=>'Die Person kann ihr Profil nicht bearbeiten (auch das Password nicht). Eine Aktivierungsmail zu senden, macht daher keine Sinn.',
'Sending an activation mail does not make sense, until the user is allowed to login. Please adjust his profile.'
	=>'Aktiveringsmail har ingen hensikt sålenge Personen ikke får logge inn. Vennligst se over Profil.',
'Activation mail has been sent.'=>'Aktiveringsmail ble sendt',
'Select some persons to notify'=>'Velg person(er) å informere',
'Failed to mail %s persons'=>'Kunne ikke sende Mail til %s.',
'Sent notification to %s person(s)'=>'Melding ble sendt til %s Person(er.',

### ../pages/proj.inc   ###
'Your tasks'                  =>'Dine oppgaver',
'No tasks assigned to you.'   =>'Ingen oppgaver tildelt deg.',
'All project tasks'           =>'Alle Projektoppgaver',

### ../pages/task.inc   ###
'Planned start|Label in Task summary'=>'Planlagt start',
'Planned end|Label in Task summary'=>'Planlagt slutt',
'Attached files'              =>'Opplastete filer',
'Send File'                   =>'Sende fil',
'Attach file to task|block title'=>'Heng fil på oppgaven',
'Feature|Task label that added by default'=>'Funksjon',
'for %s|e.g. new task for something'=>'for %s',

### ../render/render_list.inc   ###
'modified by %s'              =>'endret av %s',
'modified by unknown'         =>'endret av ukjent',

### ../render/render_misc.inc   ###
'new since last logout'       =>'endret siden siste utlogging',

### ../std/constant_names.inc   ###
'Team Member'                 =>'Team Medlem',
'Employment'                  =>'Ansettelse',
'Issue'                       =>'Feilrapport',
'Task assignment'             =>'Oppgavetildeling',
'Nitpicky|severity'           =>'Pedantisk',
'Feature|severity'            =>'Funksjon',
'Trivial|severity'            =>'Triviell',
'Text|severity'               =>'Tekst',
'Tweak|severity'              =>'Forbedring',
'Minor|severity'              =>'Uviktig',
'Major|severity'              =>'Viktig',
'Crash|severity'              =>'Crash',
'Block|severity'              =>'Blokkerer',
'Not available|reproducabilty'=>'Ikke tilgjengelig',
'Always|reproducabilty'       =>'Alltid',
'Sometimes|reproducabilty'    =>'Ofte',
'Have not tried|reproducabilty'=>'Ikke forsøkt',
'Unable to reproduce|reproducabilty'=>'ikke reproduserbar',



### ../lists/list_comments.inc   ###
'Date|column header'          =>'Dato',
'By|column header'            =>'Av',

### ../lists/list_efforts.inc   ###
'no efforts booked yet'       =>'Ingen innsats bestilt ennå',
'booked'                      =>'bestilt',
'estimated'                   =>'beregnet',
'Task|column header'          =>'Oppgave',
'Start|column header'         =>'Start',
'End|column header'           =>'Slutt',
'len|column header of length of effort'=>'Varighet',
'Daygraph|columnheader'       =>'Dagsgrafikk',

### ../lists/list_projectchanges.inc   ###
'new'                         =>'ny',
'Type|Column header'          =>'Type',


### ../render/render_list.inc   ###
'modified by unknown'         =>'Endret av ukjent',

### ../lists/list_persons.inc   ###
'last login'                  =>'siste innlogging',
'Profile|column header'       =>'Profil',
'Account settings for user (do not confuse with project rights)'
	=>'Rettigheter for Person (Ikke å forveksle med rettigheter for bestemte prosjekter).',
'Active Projects|column header'=>'Aktive Prosjekter',
'recent changes|column header'=>'Siste endringer',
'changes since YOUR last logout'=>'Siden din siste avlogging',

### ../lists/list_project_team.inc   ###
'last Login|column header'    =>'Siste Innlogging',

### ../lists/list_tasks.inc   ###
'%s hidden'                   =>'%s skjult',

### ../pages/task.inc   ###
'Item-ID %d'                  =>'Post-Nr. %s',



### ../render/render_list.inc   ###
'item #%s has undefined type' =>'post #%s har ukjent type',

### ../std/mail.inc   ###
'You have been assigned to projects:'=>'Du ble tildelt følgende Prosjekt(er):',
'You have been assigned to tasks:'=>'Du ble tildelt følgende nye oppgaver:',

'Description' => 'Beskrivelse',





### ../db/class_comment.inc   ###
'Title'                       =>'Tittel',

### ../db/class_effort.inc   ###
'Time Start'                  =>'Start tid',
'Time End'                    =>'Slutt tid',

### ../db/db.inc   ###
'Database exception'          =>'Database feil',

### ../pages/_handles.inc   ###
'Edit Description'            =>'Redigere beskrivelse',

### ../pages/comment.inc   ###
'Comment on task|page type'   =>'Notat for oppgave',


### ../pages/person.inc   ###
'Nickname has been converted to lowercase'=>'Brukernavn ble konvertert til små bokstaver',

### ../pages/proj.inc   ###
'Details|block title'         =>'Detaljer',

### ../pages/task.inc   ###
'Complete|Page function for task status complete'=>'Ferdig',
'Approved|Page function for task status approved'=>'Godkjent',
'attach new'         =>'ny fil Datei',
'(or select nothing to move to project root)'=>'(eller ikke velg noe for å flytte til prosjekt roten)',
'Select a task to edit description'=>'Velg en oppgave for å endre beskrivelsen',
'Edit description'            =>'Redigere beskrivelse',

### ../render/render_form.inc   ###
'Please use Wiki format'      =>'Wiki Formatering tillatt',

### ../render/render_wiki.inc   ###
'enlarge'                     =>'forstørre',
'Unknown File-Id:'            =>'Ukjent fil-Id',
'Unknown project-Id:'         =>'Ukjent Prosjekt-Id',
'No item matches this name'   =>'Ingen Objekt med dette navn',
'No task matches this name exactly'=>'Ingen oppgave har dette navnet',
'This task seems to be related'=>'Denne oppgaven ser ut til å være relatert',
'No item excactly matches this name.'=>'Ingen Objekt har akkurat dette navnet',
'List %s related tasks'       =>'Vis %s relevante oppgaver',

### ../std/class_auth.inc   ###
'Could not set cookie.'       =>'Kunne ikke sette Cookie.',

### ../std/constant_names.inc   ###
'Create & Edit Persons|a user right'=>'Opprette og Redigere Personer',



### ../_docs/changes.inc   ###
'to'                          =>'for',
'you'                         =>'deg',
'assign to'                   =>'tildelt',

### ../lists/list_changes.inc   ###
'to|very short for assigned tasks TO...'=>'for',
'in|very short for IN folder...'=>'i',
'read more...'                =>'les videre...',
'%s comments:'                =>'%s Notater',
'comment:'                    =>'Notat:',
'completed'                   =>'Ferdig?',
'approved'                    =>'Godkjent!',
'closed'                      =>'Lukket',
'reopened'                    =>'Gjenåpnet',
'is blocked'                  =>'BlockBlokkert',
'changed:'                    =>'endret:',
'commented'                   =>'Kommentert',
'reassigned'                  =>'tildelt',
'Who changed what when...'    =>'Hvem endret hva når...',
'what|column header in change list'=>'hva',
'Date / by'                   =>'Dato / Av',

### ../lists/list_files.inc   ###
'Name|Column header'          =>'Navn',

### ../pages/_handles.inc   ###
'Edit Project Description'    =>'Redigere Projektbeskrivelse',

### ../pages/effort.inc   ###
'Could not get person of effort'=>'kunne ikke hente person for oppgaven',

### ../pages/login.inc   ###
'I forgot my password'        =>'Husker ikke passord',

### ../pages/person.inc   ###
'A notification / activation  will be mailed to <b>%s</b> when you log out.'
=>'En aktiverings e-post blir sendt til <b>%s</b> så snart du logger ut.',

### ../pages/proj.inc   ###
'No tasks have been closed yet'=>'Ingen avsluttete oppgaver ennå',
'Select a project to edit description'=>'Vennligst velg et prosjekt å redigere.',

### ../pages/task.inc   ###
'Upload'                      =>'Laste opp',
'Created task %s with ID %s'=>'Ny oppgave %s ble opprettet med ID %s.',

### ../render/render_misc.inc   ###
'Completed'                   =>'Ferdig?',

### ../render/render_wiki.inc   ###
'No item matches this name. Create new task with this name?'=>'Objekt finnes ikke. Opprette nå?',
'This task seems to be related'=>'Oppgaven(e) kan se ut til å være relaterte.',
'No item matches this name.'  =>'Ingen Objekt med dette navn',

### ../std/constant_names.inc   ###
'blocked|status_name'         =>'Blokkert',

### ../std/mail.inc   ###
'Failure sending mail: %s'    =>'Feil under e-post sending.',
'Hello %s,|notification'      =>'Hallo %s!',
'with this automatically created e-mail we want to inform you that|notification'
	=>'Vil med denne meldingen informere om at',
'since %s'                    =>'siden %s',


### ../std/mail.inc   ###
'Streber Email Notification|notifcation mail from'=>'Systemizer prosjekt melding',
'Updates at %s|notication mail subject'=>'Oppdateringer på %s',
'following happened at %s |notification'=>'følgende hendte på %s:',
'Your account has been created.|notification'=>'Din konto er opprettet.',
'Please set password to activate it.|notification'=>'Skriv inn et passord for å aktivere den.',
'You have been assigned to projects:|notification'=>'Du ble tildelt følgende prosjekt(er):',
'Project Updates'             =>'Prosjekt oppdateringer',
'If you do not want to get further notifications or you forgot your password feel free to|notification'
	=>'Ønsker du ikke flere e-poster, eller har glemt passord',
'adjust your profile|notification'=>' kan du endre profilen din.',
'Thanks for your time|notication'=>'Takk skal du ha,',
'the management|notication'   =>'Hilsen Prosjekt admin',
'No news for <b>%s</b>'       =>'Ikke noe nytt for <b>%s</b>',



### ../db/class_milestone.inc.php   ###
'optional if tasks linked to this milestone'=>'Valgfritt dersom oppgaver er linket til denne milepælen',

### ../lists/list_milestones.inc.php   ###
'Planned for'                 =>'Planlagt for',

### ../pages/task.inc.php   ###
'For Milestone'               =>'for milepæl',

### ../db/class_task.inc.php   ###
'resolved_version'            =>'løst i versjon',
'is a milestone / version'    =>'er en milepæl / en versjon',
'milestones are shown in a different list'=>'milepæler blir vist i en separat Liste',

### ../pages/task.inc.php   ###
'Estimated time'              =>'Estimert tid',
'Estimated worst case'        =>'i verste fall',

### ../lists/list_tasks.inc.php   ###
'Milestone'                   =>'Milepæl',

### ../lists/list_changes.inc.php   ###
'moved'                       =>'flyttet',

### ../pages/proj.inc.php   ###
'Milestones'                  =>'Milepæler',

### ../pages/company.inc.php   ###
'or'                          =>'eller',

### ../lists/list_milestones.inc.php   ###
'Due Today'                   =>'Forfaller idag',
'%s days late'                =>'%s dager forsinket',
'%s days left'                =>'om %s dager',
'Tasks open|columnheader'     =>'Åpne oppgaver',
'Open|columnheader'           =>'Åpen',
'%s open'                     =>'%s åpne',
'Completed|columnheader'      =>'Ferdig',
'Completed tasks: %s'         =>'Ferdige: %s',

### ../lists/list_tasks.inc.php   ###
'Status|Columnheader'         =>'Status',
'Label|Columnheader'          =>'Etikett',
'Task has %s attachments'     =>'Oppgaven har %s bilag',
'Est/Compl'                   =>'Est/Ferdig',
'Estimated time / completed'  =>'Estimert tid / Ferdig',
'estimated %s hours'          =>'%s timer beregnet',
'estimated %s days'           =>'%s dager beregnet',
'estimated %s weeks'          =>'%s uker beregnet',
'%2.0f%% completed'           =>'%2.0f%% ferdig',

### ../pages/task.inc.php   ###
'New Milestone'               =>'Ny milepæl',

### ../pages/company.inc.php   ###
'edit'                        =>'redigere',

### ../pages/login.inc.php   ###
'Nickname|label in login form'=>'Brukernavn',

### ../pages/task.inc.php   ###
'new'                        =>'ny:',

### ../pages/proj.inc.php   ###
'Team member'                 =>'Team Medlem',
'Create task'                 =>'Opprette oppgave',

### ../pages/task.inc.php   ###
'Bug'                         =>'Feil',

### ../pages/proj.inc.php   ###
'all open'                    =>'åpne',
'all my open'                 =>'mine åpne',
'my open for next milestone'  =>'milepæl',
'not assigned'                =>'ikke tildelt',
'blocked'                     =>'blokkert',
'open bugs'                   =>'åpne feil',
'to be approved'              =>'for godkjenning',
'open tasks'                  =>'åpne oppgaver',
'my open tasks'               =>'mine oppgaver',
'next milestone'              =>'niste milepæl',
'Create new folder for tasks and files'=>'Opprette ny mappe for Oppgaver og filer',
'Filter-Preset:'              =>'Filter-Sett',
'No tasks'                    =>'Ingen oppgaver',
'new Milestone'               =>'ny milepæl',
'View open milestones'        =>'Vis åpne milepæler',
'View closed milestones'      =>'Vis lukkete milepæler',

### ../pages/task.inc.php   ###
'new task for this milestone' =>'ny oppgave for denne milepælen',
'Append details'              =>'Legg til detaljer',
'Please select only one item as parent'=>'Vennligst velg kun ett objekt som mål.',
'Insufficient rights for parent item.'=>'Utilstrekkelige rettigheter for målobjektet',
'could not find project'      =>'Kunne ikke finne Prosjekt',
'Edit %s|Page title'          =>'Redigere %s',
'-- undefined --'             =>'-- udefinert --',
'Resolved in'                 =>'Løst i',
'- select person -'           =>'- Velg Person -',
'30 min'                      =>'30 min',
'1 h'                         =>'1 t',
'2 h'                         =>'2 t',
'4 h'                         =>'4 t',
'1 Day'                       =>'1 dag',
'2 Days'                      =>'2 dager',
'3 Days'                      =>'3 dager',
'4 Days'                      =>'4 dager',
'1 Week'                      =>'1 uke',
'1,5 Weeks'                   =>'1,5 uker',
'2 Weeks'                     =>'2 uker',
'3 Weeks'                     =>'3 uker',
'Failed to retrieve parent task'=>'Kunne ikke hente over-oppgaven',
'Task called %s already exists'=>'Oppgave med navn %s finnes allerede.',
'Changed task %s with ID %s'=>'Oppgave %s (ID %s) endret.',
'insufficient rights to edit any of the selected items'=>'Utilstrekkelige rettigheter for redigering av noen av elementene',

### ../render/render_list.inc.php   ###
'for milestone %s'            =>'for Milepæl %s',
'do...'                       =>'-- Velg funksjon--',

### ../render/render_misc.inc.php   ###
'Tasks|Project option'        =>'Oppgaver',
'Completed|Project option'    =>'Ferdig',
'Milestones|Project option'   =>'Milepæler',
'Files|Project option'        =>'Filer',
'Efforts|Project option'      =>'innsatser',
'History|Project option'      =>'Historikk',

### ../render/render_page.inc.php   ###
'Help'                        =>'Hjelp',

### ../render/render_wiki.inc.php   ###
'identical'                  =>'identisk',

### ../std/class_auth.inc.php   ###
'Fresh login...'              =>'Ny innlogging',
'Cookie is no longer valid for this computer.'=>'Cookie ikke lenger gyldig på denne maskinen',
'Your IP-Address changed. Please relogin.'=>'Din IP-Adresse har endret seg. Vennligst logg inn på nytt.',
'Your account has been disabled. '=>'Din konto er sperret.',



### ../lists/list_companies.inc.php   ###
'Company|Column header'       =>'Organisasjon',

### ../lists/list_files.inc.php   ###
'Parent item'                 =>'Overordnet',
'ID'                          =>'ID',
'Move files'                  =>'Flytte filer',
'File|Column header'          =>'Fil',
'in|... folder'               =>'i',
'Attached to|Column header'   =>'bilag til',

### ../lists/list_milestones.inc.php   ###
'open'                        =>'åpen',

### ../lists/list_tasks.inc.php   ###
'Task name'                   =>'Oppgave',

### ../pages/_handles.inc.php   ###
'Mark tasks as Open'          =>'AufMerk oppgaver som åpne',
'Move files to folder'        =>'Flytt filer til mappe',

### ../pages/file.inc.php   ###
'Select some files to move'   =>'Velg filer som skal flyttes.',
'Can not edit file %s'        =>'Kan ikke redigere fil %s',
'Edit files'                  =>'Redigere filer',
'Select folder to move files into'=>'Velg mappe du vil flytte filene til',
'No folders available'        =>'Ingen mapper tilgjengelig',

### ../pages/person.inc.php   ###
'no company'                  =>'ingen organisasjon',
'Person with account (can login)|form label'=>'Person med Konto (kan logge inn)',

### ../pages/task.inc.php   ###
'edit'                       =>'redigere',
'Wiki'                        =>'Wiki',

### ../pages/proj.inc.php   ###
'Create a new folder for tasks and files'=>'Opprette ny mappe for oppgaver og filer',
'Found no persons to add. Go to `People` to create some.'=>'Fant ingen personer å legge til.',

### ../pages/task.inc.php   ###
'Add Details|page function'   =>'Legg til detaljer',
'Move|page function to move current task'=>'Flytte',
'status:'                     =>'status:',
'Reopen|Page function for task status reopened'=>'Gjenåpne',
'For Milestone|Label in Task summary'=>'For milepæl',
'Estimated|Label in Task summary'=>'Beregnet',
'Completed|Label in Task summary'=>'Ferdig',
'Created|Label in Task summary'=>'Opprettet',
'Modified|Label in Task summary'=>'Redigert',
'Open tasks for milestone'    =>'Åpne oppgaver for milepæl',
'No open tasks for this milestone'=>'Ingen åpne oppgaver for milepæl',
'New milestone'               =>'Ny milepæl',
'Select some task(s) to reopen'=>'Velg å gjenåpne oppgave(r)',
'Reopened %s tasks.'          =>'%s oppgaver gjenåpnet',

### ../render/render_form.inc.php   ###
'Wiki format'                 =>'Wiki-Formatering',


### ../std/mail.inc.php   ###
'Please set a password to activate it.|notification'=>'Vennligst sett et passord for å aktivere det.',


### ../db/db_item.inc.php   ###
'Unknown'                     =>'Ukjent',
'Item has been modified during your editing by %s (%s minutes ago). Your changes can not be submitted.'
	=>'Objektet ble endret av  %s mens du redigerte (for %s Minutter siden). Kunne derfor ikke lagres.',

### ../lists/list_changes.inc.php   ###
'renamed'                     =>'gitt nytt navn',
'edit wiki'                   =>'wiki endret',
'attached'                    =>'vedlegg',
'attached file'               =>'fil vedlegg',

### ../lists/list_files.inc.php   ###
'Click on the file ids for details.'=>'Klikk på fil id for detaljer',

### ../pages/_handles.inc.php   ###
'List Deleted Persons'        =>'Vis slettete Personer',


### ../pages/person.inc.php   ###
'Deleted People'              =>'Slettete Personer',
'notification:'               =>'Mail:',

### ../pages/task.inc.php   ###
'Parent task not found.'      =>'Overoppgave ikke funnet.',
'You do not have enough rights to edit this task'=>'Du har ikke nok rettigheter for å endre denne oppgaven.',

### ../render/render_misc.inc.php   ###
'Other Persons|page option'   =>'Andre Personer',
'Deleted|page option'         =>'Slettet',

### ../render/render_wiki.inc.php   ###
'from'                        =>'fra',

### ../std/common.inc.php   ###
'only one item expected.'     =>'Forventet kun ett element',

### ../std/constant_names.inc.php   ###
'Member|profile name'         =>'Medlem',
'Admin|profile name'          =>'Admin',
'Project manager|profile name'=>'Projektleder',
'Developer|profile name'      =>'Utvikler',
'Artist|profile name'         =>'Grafiker',
'Tester|profile name'         =>'Tester',
'Client|profile name'         =>'Kunde',
'Client trusted|profile name' =>'Kunde (betrodd)',
'Guest|profile name'          =>'Gjest',

'Warning'                     =>'Advarsel',



### ../pages/_handles.inc.php   ###
'view changes'                =>'Endringer',

### ../pages/person.inc.php   ###
'Passwords do not match'      =>'Passordene stemmer ikke overens',
'Could not insert object'     =>'Kunne ikke lagre objektet.',

### ../pages/proj.inc.php   ###
'Reanimated person as team-member'=>'Person ble igjen tatt med i teamet.',

### ../pages/projectperson.inc.php   ###
'Failed to remove %s members from team'=>'Sletting av %s medlemmer gikk feil.',
'Unassigned %s team member(s) from project'=>'%s medlemmer ble tatt vekk fra teamet.',

### ../pages/task.inc.php   ###
'View history of item'        =>'Historikk for posten',
'Create another task after submit'=>'Opprette ennå en oppgave etter lagring av denne',
'Could not update task'       =>'Kunne ikke endre oppgaven.',
'changes'                     =>'endringer',
'View task'                   =>'Vise oppgaver',
'item has not been edited history'=>'Posten er ikke redigert ennå',
'unknown'                     =>'ukjent',
' -- '                        =>' -- ',
'&lt;&lt; prev change'        =>'&lt;&lt; forrige',
'next &gt;&gt;'               =>'neste &gt;&gt;',
'summary'                     =>'Sammenfatning',
'Item did not exists at %s'   =>'Posten fantes ikke på %s',
'no changes between %s and %s'=>'Ingen endringer mellom %s og %s',
'ok'                          =>'Ok',


### ../std/class_pagehandler.inc.php   ###
'Operation aborted (%s)'      =>'Operasjon avbrutt (%s)',

'Edit multiple Tasks' =>'Endre flere oppgaver',
'Filter errors.log' =>'Filtrere errors.log',
'Delete errors.log' =>'Slette errors.log',

'Projects' =>'Prosjekter',
'Invalid checksum for hidden form elements' =>'Feil sjekksum for skjulte elementer',


### ../db/class_project.inc.php   ###
'only team members can create items'=>'Kun team medlemmer kan opprette poster',

### ../db/class_task.inc.php   ###
'resolved in version'         =>'løst i versjon',

### ../pages/task_view.inc.php   ###
'Resolve reason'              =>'løsnings årsak',

### ../db/class_task.inc.php   ###
'is a milestone'              =>'er en milepæl',
'released'                    =>'utgitt',
'release time'                =>'tid for utgivelse',

### ../lists/list_versions.inc.php   ###
'Released Milestone'          =>'Utgivelses milepæl',

### ../db/db.inc.php   ###
'Database exception. Please read %s next steps on database errors.%s'
		=>'Database feil. Vennligst les %s neste steg om db feil.',

### ../lists/list_changes.inc.php   ###
'Last of %s comments:'        =>'Siste av %s kommentarer:',
'Approve Task'                =>'Godkjenne oppgave',
'assigned'                    =>'Tildelt',
'attached file to'            =>'vedlagt fil til',

### ../lists/list_comments.inc.php   ###
'Add Comment'                 =>'Legg til kommentar',
'Shrink All Comments'         =>'Krymp alle kommentarer',
'Collapse All Comments'       =>'Kollapse alle kommentarer',
'Expand All Comments'         =>'Utvide alle kommentarer',
'Reply'                       =>'Svar',
'1 sub comment'               =>'1 under-kommentar',
'%s sub comments'             =>'%s under-kommentarer',

### ../lists/list_efforts.inc.php   ###
'Effort description'          =>'Innsatsbeskrivelse',
'%s effort(s) with %s hours'  =>'%s innsats(er) med %s timer',
'Effort name. More Details as tooltips'=>'Innsats navn. Flere detaljer som tooltips',

### ../lists/list_files.inc.php   ###
'Details/Version|Column header'=>'Detaljer/Versjon',

### ../lists/list_versions.inc.php   ###
'%s required'                 =>'%s nødvendig',
'Release Date'                =>'Utgivelsesdato',

### ../pages/_handles.inc.php   ###
'Versions'                    =>'Versjoner',
'Task Test'                   =>'Oppgave Test',
'View Task Efforts'           =>'Se på oppgave innsatser',
'New released Version'      =>'Ny utgitt milepæl',
'View effort'                 =>'Se på innsats',
'View multiple efforts'       =>'Se på flere innsatser',
'List Clients'                =>'Liste klienter',
'List Prospective Clients'    =>'Liste prospektive klienter',
'List Suppliers'              =>'Liste leverandører',
'List Partners'               =>'Liste partnere',
'Remove persons from company' =>'Slette personer fra organisasjonen',
'List Employees'              =>'Liste ansatte',

### ../pages/comment.inc.php   ###
'Publish to|form label'       =>'Publisere til',

### ../pages/company.inc.php   ###
'Clients'                     =>'Klienter',
'related companies of %s'     =>'organisasjoner relatert til %s',
'Prospective Clients'         =>'Prospektive klienter',
'Suppliers'                   =>'Leverandører',
'Partners'                    =>'Partnere',
'Remove person from company'  =>'Slette person fra organisasjon',

### ../pages/person.inc.php   ###
'Category|form label'         =>'Kategori',

### ../pages/company.inc.php   ###
'Failed to remove %s contact person(s)'=>'Klarte ikke å slette %s kontaktperson(er)',
'Removed %s contact person(s)'=>'Slettet %s kontaktperson(er)',

### ../pages/effort.inc.php   ###
'Select one or more efforts'  =>'Velg en eller flere innsatser',
'You do not have enough rights'=>'Du har ikke tilstrekkelige rettigheter',
'Effort of task|page type'    =>'Oppgave innsats',
'Edit this effort'            =>'Redigere denne innsatsen',
'Project|label'               =>'Prosjekt',
'Task|label'                  =>'Oppgave',
'No task related'             =>'Ingen oppgave relatert',
'Created by|label'            =>'Opprettet av',
'Created at|label'            =>'Opprettet den',
'Duration|label'              =>'Varighet',
'Time start|label'            =>'Start tid',
'Time end|label'              =>'Slutt tid',
'No description available'    =>'Beskrivelse ikke tilgjengelig',
'Multiple Efforts|page type'  =>'Flere innsatser',
'Multiple Efforts'            =>'Flere innsatser',
'Information'                 =>'Informasjon',
'Number of efforts|label'     =>'Antall innsatser',
'Sum of efforts|label'        =>'Sum innsatser',
'from|time label'             =>'fra',
'to|time label'               =>'til',
'Time|label'                  =>'Tid',

### ../pages/version.inc.php   ###
'Publish to'                  =>'Publiser til',

### ../pages/misc.inc.php   ###
'Error-Log'                   =>'Feil-logg',
'hide'                        =>'skjule',

### ../pages/person.inc.php   ###
'Employees|Pagetitle for person list'=>'Ansatte',
'Contact Persons|Pagetitle for person list'=>'Kontaktpersoner',
'Person details'              =>'Personopplysninger',
'The changed profile <b>does not affect existing project roles</b>! Those has to be adjusted inside the projects.'
	=>'Den endrete profilen <b> påvirker ikke eksisterende prosjekt roller</b>! Disse må justeres innenfor prosjektene.',
'Person %s created'           =>'Person %s opprettet',

### ../pages/proj.inc.php   ###
'not assigned to a closed project'=>'ikke tildelt et lukket prosjekt',
'no project templates'        =>'ingen prosjekt maler',
'all'                         =>'alle',
'my open'                     =>'mine åpne',
'for milestone'               =>'for milepæl',
'needs approval'              =>'trenger godkjenning',
'without milestone'           =>'uten milepæl',
'Released Versions'           =>'Utgitte versjoner',
'New released Version'      =>'Ny utgitt milepæl',
'Tasks resolved in upcomming version'=>'Oppgaver løst i komende versjon',

### ../pages/search.inc.php   ###
'in'                          =>'i',
'on'                          =>'den',
'cannot jump to this item type'=>'kan ikke hoppe til denne post typen',
'jumped to best of %s search results'=>'hoppet til beste av%s søkeresultater',
'Add an ! to your search request to jump to the best result.'=>'Legg en ! til i søkebegrepet for å hoppe til beste resultat. ',
'%s search results for `%s`'  =>'%s søkeresultater for `%s`',
'No search results for `%s`'  =>'Ingen søkeresultat for `%s`',

### ../pages/version.inc.php   ###
'New Version'                 =>'Ny versjon',

### ../pages/task_more.inc.php   ###
'Select some task(s) to edit' =>'Velg oppgave(r) å redigere',
'next released version' =>'neste utgitte versjon',
'Release as version|Form label, attribute of issue-reports'=>'Utgi som versjon',
'Reproducibility|Form label, attribute of issue-reports'=>'Gjenskapelsesmulighet',
'Marked %s tasks to be resolved in this version.'=>'Merket %s oppgaver som skal løses i denne versjonen',
'Failed to add comment'       =>'Klarte ikke å legge til kommentar',
'Failed to delete task %s'    =>'Klarte ikke å slette oppgave %s',
'Task Efforts'                =>'Oppgave innsats',
'date1 should be smaller than date2. Swapped'=>'dato1 burde være tidligere enn dato2. Skiftet om',
'prev change'                 =>'forrige endr.',
'next'                        =>'neste',
'For editing all tasks must be of same project.'=>'Alle oppgaver som ønskes endret må være fra samme prosjekt.',
'Edit multiple tasks|Page title'=>'Endre flere oppgaver',
'Edit %s tasks|Page title'    =>'Endre %s oppgaver',
'keep different'              =>'behold forskjellig',
'Prio'                        =>'Prio',
'none'                        =>'ingen',

### ../pages/task_view.inc.php   ###
'next released version'       =>'neste utgitte versjon',

### ../pages/task_more.inc.php   ###
'resolved in Version'         =>'løst i versjon',
'Resolve Reason'              =>'Løsningsbegrunnelse',
'%s tasks could not be written'=>'%s oppgaver kunne ikke skrives',
'Updated %s tasks tasks'      =>'Oppdaterte %s oppgaver',

### ../pages/task_view.inc.php   ###
'Released as|Label in Task summary'=>'Utgitt som',
'Publish to|Label in Task summary'=>'Publiser til',
'Severity|label in issue-reports'=>'Alvorlighetsgrad',
'Reproducibility|label in issue-reports'=>'Gjenskapelsesmuligh.',
'Sub tasks'                   =>'Underoppg.',
'1 Comment'                   =>'1 kommentar',
'%s Comments'                 =>'%s kommentarer',
'Comment / Update'            =>'Kommentar / Oppdatering',
'quick edit'                  =>'hurtigredigering',

### ../pages/version.inc.php   ###
'Edit Version|page type'      =>'Endre versjon',
'Edit Version|page title'     =>'Endre versjon',
'New Version|page title'      =>'Ny versjon',
'Could not get version'       =>'Kunne ikke hente versjon',
'Could not get project of version'=>'Kunne ikke hente prosjekt eller versjon',
'Select some versions to delete'=>'Velg noen versjoner å slette',
'Failed to delete %s versions'=>'Klarte ikke å slette %s versjoner',
'Moved %s versions to trash'=>'Flyttet %s versjoner til søppelbøtten',
'Version|page type'           =>'Versjon',
'Edit this version'           =>'Endre denne versjonen',

### ../render/render_fields.inc.php   ###
'<b>%s</b> is not a known format for date.'=>'<b>%s</b> er ikke et kjent format for datoer',

### ../render/render_list_column_special.inc.php   ###
'Status|Short status column header'=>'Status',
'Item is published to'        =>'Posten er publisert til',
'Publish to %s'               =>'Publisert til %s',
'Select / Deselect'           =>'Velg / Fjern valg',

### ../render/render_misc.inc.php   ###
'Clients|page option'         =>'Klienter',
'Prospective Clients|page option'=>'Prospektive klienter',
'Suppliers|page option'       =>'Leverandører',
'Partners|page option'        =>'Partnere',
'Companies|page option'       =>'Organisasjoner',
'Versions|Project option'     =>'Versjoner',
'Employees|page option'       =>'Ansatte',
'Contact Persons|page option' =>'Kontaktpersoner',
'All Companies|page option'   =>'Alle organisasjoner',
'%s hours'                    =>'%s timer',
'%s days'                     =>'%s dager',
'%s weeks'                    =>'%s uker',
'%s hours max'                =>'%s timer maks',
'%s days max'                 =>'%s dgr. maks',
'%s weeks max'                =>'%s uker maks',

### ../render/render_wiki.inc.php   ###
'Wiki-format: <b>%s</b> is not a valid link-type'=>'Wiki-format: <b>%s</b> er ikke en gyldig link-type',

### ../std/class_auth.inc.php   ###
'Unable to automatically detect client time zone'=>'Klarte ikke å automatisk detektere klientens tids-sone ',

### ../std/class_pagehandler.inc.php   ###
'Operation aborted with an fatal error which was cause by an programming error (%s).'=>'Operasjon avbrutt med fatal feil som følge av programmeringsfeil (%s).',

### ../std/constant_names.inc.php   ###
'urgent|priority'             =>'haster',
'done|resolve reason'         =>'utført',
'fixed|resolve reason'        =>'fikset',
'works_for_me|resolve reason' =>'virker_ok_for_meg',
'duplicate|resolve reason'    =>'duplikat',
'bogus|resolve reason'        =>'tøv',
'rejected|resolve reason'     =>'avslått',
'deferred|resolve reason'     =>'utsatt',
'Not defined|release type'    =>'Ikke definert',
'Not planned|release type'    =>'Ikke planlagt',
'Upcomming|release type'      =>'Kommende',
'Internal|release type'       =>'Intern',
'Public|release type'         =>'Offentlig',
'Without support|release type'=>'Uten støtte',
'No longer supported|release type'=>'Ikke lenger støttet',
'undefined|company category'  =>'udefinert',
'client|company category'     =>'klient',
'prospective client|company category'=>'prospektiv klient',
'supplier|company category'   =>'leverandør',
'partner|company category'    =>'partner',
'undefined|person category'   =>'udefinert',
'- employee -|person category'=>'-ansatt -',
'staff|person category'       =>'stab',
'freelancer|person category'  =>'freelancer',
'working student|person category'=>'arbeidende student',
'apprentice|person category'  =>'lærling',
'intern|person category'      =>'intern',
'ex-employee|person category' =>'ex-ansatt',
'- contact person -|person category'=>'- kontaktperson -',
'client|person category'      =>'klient',
'prospective client|person category'=>'prospektiv klient',
'supplier|person category'    =>'leverandør',
'partner|person category'     =>'partner',

);


?>