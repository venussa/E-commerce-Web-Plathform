var base_url = $("#base-url").attr("href");

function readURL(input,pos) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {

    	var active_data = $("#upload-plus").attr("data");

    	var position = parseInt($("#upload-plus").attr("data"));

      	if($("edit").attr("data") == "false"){

      		var image = '<img src="'+e.target.result+'" id="act-img-'+active_data+'" edit="true" data="'+active_data+'" onClick="upload_image(this)" style="border:1px #ddd solid;margin:5px;width:90px;height:90px;margin-top:5px;cursor: pointer;">';

      		$("#preview-img").append(image);

      		if(position > 5) $("#upload-plus").hide();

  		}else{

  			$("#act-img-"+$("edit").html()).attr("src",e.target.result);

  		}
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

for(var i = 1; i <= 5; i++){

	$("#img"+i).change(function() {
	  
	  readURL(this);

	  var position = parseInt($("#upload-plus").attr("data")) + 1;

	  $("#upload-plus").attr("data",position);

	});

}

function upload_image(data){

	var urut = $(data).attr("data");

	$("edit").attr("data",$(data).attr("edit"));

	$("edit").html($(data).attr("data"));

	$("#img"+urut).click();

}

function set_status_user(obj){

	$.ajax({

		type : "POST",
		url : base_url+"/adminpanel/set_active",
		data : {id:$(obj).attr("sort-id"),type:"users"},
		success : function(event){

			if(event.indexOf("<true/>") !== -1){

				$(obj).attr("src",base_url+"/sources/img/on.png");

			}else{

				$(obj).attr("src",base_url+"/sources/img/off.png");

			}

		},
		error : function(){

			alert("error");

		}

	});

}

function set_status(obj){

	$.ajax({

		type : "POST",
		url : base_url+"/adminpanel/set_active",
		data : {id:$(obj).attr("sort-id"),type : "product"},
		success : function(event){

			if(event.indexOf("<true/>") !== -1){

				$(obj).attr("src",base_url+"/sources/img/on.png");

			}else{

				$(obj).attr("src",base_url+"/sources/img/off.png");

			}

		},
		error : function(){

			alert("error");

		}

	});

}

function set_status_page(obj){

	$.ajax({

		type : "POST",
		url : base_url+"/adminpanel/set_active",
		data : {id:$(obj).attr("sort-id"),type : "page"},
		success : function(event){

			if(event.indexOf("<true/>") !== -1){

				$(obj).attr("src",base_url+"/sources/img/on.png");

			}else{

				$(obj).attr("src",base_url+"/sources/img/off.png");

			}

		},
		error : function(){

			alert("error");

		}

	});

}


function change_position(obj){

	$.ajax({

		type : "POST",
		url : base_url+"/adminpanel/set_active",
		data : {id:$(obj).attr("data-id"),type : "post",vals : $(obj).val()},
		success : function(event){

		},
		error : function(){

			alert("error");

		}

	});


}

function delete_product(id,slug){

	if(confirm("Anda yakin ingin menghapus data ini ? ") == true){

		window.location=base_url+"/adminpanel/"+slug+"?id="+id;
		
	}

}

function search_bank(obj){
		window.location=base_url+"/adminpanel/bank?q="+$(obj).val();
}

function search_data(obj){

	window.location=base_url+"/adminpanel/product?q="+$(obj).val();

}

function search_order(obj){

	window.location=base_url+"/adminpanel/orders?q="+$(obj).val()+"&m="+$("#month").val()+"&y="+$("#years").val();;

}

function search_money(obj){

	window.location=base_url+"/adminpanel/money?q="+$(obj).val();

}

function search_user(obj){

	window.location=base_url+"/adminpanel/users?q="+$(obj).val();

}

function search_blog(obj){

	window.location=base_url+"/adminpanel/blogs?q="+$(obj).val();

}

function go_filter(obj){

	window.location=base_url+"/adminpanel/orders?q="+$(obj).val();	
}

function order_filter(m,y,q){
	
	window.location=base_url+"/adminpanel/orders?q="+q+"&m="+$("#"+m).val()+"&y="+$("#"+y).val();	

}

function change_sub_category(obj){

	$.ajax({

		type : "POST",
		url : base_url+"/adminpanel/subcategory",
		data : {title:$(obj).val()},
		success : function(event){

			var data = event.split("|");

			$("#child-category-select").html(data[0]);
			$("#child-category").html(data[1]);

		}

	});

}

function load_chat(obj){

	// $(".list-chat .list-data").css({
	// 	"background" : "transparent"
	// });

	// $(obj).css({
	// 	"background" : "#d9ecff"
	// });

	$.ajax({

		type : "POST",
		url : base_url+"/adminpanel/chat_list",
		data : {

			user_id : $(obj).attr("user_id"),
			room : $(obj).attr("room"),
			type : "list",
			status : $("#chat-list").attr("status")

		},
		beforeSend : function(){

		},

		success : function(event){
			$(".input-chat").show();
			$(".top-box").css({"height":"420px"});
			$("#chat-data-list").html(event);
			$("#form").attr("user_id",$(obj).attr("user_id"));
			$("#form").attr("room",$(obj).attr("room"));
			$(".uid").val($(obj).attr("user_id"));
			$(".room").val($(obj).attr("room"));
			$(".alert-"+$(obj).attr("alert-el")).hide();
			$(".chat-box .header").show();

			$(".typing").removeClass("typing-"+$(".typing").attr("data"));
			$(".finish-typing").removeClass("finish-typing-"+$(".finish-typing").attr("data"));

			$(".typing").attr("data",$(obj).attr("user_id"));
			$(".finish-typing").attr("data",$(obj).attr("user_id"));

			$(".typing").addClass("typing-"+$(obj).attr("user_id"));
			$(".finish-typing").addClass("finish-typing-"+$(obj).attr("user_id"));

			
			$(".chat-box .header #title-username").html($(obj).attr("name"));
			$("#chat-username").html("( "+$(obj).attr("username")+" )");
			$(".chat-box .header .times").html($(obj).attr("date"));
			$(".chat-box .header img").attr("src",$(obj).attr("img"));

			setTimeout(function(){
				$('#chat-list').scrollTop($('#chat-list')[0].scrollHeight);
			},1000);

		}

	});

}

function send_chat(obj){

	$.ajax({

		type : "POST",
		url : base_url+"/adminpanel/chat_list",
		data : {

			user_id : $(obj).attr("user_id"),
			room : $(obj).attr("room"),
			type : "send",
			chat : $(obj).find("textarea").val(),
			chat_type : $(obj).attr("chat_type"),
			order_id : $("#chat-list").attr("status")

		},

		beforeSend : function(){
			$("#form").find("textarea").attr("readonly","true");
			$("#form").find("textarea").css({"background":"#f5f5f5"});
		},

		success : function(event){
			$("#chat-data-list").append(event);
			$("#form").find("textarea").removeAttr("readonly");
			$("#form").find("textarea").css({"background":""});
			$("#form").find("textarea").val("");
			$('#chat-list').scrollTop($('#chat-list')[0].scrollHeight);
			

		}

	});

	return false;

}

function close_preview(){
	$("#preview-upload").hide();
	$("#preview-upload").css({
		"left" : "-100%"
	});
	$(".input-img").val("");
}

function click_upload(id){

	$("#"+id).click();

}

function open_preview(){
	$("#preview-upload").show();
	$("#preview-upload").animate({
		"left" : "0"
	});
}

function readIMG(input, id) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#'+id).attr('src', e.target.result);
      open_preview();
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$("#file-upload").change(function() {
  readIMG(this,"img-prev");
});

$("#input-icon").change(function() {
  readIMG(this,"img-icon");
});

$("#input-logo").change(function() {
  readIMG(this,"img-logo");
});

$("#input-thumbnail").change(function() {
  readIMG(this,"img-thumbnail");
});

$("#input-thumbnail-0").change(function() {
  readIMG(this,"img-thumbnail-0");
});

$("#input-thumbnail-1").change(function() {
  readIMG(this,"img-thumbnail-1");
});

$("#input-thumbnail-2").change(function() {
  readIMG(this,"img-thumbnail-2");
});

$("#input-thumbnail-3").change(function() {
  readIMG(this,"img-thumbnail-3");
});

$("#upload-image").submit(function(){

	$.ajax({
		type : "post",
		url : base_url+"/adminpanel/chat_list",
		data : new FormData(this),
		contentType: false,
		cache: false,
		processData:false,
		beforeSend:function(){
			$(".input-img").attr("readonly","true");
		},
		success : function(event){
			$(".input-img").val("");
			$("#chat-data-list").append(event);
			$(".input-img").removeAttr("readonly");
			$('#chat-list').scrollTop($('#chat-list')[0].scrollHeight);
			close_preview();
		}
	});

	return false;

});

function select_box(obj){

		$.ajax({

			type : "POST",
			url : base_url+"/adminpanel/teritory",
			data: {
				code : $(obj).attr("code"),
				type : $(obj).attr("type")
			},
			success : function(event){

				switch($(obj).attr("type")){

					case "provinsi":

						$("#provinsi").val($(obj).html());
						$(".select-provinsi").html($(obj).html());
						$(".box-kabupaten").html(event);
						show_select("provinsi");

					break;

					case "kabupaten":

						$("#kabupaten").val($(obj).html());
						$(".select-kabupaten").html($(obj).html());
						$(".box-kecamatan").html(event);
						show_select("kabupaten");

						$(".box-kecamatan .select-list").attr("code",$(obj).attr("code"));

					break;

					case "kecamatan":

						$("#kecamatan").val($(obj).html());
						$(".select-kecamatan").html($(obj).html());
						$(".box-kodepos").html(event);
						show_select("kecamatan");

					break;

					case "kodepos":

						$("#kodepos").val($(obj).html());
						$(".select-kodepos").html($(obj).html());
						show_select("kodepos");

					break;

				}

			}

		});

}

function show_select(data){



	if($(".box-"+data).css("display") == "none"){
		$(".select-box").hide();
		$(".box-"+data).show();

	}else{

		$(".box-"+data).hide();		

	}


}

function change_password(){

	
	if($("#modal-password").css("display") == "none"){

		$("#modal-password").show();

	}else{

		$("#modal-password").hide();

	}

}

function change_email(){

	if($("#modal-email").css("display") == "none"){

		$("#modal-email").show();

	}else{

		$("#modal-email").hide();

	}
	

}


function check_data(){

	$("#checkbox-data").prop("checked",true);

	setTimeout(function(){
		$("#submit-profile-data").click();
	},500);

}

$("[name='district']").change(function(){

	$("[name='zip_code']").val($(this).val());

});

$("[name='province']").change(function(){

	$.ajax({

		type : "post",
		url : base_url+"/clientarea/get_region",
		data : {

			region  : 'kabupaten',
			kode 	: $(this).val(),

		},
		success: function(event){

			var result = event.split("|");

			$("[name='state']").html(result[0]);
			$("[name='district']").html(result[1]);
			$("[name='zip_code']").val(result[2]);

		}

	});

});

$("[name='state']").change(function(){

	$.ajax({

		type : "post",
		url : base_url+"/clientarea/get_region",
		data : {

			region  : 'kecamatan',
			kode 	: $(this).val(),

		},
		success: function(event){

			var result = event.split("|");
			$("[name='district']").html(result[0]);
			$("[name='zip_code']").val(result[1]);

		}

	});

});

$("button").click(function(){

	$("option").removeAttr("value");
	

});

function slugify(text)
{
    return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')
            .replace(/\-+$/, '');
}

function create_slug(obj){

	$("#slugs").val(slugify($(obj).val()));

}
