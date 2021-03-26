<?php
namespace local_course_auto_visibility\task;

/**
 * An example of a scheduled task.
 */
class update_visibility extends \core\task\scheduled_task {

    /**
     * Return the task's name as shown in admin screens.
     *
     * @return string
     */
    public function get_name() {
        return get_string('pluginname', 'local_course_auto_visibility');
    }

    /**
     * Execute the task.
     */
    public function execute() {
        global $DB;

        // Make visible classes
        $DB->execute("UPDATE {course} 
                          SET visible = 1 
                          WHERE startdate <= UNIX_TIMESTAMP() 
                              AND enddate > UNIX_TIMESTAMP() 
                              AND visible = 0");

        // Make hidden classes
        $DB->execute("UPDATE {course} 
                          SET visible = 0 
                          WHERE enddate IS NOT NULL 
                          AND enddate > 0 
                          AND enddate <= UNIX_TIMESTAMP() 
                          AND visible = 1");
    }
}