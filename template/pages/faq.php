<div class="right" id="content">
	<h1 class="title"><?php ___("faqTitle")?></h1>
	<div class="content">
		<ul class="faqItems">
		<?php
		$lang = $this->language->loadedLang;
		$q = mysql_query("SELECT * FROM `faq` WHERE `lang`='{$lang}' ORDER by `id` ASC");
		if(!mysql_num_rows($q))
			echo "<li>".langItem('noItems')."</li>";
		else{
			while($r = mysql_fetch_assoc($q)){?>
				<li>
					<div class="question"><a href="#" onclick="return showANS('ans<?php __($r['id'])?>');"><?php __($r['title'])?></a></div>
					<div class="answer" id="ans<?php __($r['id'])?>"><?php __($r['text'])?></div>
				</li>
			<?php
			}
		}
		?>
		</ul>
	</div>
</div>