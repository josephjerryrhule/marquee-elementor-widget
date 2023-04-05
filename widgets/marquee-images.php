<?php

/**
 * Marquee Image Carousel Widget Add-on
 * 
 * @package figmenta
 */

namespace MARQUEE\ElementorWidgets\Widgets;

use \Elementor\Widget_Base;

class marquee_images extends Widget_Base
{
  public function get_name()
  {
    return 'marquee-images';
  }
  public function get_title()
  {
    return __('Marquee Images', 'figmenta');
  }

  public function get_icon()
  {
    return 'eicon-elementor';
  }

  public function get_categories()
  {
    return ['figmenta', 'basic'];
  }

  public function get_style_depends()
  {
    wp_register_style('marquee-style', plugins_url('scss/marquee.css', __FILE__));

    return ['marquee-style'];
  }

  public function get_script_depends()
  {
    wp_register_script('marquee-script', plugins_url('js/marquee.js', __FILE__));
    return ['marquee-script'];
  }

  public function register_controls()
  {
    $this->start_controls_section(
      'content-section',
      [
        'label' => __('Content', 'figmenta'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
        'label' => __('Image', 'figmenta'),
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
      <div class="marqueeimages-area">
        <div class="marquee-inner">
          <?php
          foreach ($list as $index => $item) {
          ?>
            <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo $item['list_title']; ?>">
          <?php
          }
          ?>
        </div>
      </div>
<?php
    }
  }
}
