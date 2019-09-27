<?php

if (! function_exists('asset'))
{
    /**
     * @return string
     */
    function asset(string $file): string
    {
        helper('filesystem');

        // Remove the path to the file to allow for subfolders.
        $path = substr($file, 0, strrpos($file, DIRECTORY_SEPARATOR));
        if (! empty($path))
        {
            $file = substr($file, 0, strlen($path));
            $path .= '/';
        }

        // Split into segments to remove file extensions (or .min.js)
        $parts = explode('.', $file);

        // For now we make the assumption that
        // all filenames will NOT have extra periods
        // in their name, and will use the first segment
        // as the base filename.
        $filename = array_shift($parts);

        $existing = get_filenames(ROOTPATH ."public/assets/{$path}");

        $found = '';
        foreach ($existing as $exFile)
        {
            if (strpos($exFile, $filename) === 0)
            {
                $found = $exFile;
                break;
            }
        }

        return $found !== ''
            ? "/assets/{$found}"
            : '';
    }
}
