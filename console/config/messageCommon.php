<?php
/*
USAGE
  yiic message <config-file>

DESCRIPTION
  This command searches for messages to be translated in the specified
  source files and compiles them into PHP arrays as message source.

PARAMETERS
 * config-file: required, the path of the configuration file. The file
   must be a valid PHP script which returns an array of name-value pairs.
   Each name-value pair represents a configuration option. The following
   options must be specified:
   - sourcePath: string, root directory of all source files.
   - messagePath: string, root directory containing message translations.
   - languages: array, list of language codes that the extracted messages
     should be translated to. For example, array('zh_cn','en_au').
   - fileTypes: array, a list of file extensions (e.g. 'php', 'xml').
     Only the files whose extension name can be found in this list
     will be processed. If empty, all files will be processed.
   - exclude: array, a list of directory and file exclusions. Each
     exclusion can be either a name or a path. If a file or directory name
     or path matches the exclusion, it will not be copied. For example,
     an exclusion of '.svn' will exclude all files and directories whose
     name is '.svn'. And an exclusion of '/a/b' will exclude file or
     directory 'sourcePath/a/b'.
   - translator: the name of the function for translating messages.
     Defaults to 'Yii::t'. This is used as a mark to find messages to be
     translated.
*/
return array(
    'sourcePath'  => dirname(__FILE__) . '/../..' . '/common/models',
    'messagePath' => dirname(__FILE__) . '/../..' . '/common/messages',
    'languages'   => array('ru'),
    'fileTypes'   => array('php'),
    'exclude'     => array(),
    //'translator'  => '',
//    'overwrite'=>true
);
     