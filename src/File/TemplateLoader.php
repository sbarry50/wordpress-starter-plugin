<?php
/**
 * Class that loads templates and views.
 *
 * @package    Vendor\Plugin\File
 * @since      1.0.0
 * @author     sbarry
 * @link       http://example.com
 * @license    GNU General Public License 2.0+
 */

 /**
  * This class has been adapted from Carl Alexander's lesson on generating HTML content in WordPress.
  * https://carlalexander.ca/designing-class-generate-wordpress-html-content/
  */

namespace Vendor\Plugin\File;

use Vendor\Plugin;

class TemplateLoader extends Loader
{
    /**
     * Path to the default template used by the highlighted comment generator.
     *
     * @var string
     */
    private $default_template_path;

    /**
     * Name of the filter used to filter the template path.
     *
     * @var string
     */
    private $filter_name;

    /**
     * Template name used by the `get_query_template` function.
     *
     * @var string
     */
    private $query_template_name;

    /**
     * Constructor.
     *
     * @param string $default_template_path
     * @param string $filter_name
     * @param string $query_template_name
     */
    public function __construct($default_template_path, $filter_name, $query_template_name)
    {
        $this->default_template_path = $default_template_path;
        $this->filter_name = $filter_name;
        $this->query_template_name = $query_template_name;
    }

    /**
     * Set class dependecies
     *
     * @since  1.0.0
     * @param
     * @return object    $this   Instance of this object
     */
    public function setDependency()
    {


        return $this;
    }

    /**
     * Load the template.
     *
     * @return string
     */
    public function loadTemplate()
    {
        $template_path = $this->getTemplatePath();

        if ( ! is_readable( $template_path ) ) {
            return sprintf( '<!-- Could not read "%s" file -->', $template_path );
        }

        ob_start();

        include $template_path;

        return ob_get_clean();
    }

    /**
     * Get the path of PHP template that the comment generator will use.
     *
     * @return string
     */
    private function getTemplatePath()
    {
        $template_path = get_query_template($this->query_template_name);

        if ( empty( $template_path ) ) {
            $template_path = $this->default_template_path;
        }

        return apply_filters($this->filter_name, $template_path);
    }
}
