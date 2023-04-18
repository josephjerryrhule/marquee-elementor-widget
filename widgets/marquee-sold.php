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

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'list_title',
      [
        'label' => __('Image Title', 'figmenta'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Image Item #1', 'figmenta'),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'image',
      [
        'label' => __('Images', 'figmenta'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
      ]
    );


    $this->add_control(
      'list',
      [
        'label' => __('Image List', 'figmenta'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'list_title' => __('Image Title #1', 'figmenta'),
          ],
          [
            'list_title' => __('Image Title #2', 'figmenta'),
          ],
          [
            'list_title' => __('Image Title #3', 'figmenta'),
          ],
        ],
        'title_field' => '{{{ list_title }}}'
      ]
    );


    $this->end_controls_section();
  }


  protected function render()
  {
    $settings = $this->get_settings_for_display();
    $list = $settings['list'];

    if ($list) {
?>
      <div class="figmentasold">
        <div class="figmentasold-inner">
          <?php
          foreach ($list as $index => $item) {
          ?>
            <div class="figmentasold-product">
              <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo $item['list_title']; ?>" class="w-full h-full">
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
