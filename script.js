<!--
function submit() {
            if (document.getElementById('name').value != '' && document.getElementById('ip').value != '') {
                show_table( document.getElementById('name').value, 
                            document.getElementById('ip').value,
                            document.getElementById('www').checked,
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
                document.getElementById('www').checked = false;
                document.getElementById('http').checked = false; 
                document.getElementById('https').checked = false;
                document.getElementById('cert').value = '';
                document.getElementById('test').checked = false;
                document.getElementById('blog').checked = false;
                document.getElementById('blogname').value = '';
                document.getElementById('m').checked = false;
                document.getElementById('mtest').checked = false;
                document.getElementById('comment').value = '';
            } else {
                $('#newtable').addClass('wobble-horizontal');
                window.setTimeout(function(){$('#newtable').removeClass('wobble-horizontal')}, 1000);

            }
        }

function show_table(name, ip, www, http, https, cert, test, blog, blogname, m, mtest, comment){
	var dataString = '&act=add' + 
                     '&name=' + name + 
                     '&ip=' + ip + 
                     '&www=' + www + 
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
    document.getElementById('www_'+id).disabled=false;
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
                     '&www=' + document.getElementById('www_'+id).checked + 
                     '&http=' + document.getElementById('http_'+id).checked + 
                     '&https=' + document.getElementById('https_'+id).checked + 
                     '&cert=' + document.getElementById('cert_'+id).value + 
                     '&blog=' + document.getElementById('blog_'+id).checked + 
                     '&blogname=' + document.getElementById('blogname_'+id).value + 
                     '&test=' + document.getElementById('test_'+id).checked + 
                     '&m=' + document.getElementById('m_'+id).checked + 
                     '&mtest=' + document.getElementById('mtest_'+id).checked +
                     '&comment=' + encodeURIComponent(document.getElementById('comment_'+id).value);
    $.ajax({
        url: "table.php",
        data: dataString,
        cache: false,
        success: function(html){
            $('#table_div').html(html);
            $('#status_div').html("Saved (id=" + id + ").");
            setTimeout("document.getElementById('status_div').innerHTML = ''", 3000);
            $("#maintable tr").each(function(){
                $(this).attr("tabindex", 1);
            })
            var thisstr = $($("#maintable tr").get(getCookie("index")-1));
            thisstr.addClass("active");
            thisstr.focus();
        },
        error: function(){
            $('#status_div').html("ERROR!!!");
        }
    });
}

function generate(id){
    if (isempty(id) && !confirm('Do you wanna to regenerate all?')) {
        return false;
    }
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
        $('#cert').prop('readonly', false); 
    else 
        $('#cert').prop('readonly', true);;
}

function fadeblog(){
    if (document.getElementById('blog').checked) 
        $('#blogname').prop('readonly', false);
    else 
        $('#blogname').prop('readonly', true);
}

function textSelector(s){
    var tr = eval(s);
    tr.focus();
    tr.select();
}

function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(name) {
    var cookie = " " + document.cookie;
    var search = " " + name + "=";
    var setStr = null;
    var offset = 0;
    var end = 0;
    if (cookie.length > 0) {
        offset = cookie.indexOf(search);
        if (offset != -1) {
            offset += search.length;
            end = cookie.indexOf(";", offset)
            if (end == -1) {
                end = cookie.length;
            }
            setStr = unescape(cookie.substring(offset, end));
        }
    }
    return(setStr);
}

$(function() {
    $(document).ready(function() { 
        var thisstr = $($("#maintable tr").get(getCookie("index")-1));
        thisstr.addClass("active");
        thisstr.focus();
    });

    $(document).on('mousemove', 'textarea', function(e) {
        var a = $(this).offset().top + $(this).outerHeight() - 16,
            b = $(this).offset().left + $(this).outerWidth() - 16;
        $(this).css({
            cursor: e.pageY > a && e.pageX > b ? 'se-resize' : ''
        });
    })

    $(document).on('click', 'textarea', function() {
        $('textarea.comment').removeClass('comment');
        $(this).addClass('comment');
    })


    $(document).on('click', '#maintable tr', function(e) {
        var div = $("textarea");
        if (!div.is(e.target)) {
            $('textarea.comment').removeClass('comment');
        }

        $('tr.active').removeClass('active');
        $(this).addClass('active');
        if ($(this).find("input:nth-child(1)").get(0).readOnly) {
            $(this).focus();
        }
        setCookie("index",$(this).index()+1);
    })

    $("#maintable tr").each(function(){
        $(this).attr("tabindex", 1);
    })

    $(document).on('keydown', '#maintable tr', function(e) {
        var curr = $(this);
        if(e.keyCode == 40 ){
            e.preventDefault();
            var next = $($("#maintable tr").get(curr.index()+1));
            if (next.index() <= 0) { next = $($("#maintable tr").get(0)); }
            $('tr.active').removeClass('active');
            next.addClass("active");
            next.focus();
            setCookie("index",curr.index()+2);
        } else if (e.keyCode == 38) {
            e.preventDefault();
            var prev = $($("#maintable tr").get(curr.index()-1));
            $('tr.active').removeClass('active');
            prev.addClass("active");
            prev.focus();
            setCookie("index",curr.index());
        }
    })
})

function toggle_visibility(id) {
    var e = document.getElementById(id);
    if(e.style.display == 'block')
        e.style.display = 'none';
    else
        e.style.display = 'block';
}

function isempty(mixed_var) {
    return ( mixed_var === ""    ||
             mixed_var === 0     ||
             mixed_var === "0"   ||
             mixed_var === null  ||
             mixed_var === false ||
             mixed_var === undefined ) ;
}

-->
