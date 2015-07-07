<?php
/**
 * @package    Joomla.Cli
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */
define('_JEXEC', 1);

// Added to prevent the JED scanner from flagging this file
defined('_JEXEC') or die;

if (file_exists(dirname(__DIR__) . '/defines.php'))
{
	include_once dirname(__DIR__) . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', dirname(__DIR__));
	require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_BASE . '/includes/framework.php';

// Configure error reporting to maximum for CLI output.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load Library language
$lang = JFactory::getLanguage();

// Try the files_joomla file in the current language (without allowing the loading of the file in the default language)
$lang->load('files_joomla.sys', JPATH_SITE, null, false, false)
// Fallback to the files_joomla file in the default language
|| $lang->load('files_joomla.sys', JPATH_SITE, null, true);

/**
 * A command line cron job to attempt to remove files that should have been deleted at update.
 *
 * @since  3.0
 */
class PackNenoCli extends JApplicationCli
{
	/**
	 * Entry point for CLI script
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function doExecute()
	{
		/* @var $archive JArchiveZip */
		$archive     = JArchive::getAdapter('zip');
		$extractPath = dirname(__FILE__);

		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		$folders     = JFolder::folders($extractPath);
		$folder      = array_pop($folders);
		$packagePath = $extractPath . DIRECTORY_SEPARATOR . $folder;

		// Neno Component folders
		$componentPath = $packagePath . DIRECTORY_SEPARATOR . 'com_neno';

		// Creating package
		if (JFolder::exists($componentPath))
		{
			if (JFolder::delete($componentPath) !== true)
			{
				echo "Failing deleting component path\n";
			}
		}

		if (JFolder::exists($packagePath . DIRECTORY_SEPARATOR . 'plg_system_neno'))
		{
			if (JFolder::delete($packagePath . DIRECTORY_SEPARATOR . 'plg_system_neno') !== true)
			{
				echo "Failing deleting plugin path\n";
			}
		}

		if (JFolder::exists($packagePath . DIRECTORY_SEPARATOR . 'lib_neno'))
		{
			if (JFolder::delete($packagePath . DIRECTORY_SEPARATOR . 'lib_neno') !== true)
			{
				echo "Failing deleting library path\n";
			}
		}

		if (JFolder::exists($packagePath . DIRECTORY_SEPARATOR . 'packages'))
		{
			if (JFolder::delete($packagePath . DIRECTORY_SEPARATOR . 'packages') !== true)
			{
				echo "Failing deleting packages path\n";
			}
		}

		if (JFolder::create($componentPath) !== true)
		{
			echo "Failing creating component path\n";
		}

		// Administrator
		if (JFolder::move($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_neno', $componentPath . '/back') !== true)
		{
			echo "Failing moving component administrator\n";
		}

		// Languages
		if (JFolder::move($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'administrator' . DIRECTORY_SEPARATOR . 'language', $componentPath . DIRECTORY_SEPARATOR . 'languages') !== true)
		{
			echo "Failing moving component languages\n";
		}

		// Front-end
		if (JFolder::move($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_neno', $componentPath . DIRECTORY_SEPARATOR . 'front') !== true)
		{
			echo "Failing moving component front-end\n";
		}

		// Media files
		if (JFolder::move($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'neno', $componentPath . DIRECTORY_SEPARATOR . 'media') !== true)
		{
			echo "Failing moving component media files\n";
		}

		// Layouts
		if (JFolder::move($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'neno', $componentPath . DIRECTORY_SEPARATOR . 'layouts') !== true)
		{
			echo "Failing moving component layouts\n";
		}

		// Cli
		if (JFolder::move($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'cli', $componentPath . DIRECTORY_SEPARATOR . 'cli') !== true)
		{
			echo "Failing moving component cli\n";
		}

		// Moving installation manifest
		if (JFile::move($componentPath . DIRECTORY_SEPARATOR . 'back' . DIRECTORY_SEPARATOR . 'neno.xml', $componentPath . DIRECTORY_SEPARATOR . 'neno.xml') !== true)
		{
			echo "Failing moving component manifest\n";
		}

		// Moving installation script
		if (JFile::move($componentPath . DIRECTORY_SEPARATOR . 'back' . DIRECTORY_SEPARATOR . 'script.php', $componentPath . DIRECTORY_SEPARATOR . 'script.php') !== true)
		{
			echo "Failing moving component script\n";
		}

		// Neno Plugin folder
		if (JFolder::move($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'neno', $packagePath . DIRECTORY_SEPARATOR . 'plg_system_neno') !== true)
		{
			echo "Failing moving plugin\n";
		}

		// Neno library folder
		if (JFolder::move($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'neno', $packagePath . DIRECTORY_SEPARATOR . 'lib_neno') !== true)
		{
			echo "Failing moving library\n";
		}

		// Deleting empty folders
		if (JFolder::delete($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'administrator') !== true)
		{
			echo "Failing deleting component administrator folder\n";
		}

		if (JFolder::delete($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'components') !== true)
		{
			echo "Failing deleting component administrator folder\n";
		}

		if (JFolder::delete($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'plugins') !== true)
		{
			echo "Failing deleting plugin folder\n";
		}

		if (JFolder::delete($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'libraries') !== true)
		{
			echo "Failing deleting library folder\n";
		}

		if (JFolder::delete($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'layouts') !== true)
		{
			echo "Failing deleting layouts folder\n";
		}

		$files = JFolder::files($extractPath . DIRECTORY_SEPARATOR . $folder);

		$rootFiles = array ('pkg_neno.xml', 'script.php');

		foreach ($files as $file)
		{
			if (!in_array($file, $rootFiles))
			{
				JFile::delete($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $file);
			}
		}

		$folders = JFolder::folders($extractPath . DIRECTORY_SEPARATOR . $folder);

		foreach ($folders as $extensionFolder)
		{
			if ($extensionFolder != 'tests')
			{
				// Parse installation file.
				$installationFileContent = file_get_contents($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $extensionFolder . DIRECTORY_SEPARATOR . 'neno.xml');

				if ($extensionFolder == 'lib_neno')
				{
					$libraryFolders   = JFolder::folders($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $extensionFolder);
					$libraryStructure = '';

					foreach ($libraryFolders as $libraryFolder)
					{
						$libraryStructure .= '<folder>' . $libraryFolder . '</folder>' . "\r\t\t";
					}

					$libraryFiles = JFolder::files($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $extensionFolder);

					foreach ($libraryFiles as $libraryFile)
					{
						if ($libraryFile != 'neno.xml')
						{
							$libraryStructure .= '<filename>' . $libraryFile . '</filename>' . "\r\t\t";
						}
					}

					$installationFileContent = str_replace('XXX_LIBRARY_STRUCTURE', $libraryStructure, $installationFileContent);
				}

				file_put_contents($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $extensionFolder . DIRECTORY_SEPARATOR . 'neno.xml', $installationFileContent);

				// Creating zip
				$zipData = array ();
				$files   = JFolder::files($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $extensionFolder, '.', true, true);

				if (!empty($files))
				{
					foreach ($files as $file)
					{
						// Unify path structure
						$file = str_replace('/', DIRECTORY_SEPARATOR, $file);
						$file = str_replace('\\', DIRECTORY_SEPARATOR, $file);

						// Add files to zip
						$zipData[] = array (
							'name' => str_replace($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $extensionFolder . DIRECTORY_SEPARATOR, '', $file),
							'data' => file_get_contents($file)
						);
					}
				}

				if (!empty($zipData))
				{
					if ($archive->create($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'packages' . DIRECTORY_SEPARATOR . $extensionFolder . '.zip', $zipData) === false)
					{
						echo "Failing to create zip file\n";
					}
				}
			}

			JFolder::delete($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $extensionFolder);
		}

		// Parse installation file.
		$installationFileContent = file_get_contents($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'pkg_neno.xml');

		file_put_contents($extractPath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'pkg_neno.xml', $installationFileContent);

		$zipData = array ();
		$files   = JFolder::files($extractPath . DIRECTORY_SEPARATOR . $folder, '.', true, true);

		if (!empty($files))
		{
			foreach ($files as $file)
			{
				$zipData[] = array (
					'name' => substr(str_replace($extractPath . DIRECTORY_SEPARATOR . $folder, '', $file), 1),
					'data' => file_get_contents($file)
				);
			}
		}

		if (!empty($zipData))
		{
			if ($archive->create(JPATH_ROOT . DIRECTORY_SEPARATOR . 'releases' . DIRECTORY_SEPARATOR . $packageName, $zipData) === false)
			{
				echo "Failing to create zip file\n";
			}
			else
			{
				JFolder::delete($extractPath . DIRECTORY_SEPARATOR . $folder);
			}
		}
	}
}

// Instantiate the application object, passing the class name to JCli::getInstance
// and use chaining to execute the application.
JApplicationCli::getInstance('PackNenoCli')->execute();
