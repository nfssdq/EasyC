<?php

require './module/session_required.php';

//function to strip html string
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//function to shorten string
function shorten($data) {
    $new_data = "";
    for ($i = 0; $i < 50; $i++) {
        $new_data = $new_data . "" . $data[$i];
    }
    return $new_data . "" . "<strong> ...</strong>";
}

if (isset($_POST["task_id_name"])) {
    $task_id_name = test_input($_POST["task_id_name"]);
    $all_task = $task_object->get_row_using_id_or_name($task_id_name);
} else {
    $all_task = $task_object->get_all_row();
}
foreach ($all_task as $key => $value) {
    $task_id = $all_task[$key]["task_id"];
    $task_title = $all_task[$key]["task_title"];
    $task_category = $all_task[$key]["task_category"];
    $task_details = html_entity_decode($all_task[$key]["task_details"]);
    $task_details_short = shorten($task_details);
    $task_point = $all_task[$key]["task_point"];
    $task_hints = $all_task[$key]["task_hints"];
    $task_uploader = $all_task[$key]["task_uploader"];
    $task_input_file = $all_task[$key]["task_input_file"];
    $task_output_file = $all_task[$key]["task_output_file"];
    $task_media = $all_task[$key]["task_media"];

    $header_file_ar = array("<aio.h>", "<libgen.h>", "<spawn.h>", "<sys/time.h>",
        "<arpa/inet.h>", "<limits.h>", "<stdarg.h>", "<sys/times.h>",
        "<assert.h>", "<locale.h>", "<stdbool.h>", "<sys/types.h>",
        "<complex.h>", "<math.h>", "<stddef.h>", "<sys/uio.h>",
        "<cpio.h>", "<monetary.h>", "<stdint.h>", "<sys/un.h>",
        "<ctype.h>", "<mqueue.h>", "<stdio.h>", "<sys/utsname.h>",
        "<dirent.h>", "<ndbm.h>", "<stdlib.h>", "<sys/wait.h>",
        "<dlfcn.h>", "<net/if.h>", "<string.h>", "<syslog.h>",
        "<errno.h>", "<netdb.h>", "<strings.h>", "<tar.h>",
        "<fcntl.h>", "<netinet/in.h>", "<stropts.h>", "<termios.h>",
        "<fenv.h>", "<netinet/tcp.h>", "<sys/ipc.h>", "<tgmath.h>",
        "<float.h>", "<nl_types.h>", "<sys/mman.h>", "<time.h>",
        "<fmtmsg.h>", "<poll.h>", "<sys/msg.h>", "<trace.h>",
        "<fnmatch.h>", "<pthread.h>", "<sys/resource.h>", "<ulimit.h>",
        "<ftw.h>", "<pwd.h>", "<sys/select.h>", "<unistd.h>",
        "<glob.h>", "<regex.h>", "<sys/sem.h>", "<utime.h>",
        "<grp.h>", "<sched.h>", "<sys/shm.h>", "<utmpx.h>",
        "<iconv.h>", "<search.h>", "<sys/socket.h>", "<wchar.h>",
        "<inttypes.h>", "<semaphore.h>", "<sys/stat.h>", "<wctype.h>",
        "<iso646.h>", "<setjmp.h>", "<sys/statvfs.h>", "<wordexp.h>",
        "<langinfo.h>", "<signal.h>");
    $header_file_html = array();
    foreach ($header_file_ar as $value) {
        $header_file_html[] = htmlspecialchars($value);
    }
    $edit_val = $task_details;
    for ($i = 0; $i < count($header_file_ar); $i++) {
        $find_str = $header_file_ar[$i];
        $replace_str = $header_file_html[$i];

        $edit_val = str_replace($find_str, $replace_str, $edit_val);
    }

    $task_user_link='<a href = "compiler_task.php?id='.$task_id.'" class = "btn btn-dark btn-xs"><i class = "fa fa-folder"></i> View as User</a>';
    
    $del_div_id = "delete_task_id" . $task_id;
    $view_div_id = "view_task_id" . $task_id;
    $edit_div_id = "edit_task_id" . $task_id;

    $edit_link = "task_edit.php?task_id=" . $task_id;
    $del_link = "task_delete.php?task_id=" . $task_id;

    $ret_str = "<tr>";
    $ret_str = $ret_str . "<td>" . $task_id . "</td>";
    $ret_str = $ret_str . "<td>" . $task_title . "</td>";
    $ret_str = $ret_str . "<td>" . $task_category . "</td>";
    $ret_str = $ret_str . "<td>" . $task_point . "</td>";
    $ret_str = $ret_str . "<td>" . $task_uploader . "</td>";


    $ret_str = $ret_str . "<td>";
    $ret_str = $ret_str . $task_user_link;
    $ret_str = $ret_str . "<a href = \"#\" class = \"btn btn-primary btn-xs\" data-toggle = \"modal\" data-target = \"#" . $view_div_id . "\"><i class = \"fa fa-folder\"></i> View </a>";
    $ret_str = $ret_str . "<a href = \"" . $edit_link . "\" class = \"btn btn-info btn-xs\" ><i class = \"fa fa-pencil\"></i> Edit </a>";
    $ret_str = $ret_str . "<a href = \"#\" class = \"btn btn-danger btn-xs\" data-toggle = \"modal\" data-target = \"#" . $del_div_id . "\"><i class = \"fa fa-trash-o\"></i> Delete </a>";

    $del_div_str = "<div id=\"" . $del_div_id . "\" class=\"modal fade bs-example-modal-sm\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"true\">";
    $del_div_str = $del_div_str . "<div class=\"modal-dialog modal-sm\">";
    $del_div_str = $del_div_str . "<div class=\"modal-content\">";

    $del_div_str = $del_div_str . "<div class=\"modal-header\">";
    $del_div_str = $del_div_str . "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span>";
    $del_div_str = $del_div_str . "</button>";
    $del_div_str = $del_div_str . "<h4 class=\"modal-title\">Are you sure?</h4>";
    $del_div_str = $del_div_str . "</div>";
    $del_div_str = $del_div_str . "<div class=\"modal-body\">";
    $del_div_str = $del_div_str . "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">";
    $del_div_str = $del_div_str . "<h3>Warning!</h3>";
    $del_div_str = $del_div_str . "<strong>ID: </strong> " . $task_id . " <br/>";
    $del_div_str = $del_div_str . "<strong>Title: </strong> " . $task_title . " <br/>";
    $del_div_str = $del_div_str . "<strong>Uploader: </strong> " . $task_uploader . " <br/>";

    $del_div_str = $del_div_str . "<h4>The data will be deleted permanently.</h4>";
    $del_div_str = $del_div_str . "</div>";
    $del_div_str = $del_div_str . "</div>";
    $del_div_str = $del_div_str . "<div class=\"modal-footer\">";
    $del_div_str = $del_div_str . "<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>";
    $del_div_str = $del_div_str . "<a href=\"" . $del_link . "\" class=\"btn btn-danger\">Delete</button>";
    $del_div_str = $del_div_str . "</div>";

    $del_div_str = $del_div_str . "</div>";
    $del_div_str = $del_div_str . "</div>";
    $del_div_str = $del_div_str . "</div>";



    $view_div_str = '';
    $view_div_str = $view_div_str . "<div id=\"" . $view_div_id . "\" class = \"modal fade bs-example-modal-lg\" tabindex = \"-1\" role = \"dialog\" aria-hidden = \"true\">";
    $view_div_str = $view_div_str . "<div class = \"modal-dialog modal-lg\">";
    $view_div_str = $view_div_str . "<div class = \"modal-content\">";

    $view_div_str = $view_div_str . "<div class = \"modal-header\">";
    $view_div_str = $view_div_str . "<button type = \"button\" class = \"close\" data-dismiss = \"modal\"><span aria-hidden = \"true\">×</span>";
    $view_div_str = $view_div_str . "</button>";

    $view_div_str = $view_div_str . "<h4 class = \"modal-title\">Details of " . $task_title . "(" . $task_id . ")</h4>";
    $view_div_str = $view_div_str . "</div>";

    $view_div_str = $view_div_str . "<div class = \"modal-body\">";
    $view_div_str = $view_div_str . "<form class = \"form-horizontal form-label-left disable-form-design\">";



    $view_div_str = $view_div_str . "<div class = \"form-group\">";
    $view_div_str = $view_div_str . "<label class = \"control-label col-md-3 col-sm-3 col-xs-12\"><strong> ID: </strong></label>";
    $view_div_str = $view_div_str . "<div class = \"col-md-9 col-sm-9 col-xs-12\">";
    $view_div_str = $view_div_str . "<input type = \"text\" class = \"form-control\" disabled = \"disabled\" value=\"" . $task_id . "\">";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";


    $view_div_str = $view_div_str . "<div class = \"form-group\">";
    $view_div_str = $view_div_str . "<label class = \"control-label col-md-3 col-sm-3 col-xs-12\"><strong> Title: </strong></label>";
    $view_div_str = $view_div_str . "<div class = \"col-md-9 col-sm-9 col-xs-12\">";
    $view_div_str = $view_div_str . "<input type = \"text\" class = \"form-control\" disabled = \"disabled\" value=\"" . $task_title . "\">";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";

    $view_div_str = $view_div_str . "<div class = \"form-group\">";
    $view_div_str = $view_div_str . "<label class = \"control-label col-md-3 col-sm-3 col-xs-12\"><strong> Category: </strong></label>";
    $view_div_str = $view_div_str . "<div class = \"col-md-9 col-sm-9 col-xs-12\">";
    $view_div_str = $view_div_str . "<input type = \"text\" class = \"form-control\" disabled = \"disabled\" value=\"" . $task_category . "\">";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";

    $view_div_str = $view_div_str . "<div class = \"form-group\">";
    $view_div_str = $view_div_str . "<label class = \"control-label col-md-3 col-sm-3 col-xs-12\"><strong> Details: </strong></label>";
    $view_div_str = $view_div_str . "<div class = \"col-md-9 col-sm-9 col-xs-12\">";
    $view_div_str = $view_div_str . "" . $edit_val . "";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";


    $view_div_str = $view_div_str . "<div class = \"form-group\">";
    $view_div_str = $view_div_str . "<label class = \"control-label col-md-3 col-sm-3 col-xs-12\"><strong> Input File: </strong></label>";
    $view_div_str = $view_div_str . "<div class = \"col-md-9 col-sm-9 col-xs-12\">";
    $view_div_str = $view_div_str . "<input type = \"text\" class = \"form-control\" disabled = \"disabled\" value=\"" . $task_input_file . "\">";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";


    $view_div_str = $view_div_str . "<div class = \"form-group\">";
    $view_div_str = $view_div_str . "<label class = \"control-label col-md-3 col-sm-3 col-xs-12\"><strong> Output File: </strong></label>";
    $view_div_str = $view_div_str . "<div class = \"col-md-9 col-sm-9 col-xs-12\">";
    $view_div_str = $view_div_str . "<input type = \"text\" class = \"form-control\" disabled = \"disabled\" value=\"" . $task_output_file . "\">";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";


    $view_div_str = $view_div_str . "<div class = \"form-group\">";
    $view_div_str = $view_div_str . "<label class = \"control-label col-md-3 col-sm-3 col-xs-12\"><strong> Media: </strong></label>";
    $view_div_str = $view_div_str . "<div class = \"col-md-9 col-sm-9 col-xs-12\">";
    $view_div_str = $view_div_str . "<img class=\"img-responsive\" src=\"" . $task_media . "\">";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";


    $view_div_str = $view_div_str . "<div class = \"form-group\">";
    $view_div_str = $view_div_str . "<label class = \"control-label col-md-3 col-sm-3 col-xs-12\"><strong> Hints: </strong></label>";
    $view_div_str = $view_div_str . "<div class = \"col-md-9 col-sm-9 col-xs-12\">";
    $view_div_str = $view_div_str . "<input type = \"text\" class = \"form-control\" disabled = \"disabled\" value=\"" . $task_hints . "\">";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";

    $view_div_str = $view_div_str . "<div class = \"form-group\">";
    $view_div_str = $view_div_str . "<label class = \"control-label col-md-3 col-sm-3 col-xs-12\"><strong> Point: </strong></label>";
    $view_div_str = $view_div_str . "<div class = \"col-md-9 col-sm-9 col-xs-12\">";
    $view_div_str = $view_div_str . "<input type = \"text\" class = \"form-control\" disabled = \"disabled\" value=\"" . $task_point . "\">";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";

    $view_div_str = $view_div_str . "<div class = \"form-group\">";
    $view_div_str = $view_div_str . "<label class = \"control-label col-md-3 col-sm-3 col-xs-12\"><strong> Uploader: </strong></label>";
    $view_div_str = $view_div_str . "<div class = \"col-md-9 col-sm-9 col-xs-12\">";
    $view_div_str = $view_div_str . "<input type = \"text\" class = \"form-control\" disabled = \"disabled\" value=\"" . $task_uploader . "\">";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";

    $view_div_str = $view_div_str . "</form>";
    $view_div_str = $view_div_str . "</div>";

    $view_div_str = $view_div_str . "<div class = \"modal-footer\">";
    $view_div_str = $view_div_str . "<button type = \"button\" class = \"btn btn-primary\" data-dismiss = \"modal\">Close</button>";

    $view_div_str = $view_div_str . "</div>";

    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div>";
    $view_div_str = $view_div_str . "</div >";

    $ret_str = $ret_str . " " . $view_div_str;
    $ret_str = $ret_str . " " . $del_div_str;

    $ret_str = $ret_str . "</td>";


    $ret_str = $ret_str . "</tr>";
    echo $ret_str;
}
?>
