<!--
function submit() {
            if (document.getElementById('name').value != '' && document.getElementById('ip').value != '') {
                    show_table(document.getElementById('name').value, 
                        document.getElementById('ip').value, 
                        document.getElementById('http').checked, 
                        document.getElementById('https').checked,
                        document.getElementById('cert').value,
                        document.getElementById('test').checked, 
                        document.getElementById('m').checked, 
                        document.getElementById('mtest').checked); 
                    document.getElementById('name').value = ''; 
                    document.getElementById('ip').value = ''; 
                    document.getElementById('http').checked = false; 
                    document.getElementById('https').checked = false;
                    document.getElementById('cert').value = '';
                    document.getElementById('test').checked = false; 
                    document.getElementById('m').checked = false; 
                    document.getElementById('mtest').checked = false;
            }
        }

function show_table(name, ip, http, https, cert, test, m, mtest){
	var dataString = '&act=add' + '&name=' + name + '&ip=' + ip + '&http=' + http + '&https=' + https + '&cert=' + cert + '&test=' + test + '&m=' + m + '&mtest=' + mtest; 
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
    document.getElementById('m_'+id).disabled=false;
    document.getElementById('mtest_'+id).disabled=false;
}

function edit_el(id){
    var dataString = '&act=edit' + '&id=' + id + '&name=' + name + '&ip=' + ip + '&http=' + http + '&https=' + https + '&cert=' + cert + '&test=' + test + '&m=' + m + '&mtest=' + mtest; 
    $.ajax({
        url: "table.php",
        data: dataString,
        cache: false,
        success: function(html){
            $('#table_div').html(html);
            $('#status_div').html("Edited.");
            setTimeout("document.getElementById('status_div').innerHTML = ''", 3000);
        },
        error: function(){
            $('#status_div').html("ERROR!!!");
        }
    });
}

function generate(){
    $.ajax({
        url: "generator.php",
        cache: false,
        success: function(html){
            $('#status_div').html("Generated.");
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

-->
