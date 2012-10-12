<?php header("Content-type: text/xml"); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
	<?php echo '<rss version="2.0">'; ?>

<?php echo 
('
<channel>
	<title>'.$this->current['page_title'].'</title>
	<link>'.$this->current['site_url'].'</link>
	<description>'.$this->current['site_description'].'</description>
	<language>'.$this->current['feed_lang'].'</language>
	<copyright>'.$this->current['copyright'].'</copyright> 
');

foreach($list as $item):
	echo 
	('
	<item>
		<title>'.$item->title.'</title>
		<description>'.$item->content.'</description>
		<link>'.$this->url->full_path_to($item->identifier).'</link>
		<pubDate></pubDate>
	</item>
	');
endforeach;

echo 
('
	</channel>
</rss>
'); 