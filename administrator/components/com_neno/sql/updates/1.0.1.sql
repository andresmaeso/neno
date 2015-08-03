
UPDATE `#__neno_settings`
SET `setting_value` = 'http://www.neno-translate.com/'
WHERE `setting_key` = 'server_url';

UPDATE `#__neno_settings`
SET `setting_value` = 'http://www.neno-translate.com/api/v1/'
WHERE `setting_key` = 'api_server_url';