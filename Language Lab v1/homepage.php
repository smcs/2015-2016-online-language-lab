<?php

require_once 'common.inc.php';

/* do lots of other prep work before displaying */
<script language="javascript">
<!--//
/*This Script allows people to enter by using a form that asks for a
UserID and Password*/
function pasuser(form) {
if (form.id.value=="ab") { 
if (form.pass.value=="1234") {              
location="page2.html" 
} else {
alert("Invalid Password")
}
} else {  alert("Invalid UserID")
}
}
//-->
</script>

$smarty->display('homepage.tpl');

?>