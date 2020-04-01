$(document).ready(function() {
	$('#users-list').DataTable();
} );

$(".user").click(function() {
	//$("#users-list_wrapper").width("70%");
	$(".loader").show();
	$('html, body').animate({
		scrollTop: $("#user-detail").offset().top
	}, 2000);
	var user_id = $(this).attr("data-user-id");
	var result_html = "";
	$.ajax({
		type : "GET",
		url : "https://jsonplaceholder.typicode.com/users/"+user_id,
		success: function(response) {
			if(response) {
				result_html += "<table id = 'user-result'><thead><tr><th colspan = '2'>User Details</th></tr></thead><tbody>";
				$.each(response,function(key,value) {
					if($.inArray(key,['address','company']) == -1) {
						result_html += "<tr><td class = 'user-key'>"+key+"</td><td>"+value+"</td></tr>";
					}
				});
				result_html += "</tbody></table>";
				$(".loader").hide();
				$("#user-detail").html(result_html);

			} else {
				$(".loader").hide();
				$("#user-detail").css("color","red");
				$("#user-detail").html("No user found!");
			}
		},
		error: function (response) {
			$(".loader").hide();
			$("#user-detail").css("color","red");
			$("#user-detail").html("Some error occured. Please try again!");
		},
	}) 
});