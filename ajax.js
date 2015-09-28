<!--
function submit() {
            if (document.getElementById('name').value != '' && document.getElementById('ip').value != '') {
                    show_table( document.getElementById('name').value, 
                                document.getElementById('ip').value, 
                                document.getElementById('http').checked, 
                                document.getElementById('https').checked,
                                document.getElementById('cert').value,
                                document.getElementById('test').checked,
                                document.getElementById('blog').checked,
                                document.getElementById('blogname').value,
                                document.getElementById('m').checked, 
                                document.getElementById('mtest').checked,
                                document.getElementById('comment').value);
                    document.getElementById('name').value = ''; 
                    document.getElementById('ip').value = ''; 
                    document.getElementById('http').checked = false; 
                    document.getElementById('https').checked = false;
                    document.getElementById('cert').value = '';
                    document.getElementById('test').checked = false;
                    document.getElementById('blog').checked = false;
                    document.getElementById('blogname').value = '';
                    document.getElementById('m').checked = false;
                    document.getElementById('mtest').checked = false;
                    document.getElementById('comment').value = '';
            }
        }

function show_table(name, ip, http, https, cert, test, blog, blogname, m, mtest, comment){
	var dataString = '&act=add' + 
                     '&name=' + name + 
                     '&ip=' + ip + 
                     '&http=' + http + 
                     '&https=' + https + 
                     '&cert=' + cert + 
                     '&test=' + test + 
                     '&blog=' + blog +
                     '&blogname=' + blogname +
                     '&m=' + m + 
                     '&mtest=' + mtest +
                     '&comment=' + comment;
	$.ajax({
	    url: "table.php",
	    data: dataString,
    	cache: false,
    	success: function(html){
			$('#table_div').html(html);
            $('#status_div').html("Updated.");
            setTimeout("document.getElementById('status_div').innerHTML = ''", 3000);
    	},
    	error: function(){
			$('#status_div').html("ERROR!!!");
		}
	});
}

function rem_el(id){
    var dataString = '&act=remove&id=' + id; 
    $.ajax({
        url: "table.php",
        data: dataString,
        cache: false,
        success: function(html){
            $('#table_div').html(html);
            $('#status_div').html("Deleted.");
            setTimeout("document.getElementById('status_div').innerHTML = ''", 3000);
        },
        error: function(){
            $('#status_div').html("ERROR!!!");
        }
    });
}

function edit(id){
    document.getElementById('name_'+id).readOnly=false;
    document.getElementById('ip_'+id).readOnly=false;
    document.getElementById('http_'+id).disabled=false;
    document.getElementById('https_'+id).disabled=false;
    document.getElementById('cert_'+id).readOnly=false;
    document.getElementById('test_'+id).disabled=false;
    document.getElementById('blog_'+id).disabled=false;
    document.getElementById('blogname_'+id).readOnly=false;
    document.getElementById('m_'+id).disabled=false;
    document.getElementById('mtest_'+id).disabled=false;
    document.getElementById('comment_'+id).readOnly=false;
    document.getElementById('edit_'+id).style.display="none";
    document.getElementById('save_'+id).style.display="block";
}

function save(id){
    var dataString = '&act=edit' + 
                     '&id=' + id + 
                     '&name=' + document.getElementById('name_'+id).value + 
                     '&ip=' + document.getElementById('ip_'+id).value + 
                     '&http=' + document.getElementById('http_'+id).checked + 
                     '&https=' + document.getElementById('https_'+id).checked + 
                     '&cert=' + document.getElementById('cert_'+id).value + 
                     '&blog=' + document.getElementById('blog_'+id).checked + 
                     '&blogname=' + document.getElementById('blogname_'+id).value + 
                     '&test=' + document.getElementById('test_'+id).checked + 
                     '&m=' + document.getElementById('m_'+id).checked + 
                     '&mtest=' + document.getElementById('mtest_'+id).checked +
                     '&comment=' + escape(document.getElementById('comment_'+id).value);
    $.ajax({
        url: "table.php",
        data: dataString,
        cache: false,
        success: function(html){
            $('#table_div').html(html);
            $('#status_div').html("Saved (id=" + id + ").");
            setTimeout("document.getElementById('status_div').innerHTML = ''", 3000);
        },
        error: function(){
            $('#status_div').html("ERROR!!!");
        }
    });
}

function generate(id){
    var dataString = '&id=' + id;
    $.ajax({
        url: "generator.php",
        data: dataString,
        cache: false,
        success: function(html){
            $('#status_div').html("Generated." + html);
            setTimeout("document.getElementById('status_div').innerHTML = ''", 3000);
        },
        error: function(){
            $('#status_div').html("ERROR!!!");
        }
    });
}

function fade(){
    if (document.getElementById('https').checked) 
        $('#cert').fadeIn(); 
    else 
        $('#cert').fadeOut();
}

function fadeblog(){
    if (document.getElementById('blog').checked) 
        $('#blogname').fadeIn(); 
    else 
        $('#blogname').fadeOut();
}

$(function() {
                $(document).on('mousemove', 'textarea', function(e) {
                    var a = $(this).offset().top + $(this).outerHeight() - 16,  //  top border of bottom-right-corner-box area
                        b = $(this).offset().left + $(this).outerWidth() - 16;  //  left border of bottom-right-corner-box area
                    $(this).css({
                        cursor: e.pageY > a && e.pageX > b ? 'se-resize' : ''
                    });
                })
});

$(function() {
                $(document).on('click', 'tr', function() {
                    $('#tr').css({
                        outline: ''
                    });
                    $(this).css({
                        outline: 'solid thin'
                    });
                })
})
-->
