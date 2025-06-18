<?php
class ControllerFeedGoogleSitemap extends Controller {
    public function index() {
        if ($this->config->get('google_sitemap_status')) {
            $output  = '<?xml version="1.0" encoding="UTF-8"?>';
            $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

            // ДОДАНО: Головна сторінка
            $output .= '<url>';
            $output .= '<loc>' . htmlspecialchars($this->url->link('common/home'), ENT_XML1, 'UTF-8') . '</loc>';
            $output .= '<lastmod>' . date('c') . '</lastmod>';
            $output .= '<changefreq>daily</changefreq>';
            $output .= '<priority>1.0</priority>';
            $output .= '</url>';

            $this->load->model('catalog/product');
            $this->load->model('tool/image');

            $products = $this->model_catalog_product->getProducts();

            foreach ($products as $product) {
                $output .= '<url>';
                    // — Початок SEO-URL з категорією —
    $categories = $this->model_catalog_product->getCategories($product['product_id']);
    if (isset($categories[0])) {
        $path_param = 'path=' . $categories[0]['category_id'] . '&';
    } else {
        $path_param = '';
    }
    $seo_url = $this->url->link(
        'product/product',
        $path_param . 'product_id=' . $product['product_id']
    );
    $output .= '<loc>' . htmlspecialchars($seo_url, ENT_XML1, 'UTF-8') . '</loc>';
    // — Кінець SEO-URL з категорією —
                $output .= '<lastmod>' . date('c', strtotime($product['date_modified'])) . '</lastmod>';
                $output .= '<changefreq>weekly</changefreq>';
                $output .= '<priority>1.0</priority>';

                if ($product['image']) {
                    $image_url = $this->model_tool_image->resize($product['image'], 
                        $this->config->get('config_image_popup_width'), 
                        $this->config->get('config_image_popup_height'));
                    $image_url = str_replace(' ', '%20', $image_url);

                    $output .= '<image:image>';
                    $output .= '<image:loc>' . htmlspecialchars($image_url, ENT_XML1, 'UTF-8') . '</image:loc>';
                    $output .= '<image:caption>' . htmlspecialchars($product['name'], ENT_XML1, 'UTF-8') . '</image:caption>';
                    $output .= '<image:title>' . htmlspecialchars($product['name'], ENT_XML1, 'UTF-8') . '</image:title>';
                    $output .= '</image:image>';
                }

                $output .= '</url>';
            }

            $this->load->model('catalog/category');
            $output .= $this->getCategories(0);

            $this->load->model('catalog/manufacturer');
            $manufacturers = $this->model_catalog_manufacturer->getManufacturers();

            foreach ($manufacturers as $manufacturer) {
                $output .= '<url>';
                $output .= '<loc>' . htmlspecialchars($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id']), ENT_XML1, 'UTF-8') . '</loc>';
                $output .= '<lastmod>' . date('c') . '</lastmod>';
                $output .= '<changefreq>weekly</changefreq>';
                $output .= '<priority>0.7</priority>';
                $output .= '</url>';
            }

            $output .= '</urlset>';

            $this->response->addHeader('Content-Type: application/xml');
            $this->response->setOutput($output);
        }
    }

    protected function getCategories($parent_id, $current_path = '') {
        $output = '';
        $results = $this->model_catalog_category->getCategories($parent_id);

        foreach ($results as $result) {
            if (!$current_path) {
                $new_path = $result['category_id'];
            } else {
                $new_path = $current_path . '_' . $result['category_id'];
            }

            $output .= '<url>';
            $output .= '<loc>' . htmlspecialchars($this->url->link('product/category', 'path=' . $new_path), ENT_XML1, 'UTF-8') . '</loc>';
            $output .= '<lastmod>' . date('c', strtotime($result['date_modified'])) . '</lastmod>';
            $output .= '<changefreq>weekly</changefreq>';
            $output .= '<priority>0.7</priority>';
            $output .= '</url>';

            $output .= $this->getCategories($result['category_id'], $new_path);
        }

        return $output;
    }
}