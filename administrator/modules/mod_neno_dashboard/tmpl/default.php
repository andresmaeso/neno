<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_neno_dashboard
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . '/media/neno/css/languageconfiguration.css');

//Loading instances from model in order to get PositionField in the alert box
jimport('joomla.application.component.model');
JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_neno/models');
$dashboardModel = JModelLegacy::getInstance( 'Dashboard', 'NenoModel' );

$translationMethods = NenoHelper::loadTranslationMethods();
$n                  = 0;

?>
<?php if (!$dashboardModel->getIsSwitcherPublished()): ?>	
    <?php echo JLayoutHelper::render('languageswitcheralert', $dashboardModel->getPositionField() , JPATH_NENO_LAYOUTS);?>
<?php endif; ?>
<?php foreach ($languageData as $item): ?>
				
<?php $item->placement = 'dashboard';?>

<div class="language-wrapper language-<?php echo $item->placement; ?>">
	<?php if (!empty($item->errors)): ?>
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php foreach ($item->errors as $itemError): ?>
				<span><?php echo $itemError; ?></span><br/>
			<?php endforeach; ?>
		</div>
	<?php elseif (!empty($item->orderText) && $item->placement == 'dashboard'): ?>
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<span><?php echo $item->orderText; ?></span>
			<a href="<?php echo $item->orderLink; ?>"
			   class="btn btn-primary"><?php echo JText::_('COM_NENO_DASHBOARD_ORDER_BUTTON'); ?></a>
		</div>
	<?php endif; ?>
	<h4>
		<?php if (file_exists(JPATH_SITE . '/media/mod_languages/images/' . $item->image . '.gif')): ?>
			<img src="<?php echo JUri::root() . 'media/mod_languages/images/' . $item->image . '.gif'; ?>"/>
		<?php endif; ?>
		<?php echo $item->title; ?>
	</h4>
	<?php if ($item->placement == 'dashboard'): ?>
		<?php echo NenoHelper::renderWordCountProgressBar($item->wordCount, true, true) ?>
		<a class="btn <?php echo $item->isInstalled == false ? 'not-ready' : ''; ?>"
		   href="<?php echo JRoute::_('index.php?option=com_neno&task=setWorkingLang&lang=' . $item->lang_code . '&next=editor'); ?>">
			<?php echo JText::_('COM_NENO_DASHBOARD_TRANSLATE_BUTTON'); ?>
		</a>
	<?php endif; ?>
    
   
	     
</div>
 <?php endforeach; 