<?php
/**
 * Social library
 */

class Social 
{
	public $defaults = array(
			'message' 	=> 'Currently reading',
			'title' 	=> 'Click to share this post',
			'text' 		=> 'Share'
		);
	
	public $custom = array();
	
	/**
	 * Share On Twitter
	 * Let's you easily share a database object on Twitter.
	 */
	public function share($network, $identifier, $args=array()) 
	{
		$this->custom = $this->set_custom($args);
		
		/*
		
		<a href="http://twitter.com/home?status=<?php echo rawurlencode('Currently reading ').$this->url->full_path_to($item->identifier); ?>" title="Click to share this post on Twitter">Share on Twitter</a>
		
		*/
		
		$return = "<a href=\"http://twitter.com/home?status=";
		$return .= rawurlencode($this->custom['message']).$this->url->full_path_to($identifier);
		$return .= "\" title=\"{$this->custom['title']}\">{$this->custom['text']}</a>";
		
		return $return;
		
	}
	
	/**
	 *
	 */
	public function share_facebook() 
	{
		/*
		
		<li><div class="fb-like" data-href="<?php echo $this->url->full_path_to($item->identifier); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-action="recommend"></div></li>
		
		*/
	}
	
	/**
	 *
	 */
	public function share_linkedin() 
	{
		/*
		
		  <a href=”http://www.linkedin.com/shareArticle?mini=true&url=<?phpthe_permalink(); ?>&title=<?php the_title(); ?>&source=ADD_YOUR_BLOG_URL_HERE”><img src=”ADD_IMAGE_URL_HERE”></a>
		
		*/
	}
	
	/**
	 *
	 */
	public function share_delicious() 
	{
		/*
		
		<a href=”http://delicious.com/save” onclick=”window.open(‘http://delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url=’+encodeURIComponent(‘<?php the_permalink() ?>’)+’&amp;title=’+encodeURIComponent(‘<?php the_title() ?>’),’delicious’, ‘toolbar=no,width=550,height=550′); return false;”><img src=”ADD_IMAGE_URL_HERE” height=”20″ width=”20″ alt=”Delicious” /></a>
		
		*/
	}
	
	/**
	 *
	 */
	private function set_custom($args=array()) 
	{
		foreach ($this->defaults as $key => $value) 
		{
			if (isset($args[$key])) 
			{
				$custom[$key] = $args[$key];
			}
			else 
			{
				$custom[$key] = $value;
			}
		}	
	}
}