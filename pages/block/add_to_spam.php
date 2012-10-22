<script>
function myfunc(event){

if(event.keyCode==13){document.addspam.submit();}//если нажат enter.....
};
</script>
<form action="" name = "addspam" method="post" >
<input type="hidden" name="sender" value="add_to_spam">
<div class="news_suscribe" align="right">
				<div align="left"><p>&nbsp;&nbsp;&nbsp;Подписаться на новости<p><p>&nbsp;&nbsp;&nbsp;<input  type="text" name = "meil" id="text_box_subscribe" onKeyDown="myfunc(event)" /></p></div>
</div>

</form>