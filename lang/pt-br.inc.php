<?php

# streber - a php5 based project management system  (c) 2005 Thomas Mann / thomas@pixtur.de
# Distributed under the terms and conditions of the GPL as stated in lang/license.html

/**
* language-table for Brazilian Portuguese translation (C) Flávio Veras
*/

global $g_lang_table;
$g_lang_table= array(

#--- top navigation tabs -------------------------------------------------------
'<span class=accesskey>H</span>ome'
                    =>'<span class=accesskey>P</span>rincipal',
'Go to your home. Alt-h / Option-h'
                    =>'Ir para seu Espaço. Alt-h / Option-h',
'<span class=accesskey>P</span>rojects'
                    =>'<span class=accesskey>P</span>rojetos',
'Your projects. Alt-P / Option-P' =>'Seus Projetos. Alt-P / Option-P',
'People'            =>'Usuários',
'Your related People'
                    =>'Usuários de seu relacionamento',
'Companies'         =>'Organizações',
'Your related Companies'
                    =>'Organizações de seu relacionamento',
'Calendar'          =>'Calendário',
'<span class=accesskey>S</span>earch:&nbsp;'
                    =>'<span class=accesskey>P</span>esquisa:&nbsp;',
"Click Tab for complex search or enter something and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`"
                    =>'Clique em Tab para uma pesquisa complexa ou introduza algo e clique em <ENTER>. Use ALT-S para cortar caminho. Use `Pesquisa!` para `Boa Sorte`',

#--- header --------------------------------------------------------------
'Wiki+Help'         =>'Wiki+Ajuda',
'Documentation and Discussion about this page'
                    =>'Documentação e Discussão sobre esta página',
'This page requires java-script to be enabled. Please adjust your browser-settings.'
                    =>'Esta página necessita que a java-script esteja habilidato. Por favor ajuste as suas configurações do browser.',
'you are'           =>'Voce é',

'How this page looks for clients'
                    =>'Aparência desta página para clientes',
'Client view'       =>'Visão de cliente',
'Logout'            =>'Sair',

#--- common texts --------------------------------------------------------------
'Task'              =>'Tarefa',
'Effort'            =>'Rotina',
'Comment'           =>'Comentário',
'Add Now'           =>'Adicionar Agora',

#--- home -----------------------------------------------------------------------
'Today'             =>'Hoje',
'Discussions'       =>'Discusões',
'At Home'           =>'Em casa',
'F, jS'            =>'F, jS',          # format date headline home
'Functions'         =>'Funções',
'View your efforts' =>'Visualizar seus empenhos',
'Edit your profile' =>'Editar o seu perfil',
'Your projects'     =>'Seus projetos',
'This is a tooltip' =>'?',
'Company'           =>'Organização',
'Project'           =>'Projeto',
'Select lines to use functions at end of list'
                    =>'Selecione linhas para usar funções no fim da lista',
'Priority'          =>'Prioridade',
'Edit'              =>'Edtar',
'Log hours for a project' =>'Hora conectadas a um projeto',
'Create new project'=>'Criar novo projeto',
'You have no open tasks'
                    =>'Voce não tem tarefas abertas',
'Open tasks'        =>'Tarefas abertas',
'Task-Status'       =>'Estado da Tarefa',
'Folder'            =>'Pasta',
'Started'           =>'Iniciada',
'Est.'              =>'Est.',
'Estimated time in hours'
                    =>'Tempo estimado em horas',
'status->Completed' =>'Estado->Completado',
'status->Approved'  =>'Estado->Aprovado',
'Delete'            =>'Elimidado',
'Log hours for select tasks'
                    =>'Horas ligadas a determinadas tarefas',
'%s tasks with estimated %s hours of work'
                    =>'%s Tarefas com %s horas estimadas de trabalho',


#--- pages/_handles.inc -------------
'Home'                        =>'Principal',
'Active Projects'             =>'Projetos Ativos',
'Closed Projects'             =>'Projetos Fechados',
'Project Templates'           =>'Modelos de Projeto',
'View Project'                =>'Visualizar Projeto',
'Closed tasks'                =>'Tarefas Fechadas',
'New Project'                 =>'Novo Projeto',
'Duplicate Project'           =>'Duplicar Projeto',
'Edit Project'                =>'Editar Projeto',
'Delete Project'              =>'Eliminar Projeto',
'Change Project Status'       =>'Trocar Estado de Projeto',
'Add Team member'             =>'Adicionar Membro de Equipe',
'Edit Team member'            =>'Editar Menbro de Equipe',
'Remove from team'            =>'Eliminar da Equipe',

'View Task'                   =>'Visualizar Tarefa',
'Edit Task'                   =>'Editar Tarefa',
'Delete Task(s)'              =>'Eliminar Tarefa(s)',
'Restore Task(s)'             =>'Restaurar Tarefa(s)',
'Move tasks to folder'        =>'Mover Tarefas para Pasta',
'Mark tasks as Complete'      =>'Marcar tarefa como Finalizada',
'Mark tasks as Approved'      =>'Marcar tarefa como Aprovada',
'New Task'                    =>'Nova Tarefa',
'Toggle view collapsed'       =>'Ajuste de visualização',
'Log hours'                   =>'Horas de conecção',
'Edit time effort'            =>'Editar tempo de empenho',
'Create comment'              =>'Criar comentário',
'Edit comment'                =>'Editar comentário',
'Delete comment'              =>'Eliminar comentário',
'Add issue/bug report'        =>'Adicionar relatório assunto/bug',
'List Companies'              =>'Listar Organizações',
'View Company'                =>'Visualizar Organização',
'New Company'                 =>'Nova Organização',
'Edit Company'                =>'Editar Organização',
'Delete Company'              =>'Eliminar Organização',
'Link Persons'                =>'Conectar Usuários',
'List Persons'                =>'Listar Usuários',
'View Person'                 =>'Visualizar Usuários',
'New Person'                  =>'Novo Usuário',
'Edit Person'                 =>'Editar Usuário',
'Edit User Rights'            =>'Editar Direitos de Usuário',
'Delete Person'               =>'Eliminar Usuário',
'View Efforts of Person'      =>'Visializar Esforço de Usuário',
'Login'                       =>'Conectar',
'License'                     =>'Licença',
'Error'                       =>'Erro',





### ../db/class_company.inc   ###
'Optional'                    =>'Opcional',
'more than expected'          =>'mais que o esperado',
'not available'               =>'não disponível',

### ../db/class_effort.inc   ###
'optional if tasks linked to this effort'=>'opcional se terefas conectadas a este empenho',

### ../db/class_person.inc   ###
'Full name'                   =>'Nome Completo',
'Nickname'                    =>'Apelido',

### ../lists/list_persons.inc   ###
'Tagline'                     =>'Tagline',

### ../db/class_person.inc   ###
'Mobile Phone'                =>'Telefone Móvel',
'Office Phone'                =>'Telefone do Escritório',
'Office Fax'                  =>'Fax do Escritório',
'Office Street'               =>'Rua do Escritório',
'Office Zipcode'              =>'CEP do Escritório',
'Office Page'                 =>'WebSite',
'Personal Phone'              =>'Telefone de Casa',
'Personal Fax'                =>'Fax de Casa',
'Personal Street'             =>'Endereço de Casa',
'Personal Zipcode'            =>'CEP de Casa',
'Personal Page'               =>'WebSite Privado',
'Personal E-Mail'             =>'E-Mail Privado',
'Birthdate'                   =>'Data de Aniversário',

### ../db/class_project.inc   ###
'Color'                       =>'Cor',

### ../lists/list_comments.inc   ###
'Comments'                    =>'Comentários',

### ../db/class_person.inc   ###
'Password'                    =>'Senha',

### ../lists/list_projects.inc   ###
'Name'                        =>'Nome',

### ../db/class_task.inc   ###
'Short'                       =>'Apelido',
'Planned Start'               =>'Início planejado',
'Planned End'                 =>'Término planejado',
'Date start'                  =>'Data de início',
'Date closed'                 =>'Data de término',
'Status'                      =>'Estado',
'Description'                 =>'Descrição',
'Completion'                  =>'Realização',
'Estimated'                   =>'Estimado',
'Date due'                    =>'Data programada',
'Date due end'                =>'Data de término programada',


### ../db/class_project.inc   ###
'Status summary'              =>'Sumário do Estado',
'Project page'                =>'Página do projeto',
'Wiki page'                   =>'Wiki-Site do projeto',
'show tasks in home'          =>'mostrar as tarefas em Princital',
'validating invalid item'     =>'validando itens inválidos',

### ../pages/comment.inc   ###
'insuffient rights'           =>'Direitos insuficientes',


### ../db/class_projectperson.inc   ###
'job'                         =>'Trabalho',
'role'                        =>'Papel',

### ../pages/task.inc   ###
'Label'                       =>'Etiqueta',

### ../pages/task.inc   ###
'task without project?'       =>'Tarefa sem Projeto?',

### ../db/db_item.inc   ###
'<b>%s</b> isn`t a known format for date.'=>'<b>%s</b> não é um formato para data',

### ../lists/list_tasks.inc   ###
'New'                         =>'Novo',
'Sum of all booked efforts (including subtasks)'=>'Soma de todos os empenhos agendados (incluindo sub-tarefas)',

### ../lists/list_comments.inc   ###
'Move to Folder'              =>'Mover para pasta',
'Shrink View'                 =>'Encolher visualização',
'Expand View'                 =>'Expandir visualização',
'Topic'                       =>'Tópico',

### ../lists/list_companies.inc   ###
'related companies'           =>'firmas relecionadas',

### ../lists/list_efforts.inc   ###
'S'                           =>'S',

### ../lists/list_persons.inc   ###
'Name Short'                  =>'Apelido',
'Shortnames used in other lists'=>'Nomes curtos usados em outras listas',

### ../pages/proj.inc   ###
'Phone'                       =>'Telefone',

### ../lists/list_companies.inc   ###
'Phone-Number'                =>'Telefone',
'Proj'                        =>'Proj',
'Number of open Projects'     =>'Número de Projetos abertos',
'people'                      =>'Usuário',
'People working for this person'=>'Usuários trabalhando para esta Organização',
'Edit company'                =>'Editar Organização',
'Delete company'              =>'Deletar Organização',
'Create new company'          =>'Criar nova Organização',

### ../lists/list_efforts.inc   ###
'person'                      =>'Usuário',

### ../lists/list_projects.inc   ###
'Task name. More Details as tooltips'=>'Nome de Tarefa. Mais detalhes como Tooltip.',

### ../lists/list_efforts.inc   ###
'Edit effort'                 =>'Editar empenho',
'New effort'                  =>'Novo Empenho',
'D, d.m.Y'                    =>'D, d.m.Y',

### ../lists/list_persons.inc   ###
'Mobil'                       =>'Mobil',

### ../pages/person.inc   ###
'Office'                      =>'Escritório',
'Private'                     =>'Privado',

### ../lists/list_persons.inc   ###
'Edit person'                 =>'Editar Usuário',
'Delete person'               =>'Eliminar Usuário',
'Create new person'           =>'Criar novo Usuário',

### ../lists/list_project_team.inc   ###
'Your related persons'        =>'Seus Relacionados Usuários',
'Rights'                      =>'Direitos',
'Persons rights in this project'=>'Direitos de Usuários neste Projeto',
'Edit team member'            =>'Editar membro de Equipe',
'Add team member'             =>'Adicionar membro a Equipe',
'Remove person from team'     =>'Eliminar membro da Equipe',
'Member'                      =>'Membro',
'Role'                        =>'Papel',

### ../pages/proj.inc   ###
'Changes'                     =>'Trocas',

### ../lists/list_tasks.inc   ###
'Created by'                  =>'Criado por',

### ../lists/list_projectchanges.inc   ###
'Item was originally created by'=>'O item foi originalmente criado por...',
'modified'                    =>'modificado',
'C'                           =>'C',
'Created,Modified or Deleted' =>'Criado, Modificado ou Eliminado',
'Deleted'                     =>'Eliminado',
'Modified'                    =>'Modificado',
'Created'                     =>'Criado',
'by Person'                   =>'por Usuário',
'Person who did the last change'=>'Usuário que fez a última troca',
'T'                           =>'T',
'Item of item: [T]ask, [C]omment, [E]ffort, etc '=>'Ítem do ítem [T]arefa, [C]omentário, [E]sforço',
'undefined item-type'=>'tipo de ítem indefinido',
'Del'                         =>'Del',
'shows if item is deleted'    =>'mostrar esse ítem como eliminado',
'deleted'                     =>'eliminado',

### ../lists/list_projects.inc   ###
'Status Summary'              =>'Sumário de Estado',
'Short discription of the current status'=>'Pequena descrição do estado atual',

### ../lists/list_tasks.inc   ###
'Tasks'                       =>'Tarefas',
'Tasks|short column header'   =>'A',
'%s open tasks / %s h'        =>'%s tarefas abertas / %s h',

### ../lists/list_projects.inc   ###
'Number of open Tasks'        =>'Número de Terefas Abertas',
'Opened'                      =>'Aberta',
'Day the Project opened'      =>'Dia em que o Projeto foi aberto',

### ../pages/proj.inc   ###
'Closed'                      =>'Fechado',

### ../lists/list_projects.inc   ###
'Day the Project state changed to closed'=>'Dia em que o estado do Projeto trocou para fechado',
'Edit project'                =>'Editar Projeto',
'Delete project'              =>'Eliminar Projeto',
'Open / Close'                =>'Abrir / Fechar',
'... working in project'      =>'... trabalhando no projeto',

### ../lists/list_taskfolders.inc   ###
'Folders'                     =>'Pastas',
'Select all, range, no row'   =>'Selecionar todos, intervalo, nenhuma linha',
'Number of subtasks'          =>'Número de sub-tarefas',
'Create new folder under selected task'=>'Criar nova pasta dentro da tarefa selecionada',

### ../lists/list_tasks.inc   ###
'Move selected to folder'     =>'Mover selecionada para pasta',
'Priority of task'            =>'Prioridade de tarefa',
'Status->Completed'           =>'Estado->Completada',
'Status->Approved'            =>'Estado->Aprovada',
'Name, Comments'              =>'Nome, Comentários',
'has %s comments'             =>'tem %s comentários',

### ../pages/person.inc   ###
'Efforts'                     =>'Esforços',

### ../lists/list_tasks.inc   ###
'Effort in hours'             =>'Esforços em horas',

### ../pages/comment.inc   ###
'New Comment'                 =>'Novo Comentário',
'Reply to '                   =>'Responder para ',
'Edit Comment'                =>'Editar Comentário',
'On task %s'                  =>'Na tarefa %s',
'On project %s'               =>'No projeto %s',
'Occasion'                    =>'Ocasionalmente',

### ../pages/task.inc   ###
'Publish to'                   =>'Público para',
'Edit this task'              =>'Editar esta tarefa',
'Append bug report'           =>'Acrescente o relatório de bug',
'Delete this task'            =>'Eliminar esta tarefaAufgabe löschen',
'Restore this task'           =>'Recuperar esta tarefa',

### ../pages/comment.inc   ###
'Select some comments to delete'=>'Selecionar alguns comentários para eliminar',
'Select some comments to move'=>'Selecionar alguns comentários para mover',

### ../pages/task.inc   ###
'Select excactly ONE folder to move tasks into'=>'Selecionar UMA pasta para mover as tarefas para ela.',

### ../pages/comment.inc   ###
'is no longer a reply'        =>'não é mais uma resposta',

### ../pages/company.inc   ###
'related projects of %s'     =>'Projetos relacionados de %s',

### ../pages/proj.inc   ###
'admin view'                  =>'Visualização de Admin',
'List'                        =>'Listar',

### ../pages/company.inc   ###
'no companies'                =>'nenhuma Organização',

### ../pages/proj.inc   ###
'Overview'                    =>'Resumo',

### ../pages/company.inc   ###
'Edit this company'           =>'Editar esta Organização',
'edit'                        =>'editar',
'Create new person for this company'=>'Criar um novo usuário para esta Organização',

### ../pages/person.inc   ###
'Person'                      =>'Usuário',

### ../pages/company.inc   ###
'Create new project for this company'=>'Criar um novo projeto para esta Organização',
'Add existing persons to this company'=>'Adicionar usuários existentes para essa Organização',
'Persons'                     =>'Usuários',

### ../pages/person.inc   ###
'Summary'                     =>'Sumário',
'Adress'                      =>'Endereço',
'Fax'                         =>'Fax',

### ../pages/company.inc   ###
'Web'                         =>'Web',
'Intra'                       =>'Intra',
'Mail'                        =>'E-Mail',
' Hint: for already existing projects please edit those and adjust company-setting.'
                                =>' Tip: para projetos existentes favor editar esses e ajuste a configuração da Organização..',
'no projects yet'             =>'ainda sem projetos',
'link existing Person'        =>'conectar usuário existente',
'create new'                  =>'criar novo',
'no persons related'          =>'nenhuma pessoa se relacionou',
'Create another company after submit'=>'Criar nova Organização após submeter',
'Edit %s'                     =>'Editar %s',
'Add persons employed or related'=>'Acrescentar usuários empregados ou relacionados',
'No persons selected...'=>'Nenhum usuário selecionado',
'Person already related to company'=>'Usuário já está relacionado com a Organização',
'Select some companies to delete'=>'Selecionar anguma Organização para eliminar',

### ../pages/effort.inc   ###
'New Effort'                  =>'Novo Empenho',
'only expected one task. Used the first one.'=>'esperado somente uma Tarefa. Usado a primeira.',
'For task'                    =>'Para Tarefa',
'Could not get effort'        =>'Incapaz de obter empenho',
'Could not get project of effort'=>'Incapaz de obter empenho do Projeto',
'Select some efforts to delete'=>'Selecionar anguns empenhos para eliminar.',

### ../pages/error.inc   ###
'Unknown Page'                =>'Página desconhecida',

### ../pages/home.inc   ###
'You are not assigned to a project.'=>'Voce não está inscrito no Projeto.',

### ../pages/login.inc   ###
'Welcome to streber'          =>'Bem Vindo ao Streber.',
'please login'                =>'Favor conectar-se',
'invalid login'               =>'Conecção inválida',

### ../pages/person.inc   ###
'Active People'               =>'Usuários Ativos',

### ../pages/proj.inc   ###
'relating to %s'              =>'relecionando a %s',

### ../pages/person.inc   ###
'With Account'                =>'Com a conta',
'All Persons'                 =>'Todos os usuários',
'no related persons'          =>'Usuários não relacionados',
'Edit this person'            =>'Editar esse Usuário',
'Profile'                     =>'Perfil',
'User Rights'                 =>'Direitos do Usuário',
'Mobile'                      =>'Movel',
'Website'                     =>'Website',
'Personal'                    =>'Pessoal',

### ../pages/proj.inc   ###
'E-Mail'                      =>'E-Mail',

### ../pages/person.inc   ###
'works for'                   =>'trabalha para a Organização',
'not related to a company'    =>'não relacionado a uma Organização',
'works in Projects'           =>'trabalhar nos Projetos',
'no active projects'          =>'Projetos não ativos',
'not allowed to edit'         =>'permissão de editar negada',
'Person can login'            =>'Usuário pode conectar-se',
'Theme'                       =>'Tema',
'Create another person after submit'=>'Criar outro Usuário após submeter',
'Could not get person'        =>'Incapaz de obter Usuário',
'Nickname has to be unique'=>'Apelido tem que ser único.',
'passwords don´t match'       =>'Senha não coincide',
'Login-accounts require a unique nickname'=>'Conta de conecção requer apelido único',
'Could not insert object'=>'Incapaz de inserir objeto',
'Select some persons to delete'=>'Selecionar alguns Usuários para eliminar',
'Adjust user-rights of %s'    =>'Ajustar direitos de usuário de %s ',
'Please consider that activating login-accounts might trigger security-issues.'
                              =>'Favor considerar que ativando contas de acesso pode ativar problemas com a segurança.',
'User rights changed'         =>'Direitos de Usuário trocados.',

### ../pages/proj.inc   ###
'Active'                      =>'Ativo',
'Templates'                   =>'Formatos',
'Your Active Projects'        =>'Seus Projetos Ativos',
'<b>NOTE</b>: Some projects are hidden from your view. Please ask an administrator to adjust you rights to avoid double-creation of projects'
                                =>'Alguns projetos são ocultos a sua visão. Por favor peça um administrador para ajustar seus direitos para evitar a criação dupla de projetos.',
'not assigned to a project'   =>'Não destinado a um projeto',
'Your Closed Projects'        =>'Seus Projetos fechados',
'invalid project-id'          =>'Inválida identidade(ID) de Projeto',
'Edit this project'           =>'Editar este Projeto',
'Add person as team-member to project'
                              =>'Acrescentar a Usuários como membro de equipe para projetar',
'Create task with issue-report'=>'Criar tarefa com o relatório de questões',
'Add Bugreport'               =>'Adicionar relatório de BUG',
'Book effort for this project'=>'Relação de Empenhos deste Projeto',
'Log Effort'                  =>'Log de Empenhos',
'Logged effort'               =>'Empenhos registrados no Log',
'Team members'                =>'Membros da Equipe',
'All open tasks'              =>'Todas as Tarefas Abertas',
'Comments on project'         =>'Comentários do Projeto',
'Project Efforts'             =>'Empenhos no Projeto',
'Closed Tasks'                =>'Tarefas fechadas',
'changed project-items'       =>'ítens de projeto trocados',
'no changes yet'              =>'não trocados ainda',
'Project Issues'              =>'Questões de Projeto',
'Report Bug'                  =>'Relatório de BUG',
'Select some projects to delete'=>'Selecionar alguns Projetos para eliminar',
'Failed to delete %s projects'=>'A eliminação dos Projetos %s falhou',
'Moved %s projects to trash'=>'Mover os projetos %s para a lixeira',
'Select some projects...'     =>'Selecinar alguns Projetos...',
'Invalid project-id!'         =>'Identidade(ID) de Projeto inválida',
'Y-m-d'                       =>'Y-m-d',
'Failed to change %s projects'=>'Falha na troca de %s dos Projetos',
'Closed %s projects'          =>'Projetos %s fechados',
'Select new team members'     =>'Selecionar novos membros de equipe',
'found no persons to add'     =>'não foi encontrado Usuários para adicionar',
'No persons selected...'      =>'Não foram selecionados Usuários.',
'Could not access person by id'=>'Imcapaz de acessar Usuário pela identidade(ID)',
'Reanimated person as team-member'=>'Usuário reinscrito como membro da equipe.',
'Person already in project'=>'Usuário já inscrito no Projeto',
'Failed to insert new project'=>'Campo para inserir novo Projeto.',
'Failed to insert new projectproject'=>'Campo para inserir novo Projeto do Projeto.',
'Failed to insert new issue'  =>'Campo para inserir nova questão',
'Failed to update new task'   =>'Campo para atualizar nova tarefa',
'Failed to insert new comment'=>'Campo para inserir novo comentário',

### ../pages/task.inc   ###
'Issue report'                =>'Relatório de Questões',
'Plattform'                   =>'Plataforma',
'OS'                          =>'OS',
'Version'                     =>'Versão',
'Build'                       =>'Concebido',
'Steps to reproduce'          =>'Paços para reproduzir',
'Expected result'             =>'Resultados esperados',
'Suggested Solution'          =>'Soluções Sugeridas',
'I guess you wanted to create a folder...'=>'Penso que você quis criar uma pasta...',
'Assumed <b>%s</b> to be mean label <b>%s</b>'=>'<b>%s</b> wurde als Etikett <b>%s</b> verwendet',
'No project selected?'        =>'Nenhum Projeto selecionado?',
'New Folder'                  =>'Nova Pasta',
'No task selected?'           =>'Nenhuma Tarefa selecionada',
'NOTICE: Ungrouped %s subtasks to <b>%s</b>'=>'NOTAR: Subtarefas %s desagrupadas para <b>%s</b>',
'HINT: You turned task <b>%s</b> into a folder. Folders are shown in the task-folders list.'              =>'LEMBRANÇA: Você tranformou a tarefa <b> %s </b> em uma pasta. Pastas são mostradas na lista de pastas de tarefa.',
'Select some tasks to move'   =>'Selecionar algumas Tarefas para mover.',
'Task <b>%s</b> deleted'           =>'Tarefas <b>%s</b> eliminadas.',
'Moved %s tasks to trash'=>'Mover terefas %s para lixeira.',
'<br> ungrouped %s subtasks to above parents.'=>'<br> subtarefas %s desagrupadas dos predecessores acima mencionados.',
'Could not retrieve task'=>'Não pode recuperar a Tarefa.',
'Task <b>%s</b> doesn´t need to be restored'=>'A tarefa <b> %s </b> não becessita ser restaurada.',
'Task <b>%s</b> restored'          =>'Terefa <b>%s</b> recuperada.',
'Failed to restore Task <b>%s</b>' =>'Falha na restauração da Tarefa <b>%s</b> .',
'Marked %s tasks as approved and hidden from project-view.'=>'Tarefas %s marcadas como aprovadas e ocultadas da visão de projeto',
'could not update task'       =>'incapz de atualizar a tarefa',
'No task selected to add issue-report?'=>'Nenhuma tarefa selecionada para acrescentar ao relatório de questões?',
'Task already has an issue-report'=>'A tarefa já tem um relatório de questões',
'Adding issue-report to task' =>'Adicionado relatório de questões a Tarefa',
'Could not get task'          =>'Incapas de acessar Tarefa',

### ../render/render_page.inc   ###
'Return to normal view'       =>'Retornando a visualização normal',
'Leave Client-View'           =>'Nível de visualização de Cliente',



### tooltips ###
'Required. Full name like (e.g. Thomas Mann)' =>'Requerido: Nome completo exemplo (ex. Thomas Mann)',
'Required. (e.g. pixtur)' =>'Requerido: Ex. pixtur',
'Optional: Additional tagline (eg. multimedia concepts)' =>'Opcional: Etiqueta adicional (Ex. solução multimídia)',
'Optional: Private Phone (eg. +49-30-12345678)' =>'Opicional: Telefone privado (Ex. +49-30-12345678)',
'Optional: Private Fax (eg. +49-30-12345678)' =>'Opcinal: Número de Fax Privado (Ex. +49-30-12345678)',
'Optional: Private (eg. Poststreet 28)' =>'Opicional: Ex. (Poststreet 28)',
'Optional: Private (eg. 12345 Berlin)' =>'Opicional: Ex. ( 12345 Berlin)',
'Optional: (eg. http://www.pixtur.de/login.php?name=someone)' =>'Opcional: Ex. http://www.pixtur.de/login.php?name=someone',
'show as folder (may contain other tasks)' =>'mostre como pasta (pode conter outras tarefas).',
'Project priority (the icons have tooltips, too)' =>'A prioridade de projeto (os ícones têm ferramenta tip, também)',
'Duplicate project' =>'Projeto Duplicado',
'Required. (e.g. pixtur ag)' =>'Requerido: Ex. Pixtur AG limited',
'Optional: Short name shown in lists (eg. pixtur)' =>'Opcional: nome curto mostrado em listas (ex. pixtur)',
'Optional: Phone (eg. +49-30-12345678)' =>'Opcional: Telefone (ex. +49-30-12345678)',
'Optional: Fax (eg. +49-30-12345678)' =>'Opcional: Fax (ex. +49-30-12345678)',
'Optional: (eg. Poststreet 28)' =>'Opcional: (ex. Posrua 28)',
'Optional: (eg. 12345 Berlin)' =>'Opcional: (ex. 12345 Berlin)',
'Optional: (eg. http://www.pixtur.de)' =>'Opcional: (ex. http://www.pixtur.de)',
'Optional: Private (eg. Poststreet 28)' =>'Opcional: Privado (ex. Poststreet 28)',
'Optional: (eg. Poststreet 28)' =>'Opcional: (ex. Poststreet 28)',

### in listen ###
'do...'                         =>'fazer...',
"Status is %s"                  =>'Estado: %s',
"Priority is %s"                =>'Prioridade: %s',


### ../pages/comment.inc   ###
'Failed to delete %s comments'=>'Falha para eliminar comentários de %s.',
'Moved %s comments to trash'=>'Movido os comentários %s para a lixeira.',

### ../pages/company.inc   ###
'Failed to delete %s companies'=>'Falha para eliminar firmas %s.',
'Moved %s companies to trash'=>'Movida Organizações %s para a lixeira.',

### ../pages/effort.inc   ###
'Failed to delete %s efforts'=>'Falha para eliminar empenhos %s.',
'Moved %s efforts to trash'=>'Movido empenhos %s para a lixeira.',

### ../pages/person.inc   ###
'passwords don´t match'       =>'Senhas não coincidem.',
'Failed to delete %s persons'=>'Flalhou para elimuinar usuários %s .',
'Moved %s persons to trash'=>'Movido Usuários %s para a lixeira.',

### ../pages/proj.inc   ###
'Issues'                      =>'Questionamentos',
'History'                     =>'História',



### ../db/db_item.inc   ###
'unnamed'                     =>'exonerado',

### ../lists/list_tasks.inc   ###
'New / Add'                   =>'Novo / Adicionar',

### ../pages/task.inc   ###
'Assigned to'                 =>'Designado para',

### ../lists/list_tasks.inc   ###
'- no name -|in task lists'   =>'- nenhum nome - |na lista de tarefas -',

### ../pages/company.inc   ###
'Active projects'             =>'Projetos Ativos',
'Closed projects'             =>'Projetos Fechados',

### ../pages/home.inc   ###
'Open tasks assigned to you'  =>'Tarefas abertas destinadas a você',

### ../pages/person.inc   ###
'Language'                    =>'Linguagem',
'passwords don´t match'       =>'Senhas não coincidem',
'Select some persons to edit' =>'Selecionar alguns Usúarios para editar',
'Could not get Person'        =>'Incapaz de encontrar Usuário',

### ../pages/proj.inc   ###
'Reactivated %s projects'     =>'Projetos %s Reativados',
'Failed to insert new projectperson'=>'Falha para inserir novo Usuário de Projeto',

### ../pages/projectperson.inc   ###
'Edit Team Member'            =>'Editar Membro de Equipe',
'role of %s in %s|edit team-member title'=>'total de %s em título de membro da equipe %s|editar',

### ../pages/task.inc   ###
'Assign to'                   =>'Designado para',
'Also assign to'              =>'Tambem designado para',
'formerly assigned to %s'     =>'anteriormente destinado a %s',
'task was already assigned to %s'=>'a tarefa já foi destinada a %s',
'Task requires name'          =>'A tarefa necessita nome',
' ungrouped %s subtasks to above parents.'=>'subtarefas %s não agrupadas ao parente acima',
'Task <b>%s</b> doesn´t need to be restored'=>'A tarefa <b> %s </b> não necessita ser restaurada',

### ../render/render_list_column_special.inc   ###
'Days until planned start'    =>'Dias até inicialização planejada',
'Due|concerning time'         =>'Tempo esperado',
'Number of open tasks is hilighted if shown home.'=>'O número de tarefas abertas é destacada se mostrada em home',
'Item is publish to'           =>'O item é público para',
'Pub|table-header, public'    =>'Pub|tabela-cabeçalho, público',
'Publish to %s'                =>'Público para %s',


### ../db/class_project.inc   ###
'insuffient rights (not in project)'=>'direitos insuficientes (não em projeto).',

### ../lists/list_persons.inc   ###
'(adjusted)'                  =>'(ajustado)',

### ../lists/list_projectchanges.inc   ###
'(on comment)'                =>'(no Comentário)',
'(on task)'                   =>'(na Tarefa)',
'(on project)'                =>'(no Projeto)',

### ../pages/_handles.inc   ###
'Create Template'             =>'Criar Modelo',
'Project from Template'       =>'Projetar de um Modelo',

### ../pages/home.inc   ###
'Open tasks (including unassigned)'=>'Tarefas abertas (inclusive não designadas)',

### ../pages/person.inc   ###
'(resetting rights)'          =>'(reinicialização de direitos)',
'passwords do not match'      =>'as senhas não combinam',
'Password is too weak (please add numbers, special chars or length)'=>'A senha é demasiado débil (por favor acrescente números, caracteres especiais,  ou comprimento)',

### ../pages/proj.inc   ###
'Project Template'            =>'Modelo de Projeto',
'Inactive Project'            =>'Projeto Inativo',
'Project|Page Type'           =>'Tipo de Projeto|Página',
'Template|as addon to project-templates'=>'Modelo como adição para Modelo de Projetos',
'Project duplicated (including %s items)'=>'Projeto duplicado (inclusive itens %s)',

### ../pages/task.inc   ###
'No task(s) selected for deletion...'=>'Nenhuma tarefa(s) selecionada para eliminação...',
'Task <b>%s</b> do not need to be restored'=>'A tarefa <b>%s</b> não necessita ser restaurada.',
'No task(s) selected for restoring...'=>'Nenhuma tarefa(s) selecionada para restaurar...',
'Select some task(s) to mark as completed'=>'Selecione alguma tarefa(s) para marcar como concluída.',
'Marked %s tasks (%s subtasks) as completed.'=>'Marcado %s tarefas (%s subtarefas) como concluído.',
'%s error(s) occured'         =>'%s erros ocorridos.',
'Select some task(s) to mark as approved'=>'Selecione algumas Tarefa(s) para marcar como aprovadas.',
'Select some task(s)'         =>'Selecionar algumas Tarefas.',

### ../render/render_list_column_special.inc   ###
'Due|column header, days until planned start'=>'cabeçalho due|coluna, dias até partida planejada',
'planned for %s|a certain date'=>'planejado para certa data %s|a',
'Pub|column header for public level'=>'Cabeçalho para Pub|coluna de nível público',

### ../render/render_misc.inc   ###
'No element selected? (could not find id)|Message if a function started without items selected'=>'Nenhum elemento selecionado? (não pode encontrar id) |Mensagem se uma função começou sem itens selecionados',

### ../std/class_pagehandler.inc   ###
'Operation aborted (%s)'=>'A operação abortou (%s)',
'Insuffient rights'    =>'Direitos de Insuficientes.',

### ../db/class_person.inc   ###
'only required if use may login (e.g. pixtur)'=>'somente requerido se o usuário pode conectar',
'Optional: Mobile phone (eg. +49-172-12345678)'=>'Opcional: Telefone móvel (ex. +49-172-12345678)',
'Optional: Office Phone (eg. +49-30-12345678)'=>'Opcional: Telefone do Escritório (ex. +49-172-12345678)',
'Optional: Office Fax (eg. +49-30-12345678)'=>'Opcional: Telefone de FAX (ex. +49-172-12345678)',
'Optional: Official Street and Number (eg. Poststreet 28)'=>'Opcional: Rua e Número oficiais (ex. Poststreet 28)',
'Optional: Official Zip-Code and City (eg. 12345 Berlin)'=>'Opcional: Cidade e Código Postal oficiais (ex. 12345 Berlin)',
'Optional: (eg. www.pixtur.de)'=>'Opcional: (ex. www.pixtur.de)',
'Optional: (eg. thomas@pixtur.de)'=>'Opcional: (ex. thomas@pixtur.de)',
'Optional:  Private (eg. Poststreet 28)'=>'Opcional: Privado (ex. Poststreet 28)',
'Optional: Color for graphical overviews (e.g. #FFFF00)'=>'Opcional: Cor para resumos gráficos (ex. #FFFF00)',
'Only required if user can login|tooltip'=>'',

### ../lists/list_tasks.inc   ###
'Add new Task'                =>'Adicionar nova Tarefa',

### ../pages/task.inc   ###
'Report new Bug'              =>'Relatar novo Bug',
'Move tasks'                  =>'Mover tarefas',

### ../lists/list_tasks.inc   ###
'Subtasks'                    =>'Sub-tarefas',

### ../pages/_handles.inc   ###
'New Bug'                     =>'Novo Bug',
'View comment'                =>'Ver comentário',
'Send Activation E-Mail'      =>'Enviar e-mail de ativação',
'Activate an account'         =>'Ativar uma conta',
'System Information'          =>'Siatema de Informação',
'PhpInfo'                     =>'PhpInfo',
'Search'                      =>'Pesquisar',

### ../pages/task.inc   ###
'(deleted %s)|page title add on with date of deletion'=>'(deletada %s)|o título de página acrescentada com a data da deleção',

### ../pages/comment.inc   ###
'Edit this comment'           =>'Editar este comentário',
'New Comment|Default name of new comment'=>'Novo Comentário|Nome Padrão de novo comentário',
'Reply to |prefix for name of new comment on another comment'=>'Responder para|prefixo de nome de novo comentário em outro comentário',
'Edit Comment|Page title'     =>'Editar Comentário|Título de Página',
'New Comment|Page title'      =>'Novo Comentário|Título de Página',
'On task %s|page title add on'=>'Na tarefa %s|acrescimo no título de página',

### ../pages/effort.inc   ###
'On project %s|page title add on'=>'No projeto %s|acrescenta no título de página',

### ../pages/comment.inc   ###
'Occasion|form label'         =>'A ocasião|forma da etiqueta',
'Publish to|form label'        =>'Pública para|forma da etiqueta',
'is no longer a reply|message'=>'',

### ../pages/effort.inc   ###
'Edit Effort|page type'       =>'Edite Esforço|tipo de página',
'Edit Effort|page title'      =>'Edite Esforço|título de página',
'New Effort|page title'       =>'Novo Esforço|título de página',
'Date / Duration|Field label when booking time-effort as duration'=>'A data / Duração|Campo etiqueta reservando esforço de tempo como duração',
'Name required'               =>'Nome requerido',
'Cannot start before end.'    =>'Não pode começar antes do fim',

### ../pages/error.inc   ###
'Error|top navigation tab'    =>'Erro|barra de navegação superior',

### ../pages/home.inc   ###
'Personal Efforts'            =>'Esforço Pessaoal',
'S|Column header for status'  =>'S|Cabeçalho de coluna de estado',
'P|Column header for priority'=>'P|Cabeçalho de coluna de prioridade',
'Priority|Tooltip for column header'=>'Prioridade|Dica para cabeçalho de coluna',
'Company|column header'       =>'Companhia|cabeçalho de coluna',
'Project|column header'       =>'Projet|cabeçalho de coluna',
'Edit|function in context menu'=>'Editar|função em menu de contexto',
'Log hours for a project|function in context menu'=>'Horas no log de um projeto|função em menu de contexto',
'Create new project|function in context menu'=>'Criar novo projeto|função em menu de contexto',
'P|column header'             =>'P|cabeçalho de coluna',
'S|column header'             =>'S|cabeçalho de coluna',
'Folder|column header'        =>'Pasta|cabeçalho de coluna',
'Started|column header'       =>'Iniciado|cabeçalho de coluna',
'Est.|column header estimated time'=>'Est.|cabeçalho de coluna tempo estimado',
'Edit|context menu function'  =>'Editar|contexto da função menu',
'status->Completed|context menu function'=>'estado->Concluído|contexto da função menu',
'status->Approved|context menu function'=>'estado->Aprovado|contexto da função menu',
'Delete|context menu function'=>'Deletar|contexto da função menu',
'Log hours for select tasks|context menu function'=>'Horas de log para tarefas selecionadas|contexto da função menu',

### ../pages/login.inc   ###
'Login|tab in top navigation' =>'Conectar|opção na barra de navegação superior',
'License|tab in top navigation'=>'Licença|opção na barra de navegação superior',
'Welcome to streber|Page title'=>'Bem-vindo ao Streber|Título de Página',
'Name|label in login form'    =>'Nome|espaço no formulário de entrada',
'Password|label in login form'=>'Senha|espaço no formulário de entrada',
'I forgot my password.|label in login form'=>'Esqueci minha senha.|espaço no formulário de entrada',
'If you remember your name, please enter it and try again.'=>'Se você se lembrar do seu nome, por favor introduza-o e tente novamente',
'Supposed a user with this name existed a notification mail has been sent.'=>'Suponho que um usuário com este nome existe um e-mail de notificação foi enviado.',
'invalid login|message when login failed'=>'conecção inválida|mensagem quando a senha de entrada falhou',
'Welcome %s. Please adjust your profile and insert a good password to activate your account.'=>'Bem-vindo %s. Por favor ajuste o seu perfil e insira uma boa senha para ativar a sua conta.',
'Sorry, but this activation code is no longer valid. If you already have an account, you could enter your name and use the <b>forgot password link</b> below.'=>'Desculpe, mas este código de ativação não é mais válido. Se você já tem uma conta, você pode entrar seu nome e usar <b> esqueceu senha </b> abaixo.',
'License|page title'          =>'Licença|Títulode Página',

### ../pages/misc.inc   ###
'Admin|top navigation tab'    =>'Admin|Opção na barra de navegação',
'System information'          =>'Informação do Sistema',
'Admin'                       =>'Admin',
'Database Type'               =>'Tipo do Banco de Dados',
'PHP Version'                 =>'Versão PHP',
'extension directory'         =>'diretório de extenção',
'loaded extensions'           =>'extensões carregadas',
'include path'                =>'incluir caminho',
'register globals'            =>'registros globais',
'magic quotes gpc'            =>'cota mágica gpc',
'magic quotes runtime'        =>'tempo de execução cota mágica',
'safe mode'                   =>'modo seguro',

### ../pages/person.inc   ###
'relating to %s|page title add on listing pages relating to current user'=>'relacionar %s|título de página adicionado a listagem de paginas relacionadas ao usuário corrente',

### ../render/render_misc.inc   ###
'With Account|page option'    =>'Com Conta|opção de página',
'All Persons|page option'     =>'Todas as pessoas|opção de página ',

### ../pages/person.inc   ###
'People/Project Overview'     =>'Pessoal|Resumo de Projeto',
'Persons|Pagetitle for person list'=>'Pessoas|Título de página de lista de pessoa',
'relating to %s|Page title Person list title add on'=>'relacionar a %s|Título de página adicional  lista de Pessoa ',
'admin view|Page title add on if admin'=>'visão de Admin|Título de página adicional se Admin',
'Edit this person|Tooltip for page function'=>'Editar essa pessoa|Dicas para página de função',
'Profile|Page function edit person'=>'Perfil|Função de página editar pessoa',
'Edit User Rights|Tooltip for page function'=>'Editar direitos de Usuário|Dicas para página de função',
'User Rights|Page function for edit user rights'=>'Direitos de Usuário|Função de página editar direitos de usuário',

### ../pages/task.inc   ###
'Summary|Block title'         =>'Sumário|Bloquear Título',

### ../pages/person.inc   ###
'Adress|Label'                =>'Endereço|Etiqueta',
'Mobile|Label mobilephone of person'=>'Móvel|Etiqueta de telefone móvel da pessoa',
'Office|label for person'     =>'Escritório|Etiqueta para pessoa',
'Private|label for person'    =>'Privado|Etiqueta para pessoa',
'Fax|label for person'        =>'Fax|etiqueta para pessoa',
'Website|label for person'    =>'Website|Etiqueta para pessoa',
'Personal|label for person'   =>'Pessoal|Etiqueta para pessoa',
'E-Mail|label for person office email'=>'E-Mail|Etiqueta para email de pessoa do estcritório',
'E-Mail|label for person personal email'=>'E-Mail|Etiqueta pessoal de email da pessoa',
'works for|List title'        =>'trabalha para|lista de título',
'works in Projects|list title for person projects'=>'trabalha em Projetos|liste o título de projetos da pessoa',
'Efforts|Page title add on'   =>'Esforços|Título de página de adições',
'Edit Person|Page type'       =>'Editar Pessoa|Tipo de Página',
'Password|form label'         =>'Senha|forma de etiqueta',
'confirm Password|form label' =>'confirmar senha|forma de etiqueta',
'Person can login|form label' =>'Pessoa pode entrar|forma de etiqueta',
'(resetting rights)| additional form label when changing profile'=>'(reinicializar direitos)|etiqueta de forma adicional modificando perfil ',
'Profile|form label'          =>'Perfil|etiqueta de forma',
'daily'                       =>'diário',
'each 3 days'                 =>'a cada 3 dias',
'each 7 days'                 =>'a cada 7 dias',
'each 14 days'                =>'a cada 14 dias',
'each 30 days'                =>'a cada 30 dias',
'Never'                       =>'Nunca',
'Send notifications|form label'=>'Enviar notificações|etiqueta de forma',
'Send mail as html|form label'=>'Enviar mensagem usando html|etiqueta de forma',
'Theme|form label'            =>'Tema|etiqueta de forma',
'Language|form label'         =>'Idioma|etiqueta de forma',
'Sending notifactions requires an email-address.'=>'Enviar notificações necessárias requeridasem e-mail ',
'A notification / activation  will be mailed to <b>%s</b> when you log out.'=>'Uma notificação / ativação será enviada para <b>%s</b> quando voce desconectar',
'Read more about %s.'         =>'Ler mais sobre %s.',
'Insufficient rights'         =>'Direitos insuficientes',
'Sending notification-mail requires an email-adress.'=>'Enviando mensagem de notificação requerida em e-mail',
'Notification mail has been sent.'=>'E-mail de notificação foi enviado',
'Sending notification e-mail failed.'=>'Envio de e-mail de notificação falhou',
'Edit Person|page type'       =>'Editar pessoa|etiqueta de forma',

### ../pages/proj.inc   ###
'List|page type'              =>'Listar|tipo de página',
'create new project'          =>'criar novo projeto',
'Summary|block title'         =>'Sumário|título do bloco',
'Status|Label in summary'     =>'Estado|Etiqueta em sumário',
'Wikipage|Label in summary'   =>'Página Wiki|Etiqueta em sumário',
'Projectpage|Label in summary'=>'Página de Projeto|Etiqueta em sumário',
'Opened|Label in summary'     =>'Aberto|Etiqueta em sumário',
'Closed|Label in summary'     =>'Fechado|Etiquerta em sumário',
'Created by|Label in summary' =>'Criado por|Etiqueta em sumário',
'Last modified by|Label in summary'=>'Última modificação por|Etiqueta em sumário',
'hours'                       =>'horas',
'Client|label'                =>'Cliente|etiqueta',
'Phone|label'                 =>'Telefone|etiqueta',
'E-Mail|label'                =>'E-Mail|etiqueta',
'no tasks closed yet'         =>'nenhuma tarefa fechada ainda',
'new Effort'                  =>'novo esforço',
'Company|form label'          =>'',
'Create another project after submit'=>'Criar um novo projeto após submeter',
'Failed to insert new project person. Data structure might have been corrupted'=>'Reprovado para inserir nova pessoa de projeto. A estrutura de dados poderia ter sido corrompida',
'Failed to insert new issue. DB structure might have been corrupted.'=>'Falhou para inserir novo assunto. A estrutura de BD pode ter sido corrompida.',
'Failed to update new task. DB structure might have been corrupted.'=>'Falhou para atualizar nova tarefa. A estrutura de BD pode ter sido corrompida.',
'Failed to insert new comment. DB structure might have been corrupted.'=>'Falhou para inserir nova tarefa. A estrutura de BD pode ter sido corrompida.',

### ../pages/projectperson.inc   ###
'Role in this project'        =>'Papel neste projeto',
'start times and end times'   =>'tempo de início e tempo de fim',
'duration'                    =>'duração',
'Log Efforts as'              =>'Log esforços como',
'Changed role of <b>%s</b> to <b>%s</b>'=>'Trocar papel de <b>%s</b> para <b>%s</b>',

### ../pages/search.inc   ###
'Jumped to the only result found.'=>'Pulado ao único resultado encontrado.',
'Search Results'              =>'Pesquisar Resultados',
'Searching'                   =>'Pesquisando',
'Found %s companies'          =>'Encontrou %s companhias',
'Found %s projects'           =>'Encontrou %s projetos',
'Found %s persons'            =>'Encontrou %s pessoas',
'Found %s tasks'              =>'Encontrou %s tarefas',
'Found %s comments'           =>'Encontrou %s comentários',
'Sorry. Could not find anything.'=>'Desculpe, não pude encontrar nada',
'Due to limitations of MySQL fulltext search, searching will not work for...<br>- words with 3 or less characters<br>- Lists with less than 3 entries<br>- words containing special charaters'=>'Devido a limitações da pesquisa de texto cheio do MySQL, a procura não funcionará para...<br>- palavras com menos de 3 caracteres<br>- palavras contendo caracteres especiais',

### ../pages/task.inc   ###
'Task with subtasks|page type'=>'Tarefa com sub-tarefas|tipo de página',
'Task|page type'              =>'Tarefa|tipo de página',
'new subtask for this folder' =>'nova sub-tarefa para esta pasta',
'New task'                    =>'Nova tarefa',
'new bug for this folder'     =>'novo bug para esta pasta',
'Description|Label in Task summary'=>'Descricional|Etiqueta em sumário de Tarefa',
'Part of|Label in Task summary'=>'Parte de|Etiqueta em sumário de Tarefa',
'Status|Label in Task summary'=>'Estado|Etiqueta em sumário de Tarefa',
'Opened|Label in Task summary'=>'Aberto|Etiqueta em sumário de Tarefa',
'Closed|Label in Task summary'=>'Fechado|Etiqueta em sumário de Tarefa',
'Created by|Label in Task summary'=>'Criado por|Etiqueta em sumário de Tarefa',
'Last modified by|Label in Task summary'=>'Ultima modificação por|Etiqueta em sumário de Tarefa',
'Logged effort|Label in task-summary'=>'Esforço conectado|Etiqueta em sumário de tarefa',
'open sub tasks|Table headline'=>'sub-tarefas abertas|Cabeçalho de tabela',
'All open tasks|Title in table'=>'Todas as tarefas abertas|Título na tabela',
'Steps to reproduce|label in issue-reports'=>'Passos para reproduzir|etiqueta em assunto de relatório',
'Expected result|label in issue-reports'=>'Resultado esperado|etiqueta em assunto de relatório',
'Suggested Solution|label in issue-reports'=>'Solução Sugerida|etiqueta em assunto de relatório',
'Comments on task'            =>'Comentários em tarefas',
'Bug|Task-Label that causes automatically addition of issue-report'=>'Bug|Etiqueta de tarefa que causa automaticamente relatório de assuntos',
'Edit Task|Page title'        =>'Editar Tarefa|Título de página',
'Assign to|Form label'        =>'Designar para|Etiqueta de forma',
'Also assign to|Form label'   =>'Tambem designada para|Etiqueta de forma',
'Prio|Form label'             =>'Prio|Etiqueta de forma',
'undefined'                   =>'indefinida',
'Severity|Form label, attribute of issue-reports'=>'Gravidade|Etiqueta de forma, atributo de relatórios de assuntos',
'reproducibility|Form label, attribute of issue-reports'=>'reproduzibilidade|Etiqueta de forma, atributo de relatórios de assuntos',
'unassigned to %s|task-assignment comment'=>'não designada para %s|comentário de nomeação de tarefa',
'formerly assigned to %s|task-assigment comment'=>'formalmente designada para $s|comentário de nomeação de tarefa',
'Turned parent task into a folder. Note, that folders are only listed in tree'=>'Tarefa principais convertida em uma pasta. Observe, que as pastas só são listadas na arvore',
'Failed, adding to parent-task'=>'Falhou ao adicionar uma tarefa principal',
'insufficient rights'         =>'direitos insuficientes',
'Can not move task <b>%s</b> to own child.'=>'Não pode mover tarefa <b>%s</b> como dependente',
'Can not edit tasks %s'       =>'Não pode editar terefa %s',
'Edit tasks'                  =>'Editar tarefas',
'Select folder to move tasks into'=>'Selecionar pasta para mover tarefas',
'... or select nothing to move to projects root'=>'...ou não selecione nada para mover para o projeto raiz',
'Task <b>%s</b> does not need to be restored'=>'Tarefa <b>%s</b> não precisa ser restaurada',

### ../render/render_list.inc   ###
'changed today'               =>'trocada hoje',
'changed since yesterday'     =>'trocada desde ontém',
'changed since <b>%d days</b>'=>'trocada a <b>%d dias</b>',
'changed since <b>%d weeks</b>'=>'trocada a <b>%d semanas</b>',
'created by %s'               =>'criada por%s',
'created by unknown'          =>'criada por desconhecido',

### ../render/render_misc.inc   ###
' (Overview)'                 =>' (Revizada)',

### ../std/class_pagehandler.inc   ###
'Operation aborted with an fatal error (%s).'=>'Operação abortada com o erro fatal (%s)',
'Operation aborted with an fatal data-base structure error (%s). This may have happened do to an inconsistency in your database. We strongly suggest to rewind to a recent back-up.'=>'FATAL: a operação abortada erro fatal na estrutura do banco de dados (%s). Isto pode ter acontecido por uma inconsistência no seu banco de dados. Fortemente sugerimos para recarregar backup recente.',

### ../std/constant_names.inc   ###
'template|status name'        =>'padrão|nome_estado',
'undefined|status_name'       =>'indefinido|nome_estado',
'upcoming|status_name'        =>'vindouro|nome_estado',
'new|status_name'             =>'nova|nome_estado',
'open|status_name'            =>'aberto|nome_estado',
'onhold|status_name'          =>'a espera|nome_estado',
'done?|status_name'           =>'feito?|nome_estado',
'approved|status_name'        =>'aprovado|nome_estado',
'closed|status_name'          =>'fechado|nome_estado',
'undefined|pub_level_name'    =>'indefinido|nome_nível_pub',
'private|pub_level_name'      =>'privado|nome_nível_pub',
'suggested|pub_level_name'    =>'sugerido|nome_nível_pub',
'internal|pub_level_name'     =>'interno|nome_nível_pub',
'open|pub_level_name'         =>'aberto|nome_nível_pub',
'client|pub_level_name'       =>'cliente|nome_nível_pub',
'client_edit|pub_level_name'  =>'cliente_editar|nome_nível_pub',
'assigned|pub_level_name'     =>'designado|nome_nível_pub',
'owned|pub_level_name'        =>'possuido|nome_nível_pub',
'priv|short for public level private'=>'priv|abreviação para nível público privado',
'int|short for public level internal'=>'int|abreviação para nível público interno',
'pub|short for public level client'=>'pub|abreviação para nível público cliente',
'PUB|short for public level client edit'=>'PUB|abreviação para editar nível público cliente',
'A|short for public level assigned'=>'A|abreviação para nível público designado',
'O|short for public level owned'=>'O|abreviação para nível público possuido',
'Create projects|a user right'=>'Criar projetos|um direito de usuário',
'Edit projects|a user right'  =>'Editar projetos|um direito de usuário',
'Delete projects|a user right'=>'Deletar projetos|um direito de usuário',
'Edit project teams|a user right'=>'Editar time de projeto|um direito de usuário',
'View anything|a user right'  =>'Ver qualquer coisa|um direito de usuário',
'Edit anything|a user right'  =>'Editar qualquer coisa|um direito de usuário',
'Create Persons|a user right' =>'Criar Usuários|um direito de usuário',
'Edit Presons|a user right'   =>'Editar Usuários|um direito de usuário',
'Delete Persons|a user right' =>'Deletar Usuários|um direito de usuário',
'View all Persons|a user right'=>'Ver todos os usuários|um direito de usuário',
'Edit User Rights|a user right'=>'Editar Direitos de Usuários|um direito de usuário',
'Edit Own Profil|a user right'=>'Editar Próprio Perfil|Edite Próprio Perfil',
'Create Companies|a user right'=>'Criar Companhias|Edite Próprio Perfil',
'Edit Companies|a user right' =>'Editar Companhias|Edite Próprio Perfil',
'Delete Companies|a user right'=>'Deletar Companhias|Edite Próprio Perfil',
'undefined|priority'          =>'indefinido|prioridade',
'urgent|priority'             =>'urgente|prioridade',
'high|priority'               =>'alta|prioridade',
'normal|priority'             =>'normal|prioridade',
'lower|priority'              =>'baixa|prioridade',
'lowest|priority'             =>'mais baixa|prioridade',

### ../std/mail.inc   ###
'<br>- You have been assigned to projects:<br><br>'=>'<br> - Você foi destinado a projetos: <br> <br>',
'<br>- You have been assigned to tasks:<br><br>'=>'<br> - Você foi destinado a tarefas: <br> <br>',


### ../pages/effort.inc.php   ###
'Details'                     =>'Detalhes',

### ../db/class_company.inc.php   ###
'Short|form field for company'=>'Curto|campo de formulÃ¡rio para companhia',
'Tag line|form field for company'=>'Etiquera|campo de formulÃ¡rio para companhia',
'Phone|form field for company'=>'Fone|campo de formulÃ¡rio para companhia',
'Fax|form field for company'  =>'Fax|campo de formulÃ¡rio para companhia',
'Street'                      =>'Rua',
'Zipcode'                     =>'CÃ³digo Postal',
'Intranet'                    =>'Intranete',
'Comments|form label for company'=>'ComentÃ¡rios|formulÃ¡rio etiqueta para companhia',

### ../db/class_effort.inc.php   ###
'Time Start'                  =>'InÃ­cio',
'Time End'                    =>'TÃ©rmino',

### ../db/class_issue.inc.php   ###
'Production build'            =>'ProduÃ§Ã£o construida',

### ../db/class_person.inc.php   ###
'only required if user can login (e.g. pixtur)'=>'somente requerida se o usuÃ¡rio conectar (ex. pixtur)',
'Office E-Mail'               =>'E-mail do trabalho',
'Only required if user can login|dica'=>'Somente requerida se o usuÃ¡rio conectar|',
'Theme|Formlabel'             =>'Tema|Etiqueta',

### ../db/class_project.inc.php   ###
'only team members can create items'=>'somente membros de equipe podem criar itens',

### ../pages/task_view.inc.php   ###
'For Milestone'               =>'para um Marco',

### ../db/class_task.inc.php   ###
'resolved in version'         =>'resolvida na versÃ£o',

### ../pages/task_view.inc.php   ###
'Resolve reason'              =>'razÃ£o de resoluÃ§Ã£o',

### ../db/class_task.inc.php   ###
'is a milestone'              =>'Ã© um marco',
'milestones are shown in a different list'=>'marcos sÃ£o mostrados em uma lista diferente',
'released'                    =>'lanÃ§ado',
'release time'                =>'tempo do lanÃ§amento',

### ../pages/task_view.inc.php   ###
'Estimated time'              =>'Tempo estimado',
'Estimated worst case'        =>'Pior estimativa',

### ../lists/list_versions.inc.php   ###
'Released Milestone'          =>'Marco lanÃ§ado',

### ../pages/proj.inc.php   ###
'Milestone'                   =>'Marco',

### ../db/db.inc.php   ###
'Database exception. Please read %s next steps on database errors.%s'=>'ExceÃ§Ã£o de banco de dados. Por favor leia os proximos %s passos no banco de dados de erro.%s',

### ../db/db_item.inc.php   ###
'Unknown'                     =>'Desconhecido',
'Item has been modified during your editing by %s (%s minutes ago). Your changes can not be submitted.'=>'O item foi modificado durante a sua ediÃ§Ã£o por %s ( hÃ¡ %s minutos). As suas modificaÃ§Ãµes nÃ£o podem ser submetidas.',

### ../lists/list_changes.inc.php   ###
'to|very short for assigned tasks TO...'=>'para|muito curto para tarefas destinadas Para...',

### ../lists/list_tasks.inc.php   ###
'in|very short for IN folder...'=>'em|muito curto para pasta EM...',

### ../lists/list_projectchanges.inc.php   ###
'new'                         =>'novo',

### ../lists/list_changes.inc.php   ###
'Last of %s comments:'        =>'Ãšltimos %s comentÃ¡rios',
'comment:'                    =>'comentÃ¡rio:',
'completed'                   =>'terminado',
'Approve Task'                =>'Tarefa Aprovada',
'approved'                    =>'aprovada',

### ../pages/proj.inc.php   ###
'closed'                      =>'fechada',

### ../lists/list_changes.inc.php   ###
'reopened'                    =>'raabeta',
'is blocked'                  =>'estÃ¡ bloqueada',
'moved'                       =>'movida',
'renamed'                     =>'renomeada',
'edit wiki'                   =>'editar wiki',
'changed:'                    =>'trocada',
'commented'                   =>'comentada',
'assigned'                    =>'designada',
'attached'                    =>'anexada',
'attached file to'            =>'arquivo anexado para',

### ../lists/list_projectchanges.inc.php   ###
'restore'                     =>'restaurar',

### ../pages/search.inc.php   ###
'Other team members changed nothing since last logout (%s)'=>'Outros membros de equipe nÃ£o modificaram nada desde a Ãºltima saÃ­da (%s)',

### ../lists/list_changes.inc.php   ###
'Date'                        =>'Data',

### ../pages/search.inc.php   ###
'Who changed what when...'    =>'Quem modificou o que quando...',

### ../lists/list_changes.inc.php   ###
'what|column header in change list'=>'qual|cabeÃ§alho de coluna em lista de modificaÃ§Ã£o',
'Date / by'                   =>'Data / por',

### ../lists/list_comments.inc.php   ###
'Add Comment'                 =>'Adicionar ComentÃ¡rio',
'Shrink All Comments'         =>'Encurtar Todos os ComentÃ¡rios',
'Collapse All Comments'       =>'Fechar Todos os ComentÃ¡rios',
'Expand All Comments'         =>'Expandir Todos os ComentÃ¡rios',
'By|column header'            =>'Por|CabeÃ§alho de Coluna',
'Reply'                       =>'Responder',
'1 sub comment'               =>'1 sub-comentÃ¡rio',
'%s sub comments'             =>'%s sub-comentÃ¡rios',

### ../lists/list_companies.inc.php   ###
'Company|Column header'       =>'Companhia|CabeÃ§alho de Coluna',

### ../lists/list_efforts.inc.php   ###
'no efforts booked yet'       =>'nenhum esforÃ§o agendado',
'Effort description'          =>'DescriÃ§Ã£o do esforÃ§o',
'%s effort(s) with %s hours'  =>'%s esforÃ§o(s) com %s hora(s)',
'Effort name. More Details as tooltips'=>'Nome do EsforÃ§o.Mais detalhes como dicas',
'Task|column header'          =>'Tarefa|cabeÃ§alho de coluna',
'Start|column header'         =>'Inicio|cabeÃ§alho de coluna',
'End|column header'           =>'TÃ©rmino|cabeÃ§alho de coluna',
'len|column header of length of effort'=>'comprimento|cabeÃ§alho de coluna da extensÃ£o do esforÃ§o',
'Daygraph|columnheader'       =>'GrÃ¡ficodia|cabeÃ§alho de coluna',

### ../pages/search.inc.php   ###
'Type'                        =>'Tipo',

### ../lists/list_files.inc.php   ###
'Parent item'                 =>'Item superior',
'ID'                          =>'ID',
'Click on the file ids for details.'=>'Click na id do arquivo para detalhes',
'Size'                        =>'Tamanho',

### ../pages/_handles.inc.php   ###
'Edit file'                   =>'Fim do arquivo',

### ../lists/list_files.inc.php   ###
'Move files'                  =>'Mover arquivos',
'New file'                    =>'Novo arquivo',
'No files uploaded'           =>'Nenhum arquivo enviado',
'Download|Column header'      =>'Baixar|cabeÃ§alho de coluna',
'File|Column header'          =>'Arquivo|cabeÃ§alho de coluna',
'in|... folder'               =>'em|... pasta',
'Attached to|Column header'   =>'Anexado para|cabeÃ§alho de coluna',
'Details/Version|Column header'=>'Detalhes/VersÃ£o|cabeÃ§alho de coluna',

### ../pages/proj.inc.php   ###
'Milestones'                  =>'Marcos',

### ../lists/list_tasks.inc.php   ###
'%s hidden'                   =>'%s escondido',

### ../pages/company.inc.php   ###
'or'                          =>'ou',

### ../lists/list_milestones.inc.php   ###
'Planned for'                 =>'Planejado por',
'Due Today'                   =>'Feito Hoje',
'%s days late'                =>'%s dias em atrazo',
'%s days left'                =>'faltam %s dias',

### ../lists/list_versions.inc.php   ###
'%s required'                 =>'requerido %s',

### ../lists/list_milestones.inc.php   ###
'Tasks open|columnheader'     =>'Tarefas abertas|cabeÃ§alho de coluna',

### ../pages/proj.inc.php   ###
'open'                        =>'abrir',

### ../lists/list_persons.inc.php   ###
'last login'                  =>'Ãºltina conecÃ§Ã£o',
'Profile|column header'       =>'Perfil|cabeÃ§alho de coluna',
'Account settings for user (do not confuse with project rights)'=>'ConfiguraÃ§Ãµes de conta do usuÃ¡rio (nÃ£o confundem com direitos de projeto)',
'Active Projects|column header'=>'Projetos ativos|cabeÃ§alho de columa',
'recent changes|column header'=>'modificaÃ§Ãµes recentes|cabeÃ§alho de columa',
'changes since YOUR last logout'=>'modificaÃ§Ãµes desde SUA Ãºltima conecÃ§Ã£o',

### ../lists/list_project_team.inc.php   ###
'last Login|column header'    =>'Ãºltima ConecÃ§Ã£o|cabeÃ§alho de columa',

### ../lists/list_projectchanges.inc.php   ###
'Type|Column header'          =>'Tipo|cabeÃ§alho de columa',
'item %s has undefined type'  =>'o item %s tem o tipo indefinido',

### ../lists/list_tasks.inc.php   ###
'Status|Columnheader'         =>'Estado|CabeÃ§alho de coluna',
'Modified|Column header'      =>'Modificado|CabeÃ§alho de coluna',
'Add comment'                 =>'Adicionar comentÃ¡rio',
'Latest Comment'              =>'Ãšltimo comentÃ¡rio',
'by'                          =>'por',

### ../pages/search.inc.php   ###
'for'                         =>'para',

### ../lists/list_tasks.inc.php   ###
'Label|Columnheader'          =>'Etiqueta|CabeÃ§alho de coluna',
'Task name'                   =>'Nome da tarefa',
'Task has %s attachments'     =>'A tarefa tem %s anexos',
'number of subtasks'          =>'nÃºmero de sub-tarefas',
'Est/Compl'                   =>'Est/Compl',
'Estimated time / completed'  =>'Tempo estimado / completado',

### ../lists/list_versions.inc.php   ###
'Release Date'                =>'Data de PublicaÃ§Ã£o',

### ../pages/_handles.inc.php   ###
'Versions'                    =>'VersÃµes',

### ../pages/proj.inc.php   ###
'Uploaded Files'              =>'Arquivos Enviados',

### ../pages/_handles.inc.php   ###
'Edit Project Description'    =>'Editar DescriÃ§Ã£o do Projeto',
'Task Test'                   =>'Teste de Tarefa',
'Edit multiple Tasks'         =>'Editar multiplas Tarefas',
'view changes'                =>'visualizar mudanÃ§as',
'View Task Efforts'           =>'Visualizar Marcos de Tarefa',
'Mark tasks as Open'          =>'Marcar tarefa como Aberta',

### ../pages/task_more.inc.php   ###
'New Milestone'               =>'Novo Marco',

### ../pages/_handles.inc.php   ###
'New Released Milestone'      =>'Novo Marco Disponibilizado',
'Edit Description'            =>'Editar DescriÃ§Ã£o',
'View effort'                 =>'Visualizar esforÃ§o',
'View multiple efforts'       =>'Visualizar mÃºltiplos esforÃ§os',
'View file'                   =>'Visualizar arquivo',
'Upload file'                 =>'Enviar arquivo',
'Update file'                 =>'Atualizar arquivo',

### ../pages/file.inc.php   ###
'Download'                    =>'Baixar',

### ../pages/_handles.inc.php   ###
'Show file scaled'            =>'Mostrar arquivo escalado',
'Move files to folder'        =>'Mover arquivos para pasta',
'List Clients'                =>'Listar Clientes',
'List Prospective Clients'    =>'Listar Clientes em Perspectiva',
'List Suppliers'              =>'Listar Fornecedores',
'List Partners'               =>'Parceiros de Lista',
'Remove persons from company' =>'Retirar pessoas da companhia',
'List Employees'              =>'Listar FucionÃ¡rios',
'List Deleted Persons'        =>'Listar Pessoas Deletadas',
'Flush Notifications'         =>'Deletar NotificaÃ§Ãµes',
'restore Item'                =>'restaurar Item',
'Filter errors.log'           =>'Filtrar erros.log',
'Delete errors.log'           =>'Deletar erros.log',

### ../pages/comment.inc.php   ###
'Comment on task|page type'   =>'Comentar tarefa|pÃ¡gina tipo',
'Can not edit comment %s'     =>'NÃ£o pode editar comentÃ¡rio %s',
'Select one folder to move comments into'=>'Selecione uma pasta para mover comentÃ¡rios',
'... or select nothing to move to project root'=>'... ou nÃ£o selecione nada para se mover para raiz do projeto',
'No folders in this project...'=>'Nenhuma pasta neste projeto...',

### ../pages/task_more.inc.php   ###
'Move items'                  =>'Mover itens',

### ../pages/company.inc.php   ###
'Clients'                     =>'Clientes',
'related companies of %s'     =>'companhias relacionadas de %s',
'Prospective Clients'         =>'Clientes em Perspectiva',
'Suppliers'                   =>'Fornecedores',
'Partners'                    =>'Parceiros',

### ../pages/task_view.inc.php   ###
'edit:'                       =>'editar:',
'new:'                        =>'novo:',

### ../pages/company.inc.php   ###
'related Persons'             =>'Pessoas relacionadas',
'Remove person from company'  =>'Remover pessoa da companhia',

### ../pages/person.inc.php   ###
'Category|form label'         =>'Categoria|de etiqueta',

### ../pages/company.inc.php   ###
'Failed to remove %s contact person(s)'=>'Falha na remoÃ§Ã£o de %s pessoa(s) de contato',
'Removed %s contact person(s)'=>'Removida(s) %s pessoa(s) de contato',

### ../pages/effort.inc.php   ###
'Select one or more efforts'  =>'Selecione um ou mais esforÃ§os',
'You do not have enough rights'=>'Voce nÃ£o tem permissÃ£o',
'Effort of task|page type'    =>'EsforÃ§i de tarefa|tipo de pÃ¡gina',
'Edit this effort'            =>'Editar este esforÃ§o',
'Project|label'               =>'Projeto|etiqueta',
'Task|label'                  =>'Tarefa|etiqueta',
'No task related'             =>'Nenhuma tarefa relacionada',
'Created by|label'            =>'Criado por|etiqueta',
'Created at|label'            =>'Criado em|etiqueta',
'Duration|label'              =>'DuraÃ§Ã£o|etiqueta',
'Time start|label'            =>'InÃ­cio|etiqueta',
'Time end|label'              =>'TÃ©rmino|etiqueta',
'No description available'    =>'Nenhuma descriÃ§Ã£o disponÃ­vel',
'Multiple Efforts|page type'  =>'EsforÃ§os MÃºltiplos|tipo de pÃ¡gina',
'Multiple Efforts'            =>'EsforÃ§os MÃºltiplos',

### ../pages/task_more.inc.php   ###
'summary'                     =>'sumÃ¡rio',

### ../pages/effort.inc.php   ###
'Information'                 =>'InformaÃ§Ã£o',
'Number of efforts|label'     =>'NÃºmeros dos esforÃ§os|etiqueta',
'Sum of efforts|label'        =>'Soma de esforÃ§os|etiqueta',
'from|time label'             =>'de|etiqueta de tempo',
'to|time label'               =>'para|etiqueta de tempo',
'Time|label'                  =>'Tempo|etiqueta',
'Could not get person of effort'=>'Pessoa do esforÃ§o nÃ£o encontrada',

### ../pages/file.inc.php   ###
'Could not access parent task.'=>'Tarefa superior sem acesso',

### ../std/constant_names.inc.php   ###
'File'                        =>'Arquivo',

### ../pages/task_view.inc.php   ###
'Item-ID %d'                  =>'Item-ID',

### ../pages/file.inc.php   ###
'Edit this file'              =>'Editar este arquivo',
'Version #%s (current): %s'   =>'VersÃ£o #%s (corrente): %s',
'Filesize'                    =>'Tamanho do Arquivo',
'Uploaded'                    =>'Enviado',
'Uploaded by'                 =>'Enviado por',
'Version #%s : %s'            =>'VersÃ£o #%s : %s',
'Upload new version|block title'=>'Enviar nova versÃ£o|tÃ­tulo do bloco',

### ../pages/task_view.inc.php   ###
'Upload'                      =>'Enviar',

### ../pages/file.inc.php   ###
'Could not edit task'         =>'ImpossÃ­vel editar tarefa',
'Edit File|page type'         =>'Editar Arquivo|tipo de pÃ¡gina',
'Edit File|page title'        =>'Editar Arquivo|tÃ­tulo de pÃ¡gina',
'New File|page title'         =>'Novo Arquivo|tÃ­tulo de pÃ¡gina',
'Could not get file'          =>'Arquivo nÃ£o encontrado',
'Could not get project of file'=>'Projeto do arquivo nÃ£o encontrado',
'Please enter a proper filename'=>'Favor entrar um nome de arquivo apropiado',
'Select some files to delete' =>'Selecione alguns arquivos para deleÃ§Ã£o',
'Failed to delete %s files'   =>'Falha ao deletar %s arquivos',
'Moved %s files to trash'  =>'Mover %s arquivos para o lixo',
'Select some file to display' =>'Selecione alguns arquivos para mostrar',
'Select some files to move'   =>'Seleciona alguns arquivos para mover',
'Can not edit file %s'        =>'Arquivo %s nÃ£o pode ser editado',
'insufficient rights to edit any of the selected items'=>'permissÃ£o insuficiente para editar qualquer um dos arquivos selecionados',
'Edit files'                  =>'Editar arquivos',
'Select folder to move files into'=>'Selecionar pasta para mover os arquivos para',
'No folders available'        =>'Nenhuma pasta disponÃ­vel',

### ../pages/task_more.inc.php   ###
'(or select nothing to move to project root)'=>'(ou nÃ£o selecione nada para mover para a raiz do projeto',

### ../pages/home.inc.php   ###
'Projects'                    =>'Projetos',
'Modified|column header'      =>'Modificado|cabeÃ§alho de coluna',

### ../pages/login.inc.php   ###
'Nickname|label in login form'=>'Apelido|etiqueta no formulÃ¡rio de conecÃ§Ã£o',
'I forgot my password'        =>'Eu esqueci minha senha',

### ../pages/misc.inc.php   ###
'Select some items to restore'=>'Selecione alguns itens para restaurar',
'Item %s does not need to be restored'=>'Os itens %s nÃ£o precisam ser restaurados',
'Failed to restore %s items'  =>'Falha ao restaurar %s itens',
'Restored %s items'           =>'Restaurados %s itens',
'Error-Log'                   =>'Erro-Log',
'hide'                        =>'esconder',

### ../pages/person.inc.php   ###
'Employees|Pagetitle for person list'=>'Empregados|Titulo de pÃ¡gina para lista de pessoas',
'Contact Persons|Pagetitle for person list'=>'Pessoas para Contato|Titulo de pÃ¡gina para lista de pessoas',
'Deleted People'              =>'Deletar Pessoa',
'notification:'               =>'notificaÃ§Ã£o',
'Fax (office)|label for person'=>'Fax (escritÃ³rio)|etiqueta por pessoa',
'Adress Personal|Label'       =>'EndereÃ§o Residencial|Etiqueta',
'Adress Office|Label'         =>'EndereÃ§o do EscritÃ³rio|EscritÃ³rio',
'Birthdate|Label'             =>'Data de AniversÃ¡rio|Etiqueta',
'no company'                  =>'sem companhia',
'Person details'              =>'Detalhes pessoais',
'Assigned tasks'              =>'Tarefas designadas',
'No open tasks assigned'      =>'Nenhuma tarefa aberta designada',
'no efforts yet'              =>'ainda nenhum esforÃ§o',
'Person with account (can login)|form label'=>'Pessoa com conta (pode conectar)|etiqueta de formulÃ¡rio',
'-- reset to...--'            =>'-- reconfigurar para...--',

### ../pages/task_more.inc.php   ###
'Invalid checksum for hidden form elements'=>'Checksum invÃ¡lido para elementos de formulÃ¡rio escondido',

### ../pages/person.inc.php   ###
'The changed profile <b>does not affect existing project roles</b>! Those has to be adjusted inside the projects.'=>'O perfil modificado <b>nÃ£o afeta as regras de um projeto existente</b>! Estas tem que ser ajustadas nos referidos projetos.',
'Nickname has been converted to lowercase'=>'Apelido foi convertido para letras minÃºsculas',
'Passwords do not match'      =>'Senhas nÃ£o coincidem',
'Person %s created'           =>'Pessoa %s criada',
'<b>%s</b> has been assigned to projects and can not be deleted. But you can deativate his right to login.'=>'<b>%s</b> foi designado para o projeto e nÃ£o pode ser deletado. Mas voce pode desativar os seus direitos de conecÃ§Ã£o.',
'Since the user does not have the right to edit his own profile and therefore to adjust his password, sending an activation does not make sense.'=>'Desde que o usuÃ¡rio nÃ£o tem direito de editar seu perfil logo ajustar sua senha, enviar uma ativaÃ§Ã£o nÃ£o faz sentido',
'Sending an activation mail does not make sense, until the user is allowed to login. Please adjust his profile.'=>'Enviar um e-mail de ativaÃ§Ã£o nÃ£o faz sentido, atÃ© que o usuÃ¡rio possa se conectar. Favor ajustar seu perfil.',
'Activation mail has been sent.'=>'E-mail de ativaÃ§Ã£o foi enviado',
'Select some persons to notify'=>'Selecione algumas pessoas para notificaÃ§Ã£o',
'Failed to mail %s persons'   =>'Flalha ao enviar e-mail para %s',
'Sent notification to %s person(s)'=>'Enviar e-mail para as pessoas %s',
'Adjust user-rights'          =>'Ajustar direitos de usuÃ¡rio',

### ../pages/proj.inc.php   ###
'not assigned to a closed project'=>'nÃ£o designado para um projeto fechado',
'no project templates'        =>'nenhum formato de projeto',

### ../pages/task_view.inc.php   ###
'Wiki'                        =>'Wiki',

### ../pages/proj.inc.php   ###
'Team member'                 =>'Menbro de grupo',
'Create task'                 =>'Criar tarefa',

### ../pages/task_view.inc.php   ###
'Bug'                         =>'Bug',

### ../pages/proj.inc.php   ###
'Details|block title'         =>'Detalhes|tÃ­tulo de bloco',
'all'                         =>'tudo',
'my open'                     =>'aberto para mim',
'for milestone'               =>'para marco',
'needs approval'              =>'necessita de aprovaÃ§Ã£o',
'without milestone'           =>'sem marco',
'Create a new folder for tasks and files'=>'Criar uma nova pasta para terefas e arquivos',
'Filter-Preset:'              =>'Filtro-PreConfigurado',
'No tasks'                    =>'Sem tarefas',
'Upload file|block title'     =>'Enviar arquivo|tÃ­tulo de bloco',
'new Milestone'               =>'novo marco',
'View open milestones'        =>'Visualizar marcos abertos',
'View closed milestones'      =>'Visualizar marcos fechados',
'Released Versions'           =>'VersÃµes Publicadas',
'New released Milestone'      =>'Novo Marco publicado',
'Tasks resolved in upcomming version'=>'Tarefa resolvida na prÃ³xima ediÃ§Ã£o',
'Company|form label'          =>'Companhia|etiqueta de formulÃ¡rio',
'Found no persons to add. Go to `People` to create some.'=>'NÃ£o encontrada pessoas para adicionar. VÃ¡ atÃ© `Pessoas` para criar algumas',
'Add'                         =>'Adicionar',
'Select a project to edit description'=>'Selecione um projeto para editar descriÃ§Ã£o',

### ../pages/task_more.inc.php   ###
'Edit description'            =>'Editar descriÃ§Ã£o',

### ../pages/projectperson.inc.php   ###
'Failed to remove %s members from team'=>'Falha ao remover %s membros do grupo',
'Unassigned %s team member(s) from project'=>'Membros %s nÃ£o designados do projeto',

### ../pages/search.inc.php   ###
'in'                          =>'em',
'on'                          =>'no',
'cannot jump to this item type'=>'nÃ£o pode pular para esse tipo de item',
'jumped to best of %s search results'=>'alcanÃ§ado o melhor resuldato da pesquisa para %s',
'Add an ! to your search request to jump to the best result.'=>'Adicionar um ! para a sua pesquisa ir para o melhor resultado',
'%s search results for `%s`'  =>'%s resultados de pesquisa para `%s`',
'No search results for `%s`'  =>'Nenhum resultado para a pesquisa `%s`',

### ../pages/version.inc.php   ###
'New Version'                 =>'Nova VersÃ£o',

### ../pages/task_more.inc.php   ###
'Please select only one item as parent'=>'Favor selecionar somente um item como superior',
'Insufficient rights for parent item.'=>'Direitos insuficientes para o item superior',
'could not find project'      =>'projeto nÃ£o encontrado',
'Parent task not found.'      =>'Tarefa superior nÃ£o encontrada',
'Feature|Task label that added by default'=>'Disponibilidade|Etiqueta de tarefa adicionada por padrÃ£o',
'Select some task(s) to edit' =>'Seleciona alguma(s) tarefa(s) para editar',
'You do not have enough rights to edit this task'=>'Voce nÃ£o tem direitos suficientes para editar essa tarefa',
'Edit %s|Page title'          =>'Editar %s|TÃ­tulo de pÃ¡gina',
'New milestone'               =>'Novo marco',
'for %s|e.g. new task for something'=>'para %s|ex. nova tarefa para alguma coisa',
'-- next released version --' =>'-- prÃ³xima versÃ£o disponÃ­vel --',

### ../pages/task_view.inc.php   ###
'Resolved in'                 =>'Resolvido em',
'- select person -'           =>'- selecionar pessoa -',

### ../pages/task_more.inc.php   ###
'Release as version|Form label, attribute of issue-reports'=>'DisponÃ­vel como VersÃ£o|Etiqueta de formulÃ¡rio, atributo do relatÃ³rio-assuntos',

### ../pages/task_view.inc.php   ###
'30 min'                      =>'30 min',
'1 h'                         =>'1 h',
'2 h'                         =>'2 h',
'4 h'                         =>'4 h',
'1 Day'                       =>'1 Dia',
'2 Days'                      =>'2 Dias',
'3 Days'                      =>'3 Dias',
'4 Days'                      =>'4 Dias',
'1 Week'                      =>'1 Semana',
'1,5 Weeks'                   =>'1,5 Semanas',
'2 Weeks'                     =>'2 Semanas',
'3 Weeks'                     =>'3 Semanas',
'Completed'                   =>'Comcluido',

### ../pages/task_more.inc.php   ###
'Reproducibility|Form label, attribute of issue-reports'=>'Reprodutividade|Etiqueta de formulÃ¡rio, atributo do relatÃ³rio-assuntos',
'Create another task after submit'=>'Criar uma outra tarefa apÃ³s submeter',
'Failed to retrieve parent task'=>'Falha ao recuperar tarefa superior',
'Task called %s already exists'=>'Tarefa chamada %s jÃ¡ existe',
'Created task %s with ID %s'  =>'Criada tarefa %s com ID %s',
'Changed task %s with ID %s'  =>'Modificada tarefa %s com ID %s',
'Marked %s tasks to be resolved in this version.'=>'Tarefas %s marcadas paea serem resolvidas nesta versÃ£o',
'Failed to add comment'       =>'Falha ao adicionar comentÃ¡rio',
'Failed to delete task %s'    =>'Falha ao deletar tarefa %s',
'Could not find task'         =>'ImpossÃ­vel encontrar tarefa',
'Select some task(s) to reopen'=>'Selecione alguma(s) tarefa(s) para reabertura',
'Reopened %s tasks.'          =>'Tarefas %s reabertas.',
'Could not update task'       =>'ImpossÃ­vel atualizar tarefa',
'Select a task to edit description'=>'Selecione uma tarefa para editar a descriÃ§Ã£o',
'Task Efforts'                =>'EsforÃ§os de tarefa',
'changes'                     =>'trocas',
'View task'                   =>'Visualizar tarefa',
'date1 should be smaller than date2. Swapped'=>'Data1 deve ser menor que data2. Invertida',
'item has not been edited history'=>'histÃ³rico de item nÃ£o foi editado',
'unknown'                     =>'desconhecido',
' -- '                        =>' -- ',
'prev change'                 =>'prev troca',
'next'                        =>'prÃ³ximo',
'Item did not exists at %s'   =>'Item nÃ£o existe em %s',
'no changes between %s and %s'=>'nenhuma troca entre %s e %s',
'ok'                          =>'ok',
'For editing all tasks must be of same project.'=>'Para editar todas as tarefas devem ser do mesmo projeto',
'Edit multiple tasks|Page title'=>'Editar multiplas tarefas|TÃ­tulo de pÃ¡gina',
'Edit %s tasks|Page title'    =>'Editar %s tarefas|TÃ­tulo de pÃ¡gina',
'keep different'              =>'mantenha diferente',
'-- keep different --'        =>'-- mantenha diferente --',
'Prio'                        =>'Prio',
'none'                        =>'nenhum',

### ../pages/task_view.inc.php   ###
'next released version'       =>'prÃ³xima versÃ£o disponibilizada',

### ../pages/task_more.inc.php   ###
'resolved in Version'         =>'resolvido na VersÃ£o',
'Resolve Reason'              =>'RazÃ£o de ResoluÃ§Ã£o',
'%s tasks could not be written'=>'%s tarefas nÃ£o puderam ser escritas',
'Updated %s tasks tasks'      =>'Atualizar %s tarefas',

### ../pages/task_view.inc.php   ###
'new task for this milestone' =>'nova tarefa para este marco',
'Add Details|page function'   =>'Adicionar detalhes|funÃ§Ã£o de pÃ¡gina',
'Move|page function to move current task'=>'Mover|paginar a funÃ§Ã£o para mover a tarefa atual',
'status:'                     =>'estado',
'Undelete'                    =>'Recuperar',
'View history of item'        =>'Visualizar histÃ³rio do item',
'Released as|Label in Task summary'=>'Disponibilisar como|Etiqueta no sumÃ¡rio de tarefa',
'For Milestone|Label in Task summary'=>'Para Marco|Etiqueta no sumÃ¡rio de tarefa',
'Estimated|Label in Task summary'=>'Estimado|Etiqueta no sumÃ¡rio de tarefa',
'Completed|Label in Task summary'=>'Finalizado|Etiqueta no sumÃ¡rio de tarefa',
'Planned start|Label in Task summary'=>'Planejado iniciar|Etiqueta no sumÃ¡rio de tarefa',
'Planned end|Label in Task summary'=>'Planejado terminar|Etiqueta no sumÃ¡rio de tarefa',
'Created|Label in Task summary'=>'Criado|Etiqueta no sumÃ¡rio de tarefa',
'Modified|Label in Task summary'=>'Modificado|Etiqueta no sumÃ¡rio de tarefa',
'Publish to|Label in Task summary'=>'Publicado para|Etiqueta no sumÃ¡rio de tarefa',
'Attached files'              =>'Arquivos anexos',
'attach new'                  =>'novo anexo',
'Severity|label in issue-reports'=>'Gravidade|etiqueta em relatÃ³rio de Terefa',
'Reproducibility|label in issue-reports'=>'Reprodutividade|etiqueta em relatÃ³rio de Terefa',
'Sub tasks'                   =>'Sub tarefas',
'Open tasks for milestone'    =>'Abrir tarefas por marco',
'No open tasks for this milestone'=>'Nenhuma tarefa aberta para este marco',
'1 Comment'                   =>'1 ComentÃ¡rio',
'%s Comments'                 =>'%s ComentÃ¡rios',
'Comment / Update'            =>'ComentÃ¡rio / AtualizaÃ§Ã£o',
'quick edit'                  =>'editar rapidamente',
'Public to'                   =>'Publicado para',

### ../pages/version.inc.php   ###
'Edit Version|page type'      =>'VersÃ£o de EdiÃ§Ã£o|tipo de pÃ¡gina',
'Edit Version|page title'     =>'VersÃ£o de EdiÃ§Ã£o|tÃ­tulo de pÃ¡gina',
'New Version|page title'      =>'Nova VersÃ£o|tÃ­tulo de pÃ¡gina',
'Could not get version'       =>'ImpossÃ­vel resgatar versÃ£o',
'Could not get project of version'=>'ImpossÃ­vel resgatar projeto de versÃ£o',
'Select some versions to delete'=>'Selecione algumas versÃµes para deletar',
'Failed to delete %s versions'=>'Falha ao deletar %s versÃµes',
'Moved %s versions to trash'=>'Movida %s versÃµes para o lixo',
'Version|page type'           =>'VersÃ£o|tipo de pÃ¡gina',
'Edit this version'           =>'Editar esta versÃ£o',

### ../render/render_fields.inc.php   ###
'<b>%s</b> is not a known format for date.'=>'<b>%s</b> nÃ£o Ã© um formato de data conhecido',

### ../render/render_form.inc.php   ###
'Wiki format'                 =>'Formato Wiki',
'Submit'                      =>'Submeter',
'Cancel'                      =>'Cancelar',
'Apply'                       =>'Aplicar',

### ../render/render_list.inc.php   ###
'for milestone %s'            =>'para marco %s',
'modified by %s'              =>'modificado por %s',
'modified by unknown'         =>'modificado por desconhecido',
'item #%s has undefined type' =>'item %s tem tipo indefinido',

### ../render/render_list_column_special.inc.php   ###
'Status|Short status column header'=>'Estado|CabeÃ§alho de coluna de curto estado',
'Item is published to'        =>'Item publicado para',
'Select / Deselect'           =>'Marcar / Desmarcar',

### ../render/render_misc.inc.php   ###
'Other Persons|page option'   =>'Outras pessoas|opÃ§Ã£o de pÃ¡gina',
'Clients|page option'         =>'Clients|opÃ§Ã£o de pÃ¡gina',
'Prospective Clients|page option'=>'',
'Suppliers|page option'       =>'Fornecedores|opÃ§Ã£o de pÃ¡gina',
'Partners|page option'        =>'Associados|opÃ§Ã£o de pÃ¡gina',
'Companies|page option'       =>'Companhias|opÃ§Ã£o de pÃ¡gina',
'Tasks|Project option'        =>'Tarefas| OpÃ§Ã£o de Projeto',
'Milestones|Project option'   =>'Marco|OpÃ§Ã£o de Projeto',
'Versions|Project option'     =>'VersÃµes|OpÃ§Ã£o de Projeto',
'Files|Project option'        =>'Arquivos|OpÃ§Ã£o de Projeto',
'Efforts|Project option'      =>'EsforÃ§os|OpÃ§Ã£o de Projeto',
'History|Project option'      =>'HistÃ³rio|opÃ§Ã£o de Projeto',
'Employees|page option'       =>'Empregados|opÃ§Ã£o de pÃ¡gina',
'Contact Persons|page option' =>'Pessoas para Contato|opÃ§Ã£o de pÃ¡gina',
'Deleted|page option'         =>'Deletado|opÃ§Ã£o de pÃ¡gina',
'All Companies|page option'   =>'Todas as Companhias|opÃ£o de pÃ¡gina',
'new since last logout'       =>'novo desde a Ãºltima saida',
'Yesterday'                   =>'Ontem',
'%s hours'                    =>'%s horas',
'%s days'                     =>'%s dias',
'%s weeks'                    =>'%s semanas',
'estimated %s hours'          =>'estimado %s horas',
'%s hours max'                =>'%s mÃ¡ximo de horas',
'estimated %s days'           =>'estimado %s dias',
'%s days max'                 =>'%s mÃ¡ximo de dias',
'estimated %s weeks'          =>'estimado %s semanas',
'%s weeks max'                =>'%s mÃ¡ximo de semanas',
'%2.0f%% completed'           =>'%2.0f%% completada',

### ../render/render_page.inc.php   ###
'Click Tab for complex search or enter word* or Id and hit return. Use ALT-S as shortcut. Use `Search!` for `Good Luck`'=>'Clique TAB para uma pesquisa complexa ou introduza palavra* ou Id e pressione no ENTER. Use ALT-S como atalho. Use `Pesquisa! ` para `Boa Sorte`',
'Help'                        =>'Ajuda',

### ../render/render_wiki.inc.php   ###
'from'                        =>'de',
'enlarge'                     =>'aumentar',
'Unknown File-Id:'            =>'Desconhecido Id de arquivo',
'Unknown project-Id:'         =>'Desconhecido Id de projeto',
'Wiki-format: <b>%s</b> is not a valid link-type'=>'Format-Wiki: <b>%s</b> nÃ£o Ã© um tipo de link vÃ¡lido',
'No task matches this name exactly'=>'Nenhuma tarefa coincide exatamente com este nome',
'This task seems to be related'=>'Esta tarefa parece ser relacionada',
'No item excactly matches this name.'=>'Nenhuma item coincide exatamente com este nome',
'List %s related tasks'       =>'Listar %s tarefas relacionadas',
'identical'                   =>'identica',
'No item matches this name. Create new task with this name?'=>'Nenhum item combina com este nome. Criar uma nova tarefa com este nome?',
'No item matches this name.'  =>'Nenhum item combina com este nome.',
'No item matches this name'   =>'Nenhum item combina com este nome.',

### ../std/class_auth.inc.php   ###
'Cookie is no longer valid for this computer.'=>'O cookie nÃ£o Ã© mais vÃ¡lido para este computador.',
'Your IP-Address changed. Please relogin.'=>'O seu endereÃ§o-IP modificou-se. Favor conectar-se novamente.',
'Your account has been disabled. '=>'A sua conta foi desabilitada.',
'Unable to automatically detect client time zone'=>'Incapaz de descobrir automaticamente fuso horÃ¡rio de cliente',
'Could not set cookie.'       =>'NÃ£o pode estabelecer o cookie.',

### ../std/class_pagehandler.inc.php   ###
'Operation aborted with an fatal error which was cause by an programming error (%s).'=>'A operaÃ§Ã£o abortou com um erro fatal que foi causado por um erro de programaÃ§Ã£o (%s).',

### ../std/common.inc.php   ###
'only one item expected.'     =>'',

### ../std/constant_names.inc.php   ###
'blocked|status_name'         =>'bloqueado|nome de posiÃ§Ã£o',
'Member|profile name'         =>'Membro|nome de perfil',
'Admin|profile name'          =>'Admin|nome de perfil',
'Project manager|profile name'=>'Gerente de Projeto|nome de perfil',
'Developer|profile name'      =>'Desenvolvedor|nome de perfil',
'Artist|profile name'         =>'Artista|nome de perfil',
'Tester|profile name'         =>'Testador|nome de perfil',
'Client|profile name'         =>'Cliente|nome de perfil',
'Client trusted|profile name' =>'Cliente aprovado|nome de perfil',
'Guest|profile name'          =>'Convidado|nome de perfil',
'Create & Edit Persons|a user right'=>'Criar & Editar Pessoas|permissÃ£o de um usuÃ¡rio',
'Team Member'                 =>'Membro do Time',
'Employment'                  =>'Emprego',
'Issue'                       =>'Assunto',
'Task assignment'             =>'DesignaÃ§Ã£o de tarefa',
'Nitpicky|severity'           =>'Nitpicky|gravidade',
'Feature|severity'            =>'CaracterÃ­stica|gravidade',
'Trivial|severity'            =>'Trivial|gravidade',
'Text|severity'               =>'Texto|gravidade',
'Tweak|severity'              =>'TorÃ§a|gravidade',
'Minor|severity'              =>'Menor|gravidade',
'Major|severity'              =>'Maior|gravidade',
'Crash|severity'              =>'Choque|gravidade',
'Block|severity'              =>'Bloco|gravidade',
'Not available|reproducabilty'=>'NÃ£o disponÃ­vel|reprodutividade',
'Always|reproducabilty'       =>'Sempre|reprodutividade',
'Sometimes|reproducabilty'    =>'Algumas vezes|reprodutividade',
'Have not tried|reproducabilty'=>'NÃ£o tentaram|reprodutividade',
'Unable to reproduce|reproducabilty'=>'Incapaz de reproduzir|reprodutividade',
'done|resolve reason'         =>'feito|razÃ£o da soluÃ§Ã£o',
'fixed|resolve reason'        =>'fixado|razÃ£o da soluÃ§Ã£o',
'works_for_me|resolve reason' =>'bom para mim|razÃ£o da soluÃ§Ã£o',
'duplicate|resolve reason'    =>'duplicado|razÃ£o da soluÃ§Ã£o',
'bogus|resolve reason'        =>'falso|razÃ£o da soluÃ§Ã£o',
'rejected|resolve reason'     =>'rejeitado|razÃ£o da soluÃ§Ã£o',
'deferred|resolve reason'     =>'deferido|razÃ£o da soluÃ§Ã£o',
'Not defined|release type'    =>'NÃ£o deferido|tipo de lanÃ§amento',
'Not planned|release type'    =>'NÃ£o panejado|tipo de lanÃ§amento',
'Upcomming|release type'      =>'Por vir|tipo de lanÃ§amento',
'Internal|release type'       =>'Interno|tipo de lanÃ§amento',
'Public|release type'         =>'PÃºblico|tipo de lanÃ§amento',
'Without support|release type'=>'Sem suporte|tipo de lanÃ§amento',
'No longer supported|release type'=>'NÃ£o mais suportado|tipo de lanÃ§amento',
'undefined|company category'  =>'indefinido|categoria de companhia',
'client|company category'     =>'cliente|categoria de companhia',
'prospective client|company category'=>'cliente em perspectiva|categoria de companhia',
'supplier|company category'   =>'fornecedor|categoria de companhia',
'partner|company category'    =>'parceiro|categoria de companhia',
'undefined|person category'   =>'indefinido|categoria de companhia',
'- employee -|person category'=>'- empregado -|categoria pessoal',
'staff|person category'       =>'gerentes|categoria pessoal',
'freelancer|person category'  =>'freelancer|categoria pessoal',
'working student|person category'=>'estudante trabalhador|categoria pessoal',
'apprentice|person category'  =>'aprendiz|categoria pessoal',
'intern|person category'      =>'interno|categoria pessoal',
'ex-employee|person category' =>'ex-empregado|categoria pessoal',
'- contact person -|person category'=>'- pessoa de contato -|categoria pessoal',
'client|person category'      =>'cliente|categoria pessoal',
'prospective client|person category'=>'cliente em perspectiva|categoria pessoal',
'supplier|person category'    =>'fornecedor|categoria pessoal',
'partner|person category'     =>'parceiro|categoria pessoal',

### ../std/mail.inc.php   ###
'Failure sending mail: %s'    =>'Falha enviando e-mail: %s',
'Streber Email Notification|notifcation mail from'=>'NotificaÃ§Ã£o de e-mail Streber|',
'Updates at %s|notication mail subject'=>'assunto de notificaÃ§Ã£o por e-mail',
'Hello %s,|notification'      =>'OlÃ¡ %s, |notificaÃ§Ã£o',
'with this automatically created e-mail we want to inform you that|notification'=>'com este e-mail automaticamente criado queremos informar-lhe isto |notificaÃ§Ã£o',
'since %s'                    =>'desde %s',
'following happened at %s |notification'=>'seguinte aconteceu em %s |notificaÃ§Ã£o',
'Your account has been created.|notification'=>'Sua conta foi criada.|notificaÃ§Ã£o',
'Please set a password to activate it.|notification'=>'Favor configurar uma senha para ativar.|notificaÃ§Ã£o',
'You have been assigned to projects:|notification'=>'Voce foi designado para os projetos:notificaÃ§Ã£o',
'Project Updates'             =>'AtualizaÃ§Ã£o de Projetos',
'If you do not want to get further notifications or you forgot your password feel free to|notification'=>'Se vocÃª nÃ£o quer adquirir novas notificaÃ§Ãµes ou vocÃª esqueceu  sua senha sinta-se livre para|notificaÃ§Ã£o',
'adjust your profile|notification'=>'ajustar o seu perfil|notificaÃ§Ã£o',
'Thanks for your time|notication'=>'Obrigado pelo seu tempo|notificaÃ§Ã£o',
'the management|notication'   =>'o gerenciamento|notificaÃ§Ã£o',
'No news for <b>%s</b>'       =>'Nenhuma novidade para <b>%s<b>',


);


?>
