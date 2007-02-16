<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html


/**
 * give defined constants names that can be translated
 *
 * @includedby:     *
 *
 * @author:         Thomas Mann
 * @uses:
 * @usedby:
 *
 */
global $g_status_names;
$g_status_names=array(
   STATUS_TEMPLATE  => __('template', 'status name'),
   STATUS_UNDEFINED => __('undefined','status_name'),
   STATUS_UPCOMING  => __('upcoming', 'status_name'),
   STATUS_NEW       => __('new',      'status_name'),
   STATUS_OPEN      => __('open',     'status_name'),
   STATUS_BLOCKED   => __('blocked',   'status_name'),
   STATUS_COMPLETED => __('done?',    'status_name'),
   STATUS_APPROVED  => __('approved', 'status_name'),
   STATUS_CLOSED    => __('closed',   'status_name'),
);


global $g_user_profile_names;
$g_user_profile_names=array(
    PROFILE_USER              => __('Member', 'profile name'),
    PROFILE_ADMIN             => __('Admin', 'profile name'),
    PROFILE_PM                => __('Project manager', 'profile name'),
    PROFILE_DEVELOPER         => __('Developer', 'profile name'),
    PROFILE_ARTIST            => __('Artist', 'profile name'),
    PROFILE_TESTER            => __('Tester', 'profile name'),
    PROFILE_CLIENT            => __('Client', 'profile name'),
    PROFILE_CLIENT_TRUSTED    => __('Client trusted', 'profile name'),
    PROFILE_GUEST             => __('Guest', 'profile name'),
);



global $g_pub_level_names;
$g_pub_level_names=array(
    PUB_LEVEL_NONE      =>__('undefined', 'pub_level_name'),
    PUB_LEVEL_PRIVATE   =>__('private', 'pub_level_name'),
    PUB_LEVEL_SUGGESTED =>__('suggested', 'pub_level_name'),
    PUB_LEVEL_INTERNAL  =>__('internal', 'pub_level_name'),
    PUB_LEVEL_OPEN      =>__('open', 'pub_level_name'),
    PUB_LEVEL_CLIENT    =>__('client', 'pub_level_name'),
    PUB_LEVEL_CLIENTEDIT=>__('client_edit', 'pub_level_name'),
    PUB_LEVEL_ASSIGNED  =>__('assigned', 'pub_level_name'),
    PUB_LEVEL_OWNED     =>__('owned', 'pub_level_name'),
);


global $g_pub_level_short_names;
$g_pub_level_short_names=array(
    PUB_LEVEL_NONE      =>'.',
    PUB_LEVEL_PRIVATE   =>__('priv','short for public level private'),
    PUB_LEVEL_SUGGESTED =>'?',
    PUB_LEVEL_INTERNAL  =>__('int','short for public level internal'),
    PUB_LEVEL_OPEN      =>' ',
    PUB_LEVEL_CLIENT    =>__('pub','short for public level client'),
    PUB_LEVEL_CLIENTEDIT=>__('PUB','short for public level client edit'),
    PUB_LEVEL_ASSIGNED  =>__('A','short for public level assigned'),
    PUB_LEVEL_OWNED     =>__('O','short for public level owned'),
);

global $g_project_setting_names;
$g_project_setting_names=array(
    PROJECT_SETTING_EFFORTS     =>__('Enable Efforts','Project setting'),
    PROJECT_SETTING_MILESTONES  =>__('Enable Milestones','Project setting'),
    PROJECT_SETTING_VERSIONS    =>__('Enable Versions','Project setting'),
    PROJECT_SETTING_ONLY_PM_MAY_CLOSE=>__('Only PM may close tasks','Project setting'),
);


global $g_user_right_names;
$g_user_right_names=array(
    RIGHT_PROJECT_CREATE     =>__('Create projects', 'a user right'),
    RIGHT_PROJECT_EDIT       =>__('Edit projects', 'a user right'),
    RIGHT_PROJECT_DELETE     =>__('Delete projects', 'a user right'),
    RIGHT_PROJECT_ASSIGN     =>__('Edit project teams', 'a user right'),
    RIGHT_VIEWALL            =>__('View anything', 'a user right'),
    RIGHT_EDITALL            =>__('Edit anything', 'a user right'),

    RIGHT_PERSON_CREATE      =>__('Create Persons', 'a user right'),
    RIGHT_PERSON_EDIT        =>__('Create & Edit Persons', 'a user right'),
    RIGHT_PERSON_DELETE      =>__('Delete Persons', 'a user right'),
    RIGHT_PERSON_VIEWALL     =>__('View all Persons', 'a user right'),
    RIGHT_PERSON_EDIT_RIGHTS =>__('Edit User Rights', 'a user right'),
    RIGHT_PERSON_EDIT_SELF   =>__('Edit Own Profil', 'a user right'),

    RIGHT_COMPANY_CREATE     =>__('Create Companies', 'a user right'),
    RIGHT_COMPANY_EDIT       =>__('Edit Companies', 'a user right'),
    RIGHT_COMPANY_DELETE     =>__('Delete Companies', 'a user right'),
);


global $g_prio_names;
$g_prio_names= array(
 PRIO_UNDEFINED => __('undefined','priority'),
 PRIO_URGENT    => __('urgent','priority'),
 PRIO_HIGH      => __('high','priority'),
 PRIO_NORMAL    => __('normal','priority'),
 PRIO_LOWER     => __('lower','priority'),
 PRIO_LOWEST    => __('lowest','priority'),
);


/**
* name of table in database
*/
global $g_item_type_names;
$g_item_type_names=array(
    ITEM_PROJECT    =>__('Project'),
    ITEM_TASK       =>__('Task'),
    ITEM_PERSON     =>__('Person'),
    ITEM_PROJECTPERSON=>__('Team Member'),
    ITEM_COMPANY    =>__('Company'),
    ITEM_EMPLOYMENT =>__('Employment'),
    ITEM_ISSUE      =>__('Issue'),
    ITEM_EFFORT     =>__('Effort'),
    ITEM_TASK_EFFORT=>__('Effort'),
    ITEM_COMMENT    =>__('Comment'),
    ITEM_FILE       =>__('File'),
    ITEM_TASKPERSON =>__('Task assignment'),
);


global $g_severity_names;
$g_severity_names=array(
SEVERITY_UNDEFINED    =>__('undefined'),
SEVERITY_NITPICKY     =>__('Nitpicky','severity'),
SEVERITY_FEATURE      =>__('Feature','severity'),
SEVERITY_TRIVIAL      =>__('Trivial','severity'),
SEVERITY_TEXT         =>__('Text','severity'),
SEVERITY_TWEAK        =>__('Tweak','severity'),
SEVERITY_MINOR        =>__('Minor','severity'),
SEVERITY_MAJOR        =>__('Major','severity'),
SEVERITY_CRASH        =>__('Crash','severity'),
SEVERITY_BLOCK        =>__('Block','severity'),
);

global $g_reproducibility_names;
$g_reproducibility_names=array(
REPRODUCIBILITY_UNDEFINED            => __('Not available','reproducabilty'),
REPRODUCIBILITY_ALWAYS               => __('Always','reproducabilty'),
REPRODUCIBILITY_SOMETIMES            => __('Sometimes','reproducabilty'),
REPRODUCIBILITY_HAVE_NOT_TRIED       => __('Have not tried','reproducabilty'),
REPRODUCIBILITY_UNABLE_TO_REPRODUCE  => __('Unable to reproduce','reproducabilty'),
);

global $g_resolve_reason_names;
$g_resolve_reason_names=array(
RESOLVED_UNDEFINED  =>  __('undefined'),
RESOLVED_DONE       =>  __('done', 'Resolve reason'),
RESOLVED_FIXED      =>  __('fixed','Resolve reason'),
RESOLVED_WORKS_FOR_ME=> __('works_for_me','Resolve reason'),
RESOLVED_DUPLICATE  =>  __('duplicate','Resolve reason'),
RESOLVED_BOGUS      =>  __('bogus','Resolve reason'),
RESOLVED_REJECTED   =>  __('rejected','Resolve reason'),
RESOLVED_DEFERRED   =>  __('deferred','Resolve reason'),
);


global $g_released_names;
$g_released_names=array(
RELEASED_UNDEFINED       => __('Not defined', 'release type'),
RELEASED_NOT_PLANNED     => __('Not planned',    'release type'),
RELEASED_UPCOMMING       => __('Upcomming',     'release type'),
RELEASED_INTERNAL        => __('Internal',      'release type'),
RELEASED_PUBLIC          => __('Public',        'release type'),
RELEASED_WITHOUT_SUPPORT   => __('Without support',  'release type'),
RELEASED_NO_LONGER_SUPPORTED   => __('No longer supported',  'release type'),
);

### company categories ###
global $g_ccategory_names;
$g_ccategory_names=array(
CCATEGORY_UNDEFINED 	=> __('undefined', 'company category'),
CCATEGORY_CLIENT 		=> __('client', 'company category'),
CCATEGORY_PROSCLIENT 	=> __('prospective client', 'company category'),
CCATEGORY_SUPPLIER 		=> __('supplier', 'company category'),
CCATEGORY_PARTNER 		=> __('partner', 'company category')
);

### person categories ###
global $g_pcategory_names;
$g_pcategory_names=array(
CCATEGORY_UNDEFINED		=> __('undefined', 'person category'),
PCATEGORY_EMPLOYEE 		=> __('- employee -', 'person category'),
PCATEGORY_STAFF 		=> __('staff', 'person category'),
PCATEGORY_FREELANCER	=> __('freelancer', 'person category'),
PCATEGORY_STUDENT		=> __('working student', 'person category'),
PCATEGORY_APPRENTICE	=> __('apprentice', 'person category'),
PCATEGORY_INTERN		=> __('intern', 'person category'),
PCATEGORY_EXEMPLOYEE	=> __('ex-employee', 'person category'),
PCATEGORY_CONTACT 		=> __('- contact person -', 'person category'),
PCATEGORY_CLIENT		=> __('client', 'person category'),
PCATEGORY_PROSCLIENT	=> __('prospective client', 'person category'),
PCATEGORY_SUPPLIER		=> __('supplier', 'person category'),
PCATEGORY_PARTNER		=> __('partner', 'person category'),
);


### task categories ###
global $g_tcategory_names;
$g_tcategory_names=array(
TCATEGORY_TASK          => __('Task','Task Category'),
TCATEGORY_BUG           => __('Bug','Task Category'),
TCATEGORY_DOCU          => __('Documentation','Task Category'),
TCATEGORY_EVENT         => __('Event','Task Category'),
TCATEGORY_FOLDER        => __('Folder','Task Category'),
TCATEGORY_MILESTONE     => __('Milestone','Task Category'),
TCATEGORY_VERSION       => __('Version','Task Category'),
);

### task categories ###
global $g_notifychange_period;
$g_notitychange_period = array(
NOTIFY_NEVER 	 => __('never','notification period'),
NOTIFY_1DAY 	 => __('one day','notification period'),
NOTIFY_2DAYS 	 => __('two days','notification period'),
NOTIFY_3DAYS     => __('three days','notification period'),
NOTIFY_4DAYS   	 => __('four days','notification period'),
NOTIFY_5DAYS     => __('five days','notification period'),
NOTIFY_1WEEK     => __('one week','notification period'),
NOTIFY_2WEEKS	 => __('two weeks','notification period'),
NOTIFY_3WEEKS    => __('three weeks','notification period'),
NOTIFY_1MONTH    => __('one month','notification period'),
NOTIFY_2MONTH    => __('two months','notification period'),
);

global $g_effort_status_names;
$g_effort_status_names = array(
EFFORT_STATUS_NEW          => __('new','effort status'),
EFFORT_STATUS_OPEN         => __('open','effort status'),
EFFORT_STATUS_DISCOUNTED   => __('discounted','effort status'),
EFFORT_STATUS_NOTCHARGEABLE=> __('not chargeable','effort status'),
EFFORT_STATUS_BALANCED     => __('balanced','effort status')
);
?>