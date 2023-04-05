<?php

/**
 * Marquee Sold Products Widget Add-on
 * 
 * @package figmenta
 */

namespace MARQUEE\ElementorWidgets\Widgets;

use \Elementor\Widget_Base;

class marquee_sold extends Widget_Base
{
  public function get_name()
  {
    return 'marquee-soldproducts';
  }

  public function get_title()
  {
    return __('Marquee Sold Products', 'figmenta');
  }

  public function get_icon()
  {
    return 'fa fa-shopping-cart';
  }

  public function get_categories()
  {
    return ['figmenta', 'basic'];
  }

  public function get_style_depends()
  {
    wp_register_style('marqueesold-style', plugins_url('scss/marquee.css', __FILE__));

    return ['marqueesold-style'];
  }

  public function register_controls()
  {
    $this->start_controls_section(
      'section_content',
      [
        'label' => __('Content', 'figmenta'),
      ]
    );

    $this->add_control(
      'product_category',
      [
        'label' => __('Product Category', 'figmenta'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'options' => $this->get_product_categories(),
        'multiple' => true,
      ]
    );

    $this->add_control(
      'numberposts',
      [
        'label' => __('Number of Products to Display', 'figmenta'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'default' => __('6', 'figmenta'),
      ]
    );

    $this->add_control(
      'image',
      [
        'label' => __('Sold Out Badge Image', 'figmenta'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
      ]
    );


    $this->end_controls_section();
  }

  private function get_product_categories()
  {
    $categories = get_terms('product_cat', [
      'hide_empty' => true,
    ]);
    $options = [];
    foreach ($categories as $category) {
      $options[$category->term_id] = $category->name;
    }
    return $options;
  }

  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $product_category = $settings['product_category'];
    $limit = $settings['numberposts'];
    $imageurl = $settings['image']['url'];
    $query_args = [
      'post_type' => 'product',
      'post_status' => 'publish',
      'posts_per_page' => $limit,
      'tax_query' => [
        [
          'taxonomy' => 'product_cat',
          'field' => 'term_id',
          'terms' => $product_category,
          'operator' => 'IN',
        ],
      ],
      'meta_query' => [
        [
          'key' => '_stock_status',
          'value' => 'outofstock',
          'compare' => '=',
        ],
      ],
    ];

    $products = new \WC_Product_Query($query_args);

    if ($products->get_products()) {
?>
      <div class="figmentasold">
        <div class="figmentasold-inner">
          <?php
          foreach ($products->get_products() as $product) {
            $productimage_url = wp_get_attachment_image_src($product->get_image_id(), 'full')[0];
          ?>
            <div class="figmentasold-product" style="background-image: url('<?php echo esc_url($productimage_url); ?>');">
              <div class="figmentasold-title">
                <img src="<?php echo esc_url($imageurl); ?>" alt="Sold Badge">
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
      <script type="text/javascript">
        const soldContainer = document.querySelector('.figmentasold-inner');
        const productWidth = document.querySelector('.figmentasold-product').offsetWidth;
        const productCount = Math.ceil(soldContainer.offsetWidth / productWidth) + 2;
        for (let i = 0; i < productCount; i++) {
          const clonedProducts = soldContainer.cloneNode(true);
          soldContainer.parentNode.appendChild(clonedProducts);
        }
      </script>
<?php
    }
  }
}
