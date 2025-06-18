<?php
class ControllerFeedSimpleGoogleSitemap extends Controller {
	public function index() {    
    $log = new Log('simple_google_sitemap.log');
		if ($this->config->get('google_sitemap_status')) {    
			$this->load->model('feed/simple_google_sitemap');
			$this->load->model('localisation/language');
			$this->load->model('tool/image');    
      
      $languages = $this->model_localisation_language->getLanguages();
      
      $start = microtime(true);    
			$output  = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
			$output .= "\n";
     
      foreach ($languages as $language) {
        
        $args = array(
          'language_id' => (int)$language['language_id'],
          'store_id' => (int)$this->config->get('config_store_id')
        );
            
        $products = $this->model_feed_simple_google_sitemap->getProducts($args);    
        if ($products) {
          foreach ($products as $product) {
            $output .= "<url>\n";
            $output .= "  <loc>" . $this->url->link('product/product', 'product_id=' . $product['product_id']) . "</loc>\n";
            $output .= "  <lastmod>" . $product['date_modified'] . "</lastmod>\n";
            $output .= "  <changefreq>weekly</changefreq>\n";
            $output .= "  <priority>1.0</priority>\n";
            if (!empty($product['image']) && is_file(DIR_IMAGE.$product['image'])) {
              $output .= "  <image:image>\n";
              $output .= '    <image:loc>' . @$this->model_tool_image->resize($product['image'],$this->config->get('config_image_popup_width'),$this->config->get('config_image_popup_height')) . "</image:loc>\n";
              $output .= '    <image:caption>' . str_replace('&','&amp;',$product['name']) . "</image:caption>\n";
              $output .= '    <image:title>' .  str_replace('&','&amp;',$product['name']) . "</image:title>\n";
              $output .= "  </image:image>\n";
            }
            $output .= "</url>\n";
          }
        }
        
        $categories = $this->model_feed_simple_google_sitemap->getCategories($args);  
        if ($categories) {
          foreach ($categories as $category) {
            $output .= "<url>\n";
            $output .= "  <loc>" . $this->url->link('product/category', 'category_id=' . $category['category_id']) . "</loc>\n";  
            $output .= "  <lastmod>" . $category['date_modified'] . "</lastmod>\n";
            $output .= "  <changefreq>weekly</changefreq>\n";
            $output .= "  <priority>0.7</priority>\n";
            $output .= "</url>\n";
          }
        }  
        
        $manufacturers = $this->model_feed_simple_google_sitemap->getManufacturers($args);   
        if ($manufacturers) {
          foreach ($manufacturers as $manufacturer) {
            $output .= "<url>\n";
            $output .= '  <loc>' . $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id']) . "</loc>\n";
            $output .= "  <changefreq>weekly</changefreq>\n";
            $output .= "  <priority>0.7</priority>\n";
            $output .= "</url>\n";
          }
        }   
        
        $informations = $this->model_feed_simple_google_sitemap->getInformations($args); 
        if ($informations) {
          foreach ($informations as $information) {
            $output .= "<url>\n";
            $output .= '  <loc>' . $this->url->link('information/information', 'information_id=' . $information['information_id']) . "</loc>\n";
            $output .= "  <changefreq>weekly</changefreq>\n";
            $output .= "  <priority>0.5</priority>\n";
            $output .= "</url>\n";
          }       
        }   
        if ($this->config->get('news')) { 
          $news = $this->model_feed_simple_google_sitemap->getNews($args);   
          if ($news) {
            foreach ($news as $new) {
              $output .= "<url>\n";
              $output .= '  <loc>' . $this->url->link('information/news', 'news_id=' . $new['news_id']) . "</loc>\n";
              $output .= "  <changefreq>weekly</changefreq>\n";
              $output .= "  <priority>0.5</priority>\n";
              $output .= "</url>\n";
            }
          }
        }      
        
      } 
      
			$output .= "</urlset>\n";

      $time = microtime(true) - $start;
      $log->write(sprintf('Sitemap was generated for %.4F s. ', $time).'Request from '.$_SERVER["REMOTE_ADDR"].' '.$_SERVER['HTTP_USER_AGENT']);
      
			$this->response->addHeader('Content-Type: application/xml');
			$this->response->setOutput($output);       
		}
	}

}
