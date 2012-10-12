
<?php header("Content-type: text/xml"); ?>

<?xml version="1.0" encoding="UTF-8"?>

<?php 
//Cabeceras del RSS
//echo '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">'; ?>

<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" version="2.0">

<channel>
	<title>Lo títol del lloc web</title>
	<link>http://exemple.com</link>
	<description>Hola, sóc la descripció del lloc web</description>
	<language>ca</language>
	<copyright>Copyright?</copyright>

<?php foreach($list as $item): ?>

	<item>
		<title><?php echo $item->title; ?></title>
		<description><?php echo $item->content; ?></description>
		<link><?php echo $this->url->full_path_to($item->identifier); ?></link>
		<pubDate></pubDate>
	</item>

<?php endforeach; ?>

	</channel>
</rss>