<div class="right photoct" id="content">
<?php
$q = mysql_query("SELECT * FROM `draws` WHERE `filename`='{$this->core->getUrl(1)}'");
if(!mysql_num_rows($q))
	masterRedirect($this->core->createURL("/page/gallery"));
$r = mysql_fetch_assoc($q);

$path = getConfig('path');
$image = "{$path}/files.php?id={$r['filename']}";

appendFooter('<script type="text/javascript">
var config = {
     over: function(){
			$("#tools").show("slide",300);
		},
     timeout: 50, // number = milliseconds delay before onMouseOut
     out: function(){
			$("#tools").hide("slide",100);
		}
};

	$("#photoimg").hoverIntent(config);
	$("#photoimg #tools a").tipsy({fade: true,gravity: \'w\'});
</script>');
	?>
	<div class="content">
        <div id="photoinfo">
        	<ul>
            	<li><h1 class="phototitle" title="<?php __($r['title'])?> - by <?php __(getElementByID("user",$r['userid'],"user"))?>"><span id="phototitle"><?php __($r['title'])?></span> <span id="photouser">- by <?php __(getElementByID("user",$r['userid'],"user"))?></span></h1></li>
                <li><!-- AddThis Button BEGIN -->
                <?php if(logged()){?>
                <a href="#" onclick="return discuss('<?php __(getConfig('path').'/discuss.php?draw='.$r['filename']);?>')" class="no-text discuss" title="<?php ___("discuss")?>"><?php ___("discuss")?></a>
                <a class="no-text drawReport" title="<?php ___("reportDraw")?>" onclick="reportDraw('<?php __(getConfig('path'))?>','<?php __($r['filename'])?>');">&nbsp;</a>
                <?php }?>
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_facebook"></a>
<a class="addthis_button_twitter"></a>
<a class="addthis_button_google"></a>
<a class="addthis_button_tumblr"></a>
<a class="addthis_button_email"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=thg2oo6"></script>
<!-- AddThis Button END --></li>
            </ul>
        </div>

        <?php
        $extra = "";
        if($r['type']=='extended'){
        	if($r['bkgcolor']=='none')
        		$extra="background: #dfdfdf url('{$path}/extra/style/images/bkg.png')";
        	else
        		$image .= "&extended=1";
        	/*
        	if($r['bkgcolor']=='axis')
        		$extra="background: #ffffff url('{$path}/extra/style/images/axis.png') no-repeat center center";
        	elseif($r['bkgcolor']=='none')
        		$extra="background: #dfdfdf url('{$path}/extra/style/images/bkg.png')";
        	else
        		$extra="background: {$r['bkgcolor']}";
			*/
        }
		?>
        <div id="photoimg" class="clear">
        	<div id="tools">
				<ul>
					<?php
					if(logged()&&(loggedUserID()==$r['userid']||loggedUserRank()=='admin'||loggedUserRank()=='moderator')){?>
					<li><a href="<?php $r['type']=='extended'?__("{$path}/extra/index.php?type=edit&id={$r['filename']}"):$this->core->createURL("/edit/{$r['filename']}",true)?>" class="no-text edit<?php __($r['type']=='extended'?'X':'')?>" title="<?php ___("edit")?>"><?php ___("edit")?></a></li>
					<li><a href="<?php __("{$path}/delete.php?id={$r['filename']}")?>" class="no-text delete" title="<?php ___("deleteButton")?>"><?php ___("deleteButton")?></a></li>
					<?php }?>
					<li><a href="<?php __("{$image}&dl=".rand(1,10000))?>" class="no-text dl" title="<?php ___("download")?>"><?php ___("download")?></a></li>
					<?php
					if(logged())
						if($r['type']=='normal'){?>
					<li><a href="<?php $this->core->createURL("/extend/{$r['filename']}",true)?>" class="no-text extend" title="<?php ___("extend")?>"><?php ___("extend")?></a></li>
					<?php }?>
				</ul>
			</div>
        	<img src="<?php __($image)?>" title="<?php __($r['title'])?> - by <?php __(getElementByID("user",$r['userid'],"user"))?>" alt="image" style="border: 1px solid rgba(40,40,40,0.5);<?php __($extra)?>"/>
        </div>
	</div>
</div>