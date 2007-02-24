<?php

# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
* language-table for french translation (C) Yves Perrenoud
*/

global $g_lang_table;
$g_lang_table= array(

#--- top navigation tabs -------------------------------------------------------
'<span class=accesskey>H</span>ome'
                    =>'<span class=accesskey>H</span>ome',
'Go to your home. Alt-h / Option-h'
                    =>'Votre page de démarrage, Alt-h / Option-h',
'<span class=accesskey>P</span>rojects'
                    =>'<span class=accesskey>P</span>rojets',
'Your projects. Alt-P / Option-P' =>'Vos projets. Alt-P / Option-P',
'People'            =>'Contacts',
'Your related People'
                    =>'Vos relations',
'Companies'         =>'Companies',
'Your related Companies'
                    =>'Vos companies',
'Calendar'          =>'Calendrier',
'<span class=accesskey>S</span>earch:&nbsp;'
                    =>'<span class=accesskey>R</span>echerche:&nbsp;',
"Click Tab for complex search or enter something and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`"
                    =>'Clicker sur tabs pour une recherche étendue',

#--- header --------------------------------------------------------------
'Wiki+Help'         =>'Wiki+Hilfe',
'Documentation and Discussion about this page'
                    =>'Documentation et Discussion sur cette page',
'This page requires java-script to be enabled. Please adjust your browser-settings.'
                    =>'Cette page requière l´activation des script java. Ajuster les paramètres du browser.',
'you are'           =>'Actuellement connecté',

'How this page looks for clients'
                    =>'Aperçu pour client',
'Client view'       =>'Affichage Client',
'Logout'            =>'Déconnexion',

#--- common texts --------------------------------------------------------------
'Task'              =>'Tâche',
'Effort'            =>'Effort',
'Comment'           =>'Commentaire',
'Add Now'           =>'Ajouter',

#--- home -----------------------------------------------------------------------
'Today'             =>'Aujourd´hui',
'Discussions'       =>'Discussions',
'At Home'           =>'Démarrage',
'F, jS'            =>'F, jS',          # format date headline home
'Functions'         =>'Fonctions',
'View your efforts' =>'Voir votre effort',
'Edit your profile' =>'Modifier votre profil',
'Your projects'     =>'Vos projets',
'This is a tooltip' =>'?',
'Company'           =>'Companie',
'Project'           =>'Projet',
'Select lines to use functions at end of list'
                    =>'Sélectionner les lignes pour utiliser les fonctions',
'Priority'          =>'Priorité',
'Edit'              =>'Modifier',
'Log hours for a project' =>'Enregister heure pour un projet',
'Create new project'=>'Créer un nouveau projet',
'You have no open tasks'
                    =>'Vous n´avez pas de tâche ouverte',
'Open tasks'        =>'Tâches ouvertes',
'Task-Status'       =>'Etat des tâches',
'Folder'            =>'Dossier',
'Started'           =>'Créé le',
'Est.'              =>'Est.',
'Estimated time in hours'
                    =>'Temps estimé en heure',
'status->Completed' =>'Etat->terminé',
'status->Approved'  =>'Etat->approuvé',
'Delete'            =>'Effacer',
'Log hours for select tasks'
                    =>'Enregistrement heure pour la tâche',
'%s tasks with estimated %s hours of work'
                    =>'%s des tâches. %s heure de travail',


#--- pages/_handles.inc -------------
'Home'                        =>'Démarrage',
'Active Projects'             =>'Projets actifs',
'Closed Projects'             =>'Projet terminés',
'Project Templates'           =>'Projet modèle',
'View Project'                =>'Voir projet',
'Closed tasks'                =>'Tâche terminées',
'New Project'                 =>'Nouveau projet',
'Duplicate Project'           =>'Copier projet',
'Edit Project'                =>'Modifier projet',
'Delete Project'              =>'Effacer projet',
'Change Project Status'       =>'Changer l´état du projet',
'Add Team member'             =>'Ajouter un participant',
'Edit Team member'            =>'Modifier un participant',
'Remove from team'            =>'Enlever un participant',

'View Task'                   =>'Voir la tâche',
'Edit Task'                   =>'Modifier tâche',
'Delete Task(s)'              =>'Effacer tâche',
'Restore Task(s)'             =>'Restaurer tâche',
'Move tasks to folder'        =>'Déplacer les tâches dans le dossier',
'Mark tasks as Complete'      =>'Marquer la tâche comme complète',
'Mark tasks as Approved'      =>'Marquer la tâche comme aprouvée',
'New Task'                    =>'Nouvelle tâche',
'Toggle view collapsed'       =>'Toggle view collapsed',
'Log hours'                   =>'Enregistrement heure',
'Edit time effort'            =>'Modifier le temps d´effort',
'Create comment'              =>'Créer commentaire',
'Edit comment'                =>'Modifier commentaire',
'Delete comment'              =>'Effacer commentaire',
'Add issue/bug report'        =>'Ajouter problème / bug',
'List Companies'              =>'Listes des companies',
'View Company'                =>'Voir la companie',
'New Company'                 =>'Nouvelle companie',
'Edit Company'                =>'Modifier companie',
'Delete Company'              =>'Effacer companie',
'Link Persons'                =>'Personnes liées' ,
'List Persons'                =>'Listes des contacts',
'View Person'                 =>'Voir un contact',
'New Person'                  =>'Nouveau contact',
'Edit Person'                 =>'Modifier contact',
'Edit User Rights'            =>'Modifier les droits du contact',
'Delete Person'               =>'Supprimer contact',
'View Efforts of Person'      =>'Voir l´effort du contact',
'Login'                       =>'Connexion',
'License'                     =>'Licence',
'Error'                       =>'Erreur',





### ../db/class_company.inc   ###
'Optional'                    =>'Option',
'more than expected'          =>'plus que prévu',
'not available'               =>'non disponible',

### ../db/class_effort.inc   ###
'optional if tasks linked to this effort'=>'Optionnel si les tâches sont liées',

### ../db/class_person.inc   ###
'Full name'                   =>'Nom et prénom',
'Nickname'                    =>'Pseudonyme',

### ../lists/list_persons.inc   ###
'Tagline'                     =>'Etiquette',

### ../db/class_person.inc   ###
'Mobile Phone'                =>'Tél Mobile',
'Office Phone'                =>'Tél bureau',
'Office Fax'                  =>'Fax bureau',
'Office Street'               =>'Rue bureau',
'Office Zipcode'              =>'Code postal bureau',
'Office Page'                 =>'www bureau',
'Personal Phone'              =>'Tél privé',
'Personal Fax'                =>'Fax privé',
'Personal Street'             =>'Rue privé',
'Personal Zipcode'            =>'Code postal privé',
'Personal Page'               =>'www privé',
'Personal E-Mail'             =>'E-mail privé',
'Birthdate'                   =>'Date de naissance',

### ../db/class_project.inc   ###
'Color'                       =>'Couleur',

### ../lists/list_comments.inc   ###
'Comments'                    =>'Commentaire',

### ../db/class_person.inc   ###
'Password'                    =>'Mot de passe',

### ../lists/list_projects.inc   ###
'Name'                        =>'Nom',

### ../db/class_task.inc   ###
'Short'                       =>'Court',
'Planned Start'               =>'Planification début',
'Planned End'                 =>'Planification fin',
'Date start'                  =>'Date début',
'Date closed'                 =>'Date fin',
'Status'                      =>'Etat',
'Description'                 =>'Description',
'Completion'                  =>'Finalisation',
'Estimated'                   =>'Estimation',
'Date due'                    =>'Echéance',
'Date due end'                =>'Echéance finale',


### ../db/class_project.inc   ###
'Status summary'              =>'Etat',
'Project page'                =>'Site web du projet',
'Wiki page'                   =>'Wiki page',
'show tasks in home'          =>'Affiché les tâches au démarrage',
'validating invalid item'     =>'Validation invalide',

### ../pages/comment.inc   ###
'insuffient rights'           =>'Droits insuffisants',


### ../db/class_projectperson.inc   ###
'job'                         =>'job',
'role'                        =>'rôle',

### ../pages/task.inc   ###
'Label'                       =>'Etiquette',

### ../pages/task.inc   ###
'task without project?'       =>'Tâche sans projet ?',

### ../db/db_item.inc   ###
'<b>%s</b> isn`t a known format for date.'=>'<b>%s</b> Format incorrect de date',

### ../lists/list_tasks.inc   ###
'New'                         =>'Nouveau',
'Sum of all booked efforts (including subtasks)'=>'Somme de tous les efforts réservés (tches secondaires y compris)',

### ../lists/list_comments.inc   ###
'Move to Folder'              =>'Déplacer dans dossier',
'Shrink View'                 =>'Vue rétrécie',
'Expand View'                 =>'Vue étendue',
'Topic'                       =>'Thème',

### ../lists/list_companies.inc   ###
'related companies'           =>'Companie en relation',

### ../lists/list_efforts.inc   ###
'S'                           =>'S',

### ../lists/list_persons.inc   ###
'Name Short'                  =>'Nom court',
'Shortnames used in other lists'=>'Nom court utilisé dans d´autres listes',

### ../pages/proj.inc   ###
'Phone'                       =>'Téléphone',

### ../lists/list_companies.inc   ###
'Phone-Number'                =>'Téléphone',
'Proj'                        =>'Projet',
'Number of open Projects'     =>'Nombre de projet ouvert',
'people'                      =>'Contacts',
'People working for this person'=>'Contact de la companie',
'Edit company'                =>'Modifier la companie',
'Delete company'              =>'Supprimer la companie',
'Create new company'          =>'Créer nouvelle companie',

### ../lists/list_efforts.inc   ###
'person'                      =>'Contact',

### ../lists/list_projects.inc   ###
'Task name. More Details as tooltips'=>'Nom de tche.  Plus de détails comme aide',

### ../lists/list_efforts.inc   ###
'Edit effort'                 =>'Modifier l´effort',
'New effort'                  =>'nouveau effort',
'D, d.m.Y'                    =>'D, d.m.Y',

### ../lists/list_persons.inc   ###
'Mobil'                       =>'Mobile',

### ../pages/person.inc   ###
'Office'                      =>'Bureau',
'Private'                     =>'Privé',

### ../lists/list_persons.inc   ###
'Edit person'                 =>'Modifier contact',
'Delete person'               =>'Supprimer contact',
'Create new person'           =>'Créer nouveau contact',

### ../lists/list_project_team.inc   ###
'Your related persons'        =>'Vos contacts',
'Rights'                      =>'Droits',
'Persons rights in this project'=>'Droits des contacts pour ce projet',
'Add team member'             =>'Ajouter un participant',
'Remove person from team'     =>'Enlever un participant',
'Member'                      =>'Contact',
'Role'                        =>'Rôle',

### ../pages/proj.inc   ###
'Changes'                     =>'Changement',

### ../lists/list_tasks.inc   ###
'Created by'                  =>'Créé par',

### ../lists/list_projectchanges.inc   ###
'Item was originally created by'=>'Object créé originalement par...',
'modified'                    =>'modifé',
'C'                           =>'C',
'Created,Modified or Deleted' =>'Créé, modifié ou supprimé',
'Deleted'                     =>'Supprimé',
'Modified'                    =>'Modifié',
'Created'                     =>'Créé',
'by Person'                   =>'par contact',
'Person who did the last change'=>'Contact du dernier changement',
'T'                           =>'T',
'Item of item: [T]ask, [C]omment, [E]ffort, etc '=>'Type d objet: [T]âche, [C]ommentaire, [E]ffort, etc ',
'undefined item-type'=>'objet non défini',
'Del'                         =>'Supprimer',
'shows if item is deleted'    =>'voir si l´object est supprimé',
'deleted'                     =>'supprimé',

### ../lists/list_projects.inc   ###
'Status Summary'              =>'Etat',
'Short discription of the current status'=>'Courte description de l´état en cours',

### ../lists/list_tasks.inc   ###
'Tasks'                       =>'Tâches',
'Tasks|short column header'   =>'A',
'%s open tasks / %s h'        =>'%s tâches ouvertes / %s h',

### ../lists/list_projects.inc   ###
'Number of open Tasks'        =>'Nb des tâches ouvertes',
'Opened'                      =>'Créé le',
'Day the Project opened'      =>'Jour du début',

### ../pages/proj.inc   ###
'Closed'                      =>'Terminés',

### ../lists/list_projects.inc   ###
'Day the Project state changed to closed'=>'Date de l´état du projet terminé',
'Edit project'                =>'Modifier projet',
'Delete project'              =>'Supprimer projet',
'Open / Close'                =>'Ouvert / Terminé',
'... working in project'      =>'... projet en cours',

### ../lists/list_taskfolders.inc   ###
'Folders'                     =>'Dossier',
'Select all, range, no row'   =>'Sélectionné tous, une ligne, aucune ligne',
'Number of subtasks'          =>'Nb de sous-tâches',
'Create new folder under selected task'=>'Créer nouveau dossier sous la tâche séléctionnée',

### ../lists/list_tasks.inc   ###
'Move selected to folder'     =>'Déplacer séléction dans le dossier',
'Priority of task'            =>'Priorité de la tâche',
'Status->Completed'           =>'Etat->Terminé',
'Status->Approved'            =>'Etat->Approuvé',
'Name, Comments'              =>'Nom, Commentaires',
'has %s comments'             =>'a %s commentaires',

### ../pages/person.inc   ###
'Efforts'                     =>'Efforts',

### ../lists/list_tasks.inc   ###
'Effort in hours'             =>'Effort en heure',

### ../pages/comment.inc   ###
'New Comment'                 =>'Nouveau commentaire',
'Reply to '                   =>'Réponse  ',
'Edit Comment'                =>'Modifier Commentaire',
'On task %s'                  =>'Dans la tâche %s',
'On project %s'               =>'Dans le projet %s',
'Occasion'                    =>'Occasion',

### ../pages/task.inc   ###
'Publish to'                   =>'Partage',
'Edit this task'              =>'Modifier cette tâche',
'Append bug report'           =>'Ajouter un bug',
'Delete this task'            =>'Supprimer cette tâche',
'Restore this task'           =>'Restaurer cette tâche',

### ../pages/comment.inc   ###
'Select some comments to delete'=>'Sélectionner les commentaires  supprimer',
'Select some comments to move'=>'Sélectionner les commentaires  déplacer',

### ../pages/task.inc   ###
'Select excactly ONE folder to move tasks into'=>'Sélectionner UN dossier pour y déplacé la tâche',

### ../pages/comment.inc   ###
'is no longer a reply'        =>'n´est plus une réponse',

### ../pages/company.inc   ###
'related projects of %s'     =>'projets en relation avec %s',

### ../pages/proj.inc   ###
'admin view'                  =>'Vue admin',
'List'                        =>'Liste',

### ../pages/company.inc   ###
'no companies'                =>'Pas de companies',

### ../pages/proj.inc   ###
'Overview'                    =>'Vue d´ensemble',

### ../pages/company.inc   ###
'Edit this company'           =>'Modifier cette companie',
'edit'                        =>'Modifier',
'Create new person for this company'=>'Créer nouveau contact pour cette companie',

### ../pages/person.inc   ###
'Person'                      =>'Contact',

### ../pages/company.inc   ###
'Create new project for this company'=>'Créer nouveau projet pour cette companie',
'Add existing persons to this company'=>'Ajouter des contacts existants dans cette companie',
'Persons'                     =>'Contacts',

### ../pages/person.inc   ###
'Summary'                     =>'Sommaire',
'Adress'                      =>'Addresse',
'Fax'                         =>'Fax',

### ../pages/company.inc   ###
'Web'                         =>'Web',
'Intra'                       =>'Intra',
'Mail'                        =>'E-Mail',
' Hint: for already existing projects please edit those and adjust company-setting.'
                                =>' Conseil: pour les projets existant, modifier dans les paramètres de la companie',
'no projects yet'             =>'Pas encore de projet',
'link existing Person'        =>'Lien sur contacts existant',
'create new'                  =>'Créer nouveau',
'no persons related'          =>'Pas de contacts en relation',
'Create another company after submit'=>'Créer une autre companie après validation',
'Edit %s'                     =>'Modifier %s',
'Add persons employed or related'=>'Ajoutez les personnes employées ou en relation',
'No persons selected...'=>'Pas de contacts sélectionné',
'Person already related to company'=>'Contact déj en relation avec cette companie',
'Select some companies to delete'=>'Sélectionner les companies  supprimer',

### ../pages/effort.inc   ###
'New Effort'                  =>'Nouveau effort',
'only expected one task. Used the first one.'=>'Seulement prévu pour une tâche, utilisé la première',
'For task'                    =>'Pour la tâche',
'Could not get effort'        =>'N a pas pu obtenir l´effort',
'Could not get project of effort'=>'N a pas pu obtenir l´effort du projet',
'Select some efforts to delete'=>'Sélectionnez les efforts  supprimer',

### ../pages/error.inc   ###
'Unknown Page'                =>'Page inconnue',

### ../pages/home.inc   ###
'You are not assigned to a project.'=>'Pas de projet affecté',

### ../pages/login.inc   ###
'Welcome to streber'          =>'Bienvenue',
'please login'                =>'Enregistrez-vous',
'invalid login'               =>'Enregistrement invalide',

### ../pages/person.inc   ###
'Active People'               =>'Contacts actifs',

### ../pages/proj.inc   ###
'relating to %s'              =>'en relation avec %s',

### ../pages/person.inc   ###
'With Account'                =>'Avec compte',
'All Persons'                 =>'Tous les contacts',
'no related persons'          =>'Aucun',
'Edit this person'            =>'Modifier ce contact',
'Profile'                     =>'Profil',
'User Rights'                 =>'Droits du contact',
'Mobile'                      =>'Mobile',
'Website'                     =>'Site Web',
'Personal'                    =>'Privé',

### ../pages/proj.inc   ###
'E-Mail'                      =>'E-Mail',

### ../pages/person.inc   ###
'works for'                   =>'Travail pour',
'not related to a company'    =>'Pas en relation avec une companie',
'works in Projects'           =>'Travail sur les projets',
'no active projects'          =>'Pas de projet actif',
'not allowed to edit'         =>'Pas d autorisation de modification',
'Person can login'            =>'Login autorisé',
'Theme'                       =>'Style',
'Create another person after submit'=>'Créer un autre contact après validation',
'Could not get person'        =>'Recherche contact pas possible',
'Nickname has to be unique'=>'Pseudonyme doit être unique',
'passwords don´t match'       =>'Mot de passe différent',
'Login-accounts require a unique nickname'=>'Le compte de login requiert un pseudo unique',
'Could not insert object'=>'Insertion d´object pas possible',
'Select some persons to delete'=>'Sélectionner les contacts  supprimer',
'Adjust user-rights of %s'    =>'Ajuster les droits d´accès de %s',
'Please consider that activating login-accounts might trigger security-issues.'
                              =>'Please consider that activating login-accounts might trigger security-issues.',
'User rights changed'         =>'Les droits d´accès ont changé',

### ../pages/proj.inc   ###
'Active'                      =>'Actif',
'Templates'                   =>'Modèles',
'Your Active Projects'        =>'Vos projets actifs',
'<b>NOTE</b>: Some projects are hidden from your view. Please ask an administrator to adjust you rights to avoid double-creation of projects'
                                =>'<b>NOTE</b>: Quelques projets sont cachés de votre vue.  Veuillez demander  un administrateur de vous ajuster des droits pour éviter la double-création des projets',
'not assigned to a project'   =>'Pas de projet affecté',
'Your Closed Projects'        =>'Vos projets terminé',
'invalid project-id'          =>'ID projet invalide',
'Edit this project'           =>'Modifier ce projet',
'Add person as team-member to project'
                              =>'Ajouter un participant au projet',
'Create task with issue-report'=>'Créez une tâche avec un rapport de problème',
'Add Bugreport'               =>'Ajouter un rapport d´erreur',
'Book effort for this project'=>'Reservez un effort pour ce projet',
'Log Effort'                  =>'Enregistrement effort',
'Logged effort'               =>'Effort enregistré',
'Team members'                =>'Participants',
'All open tasks'              =>'Tâches ouvertes',
'Comments on project'         =>'Commentaire sur le projet',
'Project Efforts'             =>'Efforts du projet',
'Closed Tasks'                =>'Tâches terminées',
'changed project-items'       =>'Objects du projet changé',
'no changes yet'              =>'pas encore de changement',
'Project Issues'              =>'Problèmes du projet',
'Report Bug'                  =>'Signaler bug',
'Select some projects to delete'=>'Sélectionner les projets  supprimer',
'Failed to delete %s projects'=>'Erreur de suppression des projets %s',
'Moved %s projects to trash'=>'Projet %s déplacé dans la corbeille',
'Select some projects...'     =>'Sélectionnez des projets',
'Invalid project-id!'         =>'ID projet invalide',
'Y-m-d'                       =>'Y-m-d',
'Failed to change %s projects'=>'Changement du projet %s échoué',
'Closed %s projects'          =>'Projets %s terminés',
'Select new team members'     =>'Sélectionner nouveau participant',
'found no persons to add'     =>'Pas de contacts trouvé  ajouter',
'No persons selected...'      =>'Pas de contacts sélectionné',
'Could not access person by id'=>'Contact pas accessible par l´ID',
'Reanimated person as team-member'=>'Réactivez le contact comme participant',
'Person already in project'=>'Contact déj dans le projet',
'Failed to insert new project'=>'Insertion du nouveau projet a échouée',
'Failed to insert new projectproject'=>'Insertion du nouveau projet a échouée',
'Failed to insert new issue'  =>'Insertion du nouveau problème a échouée',
'Failed to update new task'   =>'Insertion de la nouvelle tâche a échouée',
'Failed to insert new comment'=>'Insertion du nouveau commentaire a échouée',

### ../pages/task.inc   ###
'Issue report'                =>'Rapport du problème',
'Plattform'                   =>'Plattform',
'OS'                          =>'OS',
'Version'                     =>'Version',
'Build'                       =>'Build',
'Steps to reproduce'          =>'Etapes  reproduire',
'Expected result'             =>'Résultat attendu',
'Suggested Solution'          =>'Solution suggérée',
'I guess you wanted to create a folder...'=>'Je suppose que vous avez voulu créer un dossier...',
'Assumed <b>%s</b> to be mean label <b>%s</b>'=>'Assumed <b>%s</b> to be mean label <b>%s</b>',
'No project selected?'        =>'Pas de projet sélectionné ?',
'New Folder'                  =>'Nouveau dossier',
'No task selected?'           =>'Pas de tâche sélectionnée ?',
'NOTICE: Ungrouped %s subtasks to <b>%s</b>'=>'NOTICE: dégroupé les sous tâches %s de <b>%s</b>',
'HINT: You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'
                              =>'Conseil: vous déplacez la tâche <b>%s</b> dans un dossier. Les dossiers sont montrés dans la liste dossier de tâches.',
'Select some tasks to move'   =>'Sélectionnez les tâches  déplacer',
'Task <b>%s</b> deleted'           =>'La tâche <b>%s</b> a été supprimée',
'Moved %s tasks to trash'=>'Les tâches %s ont été déplacées dans la corbeille',
'<br> ungrouped %s subtasks to above parents.'=>'<br>les tâches %s ont été dégroupé de leur parent.',
'Could not retrieve task'=>'La tâche n´a pas pu être retrouvée',
'Task <b>%s</b> doesn´t need to be restored'=>'La tâche %s n´a pas besoin d être restaurée',
'Task <b>%s</b> restored'          =>'La tâche <b>%s</b> a été restaurée',
'Failed to restore Task <b>%s</b>' =>'La restauration de la tâche <b>%s</b> a échouée.',
'Marked %s tasks as approved and hidden from project-view.'=>'les tâches %s ont été approuvée et cachée de la vue du projet',
'could not update task'       =>'La mise  jour de la tâche ne peut pas être effectuée',
'No task selected to add issue-report?'=>'Pas de tâches sélectionnées pour l´ajout du rapport de problème',
'Task already has an issue-report'=>'La tâche a déj un rapport de problème',
'Adding issue-report to task' =>'Ajouter un rapport de problème  la tâche',
'Could not get task'          =>'La tâche ne peut pas être prise',

### ../render/render_page.inc   ###
'Return to normal view'       =>'Retourner  la vue normale',
'Leave Client-View'           =>'Quitter la vue client',



### tooltips ###
'Required. Full name like (e.g. Thomas Mann)' =>'Nom complèt obligatoire',
'Required. (e.g. pixtur)' =>'champ obligatoire',
'Optional: Additional tagline (eg. multimedia concepts)' =>'Optionnel: Etiquette (ex multimedia solution)',
'Optional: Private Phone (eg. +49-30-12345678)' =>'Optionnel: Téléphone privé',
'Optional: Private Fax (eg. +49-30-12345678)' =>'Optionnel: Fax privé',
'Optional: Private (eg. Poststreet 28)' =>'Optionnel: Adresse',
'Optional: Private (eg. 12345 Berlin)' =>'Optionnel: o postale et ville',
'Optional: (eg. http://www.pixtur.de/login.php?name=someone)' =>'Optionnel: ex http://www.pixtur.de/login.php?name=someone',
'show as folder (may contain other tasks)' =>'Vue en dossier, peut contenir d´autres tâches',
'Project priority (the icons have tooltips, too)' =>'Priorité du projet',
'Duplicate project' =>'Copier un projet',
'Required. (e.g. pixtur ag)' =>'Obligatoire (ex VK Vision SA)',
'Optional: Short name shown in lists (eg. pixtur)' =>'Nom court (ex VK)',
'Optional: Phone (eg. +49-30-12345678)' =>'Téléphone (ex +41-21-9683128)',
'Optional: Fax (eg. +49-30-12345678)' =>'Fax (ex +41-21-9683128)',
'Optional: (eg. Poststreet 28)' =>'(ex Z.I.D, Centre Artevil)',
'Optional: (eg. 12345 Berlin)' =>'(ex 1844 Villeneuve)',
'Optional: (eg. http://www.pixtur.de)' =>'(ex www.vkvision.ch)',
'Optional: Private (eg. Poststreet 28)' =>'Privée (ex Z.I.D, Centre Artevil)',
'Optional: (eg. Poststreet 28)' =>'(ex Z.I.D, Centre Artevil)',

### in listen ###
'do...'                         =>'autres fonctions...',
"Status is %s"                  =>'Etat: %s',
"Priority is %s"                =>'Priorité: %s',


### ../pages/comment.inc   ###
'Failed to delete %s comments'=>'la supression du commentaire %s a échouée',
'Moved %s comments to trash'=>'Le commentaire %s est déplacé dans la corbeille',

### ../pages/company.inc   ###
'Failed to delete %s companies'=>'la supression de la companie %s a échouée',
'Moved %s companies to trash'=>'La companie %s est déplacé dans la corbeille',

### ../pages/effort.inc   ###
'Failed to delete %s efforts'=>'la supression de l´effort %s a échouée',
'Moved %s efforts to trash'=>'L effort %s est déplacé dans la corbeille',

### ../pages/person.inc   ###
'passwords don´t match'       =>'Le mot de pass n´est pas identique',
'Failed to delete %s persons'=>'la supression du contact %s a échouée',
'Moved %s persons to trash'=>'Le contact %s est déplacé dans la corbeille',

### ../pages/proj.inc   ###
'Issues'                      =>'Problèmes',
'History'                     =>'Historiques',



### ../db/db_item.inc   ###
'unnamed'                     =>'inconnu',

### ../lists/list_tasks.inc   ###
'New / Add'                   =>'Nouveau / Ajouter',

### ../pages/task.inc   ###
'Assigned to'                 =>'Participant',

### ../lists/list_tasks.inc   ###
'- no name -|in task lists'   =>'- inconnu -',

### ../pages/company.inc   ###
'Active projects'             =>'Projets actifs',
'Closed projects'             =>'Projets terminés',

### ../pages/home.inc   ###
'Open tasks assigned to you'  =>'Tâches ouvertes affectées',

### ../pages/person.inc   ###
'Language'                    =>'Langue',
'passwords don´t match'       =>'Mot de passe pas identique',
'Select some persons to edit' =>'Sélectionnez un contact  modifier',
'Could not get Person'        =>'La personne n´a pu être prise',

### ../pages/proj.inc   ###
'Reactivated %s projects'     =>'Réactivé le projet %s',
'Failed to insert new projectperson'=>'L´ajout d un contact au projet a échoué',

### ../pages/projectperson.inc   ###
'Edit Team Member'            =>'Modifier participants',
'role of %s in %s|edit team-member title'=>'Rôle de %s dans le projet %s',

### ../pages/task.inc   ###
'Assign to'                   =>'Participant',
'Also assign to'              =>'Autre participant',
'formerly assigned to %s'     =>'Ancien participant %s',
'task was already assigned to %s'=>'%s est déj participant',
'Task requires name'          =>'La tâche requiert un nom',
' ungrouped %s subtasks to above parents.'=>' la sous tâche %s a été dégroupée',
'Task <b>%s</b> doesn´t need to be restored'=>'La tâche <b>%s</b> n´a pas besoin d être restaurée',

### ../render/render_list_column_special.inc   ###
'Days until planned start'    =>'Jours restant jusqu´au début prévu',
'Due|concerning time'         =>'D',
'Number of open tasks is hilighted if shown home.'=>'Le nombre de tâche ouverte est mis en évidence dans la page de démarrage',
'Item is published to'           =>'Objet publié  ',
'Pub|table-header, public'    =>'Pub',
'Publish to %s'                =>'Partagé pour %s',



#<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

### ../db/class_project.inc   ###
'insuffient rights (not in project)'=>'Droits insuffisant (pas dans le projet)',

### ../lists/list_persons.inc   ###
'(adjusted)'                  =>'(ajusté)',

### ../lists/list_projectchanges.inc   ###
'(on comment)'                =>'(dans commentaire)',
'(on task)'                   =>'(dans tâches)',
'(on project)'                =>'(dans projet)',

### ../pages/_handles.inc   ###
'Create Template'             =>'Créer modèle',
'Project from Template'       =>'Projet depuis modèle',

### ../pages/home.inc   ###
'Open tasks (including unassigned)'=>'Tâches ouvertes (Inclues les non assignées)',

### ../pages/person.inc   ###
'(resetting rights)'          =>'(Initialisation droits)',
'passwords do not match'      =>'Mot de passe pas identique',
'Password is too weak (please add numbers, special chars or length)'=>'Mot de passe trop court',

### ../pages/proj.inc   ###
'Project Template'            =>'Modèle de projet',
'Inactive Project'            =>'Projet inactif',
'Project|Page Type'           =>'Projet',
'Template|as addon to project-templates'=>'Modèle',
'Project duplicated (including %s items)'=>'Projet copié (incluant %s )',

### ../pages/task.inc   ###
'No task(s) selected for deletion...'=>'Pas de tâches sélectionnées pour la supression',
'Task <b>%s</b> do not need to be restored'=>'Tâche <b>%s</b> n´a pas besoin d être restaurée',
'No task(s) selected for restoring...'=>'Pas de tâches sélectionnées pour la restauration',
'Select some task(s) to mark as completed'=>'Sélectionnez des tâches pour les marquer terminé',
'Marked %s tasks (%s subtasks) as completed.'=>'les tâches %s ont été marquées comme terminées',
'%s error(s) occured'         =>'L erreur %s c est produite',
'Select some task(s) to mark as approved'=>'Sélectionnez des tâches pour les marquer comme approuvées',
'Select some task(s)'         =>'Sélectionnez des tâches',

### ../render/render_list_column_special.inc   ###
'Due|column header, days until planned start'=>'Reste',
'planned for %s|a certain date'=>'Plannifié pour %s',
'Pub|column header for public level'=>'Pub',

### ../render/render_misc.inc   ###
'No element selected? (could not find id)|Message if a function started without items selected'=>'Pas d´élément sélectionné',

### ../std/class_pagehandler.inc   ###
'Operation aborted (%s)'=>'Opération abortée (%s)',
'Insuffient rights'    =>'Droits insuffisant',


##############

### ../lists/list_project_team.inc   ###
'Edit team member'            =>'Modifier les participants',

### ../pages/_handles.inc   ###
'Search'                      =>'Chercher',

### ../pages/effort.inc   ###
'Edit Effort'                 =>'Modifier effort',
'Date / Duration|Field label when booking time-effort as duration'=>'Date / Durée',
'Name required'               =>'Nom requit',
'Cannot start before end.'    =>'Ne peut pas débuter avant la fin',

### ../pages/proj.inc   ###
'create new project'          =>'Créer nouveau projet',
'no tasks closed yet'         =>'Pas encore de tâche terminée',
'Create another project after submit'=>'Créer un autre projet après validation',
'Failed to insert new project person. Data structure might have been corrupted'=>'Echec de l´insertion d´un contact au projet, base de donnée éventuellement corrompue',
'Failed to insert new project. Datastructure might have been corrupted'=>'Echec de l´insertion d´un projet, base de donnée éventuellement corrompue',
'Failed to insert new issue. DB structure might have been corrupted.'=>'Echec de l´insertion d´un problème, base de donnée éventuellement corrompue',
'Failed to update new task. DB structure might have been corrupted.'=>'Echec de l´insertion d´une tâche, base de donnée éventuellement corrompue',
'Failed to insert new comment. DB structure might have been corrupted.'=>'Echec de l´insertion d´un commentaire, base de donnée éventuellement corrompue',

### ../pages/projectperson.inc   ###
'Role in this project'        =>'Rôle dans le projet',
'start times and end times'   =>'Heure début et fin',
'duration'                    =>'Durée',
'Log Efforts as'              =>'Enregistrement effort comme',

### ../pages/search.inc   ###
'Jumped to the only result found.'=>'Allez vers le seul résultat trouvé',
'Search Results'              =>'Résultat de la recherche',
'Searching'                   =>'Cherche',
'Found %s companies'          =>'%s companies trouvées',
'Found %s projects'           =>'%s projets trouvées',
'Found %s persons'            =>'%s contacts trouvées',
'Found %s tasks'              =>'%s tâches trouvées',
'Found %s comments'           =>'%s commentaires trouvées',

### ../pages/task.inc   ###
'Summary|Block title'         =>'Sommaire',
'Description|Label in Task summary'=>'Description',
'Part of|Label in Task summary'=>'Partie de',
'Status|Label in Task summary'=>'Etat',
'Opened|Label in Task summary'=>'Ouverte',
'Closed|Label in Task summary'=>'Terminé',
'Created by|Label in Task summary'=>'Créé par',
'Last modified by|Label in Task summary'=>'Modifié par',
'Logged effort|Label in task-summary'=>'Effort enregistré',
'open sub tasks|Table headline'=>'Ouvrir sous tâche',
'All open tasks|Title in table'=>'Tâches ouvertes',
'Steps to reproduce|label in issue-reports'=>'Etapes   reproduire',
'Expected result|label in issue-reports'=>'Résultat attendu',
'Suggested Solution|label in issue-reports'=>'Solution suggérée',
'Bug|Task-Label that causes automatically addition of issue-report'=>'Bug',
'Edit Task|Page title'        =>'Modifier tâche',
'Assign to|Form label'        =>'Participant',
'Also assign to|Form label'   =>'Autre participant',
'Prio|Form label'             =>'Prio',
'undefined'                   =>'indéfini',
'Severity|Form label, attribute of issue-reports'=>'Gravité',
'reproducibility|Form label, attribute of issue-reports'=>'Reproductibilité',
'unassigned to %s|task-assignment comment'=>'Désassigné   %s',
'formerly assigned to %s|task-assigment comment'=>'Formellement assigné   %s',

### ../std/class_pagehandler.inc   ###
'Operation aborted with an fatal error (%s). Please help us by %s'=>'',
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up. Please help us by %s'=>'',
### ../lists/list_tasks.inc   ###
'Add new Task'                =>'Nouvelle tâche',

### ../pages/task.inc   ###
'Report new Bug'              =>'Signaler nouvelle erreur',

### ../pages/_handles.inc   ###
'New Bug'                     =>'Nouvelle erreur',
'View comment'                =>'Voir commentaire',
'System Information'          =>'Information Système',
'PhpInfo'                     =>'phpInfo',

### ../pages/task.inc   ###
'(deleted %s)|page title add on with date of deletion'=>'(effacer %s)',

### ../pages/comment.inc   ###
'Edit this comment'           =>'Modifier ce commentaire',
'New Comment|Default name of new comment'=>'Nouveau commentaire',
'Reply to |prefix for name of new comment on another comment'=>'Rèpondre   ',
'Edit Comment|Page title'     =>'Modifier commentaire',
'New Comment|Page title'      =>'Nouveau commentaire',
'On task %s|page title add on'=>' la tâche %s',

### ../pages/effort.inc   ###
'On project %s|page title add on'=>'au projet %s',

### ../pages/comment.inc   ###
'Occasion|form label'         =>'Gelegenheit',
'Publish to|form label'        =>'Public pour',
'is no longer a reply|message'=>'is no longer a reply',

### ../pages/effort.inc   ###
'Edit Effort|page type'       =>'Modifier effort',
'Edit Effort|page title'      =>'Modifier effort',
'New Effort|page title'       =>'Nouveau effort',

### ../pages/error.inc   ###
'Error|top navigation tab'    =>'Erreur',

### ../pages/home.inc   ###
'S|Column header for status'  =>'S',
'P|Column header for priority'=>'P',
'Priority|Tooltip for column header'=>'Prio',
'Company|column header'       =>'Companie',
'Project|column header'       =>'Projet',
'Edit|function in context menu'=>'Modifier',
'Log hours for a project|function in context menu'=>'Enregistrement effort au projet',
'Create new project|function in context menu'=>'Créer nouveau projet',
'P|column header'             =>'P',
'S|column header'             =>'S',
'Folder|column header'        =>'Dossier',
'Started|column header'       =>'Début',
'Est.|column header estimated time'=>'Est.',
'Edit|context menu function'  =>'Modifier',
'status->Completed|context menu function'=>'Status terminé',
'status->Approved|context menu function'=>'Status approuvé',
'Delete|context menu function'=>'Effacer',
'Log hours for select tasks|context menu function'=>'Enregistrement effort pour la tâche',

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
'Database Type'               =>'Database Type',
'PHP Version'                 =>'PHP-Version',
'extension directory'         =>'extension directory',
'loaded extensions'           =>'loaded extensions',
'include path'                =>'include path',
'register globals'            =>'register Globals',
'magic quotes gpc'            =>'magic quotes gpc',
'magic quotes runtime'        =>'magic quotes runtime',
'safe mode'                   =>'safe mode',

### ../pages/person.inc   ###
'relating to %s|page title add on listing pages relating to current user'=>'en relation a %s',
'With Account|page option'    =>'Avec compte',
'All Persons|page option'     =>'Tous les contacts',
'People/Project Overview'     =>'Contact/apercu projet',
'Persons|Pagetitle for person list'=>'Contacts',
'relating to %s|Page title Person list title add on'=>'en relation a %s',
'admin view|Page title add on if admin'=>'Vue admin',
'Edit this person|Tooltip for page function'=>'Modifier ce contact',
'Profile|Page function edit person'=>'Profile',
'Edit User Rights|Tooltip for page function'=>'Modifier droits du contact',
'User Rights|Page function for edit user rights'=>'Droits du contact',
'Adress|Label'                =>'Adresse',
'Mobile|Label mobilephone of person'=>'Mobile',
'Office|label for person'     =>'Bureau',
'Private|label for person'    =>'Privé',
'Fax|label for person'        =>'Fax',
'Website|label for person'    =>'Web',
'Personal|label for person'   =>'Privé',
'E-Mail|label for person office email'=>'E-Mail',
'E-Mail|label for person personal email'=>'E-Mail',
'works for|List title'        =>'Travail pour',
'works in Projects|list title for person projects'=>'Travail au projet',
'Efforts|Page title add on'   =>'Efforts',
'Overview|Page option'        =>'Apercu',
'Efforts|Page option'         =>'Efforts',
'Edit Person|Page type'       =>'Modifier contact',
'Password|form label'         =>'Mot de passe',
'confirm Password|form label' =>'Confirm mot de passe',
'Person can login|form label' =>'Contact peut s´enregister',
'(resetting rights)| additional form label when changing profile'=>'(Réinitialisation droits)',
'Profile|form label'          =>'Profile',
'Theme|form label'            =>'Thème',
'Language|form label'         =>'Langue',
'Edit Person|page type'       =>'Modifier contact',

### ../pages/proj.inc   ###
'List|page type'              =>'Liste',
'Summary|block title'         =>'Sommaire',
'Status|Label in summary'     =>'Status',
'Opened|Label in summary'     =>'Ouvert',
'Closed|Label in summary'     =>'Terminé',
'Created by|Label in summary' =>'Créer par',
'Last modified by|Label in summary'=>'Modifier par',
'hours'                       =>'Heures',
'Client|label'                =>'Client',
'Phone|label'                 =>'Telephone',
'E-Mail|label'                =>'E-Mail',
'new Effort'                  =>'nouveau effort',
'Company|form label'          =>'Companie',

### ../pages/projectperson.inc   ###
'Changed role of <b>%s</b> to <b>%s</b>'=>'Rôle de <b>%s</b> pour <b>%s</b>',

### ../pages/search.inc   ###
'Sorry. Could not find anything.'=>'Recherche infructueuse',
'Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters'=>'Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters',

### ../pages/task.inc   ###
'Task with subtasks|page type'=>'Tâche avec sous tâche',
'Task|page type'              =>'Tâche',
'new subtask for this folder' =>'Nouvelle sous tâche dans ce dossier',
'New task'                    =>'Nouvelle tâche',
'new bug for this folder'     =>'Nouvelle erreur dans ce dossier',
'Turned parent task into a folder. Note, that folders are only listed in tree'=>'Turned parent task into a folder. Note, that folders are only listed in tree',
'Failed, adding to parent-task'=>'Echec ajout a la tâche parente',
'Task <b>%s</b> does not need to be restored'=>'Tâche %s n´a pas besoin d´être restituée',

### ../std/class_pagehandler.inc   ###
'Operation aborted with an fatal error (%s).'=>'Opération annulée erreur fatale : %s ',
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'FATAL: operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.',

### ../pages/login.inc   ###
'Login|tab in top navigation' =>'Login',
'License|tab in top navigation'=>'License',
'Welcome to streber|Page title'=>'Bienvenue',
'Name|label in login form'    =>'Nom',
'Password|label in login form'=>'Mot de passe',
'invalid login|message when login failed'=>'Invalide login',
'License|page title'          =>'License',

### ../db/class_person.inc   ###
'only required if user can login (e.g. pixtur)'=>'Requis si le contact peut s´enregistrer',
'Optional: Mobile phone (eg. +49-172-12345678)'=>'Téléphone mobile',
'Optional: Office Phone (eg. +49-30-12345678)'=>'Téléphone bureau',
'Optional: Office Fax (eg. +49-30-12345678)'=>'Fax bureau',
'Optional: Official Street and Number (eg. Poststreet 28)'=>'Rue et No bureau',
'Optional: Official Zip-Code and City (eg. 12345 Berlin)'=>'Ville bureau',
'Optional: (eg. www.pixtur.de)'=>'Option (ex. www.vkvision.ch)',
'Optional: (eg. thomas@pixtur.de)'=>'Optional (ex. info@vkvision.ch)',
'Optional: Color for graphical overviews (e.g. #FFFF00)'=>'Couleur pour les graphiques (ex. #ff000)',
'Only required if user can login|tooltip'=>'Requis si le contact peut s´enregistrer',

### ../pages/task.inc   ###
'Move tasks'                  =>'Déplacer les tâches',

### ../lists/list_tasks.inc   ###
'Subtasks'                    =>'Sous tâches',

### ../pages/_handles.inc   ###
'Send Activation E-Mail'      =>'Envoyer email d´activation',
'Activate an account'         =>'Activer un compte',

### ../pages/home.inc   ###
'Personal Efforts'            =>'Effort personnel',

### ../pages/login.inc   ###
'I forgot my password.|label in login form'=>'Mot de passe oublié ?',
'If you remember your name, please enter it and try again.'=>'Si vous vous rappeler votre nom, éssayer une nouvelle fois',
'Supposed a user with this name existed a notification mail has been sent.'=>'Un contact avec ce nom existe, un email a été envoyé',
'Welcome %s. Please adjust your profile and insert a good password to activate your account.'=>'Bienvenue %s. Ajuster votre profil et insérez un mot de passe correct',
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter your name and use the <b>forgot password link</b> below.'=>'Désolé, ce code d´activation n´est plus valide, si vous avez un compte, entrez votre nom et utilisez le lien <b>mot de passe perdu</b>',

### ../pages/person.inc   ###
'daily'                       =>'journalier',
'each 3 days'                 =>'tous les 3 jours',
'each 7 days'                 =>'tous les 7 jours',
'each 14 days'                =>'tous les 14 jours',
'each 30 days'                =>'mensuel',
'Never'                       =>'jamais',
'Send notifications|form label'=>'Envoyer notification',
'Send mail as html|form label'=>'Envoyer email en html',
'Sending notifactions requires an email-address.'=>'Une adresse email est nécessaire pour l´envoi de notification',
'Read more about %s.'         =>'Plus de détails sur %s',
'Insufficient rights'         =>'Droits inssufisant',
'Notification mail has been sent.'=>'Un email de notification a été envoyé',
'Sending notification e-mail failed.'=>'Erreur dans l´envoi du email de notification',

### ../pages/proj.inc   ###
'Wikipage|Label in summary'   =>'Wikipage',
'Projectpage|Label in summary'=>'Site du projet',

### ../pages/task.inc   ###
'Comments on task'            =>'Commentaire de la tâche',
'insufficient rights'         =>'Droits inssufisant',
'Can not move task <b>%s</b> to own child.'=>'Déplacement de la tâche <b>%s</b> pas possible',
'Can not edit tasks %s'       =>'Modification de la tâche %s pas possible',
'Edit tasks'                  =>'Modifier tâche',
'Select folder to move tasks into'=>'Séléctionner le dossier cible',
'... or select nothing to move to project root'=>'...or ne rien séléctionner pour la déplacer dans la racine',

### ../render/render_list.inc   ###
'changed today'               =>'Changé aujourd´hui',
'changed since yesterday'     =>'Changé depuis hier',
'changed since <b>%d days</b>'=>'Changé depuis <b>%s jours</b>',
'changed since <b>%d weeks</b>'=>'Chang depuis <b>%s semaine</b>',
'created by %s'               =>'Créer par %s',
'created by unknown'          =>'Créer par inconnu',


### ../std/constant_names.inc   ###
'template|status name'        =>'modèle',
'undefined|status_name'       =>'indéfini',
'upcoming|status_name'        =>' venir',
'new|status_name'             =>'nouveau',
'open|status_name'            =>'ouvert',
'onhold|status_name'          =>'suspendu',
'done?|status_name'           =>'terminé?',
'approved|status_name'        =>'approuvé',
'closed|status_name'          =>'fermé',
'undefined|pub_level_name'    =>'indéfini',
'private|pub_level_name'      =>'Privé',
'suggested|pub_level_name'    =>'Suggéré',
'internal|pub_level_name'     =>'Interne',
'open|pub_level_name'         =>'Ouvert',
'client|pub_level_name'       =>'Client',
'client_edit|pub_level_name'  =>'Editable par client',
'assigned|pub_level_name'     =>'Assigné',
'owned|pub_level_name'        =>'Propriétaire',
'priv|short for public level private'=>'priv',
'int|short for public level internal'=>'int',
'pub|short for public level client'=>'pub',
'PUB|short for public level client edit'=>'PUB',
'A|short for public level assigned'=>'a',
'O|short for public level owned'=>'p',
'Create projects|a user right'=>'Créer projet',
'Edit projects|a user right'  =>'Modifier projet',
'Delete projects|a user right'=>'Effacer projet',
'Edit project teams|a user right'=>'Modifier membre du projet',
'View anything|a user right'  =>'Tout voir',
'Edit anything|a user right'  =>'Tout modifier',
'Create Persons|a user right' =>'Créer contact',
'Edit Presons|a user right'   =>'Modifier contact',
'Delete Persons|a user right' =>'Effacer contact',
'View all Persons|a user right'=>'Voir tous les contacts',
'Edit User Rights|a user right'=>'Modifier les droits des contacts',
'Edit own profile|a user right'=>'Modifier son profil',
'Create Companies|a user right'=>'Créer companie',
'Edit Companies|a user right' =>'Modifier companie',
'Delete Companies|a user right'=>'Effacer companie',
'undefined|priority'          =>'indéfini',
'urgent|priority'             =>'urgent',
'high|priority'               =>'haute',
'normal|priority'             =>'normale',
'lower|priority'              =>'basse',
'lowest|priority'             =>'très basse',

### ../std/mail.inc   ###
'<br>- You have been assigned to projects:<br><br>'=>'<br>- Vous êtes assigné aux projets:<br><br>',
'<br>- You have been assigned to tasks:<br><br>'=>'<br>- Vous êtes assignés aux tâches<br><br>',

'Adjust user-rights'          =>'Modifier les droits d´utilisation',




### ../db/class_company.inc   ###
'Tag line|form field for company'=>'Etiquette',
'Short|form field for company'=>'Court',
'Phone|form field for company'=>'Telephone',
'Fax|form field for company'  =>'Fax',
'Street'                      =>'Rue, No.',
'Zipcode'                     =>'NoPostal, Ville',
'Intranet'                    =>'Intranet',
'Comments|form label for company'=>'Commentaire',

### ../db/class_person.inc   ###
'Office E-Mail'               =>'E-Mail bureau',
'Optional:  Private (eg. Poststreet 28)'=>'Option: privé (ex. Poststrae 28)',
'Theme|Formlabel'             =>'Thème',

### ../pages/file.inc   ###
'Type'                        =>'Type',

### ../lists/list_files.inc   ###
'Size'                        =>'Taille',

### ../pages/_handles.inc   ###
'Edit file'                   =>'Edition fichier',

### ../lists/list_files.inc   ###
'New file'                    =>'Nouveau fichier',
'No files uploaded'           =>'Pas de fichier téléchargé',
'Download|Column header'      =>'Téléchargement',

### ../lists/list_projectchanges.inc   ###
'restore'                     =>'restauration',

### ../lists/list_tasks.inc   ###
'Modified|Column header'      =>'Modification',
'Add comment'                 =>'Ajouter commentaire',

### ../pages/proj.inc   ###
'Uploaded Files'              =>'Fichier téléchargé',

### ../pages/_handles.inc   ###
'View file'                   =>'Voir fichier',
'Upload file'                 =>'Téléchargé fichier',
'Update file'                 =>'Mise  jour fichier',

### ../pages/file.inc   ###
'Download'                    =>'Téléchargement',

### ../pages/_handles.inc   ###
'Show file scaled'             =>'Show file scaled',
'restore Item'                =>'Restaurer objet',

### ../pages/comment.inc   ###
'Can not edit comment %s'     =>'edition commentaire %s pas possible',
'Select one folder to move comments into'=>'Séléctionner le dosiier cible',
'No folders in this project...'=>'Pas de dossier dans ce projet',

### ../pages/task.inc   ###
'Move items'                  =>'Déplacement objets',

### ../pages/file.inc   ###
'File'                        =>'Fichier',
'Edit this file'              =>'Edition de ce fichier',
'Version #%s (current): %s'   =>'Version #%s (actuel): %s',
'Filesize'                    =>'Taille',
'Uploaded'                    =>'Téléchargé',
'Uploaded by'                 =>'Téléchargé par',
'Version #%s : %s'            =>'Version %s : %s',
'Upload new version|block title'=>'Téléchargé nouvelle version',
'Edit File|page type'         =>'Edition fichier',
'Edit File|page title'        =>'Edition fichier',
'New File|page title'         =>'Nouveau fichier',
'Could not get file'          =>'Ne peut pas prendre le fichier',
'Could not get project of file'=>'Ne peut pas prendre le projet du fichier',
'Please enter a proper filename'=>'Donnez un nom de fichier',
'Select some files to delete' =>'Séléctionner les fichiers  effacer',
'Failed to delete %s files'=>'Echec de l´effacement du fichier %s',
'Moved %s files to trash'  =>'Les fichiers %s sont mis  la corbeille',
'Select some file to display' =>'Séléctionner les fichiers  visualiser',

### ../pages/misc.inc   ###
'Select some items to restore'=>'Séléctionnez les objets  restaurer',
'Item %s does not need to be restored'=>'l´objet %s n´a pas besoin d´être restauré',
'Failed to restore %s items'=>'Echec de la restauration des objets %s',
'Restored %s items'           =>'Objets %s restauré',

### ../pages/person.inc   ###
'Fax (office)|label for person'=>'Fax bureau',
'Adress Personal|Label'       =>'Adresse privée',
'Adress Office|Label'         =>'Adresse bureau',
'-- reset to...--'            =>'-- reset to... --',
'Since nicknames are case sensitive using uppercase letters might confuse users at login.'=>'Utilisez les minuscules pour plus de clarté',
'<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'=>'<b>%s</b> est assigné  un projet et ne peut être effacé, mais le droit d´enregistrement peut être désactivé',

### ../pages/proj.inc   ###
'Files'                       =>'Fichiers',

### ../pages/task.inc   ###
'Upload file|block title'     =>'Téléchargement de fichier',

### ../pages/proj.inc   ###
'Add'                         =>'Ajouter',

### ../pages/task.inc   ###
'delete'                      =>'Effacer',
'undelete'                    =>'Restaurer',

### ../render/render_form.inc   ###
'Submit'                      =>'OK',
'Cancel'                      =>'Annuler',
'Apply'                       =>'Appliquer',

### ../render/render_list_column_special.inc   ###
'S|Short status column header'=>'E',
'Date'                        =>'Date',
'Yesterday'                   =>'Hier',

### ../std/constant_names.inc   ###
'Edit Persons|a user right'   =>'Modifier contact',
### ../db/class_comment.inc   ###
'Details'                     =>'Détails',

### ../db/class_issue.inc   ###
'Production build'            =>'Build Version',

### ../lists/list_projectchanges.inc   ###
'Other team members changed nothing since last logout (%s)'=>'Pas de changement depuis la dernière session (%s)',
'item %s has undefined type'=>'l´objet %s n´a pas de type défini',

### ../lists/list_tasks.inc   ###
'Latest Comment'              =>'Dernier commentaire',
'by'                          =>'de',
'for'                         =>'pour',
'number of subtasks'          =>'Nombre de sous tâches',

### ../pages/_handles.inc   ###
'Flush Notifications'         =>'Envoi email de notifications',

### ../pages/company.inc   ###
'related Persons'             =>'Contacts en relation',

### ../pages/file.inc   ###
'Could not access parent task.'=>'La tâche parente n´est pas accessible',
'Could not edit task'         =>'La tâche ne peut pas être modifiée',
'Select some file to display' =>'Séléctionner les fichiers à visualiser',

### ../pages/home.inc   ###
'Modified|column header'      =>'Modifié',

### ../pages/person.inc   ###
'Birthdate|Label'             =>'Date de naissance',
'Assigned tasks'              =>'Tâches assignées',
'No open tasks assigned'      =>'Pas de tâches assignées ouvertes',
'no efforts yet'              =>'Pas encore d´effort',
'A notification / activation  will be mailed to <b>%s</b when you log out.'=>'Un email sera envoyé  %s lors de la déconnexion',
'Since the user does not have the right to edit his own profile and therefore to adjust his password, sending an activation does not make sense.'=>'Tant que le contact n´a pas le droit de modifier son profil, il n y a pas de sens de lui envoy une activation',
'Sending an activation mail does not make sense, until the user is allowed to login. Please adjust his profile.'=>'Envoyer une activation n´a pas de sens tant que le contact ne peut pas se connecter',
'Activation mail has been sent.'=>'Le email d´activation  été envoyé',
'Select some persons to notify'=>'Sélectionner les contacts  notifiés',
'Failed to mail %s persons'=>'Echec de l´envoi de mail aux contacts %s',
'Sent notification to %s person(s)'=>'Envoi de la notification  % contacts',

### ../pages/proj.inc   ###
'Your tasks'                  =>'Vos tâches',
'No tasks assigned to you.'   =>'Pas de tâches assignées',
'All project tasks'           =>'Toutes les tâches du projet',

### ../pages/task.inc   ###
'Planned start|Label in Task summary'=>'Planification début',
'Planned end|Label in Task summary'=>'Planification fin',
'Attâched files'              =>'Fichiers attachés',
'Send File'                   =>'Fichier envoyés',
'Attach file to task|block title'=>'Fichier attaché la tâche',
'Feature|Task label that added by default'=>'Dispositif',
'for %s|e.g. new task for something'=>'pour %s',

### ../render/render_list.inc   ###
'modified by %s'              =>'modifié par %s',
'modified by unknown'         =>'modifié par inconnu',

### ../render/render_misc.inc   ###
'new since last logout'       =>'Nouveau depuis la dernière session',

### ../std/constant_names.inc   ###
'Team Member'                 =>'Team',
'Employment'                  =>'Emploi',
'Issue'                       =>'Issue',
'Task assignment'             =>'Assignement de tâche',
'Nitpicky|severity'           =>'Nitpicky',
'Feature|severity'            =>'Dispositif',
'Trivial|severity'            =>'Insignifiant',
'Text|severity'               =>'Texte',
'Tweak|severity'              =>'Amlioration',
'Minor|severity'              =>'Mineur',
'Major|severity'              =>'Majeur',
'Crash|severity'              =>'Crash',
'Block|severity'              =>'Bloquant',
'Not available|reproducabilty'=>'Non disponible',
'Always|reproducabilty'       =>'Toujours',
'Sometimes|reproducabilty'    =>'Parfois',
'Have not tried|reproducabilty'=>'Pas essayé',
'Unable to reproduce|reproducabilty'=>'Pas reproductible',



### ../lists/list_comments.inc   ###
'Date|column header'          =>'Date',
'By|column header'            =>'par',

### ../lists/list_efforts.inc   ###
'no efforts booked yet'       =>'Pas d´effort réservé',
'booked'                      =>'réservé',
'estimated'                   =>'estimé',
'Task|column header'          =>'Tâche',
'Start|column header'         =>'Début',
'End|column header'           =>'Fin',
'len|column header of length of effort'=>'Dure',
'Daygraph|columnheader'       =>'Graphe journalier',

### ../lists/list_projectchanges.inc   ###
'new'                         =>'nouveau',
'Type|Column header'          =>'Type',


### ../render/render_list.inc   ###
'modified by unknown'         =>'Modifié par inconnu',

### ../lists/list_persons.inc   ###
'last login'                  =>'dernière session',
'Profile|column header'       =>'Profile',
'Account settings for user (do not confuse with project rights)'=>'Configuration de comptes utilisateur',
'Active Projects|column header'=>'Projets actifs',
'recent changes|column header'=>'Dernières modifications',
'changes since YOUR last logout'=>'Changement depuis la dernière session',

### ../lists/list_project_team.inc   ###
'last Login|column header'    =>'Dernière session',

### ../lists/list_tasks.inc   ###
'%s hidden'                   =>'%s caché',

### ../pages/task.inc   ###
'Item-ID %d'                  =>'Objet No %s',



### ../render/render_list.inc   ###
'item #%s has undefined type' =>'objet #%s a un type inconnu',

### ../std/mail.inc   ###
'<br><br>You have been assigned to projects:<br><br>'=>'<br><br>Vous avez été assigné aux projets :<br><br>',
'<br>You have been assigned to tasks:<br><br>'=>'<br>Vous avez été assigné aux tâches :<br>',


### ../db/class_effort.inc.php   ###
'Time Start'                  =>'Heure début',
'Time End'                    =>'Heure fin',

### ../db/class_project.inc.php   ###
'only team members can create items'=>'seul les membres peuvent créer un object',

### ../pages/task_view.inc.php   ###
'For Milestone'               =>'pour l´obectif',

### ../db/class_task.inc.php   ###
'resolved in version'         =>'résolu dans la version',

### ../pages/task_view.inc.php   ###
'Resolve reason'              =>'Raison de la résolution',

### ../db/class_task.inc.php   ###
'is a milestone'              =>'est un objectif',
'milestones are shown in a different list'=>'Ojectifs affichées dans une autre liste',
'released'                    =>'Révision',
'release time'                =>'Temps de révision',

### ../pages/task_view.inc.php   ###
'Estimated time'              =>'Temps estimé',
'Estimated worst case'        =>'Estimation dans le pire des cas',

### ../lists/list_versions.inc.php   ###
'Released Milestone'          =>'Objectif révisé',

### ../pages/proj.inc.php   ###
'Milestone'                   =>'Objectifs',

### ../db/db.inc.php   ###
'Database exception. Please read %s next steps on database errors.%s'=>'Exception base de donnée. Lisez les %s cas de la liste des erreurs.%s',

### ../db/db_item.inc.php   ###
'Unknown'                     =>'Inconnu',
'Item has been modified during your editing by %s (%s minutes ago). Your changes can not be submitted.'=>'L´object à été modifié pendant votre édition. Vos changements ne sont pas pris en compte',

### ../lists/list_changes.inc.php   ###
'to|very short for assigned tasks TO...'=>'à',

### ../lists/list_tasks.inc.php   ###
'in|very short for IN folder...'=>'dans',

### ../lists/list_changes.inc.php   ###
'Last of %s comments:'        =>'Dernier des %s commentaires:',
'comment:'                    =>'commentaire:',
'completed'                   =>'achevé',
'Approve Task'                =>'approuver les tâches',
'approved'                    =>'approuvé',

### ../pages/proj.inc.php   ###
'closed'                      =>'terminé',

### ../lists/list_changes.inc.php   ###
'reopened'                    =>'réouvert',
'is blocked'                  =>'bloqué',
'moved'                       =>'déplacé',
'renamed'                     =>'renommé',
'edit wiki'                   =>'editer wiki',
'changed:'                    =>'changé',
'commented'                   =>'commenté',
'assigned'                    =>'assigné',
'attached'                    =>'attaché',
'attached file to'            =>'fichier attaché à',

### ../pages/search.inc.php   ###
'Who changed what when...'    =>'Qui a changé quoi quand...',

### ../lists/list_changes.inc.php   ###
'what|column header in change list'=>'Quoi',
'Date / by'                   =>'Date / par',

### ../lists/list_comments.inc.php   ###
'Add Comment'                 =>'Ajouter commentaire',
'Shrink All Comments'         =>'Rétrécir tous les commentaires',
'Collapse All Comments'       =>'Réduire',
'Expand All Comments'         =>'Etendre',
'Reply'                       =>'Réponse',
'1 sub comment'               =>'1 sous commentaire',
'%s sub comments'             =>'%s sous commentaire',

### ../lists/list_companies.inc.php   ###
'Company|Column header'       =>'Companie',

### ../lists/list_efforts.inc.php   ###
'Effort description'          =>'Description de làeffort',
'%s effort(s) with %s hours'  =>'%s effort(s) avec %s heures',
'Effort name. More Details as tooltips'=>'Nom de làeffort. Plus de détails comme info',

### ../lists/list_files.inc.php   ###
'Parent item'                 =>'Object parent',
'ID'                          =>'ID',
'Click on the file ids for details.'=>'clicker sur l´ID du fichier pour les détails',
'Move files'                  =>'Fichiers déplacé',
'File|Column header'          =>'Fichier',
'in|... folder'               =>'dans',
'attached to|Column header'   =>'Attaché à',
'Details/Version|Column header'=>'Détails/Version',

### ../pages/proj.inc.php   ###
'Milestones'                  =>'Objectifs',

### ../pages/company.inc.php   ###
'or'                          =>'ou',

### ../lists/list_milestones.inc.php   ###
'Planned for'                 =>'Planifié pour',
'Due Today'                   =>'Echu aujourd´hui',
'%s days late'                =>'%s jours en retard',
'%s days left'                =>'%s jours restant',

### ../lists/list_versions.inc.php   ###
'%s required'                 =>'%s requis',

### ../lists/list_milestones.inc.php   ###
'Tasks open|columnheader'     =>'Tâches ouvertes',

### ../pages/proj.inc.php   ###
'open'                        =>'ouvert',

### ../lists/list_tasks.inc.php   ###
'Status|Columnheader'         =>'Etat',
'Label|Columnheader'          =>'Label',
'Task name'                   =>'Nom de la tâche',
'Task has %s attachments'     =>'La tâche a %s pièces jointes',
'Est/Compl'                   =>'Est/Ach',
'Estimated time / completed'  =>'Estimé/achevé',

### ../lists/list_versions.inc.php   ###
'Release Date'                =>'Date de la révision',

### ../pages/_handles.inc.php   ###
'Versions'                    =>'Versions',
'Edit Project Description'    =>'Modifer la description du projet',
'Task Test'                   =>'Test de la tâche',
'Edit multiple Tasks'         =>'Modifier plusieurs tâche',
'view changes'                =>'Voir les changements',
'View Task Efforts'           =>'Voir les efforts des tâches',
'Mark tasks as Open'          =>'Marquer la tâche comme ouverte',

### ../pages/task_more.inc.php   ###
'New Milestone'               =>'Nouvelle objectif',

### ../pages/_handles.inc.php   ###
'New Released Milestone'      =>'Nouvelle objectif révisé',
'Edit Description'            =>'Modifier la description',
'View effort'                 =>'Voir effort',
'View multiple efforts'       =>'Voir plusieurs efforts',
'Move files to folder'        =>'Déplacer les fichiers dans le dossier',
'List Clients'                =>'Liste des clients',
'List Prospective Clients'    =>'Liste des clients potentiel',
'List Suppliers'              =>'Liste des fournisseurs',
'List Partners'               =>'Liste des partenaires',
'Remove persons from company' =>'Enlever des personnes des companies',
'List Employees'              =>'Liste des employés',
'List Deleted Persons'        =>'Liste des personnes supprimées',
'Filter errors.log'           =>'Filtrer errors.log',
'Delete errors.log'           =>'Supprimer errors.log',

### ../pages/comment.inc.php   ###
'Comment on task|page type'   =>'Commentaire sur la tâche',

### ../pages/company.inc.php   ###
'Clients'                     =>'Clients',
'related companies of %s'     =>'companies en relation avec %s',
'Prospective Clients'         =>'Clients potentiel',
'Suppliers'                   =>'Fournisseurs',
'Partners'                    =>'Partenaires',

### ../pages/task_view.inc.php   ###
'edit:'                       =>'modifier:',
'new:'                        =>'nouveau:',

### ../pages/company.inc.php   ###
'Remove person from company'  =>'Enlever des personnes des companies',

### ../pages/person.inc.php   ###
'Category|form label'         =>'Catégorie',

### ../pages/company.inc.php   ###
'Failed to remove %s contact person(s)'=>'Echec de la surpression de %s contact',
'Removed %s contact person(s)'=>'Suppression %s contact',

### ../pages/effort.inc.php   ###
'Select one or more efforts'  =>'Sélectionner un ou plusieurs efforts',
'You do not have enough rights'=>'Vous nàavez pas les droits suffisants',
'Effort of task|page type'    =>'Effort de la tâche',
'Edit this effort'            =>'Modifier cet effort',
'Project|label'               =>'Project',
'Task|label'                  =>'Tâche',
'No task related'             =>'Pas de tâche en relation',
'Created by|label'            =>'Créer par',
'Created at|label'            =>'Créer à',
'Duration|label'              =>'Durée',
'Time start|label'            =>'Heure début',
'Time end|label'              =>'Heure fin',
'No description available'    =>'Pas de decription valide',
'Multiple Efforts|page type'  =>'Efforts multiple',
'Multiple Efforts'            =>'Efforts multiple',

### ../pages/task_more.inc.php   ###
'summary'                     =>'sommaire',

### ../pages/effort.inc.php   ###
'Information'                 =>'Information',
'Number of efforts|label'     =>'Nombre dàeffort',
'Sum of efforts|label'        =>'Somme des efforts',
'from|time label'             =>'depuis',
'to|time label'               =>'à',
'Time|label'                  =>'Temps',
'Could not get person of effort'=>'Recherche du contact de làeffort pas possible',

### ../pages/task_view.inc.php   ###
'Upload'                      =>'Envoyé',

### ../pages/file.inc.php   ###
'Select some files to move'   =>'Séléctionnez les fichiers à déplacer',
'Can not edit file %s'        =>'Ne peut pas modifier le fichier %s',
'insufficient rights to edit any of the selected items'=>'droits inssufisant pour modifier làobject séléctionné',
'Edit files'                  =>'Modifier les fichiers',
'Select folder to move files into'=>'Séléctionner le dossier cible',
'No folders available'        =>'Pas de dossier disponible',

### ../pages/task_more.inc.php   ###
'(or select nothing to move to project root)'=>'(ou ne rien séléctionner pour déplacer dans la racine)',

### ../pages/home.inc.php   ###
'Projects'                    =>'Projets',

### ../pages/login.inc.php   ###
'Nickname|label in login form'=>'Pseudo',
'I forgot my password'        =>'Mot de passe oublié ?',

### ../pages/misc.inc.php   ###
'Error-Log'                   =>'Error-Log',
'hide'                        =>'caché',

### ../pages/person.inc.php   ###
'Employees|Pagetitle for person list'=>'Employés',
'Contact Persons|Pagetitle for person list'=>'Personnes de contact',
'Deleted People'              =>'Personne effacé',
'notification:'               =>'notification:',
'no company'                  =>'pas de companie',
'Person details'              =>'Détails de la personne',
'Person with account (can login)|form label'=>'Personne avec compte',

### ../pages/task_more.inc.php   ###
'Invalid checksum for hidden form elements'=>'Checksum invalide des objects cachés',

### ../pages/person.inc.php   ###
'The changed profile <b>does not affect existing project roles</b>! Those has to be adjusted inside the projects.'=>'',
'Nickname has been converted to lowercase'=>'pseudo convertit en minuscule',
'Passwords do not match'      =>'Mot de passe pas identique',
'A notification / activation  will be mailed to <b>%s</b> when you log out.'=>'Un email sera envoyé  %s lors de la déconnexion',
'Person %s created'           =>'Personne %s créée',

### ../pages/proj.inc.php   ###
'not assigned to a closed project'=>'pas assigné à un projet terminé',
'no project templates'        =>'pas de modèle de projet',

### ../pages/task_view.inc.php   ###
'Wiki'                        =>'Wiki',

### ../pages/proj.inc.php   ###
'Team member'                 =>'Participant',
'Create task'                 =>'Tâche créée',

### ../pages/task_view.inc.php   ###
'Bug'                         =>'Bug',

### ../pages/proj.inc.php   ###
'Details|block title'         =>'Détails',
'all'                         =>'tous',
'my open'                     =>'mes ouverts',
'for milestone'               =>'pour làobjectif',
'needs approval'              =>'besoin d´approbation',
'without milestone'           =>'sans objectif',
'Create a new folder for tasks and files'=>'Créer nouveau dossier pour tâches et fichiers',
'Filter-Preset:'              =>'Filter activé',
'No tasks'                    =>'pas de tâche',
'new Milestone'               =>'nouvel objectif',
'View open milestones'        =>'Voir objectifs ouverts',
'View closed milestones'      =>'Voir objectifs terminé',
'Released Versions'           =>'Versions révisées',
'New released Milestone'      =>'Nouvelle objectif révisé',
'Tasks resolved in upcomming version'=>'Tâches résolue dans la prochaine version',
'Found no persons to add. Go to `People` to create some.'=>'Pas de personne trouvée',
'Select a project to edit description'=>'Séléectionner un projet pour modifier la description',

### ../pages/task_more.inc.php   ###
'Edit description'            =>'Modifier la description',

### ../pages/projectperson.inc.php   ###
'Failed to remove %s members from team'=>'Echec de la supression des contacts %s comme participant',
'Unassigned %s team member(s) from project'=>'%s à été supprimé comme participant au projet',

### ../pages/search.inc.php   ###
'in'                          =>'dans',
'on'                          =>'en',
'cannot jump to this item type'=>'ne peut pas aller à ce type dàobject',
'jumped to best of %s search results'=>'allez au meilleur des %s resultats cherchés',
'Add an ! to your search request to jump to the best result.'=>'Ajouter un ! ` votre recherche pour aller au meilleur résultat',
'%s search results for `%s`'  =>'%s résultats pour `%s`',
'No search results for `%s`'  =>'pas de résultats pour `%s`',

### ../pages/version.inc.php   ###
'New Version'                 =>'Nouvelle Version',

### ../pages/task_more.inc.php   ###
'Please select only one item as parent'=>'Séléctionner un seul objet comme parent',
'Insufficient rights for parent item.'=>'Droit insuffisant pour l´objet parent',
'could not find project'      =>'Projet pas trouvé',
'Parent task not found.'      =>'Tâche parente pas trouvée',
'Select some task(s) to edit' =>'Séléctionnez les tâches à modifier',
'You do not have enough rights to edit this task'=>'Droits inssufisant pour modifier cette tâche',
'Edit %s|Page title'          =>'Modifier %s',
'New milestone'               =>'Nouvelle objectif',
'-- next released version --' =>'',

### ../pages/task_view.inc.php   ###
'Resolved in'                 =>'Résolu dans',
'- select person -'           =>'- selectionner un contact -',

### ../pages/task_more.inc.php   ###
'Release as version|Form label, attribute of issue-reports'=>'Révisé comme version',

### ../pages/task_view.inc.php   ###
'30 min'                      =>'30 min',
'1 h'                         =>'1 h',
'2 h'                         =>'2 h',
'4 h'                         =>'4 h',
'1 Day'                       =>'1 jour',
'2 Days'                      =>'2 jours',
'3 Days'                      =>'3 jours',
'4 Days'                      =>'4 jours',
'1 Week'                      =>'1 semaine',
'1,5 Weeks'                   =>'1,5 semaines',
'2 Weeks'                     =>'2 semaines',
'3 Weeks'                     =>'3 semaines',
'Completed'                   =>'Achevé',

### ../pages/task_more.inc.php   ###
'Reproducibility|Form label, attribute of issue-reports'=>'Reproductibilité',
'Create another task after submit'=>'Créer une autre tâche après validation',
'Failed to retrieve parent task'=>'Recherche de la tâche parente échouée',
'Task called %s already exists'=>'La tâche %s existe déjà',
'Created task %s with ID %s'  =>'Tâche %s créée avec ID %s',
'Changed task %s with ID %s'  =>'Tâche %s créée avec ID %s',
'Marked %s tasks to be resolved in this version.'=>'Marquer %s tâches résolues dans cette version',
'Failed to add comment'       =>'Echec de làajout du commentaire',
'Failed to delete task %s'    =>'Echec de la suppression de la tâche %s',
'Could not find task'         =>'Tâche pas trouvée',
'Select some task(s) to reopen'=>'Séléctionnez les tâches à réouvrir',
'Reopened %s tasks.'          =>'%s tâches réouvertes',
'Could not update task'       =>'La mise  jour de la tâche ne peut pas être effectuée',
'Select a task to edit description'=>'Séléctionner la tâche pour modifier la description',
'Task Efforts'                =>'Efforts des tâches',
'changes'                     =>'changement',
'View task'                   =>'Voir les tâches',
'date1 should be smaller than date2. Swapped'=>'date1 doit être pluspetie que date2',
'item has not been edited history'=>'làobject nàa pas dàhistorique de modification',
'unknown'                     =>'inconnu',
' -- '                        =>' -- ',
'prev change'                 =>'changement précédent',
'next'                        =>'suivant',
'Item did not exists at %s'   =>'object %s inéxistant dans %s',
'no changes between %s and %s'=>'pas de changement entre le %s et %s',
'ok'                          =>'ok',
'For editing all tasks must be of same project.'=>'Pour modifier, toutes les tâches doivent-être du même projet',
'Edit multiple tasks|Page title'=>'Modifier plusieurs tâches',
'Edit %s tasks|Page title'    =>'Modifier %s tâches',
'keep different'              =>'Sont différent',
'-- keep different --'        =>'-- sont différent --',
'Prio'                        =>'Prio',
'none'                        =>'sans',

### ../pages/task_view.inc.php   ###
'next released version'       =>'Version révisée suivante',

### ../pages/task_more.inc.php   ###
'resolved in Version'         =>'résolu dans la version',
'Resolve Reason'              =>'Raison de la résolution',
'%s tasks could not be written'=>'%s tâches ne peut pas être modifiées',
'Updated %s tasks tasks'      =>'Mise ` jour %s tâches',

### ../pages/task_view.inc.php   ###
'new task for this milestone' =>'Nouvelle tâche pour cet objectif',
'Add Details|page function'   =>'Ajouter détails',
'Move|page function to move current task'=>'Déplacer',
'status:'                     =>'Etat:',
'Undelete'                    =>'Restaurer',
'View history of item'        =>'Voir làhistorique de làobject',
'Released as|Label in Task summary'=>'Révisé comme',
'For Milestone|Label in Task summary'=>'Pour làobjectif',
'Estimated|Label in Task summary'=>'Estimé',
'Completed|Label in Task summary'=>'Achevé',
'Created|Label in Task summary'=>'Créé',
'Modified|Label in Task summary'=>'Modifé',
'Publish to|Label in Task summary'=>'Publié à',
'attached files'              =>'Fichiers attaché',
'attach new'                  =>'attacher nouveau',
'Severity|label in issue-reports'=>'Sévère',
'Reproducibility|label in issue-reports'=>'Reproductibilité',
'Sub tasks'                   =>'Sous tâche',
'Open tasks for milestone'    =>'Tâche ouverte pour làobjectif',
'No open tasks for this milestone'=>'Objectif sans tâche',
'1 Comment'                   =>'1 commentaire',
'%s Comments'                 =>'%s commentaires',
'Comment / Update'            =>'Commentaire / mise à jour',
'quick edit'                  =>'modification rapide',
'Public to'                   =>'Public à',

### ../pages/version.inc.php   ###
'Edit Version|page type'      =>'Modifier Version',
'Edit Version|page title'     =>'Modifier Version',
'New Version|page title'      =>'Nouvelle Version',
'Could not get version'       =>'Version pas trouvée',
'Could not get project of version'=>'Projet de la version pas trouvé',
'Select some versions to delete'=>'Séléctionnez les versions à supprimer',
'Failed to delete %s versions'=>'Echec de la suppression des %s versions',
'Moved %s versions to trash'=>'%s versions déplacé dans la corbeille',
'Version|page type'           =>'Version',
'Edit this version'           =>'Modifier cette version',

### ../render/render_fields.inc.php   ###
'<b>%s</b> is not a known format for date.'=>'<b>%s<b> nàest pas un format connu de date',

### ../render/render_form.inc.php   ###
'Wiki format'                 =>'Wiki format',

### ../render/render_list.inc.php   ###
'for milestone %s'            =>'pour objectif %s',

### ../render/render_list_column_special.inc.php   ###
'Status|Short status column header'=>'Etat',
'Select / Deselect'           =>'Select / Deselect',

### ../render/render_misc.inc.php   ###
'Other Persons|page option'   =>'Autre contacts',
'Clients|page option'         =>'Clients',
'Prospective Clients|page option'=>'Clients potentiel',
'Suppliers|page option'       =>'Fournisseurs',
'Partners|page option'        =>'Partenaires',
'Companies|page option'       =>'Companies',
'Tasks|Project option'        =>'Tâches',
'Milestones|Project option'   =>'Objectifs',
'Versions|Project option'     =>'Versions',
'Files|Project option'        =>'Fichiers',
'Efforts|Project option'      =>'Efforts',
'History|Project option'      =>'Historique',
'Employees|page option'       =>'Employés',
'Contact Persons|page option' =>'Contacts',
'Deleted|page option'         =>'Supprimé',
'All Companies|page option'   =>'Toutes les companies',
'%s hours'                    =>'%s heures',
'%s days'                     =>'%s jours',
'%s weeks'                    =>'%s semaines',
'estimated %s hours'          =>'%s heures estimée',
'%s hours max'                =>'%s heures max',
'estimated %s days'           =>'%s jours estimés',
'%s days max'                 =>'%s jours max',
'estimated %s weeks'          =>'%s semaines estimées',
'%s weeks max'                =>'%s semaines max',
'%2.0f%% completed'           =>'%2.0f%% achevé',

### ../render/render_page.inc.php   ###
'Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`'=>'Clicker sur tabs pour une recherche étendue',
'Help'                        =>'Aide',

### ../render/render_wiki.inc.php   ###
'from'                        =>'de',
'enlarge'                     =>'élargir',
'Unknown File-Id:'            =>'Id de fichier inconnu',
'Unknown project-Id:'         =>'Id de projet inconnu',
'Wiki-format: <b>%s</b> is not a valid link-type'=>'Wiki-format: <b>%s<b> nàest pas un type de lien valide',
'No task matches this name exactly'=>'Pas de tâche correspondant exactement au nom',
'This task seems to be related'=>'Cette tâche semble en relation',
'No item excactly matches this name.'=>'Pas d´objet correspondant exactement au nom',
'List %s related tasks'       =>'Liste %s relatant les tâches',
'identical'                   =>'identique',
'No item matches this name. Create new task with this name?'=>'Pas d´objet équivalant. Créer un tâche avec ce nom ?',
'No item matches this name.'  =>'Pas d´objet équivalant',
'No item matches this name'   =>'Pas d´objet équivalant',

### ../std/class_auth.inc.php   ###
'Cookie is no longer valid for this computer.'=>'Les cookies ne sont plus valide pour ce PC',
'Your IP-Address changed. Please relogin.'=>'Votre adresse IP a changé, refaire une authentification',
'Your account has been disabled. '=>'Votre compte a été désactivé',
'Unable to automatically detect client time zone'=>'Détection de la zone dàheure automatique pas possible',
'Could not set cookie.'       =>'Activation des cookie impossible',

### ../std/class_pagehandler.inc.php   ###
'Operation aborted with an fatal error which was cause by an programming error (%s).'=>'Erreur fatale: opération arrétée avec l´erreur (%s).',

### ../std/common.inc.php   ###
'only one item expected.'     =>'seul un objet attendu',

### ../std/constant_names.inc.php   ###
'blocked|status_name'         =>'blocké',
'Member|profile name'         =>'Participant',
'Admin|profile name'          =>'Admin',
'Project manager|profile name'=>'Chef de projet',
'Developer|profile name'      =>'Développeur',
'Artist|profile name'         =>'Artiste',
'Tester|profile name'         =>'Testeur',
'Client|profile name'         =>'Client',
'Client trusted|profile name' =>'Partenaire',
'Guest|profile name'          =>'Invité',
'Create & Edit Persons|a user right'=>'Créer et modifier les personnes',
'done|resolve reason'         =>'achevé',
'fixed|resolve reason'        =>'fixé',
'works_for_me|resolve reason' =>'travail pour moi',
'duplicate|resolve reason'    =>'dupliqué',
'bogus|resolve reason'        =>'faux',
'rejected|resolve reason'     =>'rejeté',
'deferred|resolve reason'     =>'reporté',
'Not defined|release type'    =>'Pas défini',
'Not planned|release type'    =>'Pas plannifié',
'Upcomming|release type'      =>'à venir',
'Internal|release type'       =>'Interne',
'Public|release type'         =>'Public',
'Without support|release type'=>'Sans support',
'No longer supported|release type'=>'Plus supporté',
'undefined|company category'  =>'indéfini',
'client|company category'     =>'Client',
'prospective client|company category'=>'Client potentiel',
'supplier|company category'   =>'fournisseur',
'partner|company category'    =>'partenaire',
'undefined|person category'   =>'indéfini',
'- employee -|person category'=>'- employé -',
'staff|person category'       =>'personnel',
'freelancer|person category'  =>'indépendant ',
'working student|person category'=>'étudiant',
'apprentice|person category'  =>'apprenti',
'intern|person category'      =>'interne',
'ex-employee|person category' =>'ex-employé',
'- contact person -|person category'=>'- contact -',
'client|person category'      =>'client',
'prospective client|person category'=>'client potentiel',
'supplier|person category'    =>'fournisseur',
'partner|person category'     =>'partenaire',

### ../std/mail.inc.php   ###
'Failure sending mail: %s'    =>'Echec de l´envoi du mail: %s',
'Streber Email Notification|notifcation mail from'=>'Streber Email Notification',
'Updates at %s|notication mail subject'=>'Changement à %s',
'Hello %s,|notification'      =>'Bonjour %s',
'with this automatically created e-mail we want to inform you that|notification'=>'Ce mail d´information a été créé automatiquement',
'since %s'                    =>'depuis le %s',
'following happened at %s |notification'=>'des changements ont eu lieu sur les projets de %s',
'Your account has been created.|notification'=>'Votre compte a été créé.',
'Please set a password to activate it.|notification'=>'Introduire un mot de passe pour l´activer',
'You have been assigned to projects:|notification'=>'Vous participez aux projets:',
'Project Updates'             =>'Projets mis à jour',
'If you do not want to get further notifications or you forgot your password feel free to|notification'=>'Si vous ne voulez plus être informé, corrigé le dans ',
'adjust your profile|notification'=>'ajuster votre profil',
'Thanks for your time|notication'=>'Merci pour votre temps',
'the management|notication'   =>'Le management',
'No news for <b>%s</b>'       =>'Pas de nouvelles pour <b>%s</b>',


);



?>