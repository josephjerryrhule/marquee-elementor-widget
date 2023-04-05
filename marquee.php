<?php

/**
 * Plugin Name: Marquee Elementor
 * Author: Figmenta
 * text-domain: figmenta
 * 
 * @package figmenta
 */

namespace MARQUEE\ElementorWidgets;

use MARQUEE\ElementorWidgets\Widgets\marquee_images;
use MARQUEE\ElementorWidgets\Widgets\marquee_sold;

if (!defined('ABSPATH')) {
  exit;
}

final class Marquee
{
  private static $_instance = null;

  public static function get_instance()
  {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct()
  {
    add_action('elementor/init', [$this, 'init']);
  }

  public function init()
  {
    add_action('elementor/elements/categories_registered', [$this, 'create_new_category']);
    add_action('elementor/widgets/register', [$this, 'init_widgets']);
  }

  public function create_new_category($elements_manager)
  {
    $elements_manager->add_category(
      'figmenta',
      [
        'title' => __('Figmenta', 'figmenta')
      ]
    );
  }

  public function init_widgets($widgets_manager)
  {
    //Require Widgets Directory
    require_once __DIR__ . '/widgets/marquee-images.php';
    require_once __DIR__ . '/widgets/marquee-sold.php';

    //Instantiate Widgets
    $widgets_manager->register(new marquee_images());
    $widgets_manager->register(new marquee_sold());
  }
}
Marquee::get_instance();
