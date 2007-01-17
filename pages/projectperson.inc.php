<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit;}
# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html


/**
*
* editing persons in project
*
*/


require_once(confGet('DIR_STREBER') . "db/class_task.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_project.inc.php");
require_once(confGet('DIR_STREBER') . "db/class_projectperson.inc.php");
require_once(confGet('DIR_STREBER') . "render/render_list.inc.php");



function projectPersonEdit($pp= NULL)
{
    global $PH;

    if(!$pp) {
        $id= getOnePassedId('projectperson','projectpersons_*', true, 'No team member selected?');   # WARNS if multiple; ABORTS if no id found
        if(!$pp= ProjectPerson::getEditableById($id)) {
            $PH->abortWarning("ERROR: could not get Project Person");
            return;
        }
    }

    ### get project ###
    if(!$project= Project::getVisibleById($pp->project)) {
        $PH->abortWarning("ERROR: could not get project");
    }

    ### get person ###
    if(!$person= Person::getVisibleById($pp->person)) {
        $PH->abortWarning("ERROR: could not get person");
    }

    ### set up page and write header ####
    {
        $page= new Page(array('use_jscalendar'=>true, 'autofocus_field'=>'projectperson_name'));
    	$page->cur_tab='projects';
        $page->type=__("Edit Team Member");
        $page->title=sprintf(__("role of %s in %s","edit team-member title"),$person->name,$project->name);

        $page->crumbs=build_project_crumbs($project);
        $page->options[]= new NaviOption(array(
            'target_id' => 'projectPersonEdit',

        ));


        echo(new PageHeader);
    }
    echo (new PageContentOpen);

    ### write form #####
    {
        require_once(confGet('DIR_STREBER') . "render/render_form.inc.php");

        $form=new PageForm();
        $form->button_cancel=true;

        ### create an assoc with roles and find the current role ###
        {
            global $g_theme_names;
            global $g_user_profile_names;
            global $g_user_profiles;

            ### display "undefined" profile if rights changed ###

            $profile_num= 0;                                # will be skipped when submitting
            $reset="";
			$check = array_keys($g_user_profile_names);
			$number = count($g_user_profile_names);
			$count  = 0;

			for($i=0; $i < $number; $i++)
			{
				if($pp->role == $check[intval($i)])
				{
					$profile_num=$count;
					break;
				}
				$count++;
			}

            /*$profile_settings= $g_user_profiles[intval($profile_num)];

            $count=0;
			echo "LevelV: " . $pp->level_view . "<br>";
			echo "SetV: " . $profile_settings['level_view'] . "<br>";
			echo "LevelC: " . $pp->level_create . "<br>";
			echo "SetC: " . $profile_settings['level_create'] . "<br>";
			echo "LevelE: " . $pp->level_edit . "<br>";
			echo "SetE: " . $profile_settings['level_edit'] . "<br>";
			echo "LevelD: " . $pp->level_delete . "<br>";
			echo "SetV: " . $profile_settings['level_delete'] . "<br>";
            foreach($g_user_profiles as $profile_id => $profile_settings) {
                if($pp->level_view          == $profile_settings['level_view']
                    && $pp->level_create    == $profile_settings['level_create']
                    && $pp->level_edit      == $profile_settings['level_edit']
                    && $pp->level_delete    == $profile_settings['level_delete']
                ){
                    $profile_num=$count;
                    break;
                }
                $count++;
            }*/

            $form->add(new Form_Dropdown('person_profile',
                                        __("Role in this project"),
                                        array_flip($g_user_profile_names),
                                        $profile_num
            ));


        }

        $form->add($pp->fields['name']->getFormElement(&$pp));

        ### public-level ###
        if(($pub_levels=$pp->getValidUserSetPublevel())
            && count($pub_levels)>1) {
            $form->add(new Form_Dropdown('projectperson_pub_level',  __("Publish to"),$pub_levels,$pp->pub_level));
        }

        ### effort-style ###
        $effort_styles=array(
            __("start times and end times")=> 1,
            __("duration")=> 2,
        );

        $form->add(new Form_Dropdown('projectperson_effort_style',  __("Log Efforts as"), $effort_styles, $pp->adjust_effort_style));


        echo ($form);

        $PH->go_submit='projectPersonEditSubmit';
        echo "<input type=hidden name='projectperson' value='$pp->id'>";
        echo "<input type=hidden name='projectperson_project' value='$pp->project'>";
    }
    echo (new PageContentClose);
}


function projectPersonEditSubmit()
{
    global $PH;

    ### cancel ###
    if(get('form_do_cancel')) {
        if(!$PH->showFromPage()) {
            $PH->show('projView',array('prj'=>$pp->project));
        }
        exit;
    }

    if(!validateFormCrc()) {
        $PH->abortWarning(__('Invalid checksum for hidden form elements'));
    }

    ### get projectperson ####
    $id= getOnePassedId('projectperson',true,'invalid id');

    if($id == 0) {
        $pp= new ProjectPerson(array('id'=>0));
    }
    else {
        $pp= new ProjectPerson($id);
        if(!$pp) {
            $PH->abortWarning("Could not get project person");
            return;
        }
    }

    ### get project ###
    if(!$project= new Project($pp->project)) {
        $PH->abortWarning("ERROR: could not get project",ERROR_FATAL);
    }

    ### get person ###
    if(!$person= new Person($pp->person)) {
        $PH->abortWarning("ERROR: could not get project",ERROR_FATAL);
    }

    # retrieve all possible values from post-data
    # NOTE:
    # - this could be an security-issue.
    # - TODO: as some kind of form-edit-behaviour to field-definition
    foreach($pp->fields as $f) {
        $name=$f->name;
        $f->parseForm(&$pp);
    }



    ### set rights role ###
    /**
    * if profile != 0, it will OVERWRITE (or reinit) user_rights
    *
    * therefore persEdit set profil to 0 if rights don't fit profile. It will
    * then be skipped here
    */
    if($profile=intval(get('person_profile'))) {

        global $g_user_profile_names;
        global $g_user_profiles;

        #if($profile_settings= $g_user_profiles[$g_user_profile_names[$profile]]) {
        if($profile_settings= $g_user_profiles[$profile]) {
            $pp->level_view = $profile_settings['level_view'];
            $pp->level_edit = $profile_settings['level_edit'];
            $pp->level_create = $profile_settings['level_create'];
            $pp->level_delete = $profile_settings['level_delete'];
            $pp->level_reduce = $profile_settings['level_reduce'];

            $pp->role=$profile;
            new FeedbackMessage(sprintf(__('Changed role of <b>%s</b> to <b>%s</b>'), $person->name,$g_user_profile_names[$profile]));
        }
        else {
            trigger_error("undefined profile requested.", E_USER_WARNING);
        }
    }

    ### pub level ###
    if($pub_level=get('projectperson_pub_level')) {
        if($pp->id) {
             if($pub_level > $pp->getValidUserSetPublevel() ) {
                 $PH->abortWarning('invalid data',ERROR_RIGHTS);
             }
        }
        #else {
        #    #@@@ check for person create rights
        #}
        $pp->pub_level = $pub_level;
    }

    ### effort-style ###
    if($effort_style=get('projectperson_effort_style')) {
        $pp->adjust_effort_style= $effort_style;
    }


    ### write to db ###
    if($pp->id == 0) {
        $pp->insert();
    }
    else {
        $pp->update();
    }

    ### return to from-page ###
    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$pp->project));
    }
}


function projectPersonDelete()
{
    global $PH;

    ### get project person ####
    $ids= getPassedIds('projectperson','projectpersons_*');

    if(!$ids) {
        $PH->abortWarning("No team-member(s) selected?",ERROR_NOTE);
        return;
    }

    $counter=0;
    $errors=0;
    foreach($ids as $id) {
        $pp= ProjectPerson::getEditableById($id);

        if(!$pp) {
            $PH->abortWarning("Invalid project person-id!");
        }
        if($pp->delete()) {
            $counter++;
        }
        else {
            $errors++;
        }
    }
    if($errors) {
        new FeedbackWarning(sprintf(__("Failed to remove %s members from team"), $errors));
    }
    elseif($counter) {
        new FeedbackMessage(sprintf(__("Unassigned %s team member(s) from project"), $counter));
    }
    else {
        trigger_error('this should never happen');
    }

    if(!$PH->showFromPage()) {
        $PH->show('projView',array('prj'=>$pp->project));
    }
}


?>