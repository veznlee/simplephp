<?php

//注释:
<!--test-->

<!--
:载入顶部的"常用工具条"
-->

//字符串引用，拼接的时候点的两边需用空格隔开
<h3>[$mhret.name]</h3>
<a href="[@encrypt_url('action=mh&method=content&tpxw=1&contentId=' . $var.id)]" target="_blank">

其中的@encrypt_url()为调用方法


//载入文件
<pp:include file="mh/inc_common_top.tpl" type="tpl" />


//if判断
<if test="$retIsKuanTpl.isKuanTpl == 1">
	<!--代码块-->
</if>

<if test="$retIsKuanTpl.isKuanTpl == 1">
	<!--代码块-->
<else>
	<!--代码块-->
</if>

<if test="$retIsKuanTpl.isKuanTpl == 1">
	<!--代码块-->
<elseif test="$retIsKuanTpl.isKuanTpl == 2">
	<!--代码块-->
</if>

<if test="$columninfo.columnTips=='mycontent'">
	<ul class="news_list"></ul>
<elseif test="$columninfo.columnTips=='favorite'">
	<ul class="news_list"></ul>
<else>
	<if test="$columninfo.showtype==1">
		<ul class="news_list"></ul>
	<elseif test="$columninfo.showtype==2">
		<ul class="sub_tk"></ul>
	</if>
</if>


<li <if test="$key==0">class="cur"</if>>
	<a href="[@encrypt_url('action=mh&method=content&tpxw=1&contentId=' . $var.id)]" target="_blank">
		<img src="[$PreviewUrl]/[$logo]@437w_328h_100q.jpg" width="437" height="328"/>
	</a>
</li>


//循环,数据为ret1.data，var 为每一项的值，key为索引值
<loop name="ret1.data" var="var" key="key">          
	<input name="" type="button" class="guide_btn" 
	onclick="window.open('[@encrypt_url('action=mh&method=aboutinfo&contentId=' . $var.id)]')" 
	value="[$ret1.columnName]" />
</loop>


//看不懂1
<pp:appfunc app="publish" file="appfunc/general" return="ret1" funcname="getColumnDataByArea('a_2_1',9)"/>
<pp:appfunc app="publish" file="appfunc/general" return="ret2" funcname="getColumnDataByArea('a_2_2',9)"/>


//数据查询，返回的结果为ret
<cms action="sql" return="ret" query="select * from mh_publish_content where addUser='{$user.staffNo}' order by publishTime desc " num="page-3"/>
        

//if嵌套使用		
<if test="$var.id != '' && $var.columnGuid != ''">
	<li>
		<if test="$var.typeName==space">
			<var name="contentype" value="space_content"/>
		<elseif test="$var.typeName==mh">
			<var name="contentype" value="content"/>
		<else>
		</if>
		<div style="display:none;">[$var.id]--[$var.columnGuid]--[$contentype]</div>
		<pp:appfunc app="publish" file="appfunc/general" return="title" funcname="u8_title_substr($var.title,75)"/>
		<if test="$var.id != '' && $var.columnGuid != ''">
			<a title="[$var.mhname]" href="http://[$var.domain][@encrypt_url('action=mh&method=' . $contentype . '&contentId=' . $var.id . '&lmguid=' . $var.columnGuid)]" target="main_stage"  style="font-weight:bold; color:#000;">[$var.title]</a>
		<else>
			<a title="[$var.mhname]" href="javascript:void(0);" onclick="errorMsg()"  style="font-weight:bold; color:#000;">[$var.title]</a>
		</if>
		<if test="$var.isDoc != ' '">
			<img width="20px" height="20px" src="/theme/images/hxj.png"/ style="position:relative; top:10px;">
		</if>
		<if test="$var.typeName==space">
			<var name="source" value="空间"/>
		<elseif test="$var.typeName==mh">
			<var name="source" value="门户"/>
		<else>
		</if>
		<span>([@date("Y-m-d",$var.publishTime1)])[来自[$source]]</span>
	</li>
</if>



<script type="text/javascript">
$(function(){
	$('#mhli').empty();
	$('#mhli').append("门户([$retlist.success.rowcount])");
});
</script>