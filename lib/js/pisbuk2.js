function confirmDialog() {
	var agree=confirm("Are you sure?");
	if (agree) return true;
	else return false;
}

function hide_me(id) {
	var e = document.getElementById(id);
	if(e.style.display == 'block') e.style.display = 'none';
	else e.style.display = 'block';
}

function lookup(inputString) {
    if(inputString.length == 0) {
        // Hide the suggestion box.
        $('#suggestions').hide();
    } else {
        $.post("ajax_predictsearch.php", {queryString: ""+inputString+""}, function(data){
            if(data.length >0) {
                $('#suggestions').show();
                $('#autoSuggestionsList').html(data);
            }
        });
    }
} // lookup
function fill(thisValue) {
    $('#inputString').val(thisValue);
   	$('#suggestions').hide();
}

function fixURL() {
	parts = window.location.href.split("#/");
	if(parts.length > 1) {
		window.location.href = parts[parts.length - 1];
	}
}

function changeURL(href) {
	href = (href == "") ? "/" : href;
	uri = window.location.href.split("#/");
	window.location.href = uri[0] + "#/" + href;
}

if(typeof jQuery == "function") {
	jQuery(document).ready(function($) {
		fixURL();
		$("#post-container").css("display", "block");
		init(jQuery, "body");

		$("a#writeup").click(function () {
		$("div#yirbuk").toggle("slow");
		});    

		$("a#boys").click(function () {
		$("span.boy").toggle("slow");
		});    

		$("a#girls").click(function () {
		$("span.girl").toggle("slow");
		});    

	});

	function init($, id) {
		id = (typeof(id) == 'undefined') ? "body" : id;


		$.ajaxSetup ({
			cache: false,
			beforeSend: function() {
			  $('#loading').show()
			},
			complete: function(){
			  $('#loading').hide()
			},
			success: function() {}
		});

		var ajax_load = "<img class='loading' src='../lib/img/pisbuk/ajax/indicator_small.gif' alt='loading...' />";
		
	//load_comments() functions
		$("a.viewall").click(function(){
			post_id = $(this).attr('id').split("-")[1];
			$("#commentcontainer-" + post_id)
				.html(ajax_load)
				.load("ajax_comments.php", "pid=" + post_id);
		});

	//load_likes() functions

		$("a.crush").click(function(){
			post_id = $(this).attr('id').split("-")[1];
			$("#likes-" + post_id)
				.show()
				.html(ajax_load)
				.load("ajax_likes.php", "pid=" + post_id);
		});

	//load_section($name) functions
		$("a.cp").click(function(){
			secname = $(this).attr('id');
			$("span.girl").toggle("slow");
			$("span.boy").toggle("slow");
			$("#cpholder")
				.html(ajax_load)
				.load("ajax_section.php", "name=" + secname);
		});
	//load_wini() functions
		$("a#wini").click(function(){
			$(".large-avatar")
				.html(ajax_load)
				.load("ajax_wini.php");
		});
	//comment link display comment form
		$("a.respondlink").click(function() {
			post_id = $(this).attr('id').split("-")[1];
			if(typeof(post_id) != "undefined") {
//				$(this).parent().next().next().css("display", "none");
				$(this).parent().next().next().next().css("display", "none");
				$("#commentform-" + post_id).css("display", "block");
				$("#commentform-" + post_id + " .focus:first").focus();
			} else {
				$(".respondtext").parent().css("display", "none");
				$("div#comment_form").css("display", "block");
				$("#commentform .focus:first").focus();
			}
			return false;
		});

	//comment textarea display comment form
		$(".respondtext").click(function() {
			$(this).parent().css("display", "none");
			if($(this).hasClass("single")) {
				$("a.respondlink").click();
			} else {
			//	$(this).parent().prev().prev().children("a.respondlink").click();
				$(this).parent().prev().prev().prev().children("a.respondlink").click();
			}
		});
	//autogrow no longer works within a table, still needed by comment form display

		$('textarea').not(".respondtext").autogrow({
			minHeight: 30
		});

	}
}
