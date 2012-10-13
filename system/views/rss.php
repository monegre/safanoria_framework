<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
	<?php echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">'; ?>

<?php echo 
('
<channel>
	<title>'.$this->current['page_title'].'</title>
	<link>'.$this->current['site_url'].'</link>
	<atom:link href="'.$this->current['site_url'].'/feeds" rel="self" type="application/rss+xml" />
	<description>'.$this->current['site_description'].'</description>
	<language>'.$this->current['feed_lang'].'</language>
	<copyright>'.$this->current['copyright'].'</copyright> 
');

foreach($list as $item):
	echo 
	('
	<item>
		<title>'.$item->title.'</title>
		<description>'.htmlentities($item->content).'</description>
		<guid>'.$this->current['site_url'].$this->url->full_path_to($item->identifier).'</guid>
		<link>'.$this->current['site_url'].$this->url->full_path_to($item->identifier).'</link>
		<pubDate>'.$item->updated_at->format("r").'</pubDate>
	</item>
	');
endforeach;

echo 
('
	</channel>
</rss>
'); 