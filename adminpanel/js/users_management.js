var UsersManagement = {	
	onButtonClick: function() { // Меню управдения разделами
		var id = this.id;
		var action = "show_usmanag_page";
		if (id == "users_management_users_button") {
			action = "show_usmanag_page";
		}
		else if (id == "users_management_groups_button") {
			action = "show-groups";
		}
		else if (id == "users_management_groups_right_button") {
			action = "show-group-right";
		}
		else if (id == "users_management_groups_member_button") {
			action = "show-group-member";
		}
		else if (id == "users-management-user-sndnewpss") {
			action = "send_user_new_pass";
		}
		else if (id == "users_management_company_button") {
			action = "show_comp_page";
		}
		ajaxreq("","",action,"users_management_content","usersmanagement");
	},
	onUserEdit: function() {
		var id = this.id;
		var parts = id.split("user_row_");
		var userid = parts[1];
		var action="show-user";		
		$("#users_management_content").load("/core/ajaxapi.php", {mod:"adminpanel",action:action,userid:userid});
	}	
};

$(function() {	
	$(".users-management-menu-button").click(UsersManagement.onButtonClick);	
	UsersManagement.onButtonClick();	
});
