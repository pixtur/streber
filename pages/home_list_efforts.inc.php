<?php if(!function_exists('startedIndexPhp')) { header("location:../index.php"); exit();}
# streber - a php5 based project management system  (c) 2005-2007  / www.streber-pm.org
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**\file
 * Pages under Home
 *
 * @author Thomas Mann
 */


require_once(confGet('DIR_STREBER') . 'db/class_task.inc.php');
require_once(confGet('DIR_STREBER') . 'db/class_project.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_list.inc.php');
require_once(confGet('DIR_STREBER') . 'render/render_form.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_tasks.inc.php');
require_once(confGet('DIR_STREBER') . 'lists/list_project_team.inc.php');


/**
* display efforts for current user  @ingroup pages
*
* @NOTE 
* - actually this is an excact copy for personViewEfforts
* - this is of course not a good solution, but otherwise the breadcrumbs would change
*
*/
function homeListEfforts()
{
    global $PH;
    global $auth;
    require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
    require_once(confGet('DIR_STREBER') . 'lists/list_efforts.inc.php');

    
    ### get current project ###
    $person= $auth->cur_user;
        
    $presets= array(
        ### all ###
        'all_efforts' => array(
            'name'=> __('all'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_NEW,
                    'max'       => EFFORT_STATUS_BALANCED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),

        ### new efforts ###
        'new_efforts' => array(
            'name'=> __('new'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_NEW,
                    'max'       => EFFORT_STATUS_NEW,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### open efforts ###
        'open_efforts' => array(
            'name'=> __('open'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_OPEN,
                    'max'       => EFFORT_STATUS_OPEN,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### discounted efforts ###
        'discounted_efforts' => array(
            'name'=> __('discounted'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_DISCOUNTED,
                    'max'       => EFFORT_STATUS_DISCOUNTED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### not chargeable efforts ###
        'notchargeable_efforts' => array(
            'name'=> __('not chargeable'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_NOTCHARGEABLE,
                    'max'       => EFFORT_STATUS_NOTCHARGEABLE,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ### balanced efforts ###
        'balanced_efforts' => array(
            'name'=> __('balanced'),
            'filters'=> array(
                'effort_status'=> array(
                    'id'        => 'effort_status',
                    'visible'   => true,
                    'active'    => true,
                    'min'       => EFFORT_STATUS_BALANCED,
                    'max'       => EFFORT_STATUS_BALANCED,
                ),
            ),
            'list_settings' => array(
                'tasks' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            )
        ),
        
        ## last logout ##
        'last_logout' => array(
            'name'=> __('last logout'),
            'filters'=> array(
                'last_logout'   => array(
                    'id'        => 'last_logout',
                    'visible'   => true,
                    'active'    => true,
                    'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
        
        ## 1 week ##
        'last_week' => array(
            'name'=> __('1 week'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
                    'visible'   => true,
                    'active'    => true,
                    'factor'    => 7,
                    'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
        
        ## 2 weeks ##
        'last_two_weeks' => array(
            'name'=> __('2 weeks'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
                    'visible'   => true,
                    'active'    => true,
                    'factor'    => 14,
                    'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
        
        ## 3 weeks ##
        'last_three_weeks' => array(
            'name'=> __('3 weeks'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
                    'visible'   => true,
                    'active'    => true,
                    'factor'    => 21,
                    'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
        
        ## 1 month ##
        'last_month' => array(
            'name'=> __('1 month'),
            'filters'=> array(
                'last_weeks'    => array(
                    'id'        => 'last_weeks',
                    'visible'   => true,
                    'active'    => true,
                    'factor'    => 28,
                    'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
        
        ## prior ##
        'prior' => array(
            'name'=> __('prior'),
            'filters'=> array(
                'prior'    => array(
                    'id'        => 'prior',
                    'visible'   => true,
                    'active'    => true,
                    'factor'    => 29,
                    'value'     => $auth->cur_user->id,
                ),
            ),
            'list_settings' => array(
                'changes' =>array(
                    'hide_columns'  => array(''),
                    'style'=> 'list',
                )
            ),
        ),
    );

    ## set preset location ##
    $preset_location = 'homeListEfforts';
    
    ### get preset-id ###
    {
        $preset_id= 'all_efforts';                           # default value
        if($tmp_preset_id= get('preset')) {
            if(isset($presets[$tmp_preset_id])) {
                $preset_id= $tmp_preset_id;
            }

            ### set cookie
            setcookie(
                'STREBER_homeListEfforts_preset',
                $preset_id,
                time()+60*60*24*30,
                '',
                '',
                0);
        }
        else if($tmp_preset_id= get('STREBER_homeListEfforts_preset')) {
            if(isset($presets[$tmp_preset_id])) {

                $preset_id= $tmp_preset_id;
            }
        }
    }
    ### create from handle ###
    $PH->defineFromHandle(array('person'=>$person->id, 'preset_id' =>$preset_id));

    ### set up page ####
    {
        $page= new Page();
        $page->cur_tab='home';
        $page->title=__("Your efforts");
        $page->title_minor=__('Efforts','Page title add on');
        $page->type=__("Person");

        #$page->crumbs = build_person_crumbs($person);
        $page->options= build_home_options($person);

        echo(new PageHeader);
    }
    echo (new PageContentOpen);



    #--- list efforts --------------------------------------------------------------------------
    {
        $order_by=get('sort_'.$PH->cur_page->id."_efforts");

        require_once(confGet('DIR_STREBER') . 'db/class_effort.inc.php');
        /*$efforts= Effort::getAll(array(
            'person'    => $person->id,
            'order_by'  => $order_by,
        ));*/

        $list= new ListBlock_efforts();
        unset($list->functions['effortNew']);
        unset($list->functions['effortNew']);
        $list->no_items_html= __('no efforts yet');
        
        $list->filters[] = new ListFilter_efforts();
        {
            $preset = $presets[$preset_id];
            foreach($preset['filters'] as $f_name=>$f_settings) {
                switch($f_name) {
                    case 'effort_status':
                        $list->filters[]= new ListFilter_effort_status_min(array(
                            'value'=>$f_settings['min'],
                        ));
                        $list->filters[]= new ListFilter_effort_status_max(array(
                            'value'=>$f_settings['max'],
                        ));
                        break;
                    case 'last_logout':
                        $list->filters[]= new ListFilter_last_logout(array(
                            'value'=>$f_settings['value'],
                        ));
                        break;
                    case 'last_weeks':
                        $list->filters[]= new ListFilter_min_week(array(
                            'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
                        ));
                        break;
                    case 'prior':
                        $list->filters[]= new ListFilter_max_week(array(
                            'value'=>$f_settings['value'], 'factor'=>$f_settings['factor']
                        ));
                        break;
                    default:
                        trigger_error("Unknown filter setting $f_name", E_USER_WARNING);
                        break;
                }
            }
    
            $filter_empty_folders =  (isset($preset['filter_empty_folders']) && $preset['filter_empty_folders'])
                                  ? true
                                  : NULL;
        }
        
        $page->print_presets(array(
        'target' => $preset_location,
        'project_id' => '',
        'preset_id' => $preset_id,
        'presets' => $presets,
        'person_id' => $person->id));
        
        $list->query_options['order_by'] = $order_by;
        $list->query_options['person'] = $person->id;
        $list->print_automatic();
        
        //$list->render_list($efforts);
    }
    
    echo '<input type="hidden" name="person" value="'.$person->id.'">';

    echo (new PageContentClose);
    echo (new PageHtmlEnd());
}
?>
