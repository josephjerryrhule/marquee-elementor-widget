<?php

/**
 * Imagine Elementor Widget Addon
 * 
 * @package figmenta
 */

namespace MARQUEE\ElementorWidgets\Widgets;

use \Elementor\Widget_Base;

class marquee_imagine extends Widget_Base
{

  public function get_name()
  {
    return 'marquee-imagine';
  }

  public function get_title()
  {
    return __('Marquee Imagine', 'figmenta');
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
    wp_register_style('marqueeimagine-style', plugins_url('scss/imagine.css', __FILE__));

    return ['marqueeimagine-style'];
  }

  public function get_script_depends()
  {
    wp_register_script('classie-script', plugins_url('js/classie.js', __FILE__));
    wp_register_script('selectFX-script', plugins_url('js/selectFx.js', __FILE__));
    wp_register_script('imaginejs-script', plugins_url('js/imagine.js', __FILE__));

    return ['classie-script', 'selectFX-script', 'imaginejs-script'];
  }

  public function register_controls()
  {
    $this->start_controls_section(
      'content',
      [
        'label' => __('Content', 'figmenta'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );


    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'list_title',
      [
        'label' => __('Color Title', 'figmenta'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => __('Color Title', 'figmenta'),
        'label_block' => true,
      ]
    );

    $repeater->add_control(
      'color',
      [
        'label' => __('Choose Color', 'figmenta'),
        'type' => \Elementor\Controls_Manager::COLOR
      ]
    );

    $this->add_control(
      'list',
      [
        'label' => __('Color List', 'figmenta'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'title_field' => '{{{list_title}}}',
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
      <div class="imagine-mainbody">
        <section class="imagineselectsection">
          <select class="cs-select imagineselect cs-skin-boxes">
            <option value="" disabled selected>Pick your color</option>
            <?php
            foreach ($list as $index => $item) {
            ?>
              <option value="<?php echo $item['color']; ?>" data-class="color-<?php echo $item['list_title']; ?>"><?php echo $item['color']; ?></option>
            <?php
            }
            ?>
          </select>
          <?php
          foreach ($list as $index => $item) {
          ?>
            <style>
              .cs-skin-boxes .cs-options li.color-<?php echo $item['list_title']; ?> {
                background-color: <?php echo $item['color']; ?>;

              }
            </style>
          <?php
          }
          ?>
        </section>
      </div>
<?php
    }
  }
}
