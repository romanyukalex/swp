<? /******************************************************************
  * Snippet Name : body           				 					 *
  * Scripted By  : RomanyukAlex		           						 *
  * Website      : http://popwebstudio.ru	   						 *
  * Email        : admin@popwebstudio.ru     					     *
  * License      : License on popwebstudio.ru	from autor		 	 *
  * Purpose 	 : Тело страницы обрамленное тегами <body></body>	 *
  * Insert		 : include_once('/templates/$currenttemplate/body.php');						 *
  *******************************************************************/

###################################################
# Начало шаблона
###################################################

#####################################
# Required 1						#
#####################################
$log->LogInfo("Got ".(__FILE__));
?>
</head><?
if(!$block and $nitka=="1"){ // Проверили, не запретил ли какой-нибудь скрипт показ тела страницы и что не запущен только body
	if (($showsiteforguest=="Не разрешать" and $userrole!=="guest") or $showsiteforguest=="Разрешать"){
#####################################
# // Required 1						#
#####################################?>
<body>
<? if($enablegatagcount!=="Не включать") insert_module("counter-ga_tagmanager");
#####################################
# Body user part					#
#####################################


$jsonString = '
{	"js_top":"<script>alert(\'hi\')</script>",
	"js_bottom":"<script>alert(\'hi bottom\')</script>",
	"div":[
		{
		  "order": 1,
			"divStyle":"background-color:#000",
			"divClass": "someclass second_classs",
			"div":[
				{
					"desktop_col":8,
					"mobile_col":12,
					"tablet_col":8,
					"large_desktop_col":8,
					"html":"<b>TEST</b>"
				},
				{
					"desktop_col":4,
					"mobile_col":6,
					"tablet_col":4,
					"large_desktop_col":4,
					"html":"<b>TEST2</b>",
					"divStyle":"color:blue; font-size:bold"

				}
			]
		},
		{
		  "order": 2,
			"divStyle":"background-color:green",
			"divClass": "someclass second_classs",
			"div":[
				{
					"desktop_col":4,
					"mobile_col":6,
					"tablet_col":8,
					"large_desktop_col":4,
					"html":"<b>TEST3</b>",
					"page":"wifi_reg"
				},
				{
					"desktop_col":4,
					"mobile_col":6,
					"tablet_col":4,
					"large_desktop_col":4,
					"html":"<b>TEST4</b>",
					"divClass":"class1",
					"page":"page_manage"

				},
				{
					"desktop_col":4,
					"mobile_col":6,
					"tablet_col":8,
					"large_desktop_col":4,
					"html":"<b>TEST5</b>",
					"module":"loginform_simple"

				}
			]
		}
	  ]
	}
';

$cart = json_decode( $jsonString, true );
if($cart["js_top"]){echo $cart["js_top"];}
foreach ($cart["div"] as $car){
	// xs (phones), sm (tablets), md (desktops), and lg (larger desktops)
	?><div class="row <?=$car["divClass"]?>" style="<?=$car["divStyle"]?>">
		<? foreach($car["div"] as $intdiv){
		?><div class="<?
			if($intdiv["mobile_col"])?>col-xs-<?=$intdiv["mobile_col"];
			if($intdiv["tablet_col"])?> col-sm-<?=$intdiv["tablet_col"];
			if($intdiv["desktop_col"])?> col-md-<?=$intdiv["desktop_col"];
			if($intdiv["large_desktop_col"])?> col-lg-<?=$intdiv["large_desktop_col"];
			if($intdiv["divClass"])?> <?=$intdiv["divClass"]; ?>
			"<? if($intdiv["divStyle"]) {?>style="<?=$intdiv["divStyle"];?>"<?}?>
			>
		<?if($intdiv["page"]) {
			if($intdiv["page"]!=="page_manage") $page=$intdiv["page"]; 
			include($_SERVER["DOCUMENT_ROOT"]."/core/pagemanage.php");
			 
		}
		elseif($intdiv["module"]) { insert_module($intdiv["module"]);}
		elseif($intdiv["html"]) echo $intdiv["html"];?>

		</div><?
		}?>
	</div>
	
	
	
	
	
	   <p>Click the buttons on datagrid toolbar to do crud actions.</p>
    
    <table id="dg" title="My Users" class="easyui-datagrid" style="width:700px;height:250px"
            url="get_users.php"
            toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
        <thead>
            <tr>
                <th field="firstname" width="50">First Name</th>
                <th field="lastname" width="50">Last Name</th>
                <th field="phone" width="50">Phone</th>
                <th field="email" width="50">Email</th>
            </tr>
        </thead>
    </table>
    <div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New User</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Edit User</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remove User</a>
    </div>
    
    <div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle">User Information</div>
        <form id="fm" method="post" novalidate>
            <div class="fitem">
                <label>First Name:</label>
                <input name="firstname" class="easyui-textbox" required="true">
            </div>
            <div class="fitem">
                <label>Last Name:</label>
                <input name="lastname" class="easyui-textbox" required="true">
            </div>
            <div class="fitem">
                <label>Phone:</label>
                <input name="phone" class="easyui-textbox">
            </div>
            <div class="fitem">
                <label>Email:</label>
                <input name="email" class="easyui-textbox" validType="email">
            </div>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
    <script type="text/javascript">
        var url;
        function newUser(){
            $('#dlg').dialog('open').dialog('center').dialog('setTitle','New User');
            $('#fm').form('clear');
            url = 'save_user.php';
        }
        function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('center').dialog('setTitle','Edit User');
                $('#fm').form('load',row);
                url = 'update_user.php?id='+row.id;
            }
        }
        function saveUser(){
            $('#fm').form('submit',{
                url: url,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close');        // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
        function destroyUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
                    if (r){
                        $.post('destroy_user.php',{id:row.id},function(result){
                            if (result.success){
                                $('#dg').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
    </script>
    <style type="text/css">
        #fm{
            margin:0;
            padding:10px 30px;
        }
        .ftitle{
            font-size:14px;
            font-weight:bold;
            padding:5px 0;
            margin-bottom:10px;
            border-bottom:1px solid #ccc;
        }
        .fitem{
            margin-bottom:5px;
        }
        .fitem label{
            display:inline-block;
            width:80px;
        }
        .fitem input{
            width:160px;
        }
    </style>
	
	
	
	
	
	
	
	
	
	
	
	<?
}
if($cart["js_bottom"]){echo $cart["js_bottom"];}
#####################################
# // Body							#
#####################################
?></body><?
#####################################
# Required 2						#
#####################################
	}
	else{?><body><?
		insert_module("loginform_simple");
		?></body><?
	}
} else {echo "Запрещен вход на сайт";
}
#####################################
# // Required 2						#
#####################################?>