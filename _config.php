<?php
ShortcodeParser::get('default')->register('YouTube', array('YouTubeShortCodeHandler', 'parse_youtube'));
ShortcodeParser::get('default')->register('Vimeo', array('VimeoShortCodeHandler', 'parse_vimeo'));
ShortcodeParser::get('default')->register('Video', array('UploadShortCodeHandler', 'parse_upload'));