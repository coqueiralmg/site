<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         DebugKit 2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * @type \DebugKit\View\AjaxView $this
 * @type string $cake
 * @type string $core
 * @type array $paths
 * @type string $app
 * @type string $plugins
 */

// Backwards compat for old DebugKit data.
if (!isset($cake) && isset($core)) {
    $cake = $core;
}
?>
<h4>Include Paths</h4>
<?= $this->Toolbar->makeNeatArray($paths) ?>

<h4>Included Files</h4>
<?= $this->Toolbar->makeNeatArray(['cake' => $cake, 'app' => $app, 'plugins' => $plugins]) ?>
