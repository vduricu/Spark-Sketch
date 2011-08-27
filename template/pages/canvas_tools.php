<li title="<?php ___("save")?>">
	<a href="<?php $this->core->createURL("/saveCanvas",true)?>" rel="facebox"><img src="<?php themePath();?>/style/images/save.png" alt="save"/></a>
</li>
<li title="<?php ___("cancelCanvas")?>">
	<a href="<?php $this->core->createURL("/page/gallery",true)?>"><img src="<?php themePath();?>/style/images/delete.png" alt="cancel"/></a>
</li>
<li style="cursor: default;" title="<?php ___("fgdColor")?>">
	<input type="hidden" name="brushColor" id="brushColor" class="colors" size="7" value="#000000" />
</li>
<li style="cursor: default;" title="<?php ___("bkgColor")?>">
	<input type="hidden" name="canvasColor" id="canvasColor" class="colors" size="7" value="#ffffff" />
</li>
<li class="no-text" id="changeColor" title="<?php ___("changeColor")?>">&nbsp;</li>
<li class="no-text" id="resetColor" title="<?php ___("resetColor")?>">&nbsp;</li>
<li class="no-text" id="clearCanvas" title="<?php ___("clearCanvas")?>">&nbsp;</li>
<li title="<?php ___("brushSize")?>">
	<select id="brushSize">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
	</select>
</li>
<li title="<?php ___("fillBkg")?>" id="fillBkg">
	<img src="<?php themePath();?>/style/images/fill.png" alt="fill"/>
</li>
<li title="<?php ___("undo")?>" id="undoCanvas">
	<img src="<?php themePath();?>/style/images/undo.png" alt="undo"/>
</li>
<input type="hidden" name="finalCanvasColor" id="finalCanvasColor" value="#ffffff" />
<li title="<?php ___("extendedDraw")?>"><a href="<?php __(getConfig('path').'/extra/')?>" id="bigCanvas"><img src="<?php themePath();?>/style/images/large.png" alt="canvas_settings"/></a></li>