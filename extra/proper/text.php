<h1><?php ___("textTool")?></h1>
<table>
	<tr>
		<th><?php ___("text")?>:</th>
		<td><input type="text" style="padding: 5px; width: 90%;" id="textbox" name="textbox" value="" /></td>
	</tr>
	<tr>
		<th><?php ___("size")?>:</th>
		<td><select id="textSize" class="select" onchange="updateTextSize();">
		<option value="6">6</option>
		<option value="8">8</option>
		<option value="10">10</option>
		<option value="12" selected>12</option>
		<option value="14">14</option>
		<option value="16">16</option>
		<option value="18">18</option>
		<option value="20">20</option>
		<option value="22">22</option>
		<option value="24">24</option>
		<option value="28">28</option>
		<option value="32">32</option>
		<option value="36">36</option>
		<option value="40">40</option>
		<option value="44">44</option>
		<option value="48">48</option>
		<option value="52">52</option>
		<option value="56">56</option>
		<option value="60">60</option>
		<option value="64">64</option>
		<option value="68">68</option>
		<option value="72">72</option>
		<option value="76">76</option>
		<option value="80">80</option>
		<option value="84">84</option>
		<option value="88">88</option>
		<option value="92">92</option>
		<option value="96">96</option>
		<option value="100">100</option>
		</select></td>
	</tr>
	<tr>
		<th><?php ___("font")?>:</th>
		<td><select id="textFont" class="select">
		<option value="Arial" selected>Arial</option>
		<option value="Tahoma">Tahoma</option>
		<option value="Verdana">Verdana</option>
		<option value="Times new roman">Times New Roman</option>
		<option value="Comic Sans MS">Comic Sans</option>
		<option value="monospace">Monospace</option>
		</select></td>
	</tr>
	<tr>
		<th><?php ___("align")?>:</th>
		<td><select id="textAlign" class="select">
		<option value="left" selected><?php ___("left")?></option>
		<option value="center"><?php ___("center")?></option>
		<option value="right"><?php ___("right")?></option>
		</select></td>
	</tr>
</table>