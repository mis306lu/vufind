<?php

/**
 * Abstract base class for PHPUnit database test cases.
 *
 * PHP version 7
 *
 * Copyright (C) Villanova University 2010.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category VuFind
 * @package  Tests
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development:testing:unit_tests Wiki
 */
namespace VuFindTest\Unit;

/**
 * Abstract base class for PHPUnit database test cases.
 *
 * @category VuFind
 * @package  Tests
 * @author   Demian Katz <demian.katz@villanova.edu>
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @link     https://vufind.org/wiki/development:testing:unit_tests Wiki
 */
abstract class ViewHelperTestCase extends DbTestCase
{
    /**
     * Get a working renderer.
     *
     * @param array  $plugins Custom VuFind plug-ins to register
     * @param string $theme   Theme directory to load from
     *
     * @return \Laminas\View\Renderer\PhpRenderer
     */
    protected function getPhpRenderer($plugins = [], $theme = 'bootstrap3')
    {
        $resolver = new \Laminas\View\Resolver\TemplatePathStack();

        // This assumes that all themes will be testing inherit directly
        // from root with no intermediate themes.  Probably safe for most
        // test situations, though other scenarios are possible.
        $resolver->setPaths(
            [
                $this->getPathForTheme('root'),
                $this->getPathForTheme($theme)
            ]
        );
        $renderer = new \Laminas\View\Renderer\PhpRenderer();
        $renderer->setResolver($resolver);
        if (!empty($plugins)) {
            $pluginManager = $renderer->getHelperPluginManager();
            foreach ($plugins as $key => $value) {
                $pluginManager->setService($key, $value);
            }
        }
        return $renderer;
    }

    /**
     * Get the directory for a given theme.
     *
     * @param string $theme Theme directory name
     *
     * @return string
     */
    protected function getPathForTheme($theme)
    {
        return APPLICATION_PATH . '/themes/' . $theme . '/templates';
    }
}
