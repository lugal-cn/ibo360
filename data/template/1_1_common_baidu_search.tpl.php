<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!-- 代码来源：百度开发平台 -->
<!-- http://help.baidu.com/question?prod_en=search&class=%C3%E2%B7%D1%B4%FA%C2%EB&id=1000664 -->
<!-- 默认平台代码有HTML bug，需要手工修改。 -->

<SCRIPT language=javascript>
function gowhere1(formname)
{
 var url;
 if (formname.myselectvalue.value == "0")
 {
  url = "http://www.baidu.com/baidu";
  document.search_form1.tn.value = "baidu";
  formname.method = "get";
 }
 if (formname.myselectvalue.value == "1")
 {
  url = "http://mp3.baidu.com/m";
  document.search_form1.tn.value = "baidump3";
  document.search_form1.ct.value = "134217728";
  document.search_form1.lm.value = "-1";
 }

 if (formname.myselectvalue.value == "4")
 {
  document.search_form1.tn.value = "news";
  document.search_form1.cl.value = "2";
  document.search_form1.rn.value = "20";
  url = "http://news.baidu.com/ns";
 }
 if (formname.myselectvalue.value == "5")
 {
  document.search_form1.tn.value = "baiduiamge";
  document.search_form1.ct.value = "201326592";
  document.search_form1.cl.value = "2";
  document.search_form1.lm.value = "-1";
  url = "http://image.baidu.com/i";
}
if (formname.myselectvalue.value == "6")
 {
  url = "http://post.baidu.com/f";
  document.search_form1.tn.value = "baiduPostSearch";
  document.search_form1.ct.value = "352321536";
  document.search_form1.rn.value = "10";
  document.search_form1.lm.value = "65536";
 }

  formname.action = url;
 return true;
}
</SCRIPT>
<center>
<form name="search_form1" target="_blank" onsubmit="return gowhere1(this)">
<table width="400" height="60" border="0" cellpadding="0" cellspacing="0" style=font-family:宋体>
<tr>
<td>
<INPUT name=myselectvalue type=hidden value=0 />
<INPUT name=tn type=hidden>
<INPUT name=ct type=hidden>
<INPUT name=lm type=hidden>
<INPUT name=cl type=hidden>
<INPUT name=rn type=hidden>

<TABLE width="100%" height="80" border=0 cellPadding=0 cellSpacing=0>
<TR>
    				<TD vAlign=bottom width="92%">
<INPUT name=myselect onclick=javascript:this.form.myselectvalue.value=4; type=radio value=0>
<FONT color=#0000cc style="FONT-SIZE: 12px">新闻</FONT>

<INPUT CHECKED name=myselect onclick=javascript:this.form.myselectvalue.value=0; type=radio value=0>
<SPAN class=f12>
<FONT color=#0000cc style="FONT-SIZE: 12px">网页</FONT>
</SPAN>
<INPUT name=myselect onclick=javascript:this.form.myselectvalue.value=1; type=radio value=1>

<SPAN class=f12><FONT color=#0000cc style="FONT-SIZE: 12px">音乐</FONT></SPAN>
<INPUT name=myselect onclick=javascript:this.form.myselectvalue.value=6; type=radio value=0>

<FONT color=#0000cc style="FONT-SIZE: 12px">贴吧</FONT>
<INPUT name=myselect onclick=javascript:this.form.myselectvalue.value=5; type=radio value=0>
<FONT color=#0000cc style="FONT-SIZE: 12px">图片</FONT>

<TABLE align=right border=0 cellPadding=0 cellSpacing=0 width="100%">
<TBODY>
<TR>
<TD>
<FONT style="FONT-SIZE: 12px">
                            					<input id=word name=word size="40">
                            				</FONT> 
                            				<input type="submit" value="百度一下"> 
                           				</TD>
</TR>
</TBODY>
</TABLE>
</TD>
</TR>
</TABLE>
</td>
</tr>
</table>
</form>
</center>