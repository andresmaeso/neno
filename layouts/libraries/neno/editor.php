<?php
/**
 * @package     Neno
 *
 * @author      Jensen Technologies S.L. <info@notwebdesign.com>
 * @copyright   Copyright (C) 2014 Jensen Technologies S.L. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

$document    = JFactory::getDocument();
$translation = $displayData;

$languageParts = null;

if (!empty($translation))
{
	$languageParts = explode('-', $translation->language);
}
?>

<div class="main-translation-div" data-translation-id="<?php echo $translation->id; ?>" data-content-id="<?php echo $translation->content_id; ?>">
    <div class="row">
        <div class="span6 lefteditor-wrapper editor-wrapper">
            <div class="copylinks pull-right">
                <a href="javascript:void(0);" class="copy-string-link"><span class="icon-copy"></span>Copy</a> 
                &nbsp; 
                <a href="javascript:void(0);" class="translate-string-link"><span class="icon-comments-2"></span>Translate</a>
            </div>
            <div class="breadcrumbs">
                <?php echo empty($translation) ? '' : implode(' <span class="gt icon-arrow-right"></span>', $translation->breadcrumbs); ?>
                <?php if (!empty($translation->breadcrumbs)): ?>
                    &nbsp;&nbsp;
                    <a data-toggle="tooltip"
                       class="hasTooltip dont-translate"
                       href="javascript:void(0);"
                       title="<?php echo JHtml::tooltipText('COM_NENO_EDITOR_BTN_DONT_TRANSLATE'); ?>"
                       data-id="<?php echo $translation->content_id; ?>"><i class="icon-unpublish"></i></a>
                <?php endif; ?>
            </div>
            <textarea
            class="original-content"
            id="original-content-<?php echo $translation->id; ?>"
            ><?php echo !empty($translation) ? $translation->original_text : ''; ?></textarea>
            <div class="clearfix"></div>
            <div class="below-lefteditor">
                <div class="note-to-translators"></div>
                <div class="pull-right last-modified">
                    <?php echo empty($translation) ? '' : JText::sprintf('COM_NENO_EDITOR_LAST_MODIFIED', $translation->time_added) ?>
                </div>
            </div>                

        </div>
        <div class="span6 pull-right righteditor-wrapper editor-wrapper">
            <div class="breadcrumbs">
                <?php echo empty($translation) ? '' : implode(' <span class="gt icon-arrow-right"></span>', $translation->breadcrumbs); ?>
                <?php if (!empty($translation->breadcrumbs)): ?>
                    &nbsp;&nbsp;
                    <a data-toggle="tooltip"
                       class="hasTooltip dont-translate"
                       href="javascript:void(0);"
                       title="<?php echo JHtml::tooltipText('COM_NENO_EDITOR_BTN_DONT_TRANSLATE'); ?>"
                       data-id="<?php echo $translation->content_id; ?>"><i class="icon-unpublish"></i></a>
                <?php endif; ?>
            </div>
            <textarea
            spellcheck="true" lang="<?php echo empty($languageParts) ? '' : $languageParts[0]; ?>"
            class="translated-content"
            id="translated-content-<?php echo $translation->id; ?>"            
            ><?php echo (empty($translation) === false && $translation->time_changed != '0000-00-00 00:00:00') ? $translation->string : ''; ?></textarea>
            
            <div class="clearfix"></div>
            <div class="pull-left translated-by">
                <?php echo JText::sprintf('COM_NENO_EDITOR_TRANSLATED_BY', NenoSettings::get('translator')); ?>
            </div>
            <div class="pull-right last-modified">
                <?php echo empty($translation) ? '' : JText::sprintf('COM_NENO_EDITOR_LAST_MODIFIED', $translation->time_changed !== '0000-00-00 00:00:00' ? $translation->time_changed : JText::_('COM_NENO_EDITOR_NEVER')) ?>
            </div>
            <div class="clearfix"></div>
            <br/>

            <div class="pull-left translated-error">
                <span
                    class="label label-important error-title"><?php echo JText::sprintf('COM_NENO_EDITOR_ERROR_TRANSLATED_BY', NenoSettings::get('translator')); ?></span>
                <span class="error-message"></span>
            </div>
        </div>
    </div>
</div>


