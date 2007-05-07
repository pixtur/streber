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
* translation into:
*
*    translated by:
*
*             date:
*
*  streber version:
*
*         comments:
*/

global $g_lang_table;
$g_lang_table= array(

undefined keys:
---------------

### ../conf/defines.inc.php   ###
'autodetect'                  =>'',  # line 304

### ../pages/company.inc.php   ###
'Summary'                     =>'',  # line 570

### ../pages/person.inc.php   ###
'Details'                     =>'',  # line 1079

### ../pages/search.inc.php   ###
'Name'                        =>'',  # line 900

### ../db/class_company.inc.php   ###
'Required. (e.g. pixtur ag)'  =>'',  # line 34
'Short|form field for company'=>'',  # line 39
'Optional: Short name shown in lists (eg. pixtur)'=>'',  # line 40
'Tag line|form field for company'=>'',  # line 45

### ../db/class_person.inc.php   ###
'Optional: Additional tagline (eg. multimedia concepts)'=>'',  # line 64

### ../db/class_company.inc.php   ###
'Phone|form field for company'=>'',  # line 51
'Optional: Phone (eg. +49-30-12345678)'=>'',  # line 52
'Fax|form field for company'  =>'',  # line 57
'Optional: Fax (eg. +49-30-12345678)'=>'',  # line 58
'Street'                      =>'',  # line 63
'Optional: (eg. Poststreet 28)'=>'',  # line 64
'Zipcode'                     =>'',  # line 69
'Optional: (eg. 12345 Berlin)'=>'',  # line 70
'Website'                     =>'',  # line 75
'Optional: (eg. http://www.pixtur.de)'=>'',  # line 76
'Intranet'                    =>'',  # line 81
'Optional: (eg. http://www.pixtur.de/login.php?name=someone)'=>'',  # line 88
'E-Mail'                      =>'',  # line 87
'Comments|form label for company'=>'',  # line 93

### ../db/db_itemperson.inc.php   ###
'Optional'                    =>'',  # line 46

### ../db/class_company.inc.php   ###
'more than expected'          =>'',  # line 623

### ../pages/effort.inc.php   ###
'not available'               =>'',  # line 379

### ../db/class_effort.inc.php   ###
'optional if tasks linked to this effort'=>'',  # line 37
'Time Start'                  =>'',  # line 44
'Time End'                    =>'',  # line 48

### ../pages/version.inc.php   ###
'Description'                 =>'',  # line 342

### ../db/class_issue.inc.php   ###
'Production build'            =>'',  # line 53
'Steps to reproduce'          =>'',  # line 57
'Expected result'             =>'',  # line 60
'Suggested Solution'          =>'',  # line 63

### ../db/class_person.inc.php   ###
'Full name'                   =>'',  # line 54
'Required. Full name like (e.g. Thomas Mann)'=>'',  # line 55
'Nickname'                    =>'',  # line 59
'only required if user can login (e.g. pixtur)'=>'',  # line 60

### ../lists/list_persons.inc.php   ###
'Tagline'                     =>'',  # line 68

### ../db/class_person.inc.php   ###
'Mobile Phone'                =>'',  # line 67
'Optional: Mobile phone (eg. +49-172-12345678)'=>'',  # line 68
'Office Phone'                =>'',  # line 73
'Optional: Office Phone (eg. +49-30-12345678)'=>'',  # line 74
'Office Fax'                  =>'',  # line 77
'Optional: Office Fax (eg. +49-30-12345678)'=>'',  # line 78
'Office Street'               =>'',  # line 81
'Optional: Official Street and Number (eg. Poststreet 28)'=>'',  # line 82
'Office Zipcode'              =>'',  # line 85
'Optional: Official Zip-Code and City (eg. 12345 Berlin)'=>'',  # line 86
'Office Page'                 =>'',  # line 89
'Optional: (eg. www.pixtur.de)'=>'',  # line 117
'Office E-Mail'               =>'',  # line 93
'Optional: (eg. thomas@pixtur.de)'=>'',  # line 121
'Personal Phone'              =>'',  # line 100
'Optional: Private Phone (eg. +49-30-12345678)'=>'',  # line 101
'Personal Fax'                =>'',  # line 104
'Optional: Private Fax (eg. +49-30-12345678)'=>'',  # line 105
'Personal Street'             =>'',  # line 108
'Optional:  Private (eg. Poststreet 28)'=>'',  # line 109
'Personal Zipcode'            =>'',  # line 112
'Optional: Private (eg. 12345 Berlin)'=>'',  # line 113
'Personal Page'               =>'',  # line 116
'Personal E-Mail'             =>'',  # line 120
'Birthdate'                   =>'',  # line 124

### ../db/class_project.inc.php   ###
'Color'                       =>'',  # line 56

### ../db/class_person.inc.php   ###
'Optional: Color for graphical overviews (e.g. #FFFF00)'=>'',  # line 130

### ../lists/list_comments.inc.php   ###
'Comments'                    =>'',  # line 29

### ../db/class_person.inc.php   ###
'Password'                    =>'',  # line 140
'Only required if user can login|tooltip'=>'',  # line 141

### ../render/render_page.inc.php   ###
'Profile'                     =>'',  # line 714

### ../db/class_person.inc.php   ###
'Theme|Formlabel'             =>'',  # line 175

### ../db/class_task.inc.php   ###
'Short'                       =>'',  # line 47

### ../db/class_project.inc.php   ###
'Status summary'              =>'',  # line 53

### ../db/class_task.inc.php   ###
'Date start'                  =>'',  # line 51
'Date closed'                 =>'',  # line 57

### ../pages/task_more.inc.php   ###
'Status'                      =>'',  # line 2335

### ../db/class_project.inc.php   ###
'Project page'                =>'',  # line 71
'Wiki page'                   =>'',  # line 74

### ../pages/home.inc.php   ###
'Priority'                    =>'',  # line 177

### ../std/constant_names.inc.php   ###
'Company'                     =>'',  # line 123

### ../db/class_project.inc.php   ###
'show tasks in home'          =>'',  # line 88
'only team members can create items'=>'',  # line 1236
'validating invalid item'     =>'',  # line 1316
'insuffient rights (not in project)'=>'',  # line 1328

### ../pages/task_more.inc.php   ###
'insuffient rights'           =>'',  # line 2877

### ../pages/project_view.inc.php   ###
'Project Template'            =>'',  # line 69
'Inactive Project'            =>'',  # line 72
'Project|Page Type'           =>'',  # line 75

### ../lists/list_project_team.inc.php   ###
'job'                         =>'',  # line 219

### ../db/class_projectperson.inc.php   ###
'role'                        =>'',  # line 57

### ../pages/task_view.inc.php   ###
'For Milestone'               =>'',  # line 790

### ../db/class_task.inc.php   ###
'resolved in version'         =>'',  # line 79

### ../pages/task_view.inc.php   ###
'Resolve reason'              =>'',  # line 796

### ../db/class_task.inc.php   ###
'show as folder (may contain other tasks)'=>'',  # line 98
'is a milestone'              =>'',  # line 103
'milestones are shown in a different list'=>'',  # line 104
'released'                    =>'',  # line 110
'release time'                =>'',  # line 116
'Completion'                  =>'',  # line 122

### ../pages/task_view.inc.php   ###
'Estimated time'              =>'',  # line 882
'Estimated worst case'        =>'',  # line 883

### ../pages/task_more.inc.php   ###
'Label'                       =>'',  # line 2364

### ../db/class_task.inc.php   ###
'Planned Start'               =>'',  # line 153
'Planned End'                 =>'',  # line 158
'Order Id'                    =>'',  # line 175

### ../pages/task_more.inc.php   ###
'task without project?'       =>'',  # line 1942

### ../pages/task_view.inc.php   ###
'Folder'                      =>'',  # line 108

### ../lists/list_versions.inc.php   ###
'Released Milestone'          =>'',  # line 180

### ../pages/project_more.inc.php   ###
'Milestone'                   =>'',  # line 908

### ../db/db.inc.php   ###
'Database exception. Please read %s next steps on database errors.%s'=>'',  # line 38

### ../db/db_item.inc.php   ###
'unnamed'                     =>'',  # line 563
'Unknown'                     =>'',  # line 1452
'Item has been modified during your editing by %s (%s minutes ago). Your changes can not be submitted.'=>'',  # line 1457

### ../db/db_itemperson.inc.php   ###
'Comment|form label for items'=>'',  # line 45

### ../lists/list_bookmarks.inc.php   ###
'Your bookmarks'              =>'',  # line 32
'You have no bookmarks'       =>'',  # line 33

### ../pages/item.inc.php   ###
'Edit bookmark'               =>'',  # line 363

### ../pages/_handles.inc.php   ###
'Remove bookmark'             =>'',  # line 52

### ../pages/search.inc.php   ###
'Type'                        =>'',  # line 871

### ../pages/person.inc.php   ###
'deleted'                     =>'',  # line 424

### ../pages/item.inc.php   ###
'Notify on change'            =>'',  # line 681

### ../lists/list_tasks.inc.php   ###
'in|very short for IN folder...'=>'',  # line 1304

### ../lists/list_projectchanges.inc.php   ###
'(on comment)'                =>'',  # line 376
'(on task)'                   =>'',  # line 381
'(on project)'                =>'',  # line 387

### ../std/constant_names.inc.php   ###
'Comment'                     =>'',  # line 128

### ../lists/list_bookmarks.inc.php   ###
'Remind'                      =>'',  # line 422
'in %s day(s)'                =>'',  # line 471
'since %s day(s)'             =>'',  # line 475

### ../render/render_list_column_special.inc.php   ###
'Modified'                    =>'',  # line 197

### ../std/constant_names.inc.php   ###
'Project'                     =>'',  # line 119

### ../lists/list_bookmarks.inc.php   ###
'State'                       =>'',  # line 718
'Modified by'                 =>'',  # line 751

### ../lists/list_changes.inc.php   ###
'to|very short for assigned tasks TO...'=>'',  # line 406

### ../lists/list_projectchanges.inc.php   ###
'new'                         =>'',  # line 215

### ../pages/project_more.inc.php   ###
'modified'                    =>'',  # line 690

### ../lists/list_comments.inc.php   ###
'New Comment'                 =>'',  # line 39

### ../lists/list_changes.inc.php   ###
'Last of %s comments:'        =>'',  # line 217
'comment:'                    =>'',  # line 220
'completed'                   =>'',  # line 242
'Approve Task'                =>'',  # line 243
'approved'                    =>'',  # line 247

### ../pages/project_more.inc.php   ###
'closed'                      =>'',  # line 770

### ../lists/list_changes.inc.php   ###
'reopened'                    =>'',  # line 255
'is blocked'                  =>'',  # line 262
'moved'                       =>'',  # line 268
'renamed'                     =>'',  # line 273
'edit wiki'                   =>'',  # line 276
'changed:'                    =>'',  # line 280
'commented'                   =>'',  # line 290
'assigned'                    =>'',  # line 329
'attached'                    =>'',  # line 348
'attached file to'            =>'',  # line 358

### ../lists/list_projectchanges.inc.php   ###
'restore'                     =>'',  # line 332

### ../pages/search.inc.php   ###
'Changes'                     =>'',  # line 752
'Other team members changed nothing since last logout (%s)'=>'',  # line 754

### ../lists/list_changes.inc.php   ###
'Date'                        =>'',  # line 564

### ../pages/search.inc.php   ###
'Who changed what when...'    =>'',  # line 833

### ../lists/list_changes.inc.php   ###
'what|column header in change list'=>'',  # line 598

### ../std/constant_names.inc.php   ###
'Task'                        =>'',  # line 120

### ../lists/list_changes.inc.php   ###
'Date / by'                   =>'',  # line 695

### ../lists/list_comments.inc.php   ###
'Add Comment'                 =>'',  # line 41

### ../pages/_handles.inc.php   ###
'Mark as bookmark'            =>'',  # line 45

### ../lists/list_comments.inc.php   ###
'Shrink All Comments'         =>'',  # line 58
'Collapse All Comments'       =>'',  # line 60
'Expand All Comments'         =>'',  # line 67
'By|column header'            =>'',  # line 88
'version %s'                  =>'',  # line 140

### ../render/render_page.inc.php   ###
'Edit'                        =>'',  # line 627

### ../pages/task_view.inc.php   ###
'Delete'                      =>'',  # line 1048

### ../lists/list_comments.inc.php   ###
'Reply'                       =>'',  # line 170
'Publish'                     =>'',  # line 173
'1 sub comment'               =>'',  # line 230
'%s sub comments'             =>'',  # line 233

### ../lists/list_companies.inc.php   ###
'related companies'           =>'',  # line 28

### ../lists/list_persons.inc.php   ###
'Name Short'                  =>'',  # line 34
'Shortnames used in other lists'=>'',  # line 35

### ../pages/company.inc.php   ###
'Phone'                       =>'',  # line 584

### ../lists/list_companies.inc.php   ###
'Phone-Number'                =>'',  # line 42
'Proj'                        =>'',  # line 50
'Number of open Projects'     =>'',  # line 51

### ../render/render_page.inc.php   ###
'People'                      =>'',  # line 237

### ../lists/list_companies.inc.php   ###
'People working for this person'=>'',  # line 58
'Edit company'                =>'',  # line 91
'Delete company'              =>'',  # line 98
'Create new company'          =>'',  # line 104
'Company|Column header'       =>'',  # line 127

### ../pages/project_more.inc.php   ###
'Documentation'               =>'',  # line 1091

### ../lists/list_efforts.inc.php   ###
'no efforts booked yet'       =>'',  # line 25

### ../pages/person.inc.php   ###
'Efforts'                     =>'',  # line 33

### ../lists/list_efforts.inc.php   ###
'person'                      =>'',  # line 37
'Edit effort'                 =>'',  # line 50
'New effort'                  =>'',  # line 57
'View selected Efforts'       =>'',  # line 72
'%s effort(s) with %s hours'  =>'',  # line 129

### ../std/constant_names.inc.php   ###
'Effort'                      =>'',  # line 127

### ../lists/list_efforts.inc.php   ###
'Effort name. More Details as tooltips'=>'',  # line 143
'Task|column header'          =>'',  # line 167
'Start|column header'         =>'',  # line 192
'D, d.m.Y'                    =>'',  # line 203
'End|column header'           =>'',  # line 219
'len|column header of length of effort'=>'',  # line 243
'Daygraph|columnheader'       =>'',  # line 263

### ../lists/list_files.inc.php   ###
'Parent item'                 =>'',  # line 39

### ../pages/task_view.inc.php   ###
'Version'                     =>'',  # line 522

### ../pages/_handles.inc.php   ###
'Edit file'                   =>'',  # line 811

### ../lists/list_files.inc.php   ###
'Move files'                  =>'',  # line 121
'New file'                    =>'',  # line 134
'No files uploaded'           =>'',  # line 219
'Download|Column header'      =>'',  # line 262
'File|Column header'          =>'',  # line 304
'in|... folder'               =>'',  # line 341
'ID %s'                       =>'',  # line 457
'Show Details'                =>'',  # line 459
'Attached to|Column header'   =>'',  # line 383
'Summary|Column header'       =>'',  # line 414
'Thumbnail|Column header'     =>'',  # line 475

### ../pages/project_more.inc.php   ###
'Milestones'                  =>'',  # line 1324

### ../pages/task_more.inc.php   ###
'New folder'                  =>'',  # line 111

### ../pages/person.inc.php   ###
'or'                          =>'',  # line 678

### ../lists/list_milestones.inc.php   ###
'Planned for'                 =>'',  # line 309
'Due Today'                   =>'',  # line 333
'%s days late'                =>'',  # line 338
'%s days left'                =>'',  # line 342

### ../lists/list_versions.inc.php   ###
'%s required'                 =>'',  # line 262

### ../lists/list_milestones.inc.php   ###
'Tasks open|columnheader'     =>'',  # line 375

### ../pages/project_more.inc.php   ###
'open'                        =>'',  # line 599

### ../lists/list_project_team.inc.php   ###
'Your related persons'        =>'',  # line 26

### ../std/constant_names.inc.php   ###
'Person'                      =>'',  # line 121

### ../lists/list_versions.inc.php   ###
'Task name. More Details as tooltips'=>'',  # line 54

### ../lists/list_persons.inc.php   ###
'Private'                     =>'',  # line 53
'Mobil'                       =>'',  # line 58
'Office'                      =>'',  # line 63

### ../render/render_page.inc.php   ###
'Companies'                   =>'',  # line 243

### ../lists/list_persons.inc.php   ###
'last login'                  =>'',  # line 78
'Edit person'                 =>'',  # line 110

### ../pages/_handles.inc.php   ###
'Edit User Rights'            =>'',  # line 1016

### ../lists/list_persons.inc.php   ###
'Delete person'               =>'',  # line 123
'Create new person'           =>'',  # line 129
'Nickname|column header'      =>'',  # line 217
'Name|column header'          =>'',  # line 239
'Profile|column header'       =>'',  # line 265
'Account settings for user (do not confuse with project rights)'=>'',  # line 267
'(adjusted)'                  =>'',  # line 282
'Active Projects|column header'=>'',  # line 304

### ../render/render_list_column_special.inc.php   ###
'Priority is %s'              =>'',  # line 255

### ../lists/list_persons.inc.php   ###
'recent changes|column header'=>'',  # line 349
'changes since YOUR last logout'=>'',  # line 351

### ../lists/list_project_team.inc.php   ###
'Rights'                      =>'',  # line 42
'Persons rights in this project'=>'',  # line 43
'Edit team member'            =>'',  # line 100
'Add team member'             =>'',  # line 107
'Remove person from team'     =>'',  # line 114

### ../pages/project_view.inc.php   ###
'Team members'                =>'',  # line 287

### ../lists/list_project_team.inc.php   ###
'Role'                        =>'',  # line 194
'last Login|column header'    =>'',  # line 234

### ../lists/list_projectchanges.inc.php   ###
'Nothing has changed.'        =>'',  # line 33

### ../render/render_list_column_special.inc.php   ###
'Created by'                  =>'',  # line 391

### ../lists/list_projectchanges.inc.php   ###
'Item was originally created by'=>'',  # line 46
'C'                           =>'',  # line 195
'Created,Modified or Deleted' =>'',  # line 196
'Deleted'                     =>'',  # line 209
'by Person'                   =>'',  # line 233
'Person who did the last change'=>'',  # line 234
'Type|Column header'          =>'',  # line 293
'item %s has undefined type'  =>'',  # line 301
'Del'                         =>'',  # line 319
'shows if item is deleted'    =>'',  # line 320

### ../lists/list_projects.inc.php   ###
'Project priority (the icons have tooltips, too)'=>'',  # line 64

### ../pages/home.inc.php   ###
'Task-Status'                 =>'',  # line 184

### ../lists/list_projects.inc.php   ###
'Status Summary'              =>'',  # line 102
'Short discription of the current status'=>'',  # line 103

### ../pages/project_view.inc.php   ###
'Tasks'                       =>'',  # line 253

### ../lists/list_projects.inc.php   ###
'Number of open Tasks'        =>'',  # line 113
'Opened'                      =>'',  # line 121
'Day the Project opened'      =>'',  # line 122

### ../render/render_misc.inc.php   ###
'Closed'                      =>'',  # line 492

### ../lists/list_projects.inc.php   ###
'Day the Project state changed to closed'=>'',  # line 128
'Edit project'                =>'',  # line 137
'Delete project'              =>'',  # line 144
'Log hours for a project'     =>'',  # line 151
'Open / Close'                =>'',  # line 159

### ../pages/company.inc.php   ###
'Create new project'          =>'',  # line 690

### ../pages/_handles.inc.php   ###
'Create Template'             =>'',  # line 262
'Project from Template'       =>'',  # line 270

### ../lists/list_projects.inc.php   ###
'... working in project'      =>'',  # line 310

### ../pages/home.inc.php   ###
'Project|column header'       =>'',  # line 191

### ../pages/project_view.inc.php   ###
'Folders'                     =>'',  # line 301

### ../lists/list_taskfolders.inc.php   ###
'Number of subtasks'          =>'',  # line 87
'New'                         =>'',  # line 105
'Create new folder under selected task'=>'',  # line 108
'Move selected to folder'     =>'',  # line 113

### ../lists/list_tasks.inc.php   ###
'Log hours for select tasks'  =>'',  # line 223
'Priority of task'            =>'',  # line 97
'Status|Columnheader'         =>'',  # line 108
'Started'                     =>'',  # line 129
'Modified|Column header'      =>'',  # line 133
'Est.'                        =>'',  # line 144

### ../pages/home.inc.php   ###
'Estimated time in hours'     =>'',  # line 223

### ../lists/list_tasks.inc.php   ###
'Add new Task'                =>'',  # line 166
'Report new Bug'              =>'',  # line 173

### ../pages/task_view.inc.php   ###
'Add comment'                 =>'',  # line 746

### ../lists/list_tasks.inc.php   ###
'Status->Completed'           =>'',  # line 194
'Status->Approved'            =>'',  # line 201
'Status->Closed'              =>'',  # line 208
'Move tasks'                  =>'',  # line 216
'List|List sort mode'         =>'',  # line 240
'Tree|List sort mode'         =>'',  # line 251
'Grouped|List sort mode'      =>'',  # line 262
'%s hidden'                   =>'',  # line 375
'Latest Comment'              =>'',  # line 502
'by'                          =>'',  # line 504

### ../pages/search.inc.php   ###
'for'                         =>'',  # line 281

### ../lists/list_tasks.inc.php   ###
'%s open tasks / %s h'        =>'',  # line 545
'Label|Columnheader'          =>'',  # line 890

### ../pages/task_view.inc.php   ###
'Assigned to'                 =>'',  # line 837

### ../lists/list_tasks.inc.php   ###
'Task name'                   =>'',  # line 1017
'has %s comments'             =>'',  # line 1047
'Task has %s attachments'     =>'',  # line 1060
'- no name -|in task lists'   =>'',  # line 1299
'number of subtasks'          =>'',  # line 1092
'Page name'                   =>'',  # line 1132
'Sum of all booked efforts (including subtasks)'=>'',  # line 1176
'Effort in hours'             =>'',  # line 1190
'Days until planned start'    =>'',  # line 1202
'Due|column header, days until planned start'=>'',  # line 1203
'planned for %s|a certain date'=>'',  # line 1232
'Est/Compl'                   =>'',  # line 1248
'Estimated time / completed'  =>'',  # line 1250

### ../lists/list_versions.inc.php   ###
'Release Date'                =>'',  # line 240

### ../pages/_handles.inc.php   ###
'Home'                        =>'',  # line 7
'Playground'                  =>'',  # line 17

### ../pages/item.inc.php   ###
'View item'                   =>'',  # line 1004

### ../pages/_handles.inc.php   ###
'Set Public Level'            =>'',  # line 37
'Send notification'           =>'',  # line 59
'Remove notification'         =>'',  # line 65
'Edit bookmarks'        =>'',  # line 71
'Edit multiple bookmarks'=>'',  # line 84
'view changes'                =>'',  # line 97
'Active Projects'             =>'',  # line 129
'Closed Projects'             =>'',  # line 137

### ../pages/project_more.inc.php   ###
'Project Templates'           =>'',  # line 194

### ../pages/_handles.inc.php   ###
'View Project'                =>'',  # line 231
'View Project as RSS'         =>'',  # line 169
'Versions'                    =>'',  # line 201

### ../pages/project_more.inc.php   ###
'Uploaded Files'              =>'',  # line 1220
'New project'                 =>'',  # line 1589
'Edit Project'                =>'',  # line 2014

### ../pages/_handles.inc.php   ###
'Delete Project'              =>'',  # line 297
'Change Project Status'       =>'',  # line 305
'Add Team member'             =>'',  # line 343
'Edit Team member'            =>'',  # line 352
'Remove from team'            =>'',  # line 364
'View Task'                   =>'',  # line 379
'View Task As Docu'           =>'',  # line 391

### ../pages/task_more.inc.php   ###
'Edit Task'                   =>'',  # line 313

### ../pages/_handles.inc.php   ###
'Edit multiple Tasks'         =>'',  # line 420
'View Task Efforts'           =>'',  # line 429
'Delete Task(s)'              =>'',  # line 442
'Restore Task(s)'             =>'',  # line 447
'Move tasks to folder'        =>'',  # line 455
'Mark tasks as Complete'      =>'',  # line 463
'Mark tasks as Approved'      =>'',  # line 471
'Mark tasks as Closed'        =>'',  # line 479
'Mark tasks as Open'          =>'',  # line 485
'New Task'                    =>'',  # line 527
'New bug'                     =>'',  # line 511

### ../pages/task_more.inc.php   ###
'New Milestone'               =>'',  # line 37

### ../pages/_handles.inc.php   ###
'New released Version'      =>'',  # line 554
'Toggle view collapsed'       =>'',  # line 769
'Add issue/bug report'        =>'',  # line 598
'Edit Description'            =>'',  # line 607
'Create Note'                 =>'',  # line 619
'Edit Note'                   =>'',  # line 633
'View effort'                 =>'',  # line 644
'View multiple efforts'       =>'',  # line 657
'Log hours'                   =>'',  # line 666
'Edit time effort'            =>'',  # line 673
'View comment'                =>'',  # line 692
'Create comment'              =>'',  # line 706
'Edit comment'                =>'',  # line 717
'Delete comment'              =>'',  # line 740
'View file'                   =>'',  # line 785
'Upload file'                 =>'',  # line 797
'Update file'                 =>'',  # line 803

### ../pages/file.inc.php   ###
'Download'                    =>'',  # line 197

### ../pages/_handles.inc.php   ###
'Show file scaled'            =>'',  # line 823
'Move files to folder'        =>'',  # line 836
'List Companies'              =>'',  # line 856
'List Clients'                =>'',  # line 864
'List Prospective Clients'    =>'',  # line 870
'List Suppliers'              =>'',  # line 877
'List Partners'               =>'',  # line 884
'View Company'                =>'',  # line 890

### ../pages/company.inc.php   ###
'New company'                 =>'',  # line 740
'Edit Company'                =>'',  # line 948

### ../pages/_handles.inc.php   ###
'Delete Company'              =>'',  # line 920

### ../pages/company.inc.php   ###
'Link Persons'                =>'',  # line 637

### ../pages/_handles.inc.php   ###
'Remove persons from company' =>'',  # line 940
'List Persons'                =>'',  # line 973
'List Employees'              =>'',  # line 966
'List Deleted Persons'        =>'',  # line 979
'View Person'                 =>'',  # line 985

### ../pages/person.inc.php   ###
'New person'                  =>'',  # line 858
'Edit Person'                 =>'',  # line 2055

### ../pages/_handles.inc.php   ###
'Delete Person'               =>'',  # line 1029
'View Efforts of Person'      =>'',  # line 1034
'Send Activation E-Mail'      =>'',  # line 1042
'Flush Notifications'         =>'',  # line 1102

### ../render/render_page.inc.php   ###
'Register'                    =>'',  # line 724

### ../pages/person.inc.php   ###
'Link Companies'              =>'',  # line 663
'Remove companies from person'=>'',  # line 669

### ../pages/_handles.inc.php   ###
'Mark all items as viewed'      =>'',  # line 1088

### ../render/render_page.inc.php   ###
'Login'                       =>'',  # line 695

### ../pages/_handles.inc.php   ###
'Forgot your password?'       =>'',  # line 1148

### ../render/render_page.inc.php   ###
'Logout'                      =>'',  # line 716

### ../pages/_handles.inc.php   ###
'License'                     =>'',  # line 1175
'restore Item'                =>'',  # line 1214

### ../pages/error.inc.php   ###
'Error'                       =>'',  # line 39

### ../pages/_handles.inc.php   ###
'Activate an account'         =>'',  # line 1228
'System Information'          =>'',  # line 1241
'PhpInfo'                     =>'',  # line 1253
'Filter errors.log'           =>'',  # line 1265
'Delete errors.log'           =>'',  # line 1274
'Search'                      =>'',  # line 1281
'Task Test'                   =>'',  # line 1290
'Load Field'                  =>'',  # line 1296
'Save Field'                  =>'',  # line 1301

### ../pages/comment.inc.php   ###
'Comment on task|page type'   =>'',  # line 67

### ../pages/version.inc.php   ###
'(deleted %s)|page title add on with date of deletion'=>'',  # line 303

### ../pages/comment.inc.php   ###
'Edit this comment'           =>'',  # line 88
'Mark this comment as bookmark'=>'',  # line 97

### ../pages/version.inc.php   ###
'Bookmark'                    =>'',  # line 321
'Remove this bookmark'        =>'',  # line 328
'Remove Bookmark'             =>'',  # line 329

### ../pages/comment.inc.php   ###
'Delete this comment'         =>'',  # line 125
'Restore'                     =>'',  # line 117
'New Comment|Default name of new comment'=>'',  # line 192
'Reply to |prefix for name of new comment on another comment'=>'',  # line 256
'Edit Comment|Page title'     =>'',  # line 334
'New Comment|Page title'      =>'',  # line 337
'On task %s|page title add on'=>'',  # line 341

### ../pages/version.inc.php   ###
'On project %s|page title add on'=>'',  # line 94

### ../pages/comment.inc.php   ###
'Occasion|form label'         =>'',  # line 384
'Publish to|form label'       =>'',  # line 389
'Select some comments to delete'=>'',  # line 517
'Failed to delete %s comments'=>'',  # line 549
'Moved %s comments to trash'  =>'',  # line 552
'Select some comments to restore'=>'',  # line 572
'Failed to restore %s comments'=>'',  # line 598
'Restored %s comments'        =>'',  # line 601
'Select some comments to move'=>'',  # line 749

### ../pages/task_more.inc.php   ###
'insufficient rights'         =>'',  # line 1399

### ../pages/comment.inc.php   ###
'Can not edit comment %s'     =>'',  # line 790

### ../pages/task_more.inc.php   ###
'Edit tasks'                  =>'',  # line 1462

### ../pages/comment.inc.php   ###
'Select one folder to move comments into'=>'',  # line 823
'... or select nothing to move to project root'=>'',  # line 835
'No folders in this project...'=>'',  # line 863

### ../pages/task_more.inc.php   ###
'Move items'                  =>'',  # line 1516

### ../pages/company.inc.php   ###
'related projects of %s'      =>'',  # line 41

### ../pages/project_more.inc.php   ###
'admin view'                  =>'',  # line 199

### ../pages/person.inc.php   ###
'List'                        =>'',  # line 395

### ../pages/task_view.inc.php   ###
'new'                        =>'',  # line 1064

### ../pages/company.inc.php   ###
'no companies'                =>'',  # line 423

### ../std/class_pagehandler.inc.php   ###
'Export as CSV'               =>'',  # line 817

### ../pages/company.inc.php   ###
'Clients'                     =>'',  # line 124
'related companies of %s'     =>'',  # line 386

### ../pages/project_more.inc.php   ###
'List|page type'              =>'',  # line 201

### ../pages/company.inc.php   ###
'Prospective Clients'         =>'',  # line 212
'Suppliers'                   =>'',  # line 298
'Partners'                    =>'',  # line 384

### ../pages/project_view.inc.php   ###
'Overview'                    =>'',  # line 66

### ../pages/task_view.inc.php   ###
'edit'                       =>'',  # line 100

### ../pages/company.inc.php   ###
'Edit this company'           =>'',  # line 501
'Mark this company as bookmark'=>'',  # line 510
'Delete this company'         =>'',  # line 528
'Create new person for this company'=>'',  # line 541
'Create new project for this company'=>'',  # line 548
'Add existing persons to this company'=>'',  # line 555
'Persons'                     =>'',  # line 556
'Adress'                      =>'',  # line 578
'Fax'                         =>'',  # line 587
'Web'                         =>'',  # line 592
'Intra'                       =>'',  # line 595
'Mail'                        =>'',  # line 598
'related Persons'             =>'',  # line 613
'Remove person from company'  =>'',  # line 643
'link existing Person'        =>'',  # line 651

### ../pages/person.inc.php   ###
'create new'                  =>'',  # line 679

### ../pages/company.inc.php   ###
'no persons related'          =>'',  # line 656
'Active projects'             =>'',  # line 675
' Hint: for already existing projects please edit those and adjust company-setting.'=>'',  # line 691
'no projects yet'             =>'',  # line 694
'Closed projects'             =>'',  # line 708

### ../pages/person.inc.php   ###
'Category|form label'         =>'',  # line 1983

### ../pages/company.inc.php   ###
'Create another company after submit'=>'',  # line 822

### ../pages/person.inc.php   ###
'Edit %s'                     =>'',  # line 2056

### ../pages/company.inc.php   ###
'Add persons employed or related'=>'',  # line 950

### ../pages/project_more.inc.php   ###
'No persons selected...'      =>'',  # line 2095

### ../pages/company.inc.php   ###
'Person already related to company'=>'',  # line 1030
'Failed to remove %s contact person(s)'=>'',  # line 1094
'Removed %s contact person(s)'=>'',  # line 1097
'Select some companies to delete'=>'',  # line 1116
'Failed to delete %s companies'=>'',  # line 1136
'Moved %s companies to trash' =>'',  # line 1139

### ../pages/project_view.inc.php   ###
'invalid project-id'          =>'',  # line 44
'Edit this project'           =>'',  # line 86
'Delete this project'         =>'',  # line 117
'Add person as team-member to project'=>'',  # line 132
'Team member'                 =>'',  # line 133
'Create task'                 =>'',  # line 140
'Create task with issue-report'=>'',  # line 147

### ../pages/task_view.inc.php   ###
'Bug'                         =>'',  # line 175

### ../pages/project_view.inc.php   ###
'Details|block title'         =>'',  # line 173
'Client|label'                =>'',  # line 187
'Phone|label'                 =>'',  # line 189
'E-Mail|label'                =>'',  # line 192
'Status|Label in summary'     =>'',  # line 205
'Wikipage|Label in summary'   =>'',  # line 210
'Projectpage|Label in summary'=>'',  # line 214
'Opened|Label in summary'     =>'',  # line 219
'Closed|Label in summary'     =>'',  # line 224
'Created by|Label in summary' =>'',  # line 228
'Last modified by|Label in summary'=>'',  # line 233
'Logged effort'               =>'',  # line 240
'hours'                       =>'',  # line 242

### ../pages/task_view.inc.php   ###
'Completed'                   =>'',  # line 906

### ../pages/project_view.inc.php   ###
'News'                        =>'',  # line 160

### ../pages/custom_projView.inc.php   ###
'%s comments'                 =>'',  # line 389

### ../pages/custom_projViewFiles.inc.php   ###
'Downloads'                   =>'',  # line 62

### ../pages/effort.inc.php   ###
'Select one or more efforts'  =>'',  # line 218
'You do not have enough rights'=>'',  # line 257
'Effort of task|page type'    =>'',  # line 70
'Edit this effort'            =>'',  # line 88
'Mark this effort as bookmark'=>'',  # line 97
'Project|label'               =>'',  # line 358
'Task|label'                  =>'',  # line 375
'No task related'             =>'',  # line 375
'Created by|label'            =>'',  # line 382
'Created at|label'            =>'',  # line 388
'Duration|label'              =>'',  # line 394
'Time start|label'            =>'',  # line 392
'Time end|label'              =>'',  # line 393
'No description available'    =>'',  # line 430
'Multiple Efforts|page type'  =>'',  # line 270
'Multiple Efforts'            =>'',  # line 291

### ../pages/item.inc.php   ###
'summary'                     =>'',  # line 1168

### ../pages/effort.inc.php   ###
'Information'                 =>'',  # line 307
'Number of efforts|label'     =>'',  # line 316
'Sum of efforts|label'        =>'',  # line 320
'from|time label'             =>'',  # line 327
'to|time label'               =>'',  # line 328
'Time|label'                  =>'',  # line 332
'New Effort'                  =>'',  # line 452

### ../pages/file.inc.php   ###
'only expected one task. Used the first one.'=>'',  # line 374

### ../pages/effort.inc.php   ###
'Edit Effort|page type'       =>'',  # line 583
'Edit Effort|page title'      =>'',  # line 597
'New Effort|page title'       =>'',  # line 600
'Date / Duration|Field label when booking time-effort as duration'=>'',  # line 642

### ../pages/file.inc.php   ###
'For task'                    =>'',  # line 186

### ../pages/version.inc.php   ###
'Publish to'                  =>'',  # line 119

### ../pages/effort.inc.php   ###
'Could not get effort'        =>'',  # line 727
'Could not get project of effort'=>'',  # line 743
'Could not get person of effort'=>'',  # line 749

### ../pages/version.inc.php   ###
'Name required'               =>'',  # line 198

### ../pages/effort.inc.php   ###
'Cannot start before end.'    =>'',  # line 818
'Select some efforts to delete'=>'',  # line 852
'Failed to delete %s efforts' =>'',  # line 871
'Moved %s efforts to trash'   =>'',  # line 874

### ../pages/error.inc.php   ###
'Error|top navigation tab'    =>'',  # line 29
'Unknown Page'                =>'',  # line 32

### ../pages/file.inc.php   ###
'Could not access parent task Id:%s'=>'',  # line 53

### ../std/constant_names.inc.php   ###
'File'                        =>'',  # line 129

### ../pages/task_view.inc.php   ###
'Item-ID %d'                  =>'',  # line 1019

### ../pages/file.inc.php   ###
'Edit this file'              =>'',  # line 116
'Move this file to another task'=>'',  # line 123
'Move'                        =>'',  # line 124
'Mark this file as bookmark'  =>'',  # line 132
'Upload new version|block title'=>'',  # line 154

### ../pages/task_view.inc.php   ###
'Upload'                      =>'',  # line 1216

### ../pages/file.inc.php   ###
'Version #%s (current): %s'   =>'',  # line 171
'Filesize'                    =>'',  # line 247
'Uploaded'                    =>'',  # line 249
'Uploaded by'                 =>'',  # line 192
'Version #%s : %s'            =>'',  # line 230
'Could not edit task'         =>'',  # line 383
'Edit File|page type'         =>'',  # line 428
'Edit File|page title'        =>'',  # line 438
'New file|page title'         =>'',  # line 441
'Could not get file'          =>'',  # line 563
'Could not get project of file'=>'',  # line 570
'Please enter a proper filename'=>'',  # line 607
'Select some files to delete' =>'',  # line 660
'Failed to delete %s files'   =>'',  # line 679
'Moved %s files to trash'     =>'',  # line 682
'Select some file to display' =>'',  # line 720
'Select some files to move'   =>'',  # line 760
'Can not edit file %s'        =>'',  # line 814
'insufficient rights to edit any of the selected items'=>'',  # line 825
'Edit files'                  =>'',  # line 849
'Select folder to move files into'=>'',  # line 851
'No folders available'        =>'',  # line 885

### ../pages/task_more.inc.php   ###
'(or select nothing to move to project root)'=>'',  # line 1512

### ../render/render_misc.inc.php   ###
'Today'                       =>'',  # line 730

### ../pages/playground.inc.php   ###
'Personal Efforts'            =>'',  # line 205
'At Home'                     =>'',  # line 212

### ../pages/home.inc.php   ###
'Functions'                   =>'',  # line 65
'View your efforts'           =>'',  # line 76
'Edit your profile'           =>'',  # line 77
'Projects'                    =>'',  # line 110

### ../pages/project_more.inc.php   ###
'<b>NOTE</b>: Some projects are hidden from your view. Please ask an administrator to adjust you rights to avoid double-creation of projects'=>'',  # line 94
'create new project'          =>'',  # line 97
'not assigned to a project'   =>'',  # line 100

### ../pages/home.inc.php   ###
'You have no open tasks'      =>'',  # line 149
'Open tasks assigned to you'  =>'',  # line 154
'Open tasks (including unassigned)'=>'',  # line 157
'All open tasks'              =>'',  # line 160
'Select lines to use functions at end of list'=>'',  # line 172
'P|column header'             =>'',  # line 176
'S|column header'             =>'',  # line 183
'Folder|column header'        =>'',  # line 196
'Modified|column header'      =>'',  # line 214
'Est.|column header estimated time'=>'',  # line 222
'Edit|context menu function'  =>'',  # line 241
'status->Completed|context menu function'=>'',  # line 248
'status->Approved|context menu function'=>'',  # line 256
'status->Closed|context menu function'=>'',  # line 264
'Delete|context menu function'=>'',  # line 273
'Log hours for select tasks|context menu function'=>'',  # line 281
'%s tasks with estimated %s hours of work'=>'',  # line 309

### ../pages/item.inc.php   ###
'Select some items(s) to change pub level'=>'',  # line 61
'itemsSetPubLevel requires item_pub_level'=>'',  # line 68
'Made %s items public to %s'  =>'',  # line 86

### ../pages/task_more.inc.php   ###
'%s error(s) occured'         =>'',  # line 1913

### ../pages/item.inc.php   ###
'No item(s) selected.'        =>'',  # line 916
'Select one or more bookmark(s)'=>'',  # line 222
'Removed %s bookmark(s).'     =>'',  # line 197
'ERROR: Cannot remove %s bookmark(s). Please try again.'=>'',  # line 201
'An error occured'            =>'',  # line 246
'Edit bookmark: "%s"|page title'=>'',  # line 365
'Bookmark: "%s"'              =>'',  # line 366
'Notify if unchanged in'      =>'',  # line 696
'Could not get bookmark'      =>'',  # line 432
'Added %s bookmark(s).'       =>'',  # line 813
'Edit bookmarks'              =>'',  # line 573
'Edit multiple bookmarks|page title'=>'',  # line 575
'Edit %s bookmark(s)'         =>'',  # line 576
'no'                          =>'',  # line 674
'yes'                         =>'',  # line 675

### ../pages/task_more.inc.php   ###

### ../pages/item.inc.php   ###
'Edited %s bookmark(s).'      =>'',  # line 817
'%s bookmark(s) could not be added.'=>'',  # line 821
'changes'                     =>'',  # line 994
'date1 should be smaller than date2. Swapped'=>'',  # line 1018
'item has not been edited history'=>'',  # line 1026
'unknown'                     =>'',  # line 1104
' -- '                        =>'',  # line 1126
'prev change'                 =>'',  # line 1138
'next'                        =>'',  # line 1154
'Item did not exists at %s'   =>'',  # line 1200
'no changes between %s and %s'=>'',  # line 1203

### ../std/constant_names.inc.php   ###
'undefined'                   =>'',  # line 159

### ../pages/item.inc.php   ###
'ok'                          =>'',  # line 1295

### ../pages/login.inc.php   ###
'Login|tab in top navigation' =>'',  # line 26

### ../render/render_page.inc.php   ###
'Go to your home. Alt-h / Option-h'=>'',  # line 225

### ../pages/login.inc.php   ###
'License|tab in top navigation'=>'',  # line 32

### ../render/render_page.inc.php   ###
'Your projects. Alt-P / Option-P'=>'',  # line 231

### ../pages/login.inc.php   ###
'Welcome to streber|Page title'=>'',  # line 81
'please login'                =>'',  # line 100
'Nickname|label in login form'=>'',  # line 336
'Password|label in login form'=>'',  # line 109
'I forgot my password'        =>'',  # line 337
'Continue anonymously'        =>'',  # line 114
'invalid login|message when login failed'=>'',  # line 229
'Password reminder|Page title'=>'',  # line 307
'Please enter your nickname'  =>'',  # line 319
'We will then sent you an E-mail with a link to adjust your password.'=>'',  # line 329
'If you do not know your nickname, please contact your administrator: %s.'=>'',  # line 331
'If you remember your name, please enter it and try again.'=>'',  # line 368
'A notification mail has been sent.'=>'',  # line 390
'Welcome %s. Please adjust your profile and insert a good password to activate your account.'=>'',  # line 411
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter your name and use the <b>forgot password link</b> below.'=>'',  # line 417
'License|page title'          =>'',  # line 440

### ../pages/misc.inc.php   ###
'Could not find requested page `%s`'=>'',  # line 47
'Select some items to restore'=>'',  # line 216
'Item %s does not need to be restored'=>'',  # line 228
'Failed to restore %s items'  =>'',  # line 241
'Restored %s items'           =>'',  # line 244
'Admin|top navigation tab'    =>'',  # line 269
'System information'          =>'',  # line 275
'Admin'                       =>'',  # line 276
'Database Type'               =>'',  # line 334
'Error-Log'                   =>'',  # line 345
'PHP Version'                 =>'',  # line 347
'extension directory'         =>'',  # line 350
'loaded extensions'           =>'',  # line 352
'include path'                =>'',  # line 354
'register globals'            =>'',  # line 356
'magic quotes gpc'            =>'',  # line 358
'magic quotes runtime'        =>'',  # line 360
'safe mode'                   =>'',  # line 362
'hide'                        =>'',  # line 479

### ../pages/person.inc.php   ###
'Active People'               =>'',  # line 55
'relating to %s|page title add on listing pages relating to current user'=>'',  # line 390
'People/Project Overview'     =>'',  # line 431
'no related persons'          =>'',  # line 442
'Persons|Pagetitle for person list'=>'',  # line 135
'relating to %s|Page title Person list title add on'=>'',  # line 306
'admin view|Page title add on if admin'=>'',  # line 309
'Employees|Pagetitle for person list'=>'',  # line 221
'Contact Persons|Pagetitle for person list'=>'',  # line 304
'Deleted People'              =>'',  # line 388
'Create Note|Tooltip for page function'=>'',  # line 511
'Note|Page function person'   =>'',  # line 512
'Add existing companies to this person'=>'',  # line 517
'Edit this person|Tooltip for page function'=>'',  # line 528
'Profile|Page function edit person'=>'',  # line 529
'Edit User Rights|Tooltip for page function'=>'',  # line 536
'User Rights|Page function for edit user rights'=>'',  # line 537
'Mark this person as bookmark'=>'',  # line 545
'notification:'               =>'',  # line 559

### ../pages/task_view.inc.php   ###
'Summary|Block title'         =>'',  # line 243

### ../pages/person.inc.php   ###
'Mobile|Label mobilephone of person'=>'',  # line 591
'Office|label for person'     =>'',  # line 594
'Private|label for person'    =>'',  # line 597
'Fax (office)|label for person'=>'',  # line 600
'Website|label for person'    =>'',  # line 605
'Personal|label for person'   =>'',  # line 608
'E-Mail|label for person office email'=>'',  # line 612
'E-Mail|label for person personal email'=>'',  # line 615
'Adress Personal|Label'       =>'',  # line 620
'Adress Office|Label'         =>'',  # line 627
'Birthdate|Label'             =>'',  # line 634
'works for|List title'        =>'',  # line 649
'link existing Company'       =>'',  # line 677
'no companies related'        =>'',  # line 682
'no company'                  =>'',  # line 684
'Person details'              =>'',  # line 694
'works in Projects|list title for person projects'=>'',  # line 730
'no active projects'          =>'',  # line 744
'Assigned tasks'              =>'',  # line 762
'No open tasks assigned'      =>'',  # line 763
'Efforts|Page title add on'   =>'',  # line 805
'no efforts yet'              =>'',  # line 833
'not allowed to edit'         =>'',  # line 1273
'Edit Person|Page type'       =>'',  # line 1902
'Person with account (can login)|form label'=>'',  # line 1954
'Account'                     =>'',  # line 976
'Password|form label'         =>'',  # line 1968
'confirm Password|form label' =>'',  # line 1972
'-- reset to...--'            =>'',  # line 1021
'Profile|form label'          =>'',  # line 1026
'daily'                       =>'',  # line 1988
'each 3 days'                 =>'',  # line 1989
'each 7 days'                 =>'',  # line 1990
'each 14 days'                =>'',  # line 1991
'each 30 days'                =>'',  # line 1992
'Never'                       =>'',  # line 1993
'Send notifications|form label'=>'',  # line 1999
'Send mail as html|form label'=>'',  # line 2000
'- no -'                      =>'',  # line 1057
'Assigne to project|form label'=>'',  # line 1066
'Options'                     =>'',  # line 1120
'Theme|form label'            =>'',  # line 2009
'Language|form label'         =>'',  # line 2013
'Time zone|form label'        =>'',  # line 2021

### ../pages/projectperson.inc.php   ###
'start times and end times'   =>'',  # line 133
'duration'                    =>'',  # line 134
'Log Efforts as'              =>'',  # line 137

### ../pages/person.inc.php   ###
'Create another person after submit'=>'',  # line 1168

### ../pages/task_more.inc.php   ###
'Invalid checksum for hidden form elements'=>'',  # line 777

### ../pages/person.inc.php   ###
'Malformed activation url'    =>'',  # line 1225
'Could not get person'        =>'',  # line 1833
'The changed profile <b>does not affect existing project roles</b>! Those has to be adjusted inside the projects.'=>'',  # line 1314
'Sending notifactions requires an email-address.'=>'',  # line 1655
'Using auto detection of time zone requires this user to relogin.'=>'',  # line 1388
'Nickname has been converted to lowercase'=>'',  # line 1433
'Nickname has to be unique'   =>'',  # line 1439
'Passwords do not match'      =>'',  # line 1454
'Password is too weak (please add numbers, special chars or length)'=>'',  # line 1469
'Login-accounts require a unique nickname'=>'',  # line 1483
'A notification / activation  will be mailed to <b>%s</b> when you log out.'=>'',  # line 1509

### ../render/render_wiki.inc.php   ###
'Read more about %s.'         =>'',  # line 1088

### ../pages/person.inc.php   ###
'Person %s created'           =>'',  # line 1549
'Could not insert object'     =>'',  # line 1552
'Select some persons to delete'=>'',  # line 1599
'<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'=>'',  # line 1616
'Failed to delete %s persons' =>'',  # line 1628
'Moved %s persons to trash'   =>'',  # line 1631
'Insufficient rights'         =>'',  # line 1649
'Since the user does not have the right to edit his own profile and therefore to adjust his password, sending an activation does not make sense.'=>'',  # line 1661
'Sending an activation mail does not make sense, until the user is allowed to login. Please adjust his profile.'=>'',  # line 1666
'Activation mail has been sent.'=>'',  # line 1677
'Sending notification e-mail failed.'=>'',  # line 1680
'Select some persons to notify'=>'',  # line 1701
'Failed to mail %s persons'   =>'',  # line 1726
'Sent notification to %s person(s)'=>'',  # line 1729
'Select some persons to edit' =>'',  # line 1755
'Could not get Person'        =>'',  # line 1759
'Edit Person|page type'       =>'',  # line 1775
'Adjust user-rights'          =>'',  # line 1777
'Please consider that activating login-accounts might trigger security-issues.'=>'',  # line 1787
'Person can login|form label' =>'',  # line 1793
'User rights changed'         =>'',  # line 1865
'Registering is not enabled'  =>'',  # line 1890
'Please provide information, why you want to register.'=>'',  # line 1895
'Register as a new user'      =>'',  # line 1903
'Add related companies'       =>'',  # line 2057
'No companies selected...'    =>'',  # line 2158
'Company already related to person'=>'',  # line 2134
'Failed to remove %s companies'=>'',  # line 2198
'Removed %s companies'        =>'',  # line 2201
'Marked all previous items as viewed.'=>'',  # line 2251

### ../pages/project_more.inc.php   ###
'Your Active Projects'        =>'',  # line 46
'relating to %s'              =>'',  # line 196
'Your Closed Projects'        =>'',  # line 130
'not assigned to a closed project'=>'',  # line 166
'no project templates'        =>'',  # line 230
'all'                         =>'',  # line 577
'modified by me'              =>'',  # line 284
'modified by others'          =>'',  # line 309
'last logout'                 =>'',  # line 334
'1 week'                      =>'',  # line 352
'2 weeks'                     =>'',  # line 371
'changed project-items'       =>'',  # line 531
'no changes yet'              =>'',  # line 532
'my open'                     =>'',  # line 621
'for milestone'               =>'',  # line 657
'needs approval'              =>'',  # line 716
'without milestone'           =>'',  # line 740
'Create a new folder for tasks and files'=>'',  # line 940

### ../pages/task_view.inc.php   ###
'new subtask for this folder' =>'',  # line 143

### ../render/render_page.inc.php   ###
'Filter-Preset:'              =>'',  # line 366

### ../pages/project_more.inc.php   ###
'No tasks'                    =>'',  # line 1170
'Create a new page'           =>'',  # line 1111

### ../pages/task_view.inc.php   ###
'Page'                        =>'',  # line 1097

### ../pages/task_more.inc.php   ###
'new Effort'                  =>'',  # line 2124

### ../pages/project_more.inc.php   ###
'Upload file|block title'     =>'',  # line 1246
'new Milestone'               =>'',  # line 1333
'View open milestones'        =>'',  # line 1359
'View closed milestones'      =>'',  # line 1365
'Project Efforts'             =>'',  # line 1407
'Released Versions'           =>'',  # line 1497
'New released Version'      =>'',  # line 1516
'Tasks resolved in upcomming version'=>'',  # line 1551
'Company|form label'          =>'',  # line 1668

### ../pages/task_more.inc.php   ###
'Display'                     =>'',  # line 681

### ../pages/project_more.inc.php   ###
'Create another project after submit'=>'',  # line 1728
'Select some projects to delete'=>'',  # line 1907
'Failed to delete %s projects'=>'',  # line 1927
'Moved %s projects to trash'  =>'',  # line 1930
'Select some projects...'     =>'',  # line 1950
'Invalid project-id!'         =>'',  # line 1960
'Y-m-d'                       =>'',  # line 1965
'Failed to change %s projects'=>'',  # line 1975
'Closed %s projects'          =>'',  # line 1979
'Reactivated %s projects'     =>'',  # line 1982
'Select new team members'     =>'',  # line 2016
'Found no persons to add. Go to `People` to create some.'=>'',  # line 2060
'Add'                         =>'',  # line 2072
'Could not access person by id'=>'',  # line 2104
'Reanimated person as team-member'=>'',  # line 2150
'Person already in project'   =>'',  # line 2154
'Template|as addon to project-templates'=>'',  # line 2237
'Failed to insert new project person. Data structure might have been corrupted'=>'',  # line 2350
'Failed to insert new issue. DB structure might have been corrupted.'=>'',  # line 2368
'Failed to update new task. DB structure might have been corrupted.'=>'',  # line 2423
'Failed to insert new comment. DB structure might have been corrupted.'=>'',  # line 2520
'Project duplicated (including %s items)'=>'',  # line 2541

### ../pages/project_view.inc.php   ###
'Mark this project as bookmark'=>'',  # line 97
'Book effort for this project'=>'',  # line 154
'Comments on project'         =>'',  # line 433

### ../pages/projectperson.inc.php   ###
'Edit Team Member'            =>'',  # line 46
'role of %s in %s|edit team-member title'=>'',  # line 47
'Role in this project'        =>'',  # line 115
'Changed role of <b>%s</b> to <b>%s</b>'=>'',  # line 222
'Failed to remove %s members from team'=>'',  # line 291
'Unassigned %s team member(s) from project'=>'',  # line 294

### ../pages/search.inc.php   ###
'in'                          =>'',  # line 349
'on'                          =>'',  # line 460
'cannot jump to this item type'=>'',  # line 608
'Due to the implementation of MySQL following words cannot be searched and have been ignored: %s'=>'',  # line 660
'Sorry, but there is nothing left to search.'=>'',  # line 665
'jumped to best of %s search results'=>'',  # line 680
'Add an ! to your search request to jump to the best result.'=>'',  # line 688
'%s search results for `%s`'  =>'',  # line 706
'No search results for `%s`'  =>'',  # line 709
'Searching'                   =>'',  # line 711
'Sorry. Could not find anything.'=>'',  # line 719
'Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters'=>'',  # line 720

### ../pages/task_more.inc.php   ###
'No project selected?'        =>'',  # line 85

### ../pages/version.inc.php   ###
'New Version'                 =>'',  # line 32

### ../pages/task_more.inc.php   ###
'Please select only one item as parent'=>'',  # line 138
'Insufficient rights for parent item.'=>'',  # line 142
'could not find project'      =>'',  # line 164
'Parent task not found.'      =>'',  # line 169
'Select some task(s) to edit' =>'',  # line 249
'You do not have enough rights to edit this task'=>'',  # line 257
'Edit %s|Page title'          =>'',  # line 282
'New milestone'               =>'',  # line 289
'New task'                    =>'',  # line 1322
'for %s|e.g. new task for something'=>'',  # line 294
'Display as'                  =>'',  # line 354
'This folder has %s subtasks. Changing category will ungroup them.'=>'',  # line 358
'-- next released version --' =>'',  # line 391

### ../pages/task_view.inc.php   ###
'Prio|Form label'             =>'',  # line 860
'- select person -'           =>'',  # line 819
'Assign to'                   =>'',  # line 840
'Assign to|Form label'        =>'',  # line 851
'Also assign to|Form label'   =>'',  # line 852
'Resolved in'                 =>'',  # line 793

### ../pages/task_more.inc.php   ###
'Bug Report'                  =>'',  # line 566
'Severity|Form label, attribute of issue-reports'=>'',  # line 612
'Reproducibility|Form label, attribute of issue-reports'=>'',  # line 613
'Timing'                      =>'',  # line 629

### ../pages/task_view.inc.php   ###
'30 min'                      =>'',  # line 869
'1 h'                         =>'',  # line 870
'2 h'                         =>'',  # line 871
'4 h'                         =>'',  # line 872
'1 Day'                       =>'',  # line 873
'2 Days'                      =>'',  # line 874
'3 Days'                      =>'',  # line 875
'4 Days'                      =>'',  # line 876
'1 Week'                      =>'',  # line 877
'1,5 Weeks'                   =>'',  # line 878
'2 Weeks'                     =>'',  # line 879
'3 Weeks'                     =>'',  # line 880

### ../pages/task_more.inc.php   ###
'Release as version|Form label, attribute of issue-reports'=>'',  # line 663
'Create another task after submit'=>'',  # line 737
'Comment has been rejected, because it looks like spam.'=>'',  # line 841
'Failed to add comment'       =>'',  # line 848
'Not enough rights to edit task'=>'',  # line 881
'unassigned to %s|task-assignment comment'=>'',  # line 993
'formerly assigned to %s|task-assigment comment'=>'',  # line 3306
'task was already assigned to %s'=>'',  # line 1017
'Failed to retrieve parent task'=>'',  # line 1082
'Task requires name'          =>'',  # line 2062
'Task called %s already exists'=>'',  # line 1119
'Milestones may not have sub tasks'=>'',  # line 1147
'Turned parent task into a folder. Note, that folders are only listed in tree'=>'',  # line 1153
'Failed, adding to parent-task'=>'',  # line 1157
'NOTICE: Ungrouped %s subtasks to <b>%s</b>'=>'',  # line 1178
'Created task %s with ID %s'  =>'',  # line 3401
'Changed task %s with ID %s'  =>'',  # line 1291
'Marked %s tasks to be resolved in this version.'=>'',  # line 1309
'Select some tasks to move'   =>'',  # line 2173
'Can not move task <b>%s</b> to own child.'=>'',  # line 1424
'Can not edit tasks %s'       =>'',  # line 1433
'Select folder to move tasks into'=>'',  # line 1464
'Failed to delete task %s'    =>'',  # line 1573
'Moved %s tasks to trash'     =>'',  # line 1579
' ungrouped %s subtasks to above parents.'=>'',  # line 1582
'No task(s) selected for deletion...'=>'',  # line 1591
'Could not find task'         =>'',  # line 1952
'Task <b>%s</b> does not need to be restored'=>'',  # line 1625
'Task <b>%s</b> restored'     =>'',  # line 1665
'Failed to restore Task <b>%s</b>'=>'',  # line 1668
'Task <b>%s</b> do not need to be restored'=>'',  # line 1660
'No task(s) selected for restoring...'=>'',  # line 1679
'Select some task(s) to mark as completed'=>'',  # line 1697
'Marked %s tasks (%s subtasks) as completed.'=>'',  # line 1740
'Select some task(s) to mark as approved'=>'',  # line 2511
'Marked %s tasks as approved and hidden from project-view.'=>'',  # line 1782
'Select some task(s) to mark as closed'=>'',  # line 1804
'Marked %s tasks as closed.'  =>'',  # line 1825
'Not enough rights to close %s tasks.'=>'',  # line 1827
'Select some task(s) to reopen'=>'',  # line 1843
'Reopened %s tasks.'          =>'',  # line 1862
'Select some task(s)'         =>'',  # line 1885
'Could not update task'       =>'',  # line 1901
'No task selected to add issue-report?'=>'',  # line 1932
'Task already has an issue-report'=>'',  # line 1936
'Adding issue-report to task' =>'',  # line 1946
'Select a task to edit description'=>'',  # line 1973
'Edit description'            =>'',  # line 1994
'Task Efforts'                =>'',  # line 2115
'For editing all tasks must be of same project.'=>'',  # line 2239
'Edit multiple tasks|Page title'=>'',  # line 2275
'Edit %s tasks|Page title'    =>'',  # line 2277
'keep different'              =>'',  # line 2464
'Category'                    =>'',  # line 2317
'Prio'                        =>'',  # line 2381
'none'                        =>'',  # line 2471

### ../pages/task_view.inc.php   ###
'next released version'       =>'',  # line 781

### ../pages/task_more.inc.php   ###
'resolved in Version'         =>'',  # line 2426
'Resolve Reason'              =>'',  # line 2445
'select person'               =>'',  # line 2477
'Also assigned to'            =>'',  # line 2478
'%s tasks could not be written'=>'',  # line 2780
'Updated %s tasks tasks'      =>'',  # line 2783
'ERROR: could not get Person' =>'',  # line 2930
'Select a note to edit'       =>'',  # line 2921
'Note'                        =>'',  # line 2948
'Create new note'             =>'',  # line 2951
'New Note on %s, %s'          =>'',  # line 2957
'Publish to|Form label'       =>'',  # line 2986
'ERROR: could not get project'=>'',  # line 3264
'Assigned Projects'           =>'',  # line 3019
'- no assigend projects'      =>'',  # line 3015
'Company Projects'            =>'',  # line 3041
'- no company projects'       =>'',  # line 3031
'All other Projects'          =>'',  # line 3059
'- no other projects'         =>'',  # line 3056
'For Project|form label'      =>'',  # line 3065
'New project|form label'      =>'',  # line 3070
'Project name|form label'     =>'',  # line 3071
'ERROR: could not get assigned persons'=>'',  # line 3087
'Also assign to'              =>'',  # line 3123
'Book effort after submit'    =>'',  # line 3127
'ERROR: could not get task'   =>'',  # line 3165
'Note requires project'       =>'',  # line 3217
'Note requires assigned person(s)'=>'',  # line 3221

### ../pages/task_view.inc.php   ###
'Edit this task'              =>'',  # line 1032
'Move|page function to move current task'=>'',  # line 1039
'new bug for this folder'     =>'',  # line 174
'new task for this milestone' =>'',  # line 166
'Mark this task as bookmark'  =>'',  # line 197
'Delete this task'            =>'',  # line 1047
'Restore this task'           =>'',  # line 1056
'Undelete'                    =>'',  # line 1057
'Released as|Label in Task summary'=>'',  # line 256
'For Milestone|Label in Task summary'=>'',  # line 267
'Status|Label in Task summary'=>'',  # line 274
'Opened|Label in Task summary'=>'',  # line 278
'Estimated|Label in Task summary'=>'',  # line 281
'Completed|Label in Task summary'=>'',  # line 290
'Planned start|Label in Task summary'=>'',  # line 295
'Planned end|Label in Task summary'=>'',  # line 299
'Closed|Label in Task summary'=>'',  # line 304
'Created|Label in Task summary'=>'',  # line 1144
'Modified|Label in Task summary'=>'',  # line 1148
'View previous %s versions'   =>'',  # line 1157
'Logged effort|Label in task-summary'=>'',  # line 339
'Publish to|Label in Task summary'=>'',  # line 1168
'Set to Open'                 =>'',  # line 1171
'Further Documentation'       =>'',  # line 383
'Attached files'              =>'',  # line 1210
'attach new'                  =>'',  # line 1212
'Severity|label in issue-reports'=>'',  # line 503
'Reproducibility|label in issue-reports'=>'',  # line 510
'Plattform'                   =>'',  # line 516
'OS'                          =>'',  # line 519
'Build'                       =>'',  # line 525
'Steps to reproduce|label in issue-reports'=>'',  # line 530
'Expected result|label in issue-reports'=>'',  # line 534
'Suggested Solution|label in issue-reports'=>'',  # line 538
'Issue report'                =>'',  # line 546
'Sub tasks'                   =>'',  # line 566
'Open tasks for milestone'    =>'',  # line 589
'No open tasks for this milestone'=>'',  # line 592
'1 Comment'                   =>'',  # line 1278
'%s Comments'                 =>'',  # line 1281
'Comment / Update'            =>'',  # line 692
'quick edit'                  =>'',  # line 723
'Update'                      =>'',  # line 764
'Public to'                   =>'',  # line 803
'Book Effort'                 =>'',  # line 1109

### ../pages/version.inc.php   ###
'Edit Version|page type'      =>'',  # line 79
'Edit Version|page title'     =>'',  # line 88
'New Version|page title'      =>'',  # line 91
'Could not get version'       =>'',  # line 148
'Could not get project of version'=>'',  # line 164
'Select some versions to delete'=>'',  # line 229
'Failed to delete %s versions'=>'',  # line 248
'Moved %s versions to dumpster'=>'',  # line 251
'Version|page type'           =>'',  # line 290
'Edit this version'           =>'',  # line 311
'Mark this version as bookmark'=>'',  # line 320

### ../render/render_fields.inc.php   ###
'<b>%s</b> is not a known format for date.'=>'',  # line 307

### ../render/render_form.inc.php   ###
'Please copy the text'        =>'',  # line 62
'Sorry. To reduce the efficiency of spam bots, guests have to copy the text'=>'',  # line 64
'Wiki format'                 =>'',  # line 416
'Submit'                      =>'',  # line 578
'Cancel'                      =>'',  # line 618
'Apply'                       =>'',  # line 628

### ../render/render_list.inc.php   ###
'for milestone %s'            =>'',  # line 186
'changed today'               =>'',  # line 430
'changed since yesterday'     =>'',  # line 433
'changed since <b>%d days</b>'=>'',  # line 436
'changed since <b>%d weeks</b>'=>'',  # line 439
'created by %s'               =>'',  # line 715
'created by unknown'          =>'',  # line 718
'modified by %s'              =>'',  # line 741
'modified by unknown'         =>'',  # line 744
'item #%s has undefined type' =>'',  # line 767
'do...'                       =>'',  # line 1024

### ../render/render_list_column_special.inc.php   ###
'Tasks|short column header'   =>'',  # line 226
'Number of open tasks is hilighted if shown home.'=>'',  # line 227
'Status|Short status column header'=>'',  # line 273
'Status is %s'                =>'',  # line 291
'Item is published to'        =>'',  # line 330
'Pub|column header for public level'=>'',  # line 331
'Publish to %s'               =>'',  # line 347
'Select / Deselect'           =>'',  # line 364

### ../render/render_misc.inc.php   ###
'With Account|page option'    =>'',  # line 430
'Other Persons|page option'   =>'',  # line 434
'Clients|page option'         =>'',  # line 461
'Prospective Clients|page option'=>'',  # line 465
'Suppliers|page option'       =>'',  # line 469
'Partners|page option'        =>'',  # line 473
'Companies|page option'       =>'',  # line 268
'Tasks|Project option'        =>'',  # line 374
'Docu|Project option'         =>'',  # line 380
'Milestones|Project option'   =>'',  # line 387
'Versions|Project option'     =>'',  # line 395
'Files|Project option'        =>'',  # line 404
'Efforts|Project option'      =>'',  # line 411
'History|Project option'      =>'',  # line 417
'Employees|page option'       =>'',  # line 438
'Contact Persons|page option' =>'',  # line 442
'Deleted|page option'         =>'',  # line 446
'All Companies|page option'   =>'',  # line 457
'Active'                      =>'',  # line 488
'Templates'                   =>'',  # line 496
'%b %e, %Y|strftime format string'=>'',  # line 579
'%I:%M%P|strftime format string'=>'',  # line 592
'%a %b %e, %Y %I:%M%P|strftime format string'=>'',  # line 601
'new since last logout'       =>'',  # line 784
'%s weeks'                    =>'',  # line 823
'%s days'                     =>'',  # line 819
'%s hours'                    =>'',  # line 815
'%s min'                      =>'',  # line 696
'Yesterday'                   =>'',  # line 736
'estimated %s hours'          =>'',  # line 851
'%s hours max'                =>'',  # line 853
'estimated %s days'           =>'',  # line 860
'%s days max'                 =>'',  # line 863
'estimated %s weeks'          =>'',  # line 872
'%s weeks max'                =>'',  # line 874
'%2.0f%% completed'           =>'',  # line 878
'%A, %B %e|strftime format string'=>'',  # line 921

### ../render/render_page.inc.php   ###
'<span class=accesskey>H</span>ome'=>'',  # line 222
'<span class=accesskey>P</span>rojects'=>'',  # line 229
'Your related People'         =>'',  # line 238
'Your related Companies'      =>'',  # line 244
'Calendar'                    =>'',  # line 249
'<span class=accesskey>S</span>earch:&nbsp;'=>'',  # line 254
'Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`'=>'',  # line 257
'This page requires java-script to be enabled. Please adjust your browser-settings.'=>'',  # line 565
'Add Now'                     =>'',  # line 626
'you are'                     =>'',  # line 710
'Go to parent / alt-U'        =>'',  # line 990
'Documentation and Discussion about this page'=>'',  # line 961
'Help'                        =>'',  # line 963
'rendered in'                 =>'',  # line 1316
'memory used'                 =>'',  # line 1319
'%s queries / %s fields '     =>'',  # line 1322

### ../render/render_wiki.inc.php   ###
'from'                        =>'',  # line 366
'Image details'               =>'',  # line 997
'Unknown File-Id:'            =>'',  # line 1010
'Unknown project-Id:'         =>'',  # line 1020
'Cannot link to item of type %s'=>'',  # line 1075
'Wiki-format: <b>%s</b> is not a valid link-type'=>'',  # line 1087
'No task matches this name exactly'=>'',  # line 1157
'This task seems to be related'=>'',  # line 1158
'No item excactly matches this name.'=>'',  # line 1185
'List %s related tasks'       =>'',  # line 1186
'identical'                   =>'',  # line 1194
'No item matches this name. Create new task with this name?'=>'',  # line 1228
'No item matches this name.'  =>'',  # line 1204
'No item matches this name'   =>'',  # line 1255
'Unknown Item Id'             =>'',  # line 1351

### ../std/class_auth.inc.php   ###
'Cookie is no longer valid for this computer.'=>'',  # line 51
'Your IP-Address changed. Please relogin.'=>'',  # line 57
'Your account has been disabled. '=>'',  # line 63
'Invalid anonymous user'      =>'',  # line 94
'Anonymous account has been disabled. '=>'',  # line 100
'Unable to automatically detect client time zone'=>'',  # line 262
'Could not set cookie.'       =>'',  # line 304
'Sorry. Authentication failed'=>'',  # line 373

### ../std/class_pagehandler.inc.php   ###
'Operation aborted (%s)'      =>'',  # line 742
'Operation aborted with an fatal error (%s).'=>'',  # line 745
'Operation aborted with an fatal error which was cause by an programming error (%s).'=>'',  # line 748
'Insuffient rights'           =>'',  # line 757
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'',  # line 761

### ../std/common.inc.php   ###
'Sorry, but the entered number did not match'=>'',  # line 236
'No element selected? (could not find id)|Message if a function started without items selected'=>'',  # line 374
'only one item expected.'     =>'',  # line 385
'en_US.utf8,en_US,enu|list of locales'=>'',  # line 482

### ../std/constant_names.inc.php   ###
'template|status name'        =>'',  # line 18
'undefined|status_name'       =>'',  # line 19
'upcoming|status_name'        =>'',  # line 20
'new|status_name'             =>'',  # line 21
'open|status_name'            =>'',  # line 22
'blocked|status_name'         =>'',  # line 23
'done?|status_name'           =>'',  # line 24
'approved|status_name'        =>'',  # line 25
'closed|status_name'          =>'',  # line 26
'Member|profile name'         =>'',  # line 32
'Admin|profile name'          =>'',  # line 33
'Project manager|profile name'=>'',  # line 34
'Developer|profile name'      =>'',  # line 35
'Artist|profile name'         =>'',  # line 36
'Tester|profile name'         =>'',  # line 37
'Client|profile name'         =>'',  # line 38
'Client trusted|profile name' =>'',  # line 39
'Guest|profile name'          =>'',  # line 40
'undefined|pub_level_name'    =>'',  # line 47
'private|pub_level_name'      =>'',  # line 48
'suggested|pub_level_name'    =>'',  # line 49
'internal|pub_level_name'     =>'',  # line 50
'open|pub_level_name'         =>'',  # line 51
'client|pub_level_name'       =>'',  # line 52
'client_edit|pub_level_name'  =>'',  # line 53
'assigned|pub_level_name'     =>'',  # line 54
'owned|pub_level_name'        =>'',  # line 55
'priv|short for public level private'=>'',  # line 62
'int|short for public level internal'=>'',  # line 64
'pub|short for public level client'=>'',  # line 66
'PUB|short for public level client edit'=>'',  # line 67
'A|short for public level assigned'=>'',  # line 68
'O|short for public level owned'=>'',  # line 69
'Enable Efforts|Project setting'=>'',  # line 74
'Enable Milestones|Project setting'=>'',  # line 75
'Enable Versions|Project setting'=>'',  # line 76
'Only PM may close tasks|Project setting'=>'',  # line 77
'Create projects|a user right'=>'',  # line 83
'Edit projects|a user right'  =>'',  # line 84
'Delete projects|a user right'=>'',  # line 85
'Edit project teams|a user right'=>'',  # line 86
'View anything|a user right'  =>'',  # line 87
'Edit anything|a user right'  =>'',  # line 88
'Create Persons|a user right' =>'',  # line 90
'Create & Edit Persons|a user right'=>'',  # line 91
'Delete Persons|a user right' =>'',  # line 92
'View all Persons|a user right'=>'',  # line 93
'Edit User Rights|a user right'=>'',  # line 94
'Edit own profile|a user right'=>'',  # line 95
'Create Companies|a user right'=>'',  # line 97
'Edit Companies|a user right' =>'',  # line 98
'Delete Companies|a user right'=>'',  # line 99
'undefined|priority'          =>'',  # line 105
'urgent|priority'             =>'',  # line 106
'high|priority'               =>'',  # line 107
'normal|priority'             =>'',  # line 108
'lower|priority'              =>'',  # line 109
'lowest|priority'             =>'',  # line 110
'Team Member'                 =>'',  # line 122
'Employment'                  =>'',  # line 124
'Issue'                       =>'',  # line 125
'Task assignment'             =>'',  # line 130
'Nitpicky|severity'           =>'',  # line 137
'Feature|severity'            =>'',  # line 138
'Trivial|severity'            =>'',  # line 139
'Text|severity'               =>'',  # line 140
'Tweak|severity'              =>'',  # line 141
'Minor|severity'              =>'',  # line 142
'Major|severity'              =>'',  # line 143
'Crash|severity'              =>'',  # line 144
'Block|severity'              =>'',  # line 145
'Not available|reproducabilty'=>'',  # line 150
'Always|reproducabilty'       =>'',  # line 151
'Sometimes|reproducabilty'    =>'',  # line 152
'Have not tried|reproducabilty'=>'',  # line 153
'Unable to reproduce|reproducabilty'=>'',  # line 154
'done|Resolve reason'         =>'',  # line 160
'fixed|Resolve reason'        =>'',  # line 161
'works_for_me|Resolve reason' =>'',  # line 162
'duplicate|Resolve reason'    =>'',  # line 163
'bogus|Resolve reason'        =>'',  # line 164
'rejected|Resolve reason'     =>'',  # line 165
'deferred|Resolve reason'     =>'',  # line 166
'Not defined|release type'    =>'',  # line 172
'Not planned|release type'    =>'',  # line 173
'Upcomming|release type'      =>'',  # line 174
'Internal|release type'       =>'',  # line 175
'Public|release type'         =>'',  # line 176
'Without support|release type'=>'',  # line 177
'No longer supported|release type'=>'',  # line 178
'undefined|company category'  =>'',  # line 184
'client|company category'     =>'',  # line 185
'prospective client|company category'=>'',  # line 186
'supplier|company category'   =>'',  # line 187
'partner|company category'    =>'',  # line 188
'undefined|person category'   =>'',  # line 194
'- employee -|person category'=>'',  # line 195
'staff|person category'       =>'',  # line 196
'freelancer|person category'  =>'',  # line 197
'working student|person category'=>'',  # line 198
'apprentice|person category'  =>'',  # line 199
'intern|person category'      =>'',  # line 200
'ex-employee|person category' =>'',  # line 201
'- contact person -|person category'=>'',  # line 202
'client|person category'      =>'',  # line 203
'prospective client|person category'=>'',  # line 204
'supplier|person category'    =>'',  # line 205
'partner|person category'     =>'',  # line 206
'Task|Task Category'          =>'',  # line 213
'Bug|Task Category'           =>'',  # line 214
'Documentation|Task Category' =>'',  # line 215
'Event|Task Category'         =>'',  # line 216
'Folder|Task Category'        =>'',  # line 217
'Milestone|Task Category'     =>'',  # line 218
'Version|Task Category'       =>'',  # line 219
'never|notification period'   =>'',  # line 225
'one day|notification period' =>'',  # line 226
'two days|notification period'=>'',  # line 227
'three days|notification period'=>'',  # line 228
'four days|notification period'=>'',  # line 229
'five days|notification period'=>'',  # line 230
'one week|notification period'=>'',  # line 231
'two weeks|notification period'=>'',  # line 232
'three weeks|notification period'=>'',  # line 233
'one month|notification period'=>'',  # line 234
'two months|notification period'=>'',  # line 235

### ../std/mail.inc.php   ###
'Failure sending mail: %s'    =>'',  # line 49
'Streber Email Notification|notifcation mail from'=>'',  # line 572
'Updates at %s|notication mail subject'=>'',  # line 116
'Hello %s,|notification'      =>'',  # line 607
'with this automatically created e-mail we want to inform you that|notification'=>'',  # line 135
'since %s'                    =>'',  # line 140
'following happened at %s |notification'=>'',  # line 147
'Your account has been created.|notification'=>'',  # line 157
'Please set a password to activate it.|notification'=>'',  # line 159
'You have been assigned to projects:|notification'=>'',  # line 174
'Changed monitored items:|notification'=>'',  # line 229
'%s edited > %s'              =>'',  # line 239
'Unchanged monitored items:|notification'=>'',  # line 267
'%s (not touched since %s day(s))'=>'',  # line 322
'Project Updates'             =>'',  # line 431
'If you do not want to get further notifications or you forgot your password feel free to|notification'=>'',  # line 451
'adjust your profile|notification'=>'',  # line 453
'Thanks for your time|notication'=>'',  # line 618
'the management|notication'   =>'',  # line 619
'No news for <b>%s</b>'       =>'',  # line 541
'Your account at|notification'=>'',  # line 593
'Your account at %s is still active.|notification'=>'',  # line 610
'Your login name is|notification'=>'',  # line 611
'Maybe you want to %s set your password|notification'=>'',  # line 612




);



?>