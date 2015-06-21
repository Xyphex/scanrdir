<?php
/**
 * Recursive addition to scandir, using the names of directories as associative
 * array keys.
 *
 * Copyright © 2015 Aram Nap
 *
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License
 * for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
function scanrdir($directory, $hideDotFiles = false)
{
	// Add trailing slash if necessary.
	if ($directory[mb_strlen($directory) - 1] !== DIRECTORY_SEPARATOR) {
		$directory .= DIRECTORY_SEPARATOR;
	}

	$directoryStructure = [];

	// array_diff is used to remove the "." and ".." files in directories on
	// Linux systems.
	foreach (array_diff(scandir($directory), ['.', '..']) as $file) {
		if ($hideDotFiles && $file[0] === '.') {
			continue;
		}

		if (is_dir($directory . $file)) {
			$directoryStructure[$file] = scanrdir($directory . $file);
		} else {
			$directoryStructure[] = $file;
		}
	}

	return $directoryStructure;
}
