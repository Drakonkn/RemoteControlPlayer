<script type="text/javascript">
	 var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++)
    {   
        var spcook =  cookies[i].split("=");
        deleteCookie(spcook[0]);
    }
    function deleteCookie(cookiename)
    {
        var d = new Date();
        d.setDate(d.getDate() - 1);
        var expires = ";expires="+d;
        var name=cookiename;
        alert(name);
        var value="";
        document.cookie = name + "=" + value + expires + "; path=vk.com";                    
    }
    window.location = ""; // TO REFRESH THE PAGE
</script>
<?php
?>