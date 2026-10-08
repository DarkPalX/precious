-- Run this once in the database used by the application.
-- This extends the existing cms_activity_logs table; it does not replace it.

ALTER TABLE `cms_activity_logs`
    ADD COLUMN `action` VARCHAR(20) NULL AFTER `reference`,
    ADD COLUMN `page` VARCHAR(255) NULL AFTER `action`,
    ADD COLUMN `url` TEXT NULL AFTER `page`,
    ADD COLUMN `status_code` SMALLINT UNSIGNED NULL AFTER `url`,
    ADD COLUMN `ip_address` VARCHAR(45) NULL AFTER `status_code`,
    ADD COLUMN `user_agent` TEXT NULL AFTER `ip_address`;

CREATE INDEX `cms_activity_logs_page_index` ON `cms_activity_logs` (`page`);
CREATE INDEX `cms_activity_logs_action_index` ON `cms_activity_logs` (`action`);
