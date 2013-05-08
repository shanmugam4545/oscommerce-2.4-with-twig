<?php
/**
 * osCommerce Online Merchant
 *
 * @copyright Copyright (c) 2013 osCommerce; http://www.oscommerce.com
 * @copyright Copyright (c) 2013 James W Burke; http://bootsnipp.com/snipps/carousel-extended
 * @copyright Copyright (c) 2013 FoxP2; http://www.oscommerce.fr
 * @license GNU General Public License; http://www.oscommerce.com/gpllicense.txt
 */
class TwigModules extends Twig_Extension
{


    public function getFunctions()
    {

        return array(
            new Twig_SimpleFunction('moduleproductsnew', 'twig_module_products_new'),
            new Twig_SimpleFunction('modulefeatureproducts', 'twig_module_feature_products'),
        );
    }

    public function getName()
    {
        return 'ModulesExtension';

    }
}
function twig_module_feature_products(){
    
    $feature_products_query = osc_db_query("select distinct p.products_id, pi.image, p.products_tax_class_id, pd.products_name, pd.products_description, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c,  " . TABLE_PRODUCTS_IMAGES . " pi where p.products_id = pi.products_id and pi.sort_order = 1  and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.categories_id = 35 and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by p.products_date_added desc limit 6");
    
    $num_feature_products = osc_db_num_rows($feature_products_query);
    
    while ($feature_products = osc_db_fetch_array($feature_products_query)) {

      $products[] = $feature_products;

    }
    if ( $num_feature_products > 0) {
        
    }
    $string = '<div class="row-fluid"><h3>Features Products</h3>
					<ul class="thumbnails row-fluid">
                                                						<li class="span4">
							<div class="thumbnail">
								<img src="images/nokia/520/Nokia-Lumia-520-fp.png" alt="">
								<div class="caption">
									<h5>Nokia Lumia 520</h5>
									
									<strong>400 €</strong>
									<a href="product.html" class="btn btn_small btn-info">Learn more</a>
								</div>
							</div>			
						</li>



						<li class="span4">
							<div class="thumbnail">
								<img src="images/nokia/620/Nokia-Lumia-620-fp.png" alt="">
								<div class="caption">
									<h5>Nokia Lumia 620</h5>
									<p>The brightest Lumia yet</p>
									<strong>400 €</strong>
									<a href="product.html" class="btn btn_small btn-info">Learn more</a>
								</div>
							</div>			
						</li>

						<li class="span4">
							<div class="thumbnail">
								<img src="images/nokia/720/Nokia-Lumia-720-fp.png" alt="">
								<div class="caption">
									<h5>Nokia Lumia 720</h5>
									
									<strong>400 €</strong>
									<a href="product.html" class="btn btn_small btn-info">Learn more</a>
								</div>
							</div>			
						</li>
                                                </ul>
                                                <ul class="thumbnails row-fluid">

						<li class="span4">
							<div class="thumbnail">
								<img src="images/nokia/820/Nokia-Lumia-820-fp.png" alt="">
								<div class="caption">
									<h5>Nokia Lumia 820</h5>
									
									<strong>400 €</strong>
									<a href="product.html" class="btn btn_small btn-info">Learn more</a>
								</div>
							</div>			
						</li>

						
						
						<li class="span4">
							<div class="thumbnail">
								<img src="images/nokia/920/920-fp.png" alt="">
								<div class="caption">
									<h5>Nokia Lumia 920</h5>
									
									<strong>400 €</strong>
									<a href="product.html" class="btn btn_small btn-info">Learn more</a>
								</div>
							</div>			
						</li>	
                                          <li class="span4">
							<div class="thumbnail">
								<img src="images/nokia/900/nokia-lumia-900-fp.png" alt="">
								<div class="caption">
									<h5>Nokia Lumia 900</h5>
									
									<strong>400 €</strong>
									<a href="product.html" class="btn btn_small btn-info">Learn more</a>
								</div>
							</div>			
						</li>



					</ul>
				</div>';
    return $string;
    
}

function twig_module_products_new($cid)
{
  global $currencies;
  if ( (!isset($cid))) {
    $new_products_query = osc_db_query("select p.products_id, pi.image, p.products_tax_class_id, pd.products_name, pd.products_short_description, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_IMAGES . " pi, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = pd.products_id and p.products_id = pi.products_id and pi.sort_order = 1 and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by p.products_date_added desc limit 6");
  } else {
   $new_products_query = osc_db_query("select distinct p.products_id, pi.image, p.products_tax_class_id, pd.products_name, pd.products_short_description, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c,  " . TABLE_PRODUCTS_IMAGES . " pi where p.products_id = pi.products_id and pi.sort_order = 1  and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . $cid . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by p.products_date_added desc limit 6");
   }
  $num_new_products = osc_db_num_rows($new_products_query);
  
  while ($new_products = osc_db_fetch_array($new_products_query)) {

      $products[] = $new_products;

  }
  
  if ($num_new_products > 0) {

  $string = '<h2>' . sprintf(TABLE_HEADING_NEW_PRODUCTS, strftime('%B')) .'</h2>' . "\n";

  $string .= '<div class="row" style="margin-left:20px;">' . "\n";

  $string .= '<div id="main_area">' . "\n";

  $string .= '  <div class="row">' . "\n";

  $string .= '      <div class="span12" id="slider">' . "\n";

  $string .= '          <div class="row">' . "\n";

  $string .= '              <div class="span8" id="carousel-bounding-box" style="background-color: #e9e8e8;margin-left:20px;margin-right:-20px;">' . "\n";

  $string .= '                  <div id="myCarousel" class="carousel slide">' . "\n";

  $string .= '                      <div class="carousel-inner">' . "\n";

  for ($i = 0; $i < sizeof($products); $i++) {

      $class = ($i == 0) ? 'item active'  : 'item';

      $string .= '                          <div class="' . $class . '" data-slide-number="' . ($i - 1) . '">' . osc_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['products_name']) . '</div>' . "\n";

  }
  $string .= '                      </div>' . "\n";

  $string .= '<a class="carousel-control left" href="#myCarousel" data-slide="prev">‹</a>' . "\n";

  $string .= '<a class="carousel-control right" href="#myCarousel" data-slide="next">›</a>' . "\n";

  $string .= '                  </div>' . "\n";

  $string .= '              </div>' . "\n";

  $string .= '          <div class="span4" id="carousel-text"></div>' . "\n";

  $string .= '          <div style="display: none;" id="slide-content">' . "\n";

  for ($i = 0; $i < sizeof($products); $i++) {

  $string .= '      <div id="slide-content-' . ($i - 1) . '">' . "\n";

  $string .= '<h3>' . $products[$i]['products_name'] . '</h3>' . "\n";

  $string .= '<h4>' . $currencies->display_price($products[$i]['products_price'], osc_get_tax_rate($products[$i]['products_tax_class_id'])) . '</h4><br /><p class="sub-text">' . substr($products[$i]['products_short_description'],0,300) . '<br /><strong><en>...</em></strong></p>' . "\n";

  $string .= '<span class="pull-right">' . osc_draw_button(IMAGE_BUTTON_BUY_NOW, 'play', osc_href_link('products', 'id=' . $products[$i]['products_id']), 'primary') . '</span><br /><br />'  . "\n";

  $string .= '      </div>' . "\n";

  }

  $string .= '          </div>' . "\n";

  $string .= '      </div>' . "\n";

  $string .= '  </div>' . "\n";

  $string .= '</div>' . "\n";

  $string .= '<div class="row hidden-phone" id="slider-thumbs">' . "\n";

  $string .= '  <div class="span12">' . "\n";

  $string .= '      <ul class="thumbnails">' . "\n";

  for ($i = 0; $i < sizeof($products); $i++) {

  $string .= '          <li class="span2">' . "\n";

  $string .= '              <a class="thumbnail" id="carousel-selector-' . $i . '">' . "\n";

  $string .= osc_image(DIR_WS_IMAGES . $products[$i]['image'], $products[$i]['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . "\n";

  $string .= '              </a>' . "\n";

  $string .= '          </li>' . "\n";

  }

  $string .= '      </ul>' . "\n";

  $string .= '  </div>' . "\n";

  $string .= '</div>' . "\n";

  $string .= '</div>' . "\n";

  $string .= '</div>' . "\n";

  $string .= '<script>' . "\n";

  $string .= 'jQuery(document).ready(function($) {' . "\n";

  $string .= '$(\'#myCarousel\').carousel({interval: 5000});' . "\n";

  $string .= '$(\'#carousel-text\').html($(\'#slide-content-0\').html());' . "\n";

  $string .= '$(\'[id^=carousel-selector-]\').click( function(){
                var id_selector = $(this).attr("id");
                var id = id_selector.substr(id_selector.length -1);
                var id = parseInt(id);
                $(\'#myCarousel\').carousel(id);
               });' . "\n";
  $string .= '$(\'#myCarousel\').on(\'slid\', function (e) {
                var id = $(\'.item.active\').data(\'slide-number\');
                $(\'#carousel-text\').html($(\'#slide-content-\'+id).html());
        });' . "\n";

  $string .= '});' . "\n";

  $string .= '</script>' . "\n";

  return $string;
  }
}
?>
